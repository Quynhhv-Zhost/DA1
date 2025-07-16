<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Giỏ hàng</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.0/dist/sweetalert2.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">

    <div class="container mx-auto p-6">
        <h2 class="text-3xl font-semibold text-gray-800 mb-6">Giỏ hàng của bạn</h2>

        <?php if (empty($data['cart'])) : ?>
            <div class="p-4 bg-blue-100 text-blue-800 rounded-lg shadow-md mb-6">
                Giỏ hàng của bạn đang trống.
            </div>
            <div class="flex justify-center">
                <a href="?url=client/home" class="bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 transition">Quay lại trang chủ</a>
            </div>
        <?php else : ?>
            <form method="POST" action="?url=cart/remove" id="cartForm">
                <div class="overflow-x-auto bg-white shadow-lg rounded-lg">
                    <table class="min-w-full">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="px-4 py-2"><input type="checkbox" id="selectAll"></th>
                                <th class="px-4 py-2 text-left">Sản phẩm</th>
                                <th class="px-4 py-2 text-left">Hình ảnh</th>
                                <th class="px-4 py-2 text-left">Giá</th>
                                <th class="px-4 py-2 text-left">Số lượng</th>
                                <th class="px-4 py-2 text-left">Tổng</th>
                                <th class="px-4 py-2 text-center">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $total = 0;
                            foreach ($data['cart'] as $item) :
                                $name = htmlspecialchars($item['product_name'] ?? '');
                                $variation_name = htmlspecialchars($item['variation_name'] ?? '');
                                $color = htmlspecialchars($item['color'] ?? '');
                                $size = htmlspecialchars($item['size'] ?? '');
                                $price = floatval($item['price']);
                                $quantity = intval($item['quantity']);
                                $subtotal = $price * $quantity;
                                $total += $subtotal;
                            ?>
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-4 py-2">
                                        <input type="checkbox" name="remove[]" value="<?= $item['variation_id'] ?>">
                                    </td>
                                    <td class="px-4 py-2">
                                        <div class="font-semibold"><?= $name ?></div>
                                        <div class="text-sm text-gray-600">Loại: <?= $variation_name ?> | Màu: <?= $color ?> | Size: <?= $size ?></div>
                                    </td>
                                    <td class="px-4 py-2">
                                        <img src="/DA1/code/public/assets/images/<?= htmlspecialchars($item['image']) ?>" width="80" class="rounded-lg">
                                    </td>
                                    <td class="px-4 py-2"><?= number_format($price, 0, ',', '.') ?> VND</td>
                                    <td class="px-4 py-2"><?= $quantity ?></td>
                                    <td class="px-4 py-2"><?= number_format($subtotal, 0, ',', '.') ?> VND</td>
                                    <td class="px-4 py-2 text-center">
                                        <button type="button" class="text-red-500 hover:text-red-600" onclick="confirmDeleteSingle('<?= $item['variation_id'] ?>')">Xoá</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="flex justify-between items-center mt-4">
                    <span class="text-xl font-semibold">Tổng cộng: <span class="text-red-600"><?= number_format($total, 0, ',', '.') ?> VND</span></span>
                    <div class="flex gap-4">
                        <button type="button" id="deleteSelected" class="bg-red-500 text-white px-6 py-2 rounded-lg hover:bg-red-600 disabled:opacity-50" disabled onclick="confirmDeleteSelected()">Xoá đã chọn</button>
                        <a href="?url=client/home" class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600">Tiếp tục mua hàng</a>
                        <a href="?url=cart/checkout" class="bg-green-500 text-white px-6 py-2 rounded-lg hover:bg-green-600">Thanh toán</a>
                    </div>
                </div>
            </form>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.0/dist/sweetalert2.all.min.js"></script>
    <script>
        const selectAll = document.getElementById('selectAll');
        const checkboxes = document.querySelectorAll('input[name="remove[]"]');
        const deleteSelectedBtn = document.getElementById('deleteSelected');

        selectAll.addEventListener('change', function() {
            checkboxes.forEach(cb => cb.checked = this.checked);
            toggleDeleteButton();
        });

        checkboxes.forEach(cb => cb.addEventListener('change', toggleDeleteButton));

        function toggleDeleteButton() {
            const checked = [...checkboxes].some(cb => cb.checked);
            deleteSelectedBtn.disabled = !checked;
        }

        function confirmDeleteSelected() {
            Swal.fire({
                title: 'Bạn có chắc chắn xoá sản phẩm đã chọn?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Xoá',
                cancelButtonText: 'Huỷ',
                confirmButtonColor: '#d33'
            }).then(result => {
                if (result.isConfirmed) {
                    document.getElementById('cartForm').submit();
                }
            });
        }

        function confirmDeleteSingle(variationId) {
            Swal.fire({
                title: 'Bạn chắc chắn muốn xoá sản phẩm này?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Xoá',
                cancelButtonText: 'Huỷ',
                confirmButtonColor: '#d33'
            }).then(result => {
                if (result.isConfirmed) {
                    const form = document.getElementById('cartForm');
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'remove[]';
                    input.value = variationId;
                    form.appendChild(input);
                    form.submit();
                }
            });
        }
    </script>

</body>

</html>