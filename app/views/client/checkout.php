<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Thanh toán đơn hàng</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <div class="container mx-auto p-6 max-w-4xl bg-white rounded-lg shadow-lg mt-10">
        <h2 class="text-3xl font-bold mb-6 text-center">Xác nhận đơn hàng</h2>

        <!-- Danh sách sản phẩm -->
        <div class="mb-6">
            <h3 class="text-xl font-semibold mb-4">Chi tiết đơn hàng:</h3>
            <ul class="space-y-4">
                <?php
                $total = 0;
                foreach ($data['cart'] as $item) :
                    $subtotal = $item['price'] * $item['quantity'];
                    $total += $subtotal;
                ?>
                    <li class="flex justify-between items-center p-4 border rounded-lg">
                        <div>
                            <p class="font-bold"><?= htmlspecialchars($item['product_name']) ?></p>
                            <p class="text-gray-600">Màu: <?= htmlspecialchars($item['color']) ?> | Size: <?= htmlspecialchars($item['size']) ?></p>
                            <p class="text-gray-600">Số lượng: <?= $item['quantity'] ?></p>
                        </div>
                        <div class="font-bold text-red-600"><?= number_format($subtotal, 0, ',', '.') ?> VND</div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <!-- Tổng tiền -->
        <?php
        $vat = $total * 0.1;
        $grandTotal = $total + $vat;
        ?>
        <div class="border-t pt-4 mb-6 text-xl font-semibold space-y-2">
            <div class="flex justify-between">
                <span>Tạm tính:</span>
                <span><?= number_format($total, 0, ',', '.') ?> VND</span>
            </div>
            <div class="flex justify-between">
                <span>VAT (10%):</span>
                <span><?= number_format($vat, 0, ',', '.') ?> VND</span>
            </div>
            <div class="flex justify-between text-2xl text-red-600 font-bold">
                <span>Tổng cộng:</span>
                <span><?= number_format($grandTotal, 0, ',', '.') ?> VND</span>
            </div>
        </div>

        <!-- Form đặt hàng -->
        <form method="POST" action="?url=cart/checkoutSubmit" class="space-y-5">
            <input type="hidden" name="total_price" value="<?= $grandTotal ?>">

            <div>
                <label class="block font-semibold mb-1">Họ và tên người nhận:</label>
                <input type="text" name="fullname" required class="w-full border rounded p-3" placeholder="Nhập họ và tên">
            </div>

            <div>
                <label class="block font-semibold mb-1">Email:</label>
                <input type="email" name="email" required class="w-full border rounded p-3" placeholder="Nhập email">
            </div>

            <div>
                <label class="block font-semibold mb-1">Số điện thoại:</label>
                <input type="tel" name="phone" required class="w-full border rounded p-3" placeholder="Nhập số điện thoại">
            </div>

            <div>
                <label class="block font-semibold mb-1">Tỉnh/Thành phố:</label>
                <input type="text" name="province" required class="w-full border rounded p-3" placeholder="Nhập tỉnh/thành phố">
            </div>

            <div>
                <label class="block font-semibold mb-1">Quận/Huyện:</label>
                <input type="text" name="district" required class="w-full border rounded p-3" placeholder="Nhập quận/huyện">
            </div>

            <div>
                <label class="block font-semibold mb-1">Địa chỉ chi tiết:</label>
                <input type="text" name="address" required class="w-full border rounded p-3" placeholder="Ví dụ: Số 1, đường A, phường B">
            </div>

            <div>
                <label class="block font-semibold mb-1">Phương thức thanh toán:</label>
                <select name="payment_method" required class="w-full border rounded p-3">
                    <option value="">-- Chọn phương thức --</option>
                    <option value="cod">Thanh toán khi nhận hàng (COD)</option>
                    <option value="momo">Ví Momo</option>
                </select>
            </div>

            <div>
                <label class="block font-semibold mb-1">Ghi chú:</label>
                <textarea name="note" class="w-full border rounded p-3" placeholder="Ghi chú thêm..."></textarea>
            </div>

            <button type="submit" class="w-full bg-green-600 text-white font-bold text-xl rounded-lg p-3 hover:bg-green-700 transition">Xác nhận đặt hàng</button>
        </form>
    </div>
</body>

</html>