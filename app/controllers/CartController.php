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

        if (isset($_POST['remove'])) {
            $removeIds = $_POST['remove'];  // remove[] chứa variation_id
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
        $address = $_POST['address'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $paymentMethod = $_POST['payment_method'] ?? 'cod';
        $totalPrice = $_POST['total_price'] ?? 0;

        $cartModel = $this->model('Cart');
        $cart = $cartModel->getCartWithProductInfo($userId);

        if (empty($cart)) {
            header('Location: ?url=cart/show');
            exit;
        }

        $orderModel = $this->model('Order');
        $orderId = $orderModel->createOrder($userId, $totalPrice, $paymentMethod, $address, $phone);
        $orderModel->addOrderItems($orderId, $cart);

        // Xóa giỏ hàng
        $cartModel->clearCart($userId);

        header('Location: ?url=cart/checkoutSuccess&order_id=' . $orderId);
        exit;
    }

    public function checkoutSuccess()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $orderId = $_GET['order_id'] ?? null;
        $this->view('client/checkoutSuccess', ['order_id' => $orderId]);
    }
}
