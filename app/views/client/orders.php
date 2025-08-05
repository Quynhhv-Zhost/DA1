<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Danh sách đơn hàng</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen">
    <nav class="bg-gray-900 text-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <a href="/" class="text-2xl font-bold text-yellow-500">Sneaker Shop</a>
            <div class="space-x-4 text-gray-700 font-medium">
                <a href="?url=client/home" class="hover:text-yellow-600">🏠 Trang chủ</a>
                <a href="?url=client/list" class="hover:text-yellow-600">👟 Sản phẩm</a>
                <a href="?url=cart/show" class="hover:text-yellow-600">🛒 Xem giỏ hàng</a>
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
                            <a href="?url=client/orderDetail/<?= $order['id'] ?>"
                                class="inline-block px-6 py-3 bg-blue-500 text-white font-bold rounded-lg hover:bg-blue-600 transition w-full md:w-auto text-center">
                                Xem chi tiết
                            </a>

                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- Thêm nút quay lại trang chủ -->
        <div class="mt-8 text-center">
            <a href="?url=client/home" class="inline-block px-6 py-3 bg-green-600 text-white font-bold rounded-lg hover:bg-green-700 transition">Quay lại trang chủ</a>
        </div>
    </div>
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