<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Thanh toán đơn hàng</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .banner {
            background: url('/DA1/code/public/assets/images/banner.jpg') no-repeat center center;
            background-size: cover;
            height: 400px;
            margin-bottom: 30px;
        }


        .product-card {
            transition: transform 0.2s ease-in-out;
        }

        .product-card:hover {
            transform: scale(1.03);
        }

        footer {
            background: #333;
            color: white;
            padding: 20px 0;
            margin-top: 40px;
        }

        .arrow-btn {
            background-color: #f8f9fa;
            border: 1px solid #ccc;
            border-radius: 50%;
            width: 48px;
            height: 48px;
            font-size: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.3s;
        }

        .arrow-btn:hover {
            background-color: #e2e6ea;
        }

        .arrow-container {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .arrow-wrapper {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        @media (max-width: 768px) {
            .arrow-wrapper {
                flex-direction: column;
            }

            .arrow-btn {
                margin: 10px 0;
            }
        }
    </style>
</head>

<body class="bg-gray-100">
    <!-- Navbar -->
    <nav class="bg-gray-900 text-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <a href="/" class="text-2xl font-bold text-yellow-500">Sneaker Shop</a>
            <div class="space-x-4 text-gray-700 font-medium">
                <a href="?url=client/home" class="hover:text-yellow-600">🏠 Trang chủ</a>
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