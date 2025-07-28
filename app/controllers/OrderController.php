<?php
require_once __DIR__ . '/../models/Coupon.php';


class OrderController

{
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

    public function placeOrder()
{
    session_start();

    // Lấy dữ liệu từ session
    $userId = $_SESSION['user']['id'] ?? 0;
    $cart = $_SESSION['cart'] ?? [];
    $paymentMethod = $_POST['payment_method'] ?? 'cod';

    if (empty($cart)) {
        $_SESSION['order_message'] = "❌ Giỏ hàng trống, không thể đặt hàng.";
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    }

    // Tính tổng
    $total = 0;
    foreach ($cart as $item) {
        $total += $item['price'] * $item['quantity'];
    }

    $vat = $total * 0.1;
    $discount = $_SESSION['coupon']['discount'] ?? 0;
    $couponCode = $_SESSION['coupon']['code'] ?? null;

    // Tổng cuối cùng
    $grandTotal = $total + $vat - $discount;

    // Gọi model để lưu đơn hàng
    require_once __DIR__ . '/../models/Order.php';
    $orderModel = new Order();
    $orderId = $orderModel->createOrder($userId, $grandTotal, $paymentMethod, $discount, $couponCode);

    // Lưu sản phẩm vào bảng order_items
    $orderModel->addOrderItems($orderId, $cart);

    // Xóa giỏ hàng và mã
    unset($_SESSION['cart'], $_SESSION['coupon']);

    // Chuyển về trang chi tiết đơn hàng
    header("Location: ?url=client/orderDetail&id=" . $orderId);
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
