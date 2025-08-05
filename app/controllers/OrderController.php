<?php
class OrderController extends Controller
{
    public function index()
    {
        $this->checkAdmin();
        $orderModel = $this->model('Order');
        $orders = $orderModel->getAllOrders();
        $this->view('admin/order-list', ['orders' => $orders]);
    }

    public function detail($id)
    {
        $this->checkAdmin();
        $orderModel = $this->model('Order');
        $order = $orderModel->getOrderByIdAdmin($id);
        if (!$order) {
            die("Không tìm thấy đơn hàng!");
        }
        $this->view('admin/order-detail', ['order' => $order]);
    }

    public function updateStatus($id)
    {
        $this->checkAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $status = $_POST['status'];
            $orderModel = $this->model('Order');
            $orderModel->updateStatus($id, $status);
            header("Location: ?url=order/detail/$id");
            exit;
        }
    }

    private function checkAdmin()
    {
        if (!isset($_SESSION['admin'])) {
            header('Location: ?url=auth/login');
            exit;
        }
    }

    public function applyCoupon()
    {
        $code = $_POST['coupon_code'] ?? '';
        $total = $_POST['total'] ?? 0;

        $couponModel = new Coupon();
        $coupon = $couponModel->findByCode($code);

        if ($coupon) {
            $discountValue = (float)$coupon['discount_value'];
            $discountType = $coupon['discount_type'];
            $minOrder = (float)$coupon['min_order_value'];
            $maxDiscount = isset($coupon['max_discount']) ? (float)$coupon['max_discount'] : null;

            if ($total < $minOrder) {
                $_SESSION['coupon_message'] = "❌ Đơn hàng cần tối thiểu " . number_format($minOrder, 0, ',', '.') . "đ để dùng mã.";
                header("Location: " . $_SERVER['HTTP_REFERER']);
                exit;
            }

            // Tính tiền giảm
            if ($discountType === 'percentage') {
                $discount = $total * ($discountValue / 100);
                if ($maxDiscount && $discount > $maxDiscount) {
                    $discount = $maxDiscount;
                }
            } elseif ($discountType === 'fixed') {
                $discount = $discountValue;
            } else {
                $discount = 0;
            }

            $_SESSION['coupon'] = [
                'code' => $code,
                'discount' => $discount
            ];

            $_SESSION['coupon_message'] = "✅ Mã '$code' được giảm " . number_format($discount, 0, ',', '.') . "đ.";
        } else {
            unset($_SESSION['coupon']);
            $_SESSION['coupon_message'] = "❌ Mã giảm giá không hợp lệ.";
        }

        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    }

    public function checkout()
    {
        session_start();

        // Lấy giỏ hàng từ session
        $cart = $_SESSION['cart'] ?? [];

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        $vat = $total * 0.1;

        // Áp mã giảm giá nếu có
        $discount = $_SESSION['coupon']['discount'] ?? 0;

        // Tổng tiền cuối cùng sau VAT và giảm giá
        $grandTotal = $total + $vat - $discount;

        // Gửi dữ liệu sang view
        require_once './app/views/client/checkout.php';
    }
}
