<?php
class CartController extends Controller
{
    // Trong CartController
    public function show()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (!isset($_SESSION['user'])) {
            header('Location: ?url=client/showLoginForm');
            exit;
        }

        $userId = $_SESSION['user']['id'];
        $cartModel = $this->model('Cart');

        // Lấy giỏ hàng với thông tin sản phẩm, bao gồm giá mới nhất
        $cart = $cartModel->getCartWithProductInfo($userId);  // Phương thức getCartWithProductInfo cần sửa

        $this->view('client/cart', ['cart' => $cart]);
    }



    public function add()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (!isset($_SESSION['user'])) {
            header('Location: ?url=client/showLoginForm');
            exit;
        }

        $variation_id = $_POST['variation_id'] ?? null;
        $quantity = max(1, intval($_POST['quantity'] ?? 1));
        $user_id = $_SESSION['user']['id'];

        if (!$variation_id) {
            header('Location: ?url=client/home');
            exit;
        }

        $productModel = $this->model('Product');
        $variation = $productModel->getVariationById($variation_id);
        if (!$variation) {
            header('Location: ?url=client/home');
            exit;
        }

        $cartModel = $this->model('Cart');
        $cartModel->addToCart($user_id, $variation_id, $quantity);

        header('Location: ?url=cart/show');
        exit;
    }

    // Kiểm tra và xóa sản phẩm trong giỏ hàng
    public function remove()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (!isset($_SESSION['user'])) {
            header('Location: ?url=client/showLoginForm');
            exit;
        }
        if (isset($_POST['selected_items'])) {  // ✅ dùng đúng name="selected_items[]"
            $removeIds = $_POST['selected_items'];
            $user_id = $_SESSION['user']['id'];
            $cartModel = $this->model('Cart');

            foreach ($removeIds as $variation_id) {
                $cartModel->removeFromCart($user_id, $variation_id);
            }
        }
        header('Location: ?url=cart/show');
        exit;
    }
    public function checkout()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (!isset($_SESSION['user'])) {
            header('Location: ?url=client/showLoginForm');
            exit;
        }

        $userId = $_SESSION['user']['id'];
        $cartModel = $this->model('Cart');
        $cart = $cartModel->getCartWithProductInfo($userId);

        // Lọc lại nếu người dùng chọn sản phẩm riêng để thanh toán
        if (isset($_SESSION['checkout_cart_ids']) && !empty($_SESSION['checkout_cart_ids'])) {
            $selectedIds = $_SESSION['checkout_cart_ids'];

            // Lọc cart để chỉ giữ sản phẩm có id nằm trong selectedIds
            $cart = array_filter($cart, function ($item) use ($selectedIds) {
                return in_array($item['id'], $selectedIds); // id là id trong bảng cart
            });
        }

        if (empty($cart)) {
            header('Location: ?url=cart/show');
            exit;
        }

        $this->view('client/checkout', ['cart' => $cart]);
    }
    public function checkoutSubmit()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user'])) {
            header('Location: ?url=client/showLoginForm');
            exit;
        }

        $userId = $_SESSION['user']['id'];
        $fullname = $_POST['fullname'] ?? '';
        $email = $_POST['email'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $address = $_POST['address'] ?? '';
        $province = $_POST['province'] ?? '';
        $district = $_POST['district'] ?? '';
        $note = $_POST['note'] ?? '';
        $paymentMethod = $_POST['payment_method'] ?? 'cod';
        $totalPrice = $_POST['total_price'] ?? 0;

        $cartModel = $this->model('Cart');
        $cart = $cartModel->getCartWithProductInfo($userId);

        // Lọc lại cart nếu chỉ thanh toán một phần
        if (isset($_SESSION['checkout_cart_ids']) && !empty($_SESSION['checkout_cart_ids'])) {
            $selectedIds = $_SESSION['checkout_cart_ids'];
            $cart = array_filter($cart, function ($item) use ($selectedIds) {
                return in_array($item['id'], $selectedIds);
            });
        }

        if (empty($cart)) {
            header('Location: ?url=cart/show');
            exit;
        }

        $orderModel = $this->model('Order');

        // Giả sử bạn sửa createOrder để nhận thêm thông tin
        $orderId = $orderModel->createOrder(
            $userId,
            $totalPrice,
            $paymentMethod,
            $address,
            $phone,
            $fullname,
            $email,
            $province,
            $district,
            $note
        );

        $orderModel->addOrderItems($orderId, $cart);

        $cartModel->clearCart($userId);
        unset($_SESSION['checkout_cart_ids']);

        header('Location: ?url=cart/checkoutSuccess&order_id=' . $orderId);
        exit;
    }
    public function checkoutSuccess()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $orderId = $_GET['order_id'] ?? null;
        $this->view('client/checkoutSuccess', ['order_id' => $orderId]);
    }
    public function checkoutSelected()
    {
        if (!isset($_POST['selected_items']) || empty($_POST['selected_items'])) {
            echo "<script>alert('Vui lòng chọn ít nhất 1 sản phẩm để thanh toán'); window.history.back();</script>";
            exit;
        }

        $_SESSION['checkout_cart_ids'] = $_POST['selected_items'];

        // Điều hướng tới trang thanh toán như bình thường
        header("Location: ?url=cart/checkout");
        exit;
    }
}
