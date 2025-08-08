<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<?php
$order = $data['order'];
$editable = in_array($order['status'], ['pending', 'preparing']);
$canMarkAsReceived = strtolower($order['status']) === 'delivered';
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Chi tiết đơn hàng</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function toggleEditForm(show) {
            const viewInfo = document.getElementById("deliveryInfo");
            const editForm = document.getElementById("editForm");
            if (show) {
                viewInfo.classList.add("hidden");
                editForm.classList.remove("hidden");
            } else {
                editForm.classList.add("hidden");
                viewInfo.classList.remove("hidden");
            }
        }
    </script>
</head>

<body class="bg-gray-100 min-h-screen font-sans">

    <div class="max-w-4xl mx-auto my-10 bg-white p-6 sm:p-8 rounded-xl shadow-lg">
        <h1 class="text-3xl font-bold text-center text-green-600 mb-8">
            Chi tiết đơn hàng #<?= htmlspecialchars($order['id']) ?>
        </h1>

        <div class="space-y-2 text-lg mb-6">
            <?php
            $status = $order['status'];
            $statusLabels = [
                'pending'    => '⏳ Chờ duyệt',
                'preparing'  => '🛠 Đang chuẩn bị',
                'packed'     => '📦 Đã đóng gói',
                'shipping'   => '🚚 Đã giao vận chuyển',
                'delivered'  => '📬 Đã giao hàng (chờ xác nhận)',
                'completed'  => '✅ Hoàn tất',
                'canceled'   => '❌ Đã huỷ',
            ];

            $statusClasses = [
                'pending'    => 'secondary',
                'preparing'  => 'info',
                'packed'     => 'primary',
                'shipping'   => 'warning',
                'delivered'  => 'light text-dark border',
                'completed'  => 'success',
                'canceled'   => 'danger',
            ];
            ?>

            <strong>Trạng thái:</strong>
            <span class="badge bg-<?= $statusClasses[$status] ?? 'secondary' ?>">
                <?= $statusLabels[$status] ?? $status ?>
            </span>

            <p><strong>Phương thức thanh toán:</strong> <?= htmlspecialchars($order['payment_method']) ?></p>
            <p><strong>Ngày đặt hàng:</strong> <?= htmlspecialchars($order['created_at']) ?></p>
            <p><strong>Tổng tiền:</strong>
                <span class="text-red-600 font-bold text-xl">
                    <?= number_format($order['total_price'], 0, ',', '.') ?> VND
                </span>
            </p>
        </div>

        <div class="flex flex-col sm:flex-row justify-center gap-4 my-6">
            <?php if ($canMarkAsReceived) : ?>
                <form method="POST" action="?url=client/confirmReceived/<?= $order['id'] ?>" class="text-center">
                    <button type="submit" class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 font-semibold">
                        ✅ Tôi đã nhận hàng
                    </button>
                </form>
            <?php endif; ?>

            <a href="?url=client/orders" class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">
                Quay lại danh sách đơn hàng
            </a>
            <a href="?url=client/home" class="px-6 py-3 bg-gray-600 text-white font-semibold rounded-lg hover:bg-gray-700 transition">
                Trang chủ
            </a>
        </div>

        <!-- THÔNG TIN GIAO HÀNG -->
        <div id="deliveryInfo" class="bg-gray-50 border p-4 rounded mb-6">
            <h2 class="text-xl font-bold text-gray-700 mb-3">Thông tin giao hàng</h2>
            <p><strong>Họ tên:</strong> <?= htmlspecialchars($order['fullname']) ?></p>
            <p><strong>Điện thoại:</strong> <?= htmlspecialchars($order['phone']) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($order['email']) ?></p>
            <p><strong>Địa chỉ:</strong> <?= htmlspecialchars($order['address']) ?>, <?= htmlspecialchars($order['district']) ?>, <?= htmlspecialchars($order['province']) ?></p>
            <?php if (!empty($order['note'])) : ?>
                <p><strong>Ghi chú:</strong> <?= htmlspecialchars($order['note']) ?></p>
            <?php endif; ?>
            <?php if ($editable) : ?>
                <button onclick="toggleEditForm(true)" class="mt-4 px-5 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                    ✏️ Cập nhật địa chỉ nhận hàng
                </button>
            <?php endif; ?>
        </div>

        <?php if ($editable) : ?>
            <form id="editForm" method="POST" action="?url=client/updateDeliveryInfo/<?= $order['id'] ?>" class="bg-yellow-50 p-4 rounded-lg shadow mb-6 hidden">
                <h2 class="text-xl font-bold mb-4 text-yellow-700">Cập nhật thông tin giao hàng</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <input name="fullname" required maxlength="100" value="<?= htmlspecialchars($order['fullname']) ?>" class="border p-2 rounded" placeholder="Họ tên người nhận">
                    <input name="phone" required maxlength="10" value="<?= htmlspecialchars($order['phone']) ?>" class="border p-2 rounded" placeholder="Số điện thoại">
                    <input name="email" value="<?= htmlspecialchars($order['email']) ?>" class="border p-2 rounded" placeholder="Email">
                    <input name="province" value="<?= htmlspecialchars($order['province']) ?>" class="border p-2 rounded" placeholder="Tỉnh/Thành phố">
                    <input name="district" value="<?= htmlspecialchars($order['district']) ?>" class="border p-2 rounded" placeholder="Quận/Huyện">
                    <input name="address" required maxlength="255" value="<?= htmlspecialchars($order['address']) ?>" class="border p-2 rounded col-span-full" placeholder="Địa chỉ chi tiết">
                </div>
                <div class="mt-4">
                    <textarea name="note" class="w-full border rounded p-2" maxlength="255" placeholder="Ghi chú"><?= htmlspecialchars($order['note']) ?></textarea>
                </div>
                <div class="mt-4 flex justify-end gap-4">
                    <button type="button" onclick="toggleEditForm(false)" class="px-5 py-2 bg-gray-400 text-white rounded hover:bg-gray-500">❌ Huỷ</button>
                    <button type="submit" class="px-5 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">💾 Lưu cập nhật</button>
                </div>
            </form>
        <?php endif; ?>

        <h2 class="text-2xl font-bold border-b pb-2 mb-4">Danh sách sản phẩm</h2>

        <div class="space-y-4">
            <?php foreach ($order['items'] as $item) :
                $image = htmlspecialchars($item['image'] ?? 'default.jpg');
                $line_total = $item['variation_price'] * $item['quantity'];
            ?>
                <div class="flex flex-col sm:flex-row items-center sm:items-start gap-4 p-4 bg-white rounded-lg border shadow-sm">
                    <img src="/DA1/code/public/assets/images/<?= $image ?>" alt="Ảnh sản phẩm" class="w-24 h-24 object-cover rounded-lg shadow-sm border">
                    <div class="flex-grow">
                        <p class="text-xl font-semibold mb-1"><?= htmlspecialchars($item['product_name'] ?? 'Tên SP') ?></p>
                        <p class="text-gray-700 mb-1">
                            Màu: <?= htmlspecialchars($item['color'] ?? '-') ?> | Size: <?= htmlspecialchars($item['size'] ?? '-') ?>
                        </p>
                        <p class="text-gray-700 mb-1">Số lượng: <strong><?= (int) ($item['quantity'] ?? 0) ?></strong></p>
                        <p class="text-sm text-gray-500">Đơn giá: <?= number_format($item['variation_price'], 0, ',', '.') ?> VND</p>
                    </div>
                    <div class="text-lg font-bold text-red-600 whitespace-nowrap">
                        <?= number_format($line_total, 0, ',', '.') ?> VND
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>

</html>