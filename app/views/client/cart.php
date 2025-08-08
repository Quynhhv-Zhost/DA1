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
    <!-- Navbar -->
    <nav class="bg-gray-900 text-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <a href="/" class="text-2xl font-bold text-yellow-500">Sneaker Shop</a>
            <div class="space-x-4 text-gray-700 font-medium">
                <a href="?url=client/home" class="hover:text-yellow-600" class="nav-link active">🏠 Trang chủ</a>
                <a href="?url=client/list" class="hover:text-yellow-600">👟 Sản phẩm</a>
                <a href="?url=client/about" class="hover:text-yellow-600">📖 Giới thiệu</a>
                <a href="?url=client/contact" class="hover:text-yellow-600">📞 Liên hệ</a>
                <?php if (isset($_SESSION['user']) && is_array($_SESSION['user']) && isset($_SESSION['user']['username'])) : ?>
                    <div class="inline-block relative group">
                        <button class="hover:text-yellow-600">
                            <i class="fas fa-user"></i> <?= htmlspecialchars($_SESSION['user']['username']) ?>
                        </button>
                        <ul class="absolute hidden group-hover:block bg-white border rounded shadow-md right-0 mt-2 w-40">
                            <li><a href="?url=client/logout" class="block px-4 py-2 hover:bg-gray-100">Đăng xuất</a></li>
                        </ul>
                    </div>
                <?php else : ?>
                    <a href="?url=client/showLoginForm" class="hover:text-yellow-600"><i class="fas fa-user"></i> Đăng nhập</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>


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
                                        <img src="/DA1/public/assets/images/<?= htmlspecialchars($item['image']) ?>" width="80" class="rounded-lg">
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
    <!-- Footer -->
    <footer class="bg-white text-gray-700 mt-16 py-10 border-t border-gray-200">
        <div class="max-w-6xl mx-auto grid grid-cols-2 md:grid-cols-4 gap-8 px-4 text-sm">
            <!-- Cột 1 -->
            <div>
                <h6 class="font-bold mb-2">Về Uniqlo</h6>
                <ul>
                    <li><a href="#" class="hover:underline">Thông tin</a></li>
                    <li><a href="#" class="hover:underline">Danh sách cửa hàng</a></li>
                    <li><a href="#" class="hover:underline">Cơ hội nghề nghiệp</a></li>
                </ul>
            </div>
            <!-- Cột 2 -->
            <div>
                <h6 class="font-bold mb-2">Trợ giúp</h6>
                <ul>
                    <li><a href="#" class="hover:underline">FAQ</a></li>
                    <li><a href="#" class="hover:underline">Chính sách trả hàng</a></li>
                    <li><a href="#" class="hover:underline">Chính sách bảo mật</a></li>
                    <li><a href="#" class="hover:underline">Tiếp cận</a></li>
                </ul>
            </div>
            <!-- Cột 3 -->
            <div>
                <h6 class="font-bold mb-2">Tài khoản</h6>
                <ul>
                    <li><a href="#" class="hover:underline">Tư cách thành viên</a></li>
                    <li><a href="#" class="hover:underline">Hồ sơ</a></li>
                    <li><a href="#" class="hover:underline">Coupons</a></li>
                </ul>
            </div>
            <!-- Cột 4 -->
            <div>
                <h6 class="font-bold mb-2">Bản tin điện tử</h6>
                <p class="text-gray-400 mb-2">Đăng ký ngay để nhận thông tin về sản phẩm mới, chương trình khuyến mãi & sự kiện.</p>
                <a href="#" class="text-yellow-400 hover:underline font-semibold">ĐĂNG KÝ NGAY</a>
            </div>
        </div>

        <div class="border-t border-gray-700 mt-10 pt-4 px-4 text-xs text-gray-400 flex flex-col md:flex-row justify-between items-center">
            <div class="mb-2 md:mb-0">
                Cài đặt cookies |
                <a href="#" class="hover:underline">English</a> |
                <a href="#" class="hover:underline">Tiếng Việt</a>
            </div>
            <div class="space-x-4">
                <a href="#" class="hover:text-white"><i class="fab fa-facebook"></i></a>
                <a href="#" class="hover:text-white"><i class="fab fa-instagram"></i></a>
                <a href="#" class="hover:text-white"><i class="fab fa-youtube"></i></a>
                <a href="#" class="hover:text-white"><i class="fab fa-tiktok"></i></a>
            </div>
        </div>

        <div class="text-center text-xs mt-4 text-gray-500">
            BẢN QUYỀN THUỘC CÔNG TY TNHH UNIQLO. BẢO LƯU MỌI QUYỀN.
        </div>
    </footer>

</body>

</html>