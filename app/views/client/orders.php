<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Danh sách đơn hàng</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen">

    <div class="max-w-6xl mx-auto my-10 p-6 bg-white rounded-xl shadow-lg">
        <h1 class="text-4xl font-bold mb-8 text-center text-blue-700">Danh sách đơn hàng của bạn</h1>

        <?php if (empty($data['orders'])) : ?>
            <p class="text-center text-xl text-gray-700">Bạn chưa có đơn hàng nào.</p>
            <div class="flex justify-center mt-8">
                <a href="?url=client/home" class="px-6 py-3 bg-green-500 text-white font-semibold rounded-lg hover:bg-green-600 transition">Quay lại mua hàng</a>
            </div>
        <?php else : ?>
            <div class="space-y-6">
                <?php foreach ($data['orders'] as $order) : ?>
                    <div class="flex flex-col md:flex-row md:justify-between md:items-center bg-gray-50 p-5 rounded-lg border hover:shadow transition">
                        <div class="space-y-2">
                            <p class="text-2xl font-bold text-gray-800">Đơn hàng #<?= $order['id'] ?></p>
                            <p><span class="font-semibold">Ngày đặt:</span> <?= htmlspecialchars($order['created_at']) ?></p>
                            <p>
                                <span class="font-semibold">Trạng thái:</span>
                                <?php
                                $statusClass = match ($order['status']) {
                                    'pending' => 'text-yellow-500',
                                    'completed' => 'text-green-600',
                                    'canceled' => 'text-red-600',
                                    default => 'text-gray-600',
                                };
                                ?>
                                <span class="<?= $statusClass ?> font-bold uppercase"><?= htmlspecialchars($order['status']) ?></span>
                            </p>
                            <p><span class="font-semibold">Phương thức thanh toán:</span> <?= htmlspecialchars($order['payment_method']) ?></p>
                            <p><span class="font-semibold">Tổng tiền:</span> <span class="text-red-600 font-bold text-lg"><?= number_format($order['total_price'], 0, ',', '.') ?> VND</span></p>
                        </div>
                        <div class="mt-4 md:mt-0">
                            <a href="?url=client/orderDetail/<?= $order['id'] ?>" class="inline-block px-6 py-3 bg-blue-500 text-white font-bold rounded-lg hover:bg-blue-600 transition w-full md:w-auto text-center">
                                Xem chi tiết
                            </a>

                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

</body>

</html>