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

        <div class="text-center mt-4 mb-6">
            <a href="?url=client/home" class="inline-block px-6 py-3 bg-green-600 text-white font-bold rounded-lg hover:bg-green-700 transition">
                Quay lại trang chủ
            </a>
        </div>

        <!-- Form lọc -->
        <form method="GET" action="?url=client/listOrders" class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            <input type="hidden" name="url" value="client/orders">

            <div>
                <label for="status" class="block font-semibold mb-1">Trạng thái đơn hàng:</label>
                <select name="status" id="status" class="w-full border px-3 py-2 rounded">
                    <option value="">Tất cả</option>
                    <option value="pending" <?= ($_GET['status'] ?? '') === 'pending' ? 'selected' : '' ?>>⏳ Chờ duyệt</option>
                    <option value="preparing" <?= ($_GET['status'] ?? '') === 'preparing' ? 'selected' : '' ?>>🛠 Đang chuẩn bị</option>
                    <option value="packed" <?= ($_GET['status'] ?? '') === 'packed' ? 'selected' : '' ?>>📦 Đã đóng gói</option>
                    <option value="shipping" <?= ($_GET['status'] ?? '') === 'shipping' ? 'selected' : '' ?>>🚚 Đang giao hàng</option>
                    <option value="delivered" <?= ($_GET['status'] ?? '') === 'delivered' ? 'selected' : '' ?>>📬 Đã giao</option>
                    <option value="completed" <?= ($_GET['status'] ?? '') === 'completed' ? 'selected' : '' ?>>✅ Hoàn tất</option>
                    <option value="canceled" <?= ($_GET['status'] ?? '') === 'canceled' ? 'selected' : '' ?>>❌ Đã huỷ</option>
                </select>
            </div>

            <div>
                <label for="q" class="block font-semibold mb-1">Tìm theo mã đơn hàng:</label>
                <input type="text" name="q" id="q" value="<?= htmlspecialchars($_GET['q'] ?? '') ?>" placeholder="VD: 123" class="w-full border px-3 py-2 rounded" />
            </div>

            <div class="flex items-end">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white font-bold rounded hover:bg-blue-700 transition w-full">
                    Lọc đơn hàng
                </button>
            </div>
        </form>
        <?php if ($_GET) : ?>
            <div class="mb-4 text-sm text-gray-600">
                Đang lọc:
                <?php if (!empty($_GET['q'])) : ?>
                    <span class="font-medium text-blue-700">Theo mã: <?= htmlspecialchars($_GET['q']) ?></span>
                <?php endif; ?>
                <?php if (!empty($_GET['status'])) : ?>
                    <span class="font-medium text-blue-700 ml-4">Trạng thái: <?= $statusLabels[$_GET['status']] ?? $_GET['status'] ?></span>
                <?php endif; ?>
                <a href="?url=client/listOrders" class="ml-4 text-red-600 underline">Xoá lọc</a>
            </div>
        <?php endif; ?>

        <!-- Danh sách đơn -->
        <?php if (empty($data['orders'])) : ?>
            <div class="text-center text-xl text-gray-700 bg-yellow-100 p-5 rounded-md">
                Không có đơn hàng nào phù hợp với điều kiện lọc bạn đã chọn.
            </div>
        <?php else : ?>
            <div class="space-y-6">
                <?php foreach ($data['orders'] as $order) : ?>
                    <?php
                    $statusLabels = [
                        'pending'    => '⏳ Chờ duyệt',
                        'preparing'  => '🛠 Đang chuẩn bị',
                        'packed'     => '📦 Đã đóng gói',
                        'shipping'   => '🚚 Đang giao hàng',
                        'delivered'  => '📬 Đã giao (chờ xác nhận)',
                        'completed'  => '✅ Hoàn tất',
                        'canceled'   => '❌ Đã huỷ',
                    ];

                    $statusColors = [
                        'pending'    => 'text-yellow-600',
                        'preparing'  => 'text-blue-500',
                        'packed'     => 'text-indigo-500',
                        'shipping'   => 'text-orange-500',
                        'delivered'  => 'text-gray-600',
                        'completed'  => 'text-green-600',
                        'canceled'   => 'text-red-600',
                    ];

                    $status = $order['status'];
                    $statusClass = $statusColors[$status] ?? 'text-gray-600';
                    $statusLabel = $statusLabels[$status] ?? strtoupper($status);
                    ?>
                    <div class="flex flex-col md:flex-row md:justify-between md:items-center bg-gray-50 p-5 rounded-lg border hover:shadow transition">
                        <div class="space-y-2">
                            <p class="text-2xl font-bold text-gray-800">Đơn hàng #<?= $order['id'] ?></p>
                            <p><span class="font-semibold">Ngày đặt:</span> <?= htmlspecialchars($order['created_at']) ?></p>
                            <p><span class="font-semibold">Trạng thái:</span> <span class="<?= $statusClass ?> font-bold"><?= $statusLabel ?></span></p>
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