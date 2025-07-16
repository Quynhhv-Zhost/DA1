<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Đặt hàng thành công</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-r from-green-100 via-green-200 to-green-300 min-h-screen flex items-center justify-center">

    <div class="bg-white rounded-xl shadow-lg p-8 max-w-xl w-full text-center">
        <div class="flex justify-center mb-4">
            <svg class="w-20 h-20 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2l4 -4M12 20c4.418 0 8 -3.582 8 -8s-3.582 -8 -8 -8s-8 3.582 -8 8s3.582 8 8 8z" />
            </svg>
        </div>

        <h1 class="text-3xl font-bold text-green-700 mb-4">Đặt hàng thành công!</h1>
        <p class="text-lg text-gray-700 mb-2">Cảm ơn bạn đã đặt hàng tại cửa hàng của chúng tôi.</p>
        <p class="text-lg mb-6">Mã đơn hàng của bạn là:
            <span class="font-bold text-green-700">#<?= htmlspecialchars($data['order_id']) ?></span>
        </p>

        <a href="?url=client/home" class="inline-block w-full bg-green-500 text-white font-semibold py-3 rounded-lg hover:bg-green-600 transition mb-3">
            Tiếp tục mua hàng
        </a>

        <a href="?url=client/orderDetail/<?= htmlspecialchars($data['order_id']) ?>" class="inline-block w-full bg-gray-200 text-gray-800 font-semibold py-3 rounded-lg hover:bg-gray-300 transition">
            Xem chi tiết đơn hàng
        </a>
    </div>

</body>

</html>