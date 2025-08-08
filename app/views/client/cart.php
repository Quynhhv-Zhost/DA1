<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Giỏ hàng</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.0/dist/sweetalert2.min.css" rel="stylesheet"> -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body class="bg-gray-100">
    <div class="container mx-auto max-w-5xl p-6 bg-white rounded-lg shadow-lg mt-10">
        <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">🛒 Giỏ hàng của bạn</h2>

        <?php if (empty($data['cart'])) : ?>
            <div class="p-5 bg-blue-100 text-blue-800 text-center rounded-md shadow mb-6 text-lg">
                Giỏ hàng của bạn đang trống.
            </div>
        <?php else : ?>
            <form method="POST" id="cartForm" action="?url=cart/remove">
                <div class="overflow-x-auto">
                    <table class="min-w-full border rounded-lg">
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
                        <tbody class="bg-white">
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
                                    <td class="px-4 py-2 text-center">
                                        <input type="checkbox" data-cart-id="<?= $item['id'] ?>" data-variation-id="<?= $item['variation_id'] ?>" class="item-checkbox">
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

                <!-- Tổng và nút xử lý -->
                <div class="flex flex-col md:flex-row justify-between items-center mt-6 space-y-4 md:space-y-0">
                    <span class="text-xl font-semibold">Tổng cộng: <span class="text-red-600"><?= number_format($total, 0, ',', '.') ?> VND</span></span>
                    <div class="flex flex-wrap gap-4 justify-center">
                        <button type="button" onclick="submitForm('remove')" id="deleteBtn" class="bg-red-500 text-white px-6 py-2 rounded hover:bg-red-600 transition">
                            Xoá các sản phẩm đã chọn
                        </button>
                        <button type="button" onclick="submitForm('checkout')" class="bg-green-500 text-white px-6 py-2 rounded hover:bg-green-600 transition">
                            Thanh toán các sản phẩm đã chọn
                        </button>
                    </div>
                </div>
            </form>
        <?php endif; ?>

        <!-- Luôn hiển thị: điều hướng -->
        <div class="flex justify-center gap-6 mt-8">
            <a href="?url=client/home" class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 transition">Tiếp tục mua hàng</a>
            <a href="?url=client/orders" class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition">Danh sách đơn hàng</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.0/dist/sweetalert2.all.min.js"></script>
    <script>
        const selectAll = document.getElementById('selectAll');
        const checkboxes = document.querySelectorAll('.item-checkbox');
        const form = document.getElementById('cartForm');

        if (selectAll) {
            selectAll.addEventListener('change', function() {
                checkboxes.forEach(cb => cb.checked = this.checked);
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
                    input.name = 'selected_items[]';
                    input.value = variationId;
                    form.appendChild(input);
                    form.action = '?url=cart/remove'; // ⚠ đảm bảo đúng
                    form.submit();
                }
            });
        }

        function submitForm(actionType) {
            const selected = [...document.querySelectorAll('.item-checkbox:checked')];

            if (selected.length === 0) {
                Swal.fire('Bạn chưa chọn sản phẩm nào');
                return;
            }

            // Xoá các checkbox đang có
            document.querySelectorAll('input[name="selected_items[]"]').forEach(e => e.remove());

            selected.forEach(item => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'selected_items[]';
                input.value = actionType === 'remove' ?
                    item.dataset.variationId :
                    item.dataset.cartId;
                form.appendChild(input);
            });

            if (actionType === 'remove') {
                Swal.fire({
                    title: 'Bạn có chắc muốn xoá sản phẩm đã chọn?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Xoá',
                    cancelButtonText: 'Huỷ'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.action = '?url=cart/remove';
                        form.submit();
                    }
                });
            } else {
                form.action = '?url=cart/checkoutSelected';
                form.submit();
            }
        }

        function handleCheckout() {
            const checked = [...document.querySelectorAll('input[name="selected_items[]"]')].some(cb => cb.checked);
            if (!checked) {
                alert("Vui lòng chọn ít nhất 1 sản phẩm để thanh toán");
                return false;
            }
            const form = document.getElementById('cartForm');
            form.action = '?url=cart/checkoutSelected';
            form.submit();
            return false;
        }
    </script>

</body>

</html>