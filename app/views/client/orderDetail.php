<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Chi tiết đơn hàng</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen">

    <div class="max-w-5xl mx-auto my-10 bg-white p-8 rounded-xl shadow-lg">
        <h1 class="text-3xl font-bold mb-6 text-center text-green-600">Chi tiết đơn hàng #<?= htmlspecialchars($data['order']['id']) ?></h1>

        <div class="mb-8 space-y-2">
            <p class="text-lg"><strong>Trạng thái:</strong>
                <span class="font-semibold text-blue-600"><?= htmlspecialchars($data['order']['status']) ?></span>
            </p>
            <p><strong>Địa chỉ nhận hàng:</strong> <?= htmlspecialchars($data['order']['address']) ?></p>
            <p><strong>Số điện thoại:</strong> <?= htmlspecialchars($data['order']['phone']) ?></p>

            <p class="text-lg"><strong>Phương thức thanh toán:</strong> <?= htmlspecialchars($data['order']['payment_method']) ?></p>
            <p class="text-lg"><strong>Ngày đặt hàng:</strong> <?= htmlspecialchars($data['order']['created_at']) ?></p>
            <?php
            $total = $data['order']['total_price'];
            $discount = $data['order']['discount'] ?? 0;
            $finalTotal = $total - $discount;
            ?>
            <p class="text-lg"><strong>Tổng tiền thanh toán:</strong>
                <span class="font-bold text-red-600"><?= number_format($finalTotal, 0, ',', '.') ?> VND</span>
            </p>

            <?php if (!empty($data['order']['discount'])) : ?>
                <p class="text-lg text-green-700">
                    <strong>Đã áp mã: <?= htmlspecialchars($data['order']['coupon_code']) ?></strong> – giảm <?= number_format($data['order']['discount'], 0, ',', '.') ?> VND
                </p>
            <?php endif; ?>

        </div>

        <h2 class="text-2xl font-bold mb-4 border-b pb-2">Danh sách sản phẩm</h2>

        <div class="space-y-4">
            <?php foreach ($data['order']['items'] as $item) :
                $image = htmlspecialchars($item['image'] ?? 'default.jpg');
            ?>
                <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-lg border">
                    <img src="/DA1/code/public/assets/images/<?= $image ?>" alt="Ảnh sản phẩm" class="w-24 h-24 object-cover rounded">
                    <div class="flex-grow">
                        <p class="text-xl font-bold"><?= htmlspecialchars($item['product_name'] ?? 'Tên SP') ?></p>
                        <p class="text-gray-700">Màu: <?= htmlspecialchars($item['color'] ?? '-') ?> | Size: <?= htmlspecialchars($item['size'] ?? '-') ?></p>
                        <p>Số lượng: <strong><?= (int) ($item['quantity'] ?? 0) ?></strong></p>
                    </div>
                    <div class="text-lg font-semibold text-red-600">
                        <?= number_format(($item['price'] ?? 0) * ($item['quantity'] ?? 0), 0, ',', '.') ?> VND
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="mt-8 text-center">
            <a href="?url=client/orders" class="inline-block px-6 py-3 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 transition">Quay lại danh sách đơn hàng</a>
        </div>
    </div>
    <?php include 'chat_popup.php'; ?>

</body>

</html>