<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chi tiết sản phẩm - ZSneaker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background-color: #f8f9fa;
            color: #212529;
            font-family: 'Segoe UI', sans-serif;
        }

        header,
        .footer {
            background-color: #1f1f1f;
        }

        header a,
        .footer a,
        header .text-muted {
            color: #f8f9fa !important;
            text-decoration: none;
        }

        .product-image {
            height: 500px;
            object-fit: cover;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .product-info h2 {
            color: #343a40;
        }

        .section-title {
            font-size: 1.8rem;
            font-weight: bold;
            margin-top: 40px;
            color: #212529;
        }

        .review-box {
            background: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .footer a {
            color: #ccc;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        .star-rating i {
            color: gold;
        }

        .form-control,
        .form-select {
            background-color: #fff;
            border: 1px solid #ced4da;
            color: #212529;
        }

        .form-control:focus,
        .form-select:focus {
            background-color: #fff;
            color: #212529;
        }

        .alert-warning {
            background-color: #fff3cd;
            color: #856404;
            border-color: #ffeeba;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }
    </style>
</head>

<<<<<<< HEAD
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow">
        <div class="container">
            <a class="navbar-brand fw-bold text-warning" href="/">
                <i class="fas fa-shoe-prints me-2"></i> Sneaker Shop
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active" href="?url=client/home">🏠 Trang chủ</a></li>
                    <li class="nav-item"><a class="nav-link" href="?url=client/list">👟 Sản phẩm</a></li>
                    <li class="nav-item"><a class="nav-link" href="?url=client/about">📖 Giới thiệu</a></li>
                    <li class="nav-item"><a class="nav-link" href="?url=client/contact">📞 Liên hệ</a></li>
                    <li class="nav-item">

                        <?php if (isset($_SESSION['user']) && is_array($_SESSION['user']) && isset($_SESSION['user']['username'])) : ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user"></i> <?= htmlspecialchars($_SESSION['user']['username']) ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="?url=client/logout">Đăng xuất</a></li>
                        </ul>
                    </li>
                <?php else : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="?url=client/showLoginForm">
                            <i class="fas fa-user"></i> Đăng nhập
                        </a>
                    </li>
                <?php endif; ?>
                </ul>
            </div>
    </nav>
=======
<body>
    <?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
    <header class="border-bottom shadow-sm sticky-top">
        <div class="container py-2 d-flex justify-content-between align-items-center">
            <a href="?url=client/home" class="text-danger fw-bold h4 m-0"><i class="fas fa-shoe-prints me-2"></i>ZSneaker</a>
            <nav>
                <a href="?url=client/home" class="me-3 text-decoration-none">Trang chủ</a>
                <a href="?url=client/product" class="me-3 text-decoration-none">Sản phẩm</a>
                <a href="?url=client/news" class="me-3 text-decoration-none">Tin tức</a>
                <a href="?url=client/contact" class="text-decoration-none">Liên hệ</a>
            </nav>
            <div>
                <?php if (isset($_SESSION['user']['username'])) : ?>
                    <span class="text-muted me-2"><i class="fas fa-user"></i> <?= htmlspecialchars($_SESSION['user']['username']) ?></span>
                    <a href="?url=client/logout" class="btn btn-outline-light btn-sm">Đăng xuất</a>
                <?php else : ?>
                    <a href="?url=client/showLoginForm" class="btn btn-warning btn-sm">Đăng nhập</a>
                <?php endif; ?>
            </div>
        </div>
    </header>
>>>>>>> ebe0897 (update asm1)

    <div class="container py-5">
        <?php if (isset($data['product'])) :
            $p = $data['product'];
            $variations = $p['variations'] ?? [];
            $colors = array_unique(array_column($variations, 'color'));
            $sizes = array_unique(array_column($variations, 'size'));
        ?>
<<<<<<< HEAD
            <div class="row justify-content-center">
                <div class="col-lg-10 product-card">
                    <div class="row g-5 align-items-center">
                        <!-- Hình ảnh -->
                        <div class="col-md-6 text-center">
                            <img src="/DA1/public/assets/images/<?= htmlspecialchars($p['image']) ?>" class="product-image img-fluid" alt="<?= htmlspecialchars($p['name']) ?>">
=======
            <div class="row justify-content-center align-items-center">
                <div class="col-md-6">
                    <img src="/DA1/code/public/assets/images/<?= htmlspecialchars($p['image']) ?>" class="product-image img-fluid" alt="<?= htmlspecialchars($p['name']) ?>">
                </div>
                <div class="col-md-6 product-info">
                    <h2><?= htmlspecialchars($p['name']) ?></h2>
                    <p><strong>Giá: </strong><span id="productPrice" class="text-danger fw-bold fs-4"><?= number_format($p['price'], 0, ',', '.') ?> VND</span></p>
                    <p><?= nl2br(htmlspecialchars($p['description'])) ?></p>
                    <form method="POST" action="?url=cart/add">
                        <input type="hidden" name="product_id" value="<?= $p['id'] ?>">
                        <input type="hidden" id="variation_id" name="variation_id" value="">
                        <div class="row g-3 mb-3">
                            <div class="col">
                                <label class="form-label fw-semibold">Màu sắc</label>
                                <select id="colorSelect" class="form-select" required>
                                    <option value="">-- Chọn màu --</option>
                                    <?php foreach ($colors as $color) : ?>
                                        <option value="<?= htmlspecialchars($color) ?>"><?= ucfirst($color) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col">
                                <label class="form-label fw-semibold">Size</label>
                                <select id="sizeSelect" class="form-select" required>
                                    <option value="">-- Chọn size --</option>
                                    <?php foreach ($sizes as $size) : ?>
                                        <option value="<?= htmlspecialchars($size) ?>"><?= $size ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
>>>>>>> ebe0897 (update asm1)
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Số lượng</label>
                            <input type="number" name="quantity" value="1" min="1" class="form-control" required>
                        </div>
                        <div id="notFoundAlert" class="alert alert-warning d-none">Không có biến thể phù hợp</div>
                        <button class="btn btn-danger w-100">Thêm vào giỏ hàng</button>
                    </form>
                </div>
            </div>

            <div class="section-title">Đánh giá</div>
            <div class="review-box mb-4">
                <p><strong>Nguyễn Văn A</strong> <span class="star-rating">★★★★★</span></p>
                <p>Giày chất lượng, giao hàng nhanh!</p>
                <hr>
                <p><strong>Lê Thị B</strong> <span class="star-rating">★★★★☆</span></p>
                <p>Size chuẩn, màu đúng như hình. Sẽ quay lại mua lần sau.</p>
            </div>

            <div class="section-title">Bình luận</div>
            <form class="review-box mb-5">
                <div class="mb-3">
                    <label class="form-label">Nội dung bình luận</label>
                    <textarea class="form-control" rows="3" placeholder="Viết bình luận của bạn..."></textarea>
                </div>
                <button class="btn btn-dark">Gửi bình luận</button>
            </form>
        <?php else : ?>
            <div class="alert alert-warning">Không tìm thấy sản phẩm.</div>
        <?php endif; ?>
    </div>
    <footer class="bg-light text-dark py-5 border-top">
        <div class="container">
            <div class="row">
                <!-- Cột 1: Về Uniqlo -->
                <div class="col-md-3">
                    <h6 class="fw-bold">Về Uniqlo</h6>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-dark text-decoration-none">Thông tin</a></li>
                        <li><a href="#" class="text-dark text-decoration-none">Danh sách cửa hàng</a></li>
                        <li><a href="#" class="text-dark text-decoration-none">Cơ hội nghề nghiệp</a></li>
                    </ul>
                </div>

                <!-- Cột 2: Trợ giúp -->
                <div class="col-md-3">
                    <h6 class="fw-bold">Trợ giúp</h6>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-dark text-decoration-none">FAQ</a></li>
                        <li><a href="#" class="text-dark text-decoration-none">Chính sách trả hàng</a></li>
                        <li><a href="#" class="text-dark text-decoration-none">Chính sách bảo mật</a></li>
                        <li><a href="#" class="text-dark text-decoration-none">Tiếp cận</a></li>
                    </ul>
                </div>

                <!-- Cột 3: Tài khoản -->
                <div class="col-md-3">
                    <h6 class="fw-bold">Tài khoản</h6>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-dark text-decoration-none">Tư cách thành viên</a></li>
                        <li><a href="#" class="text-dark text-decoration-none">Hồ sơ</a></li>
                        <li><a href="#" class="text-dark text-decoration-none">Coupons</a></li>
                    </ul>
                </div>

                <!-- Cột 4: Bản tin điện tử -->
                <div class="col-md-3">
                    <h6 class="fw-bold">Bản tin điện tử</h6>
                    <p class="small">
                        Đăng ký ngay để nhận thông tin về sản phẩm mới, chương trình khuyến mãi & sự kiện.
                    </p>
                    <a href="#" class="fw-bold text-dark">ĐĂNG KÝ NGAY</a>
                </div>
            </div>

            <hr class="border-dark my-4" />

            <!-- Tài khoản xã hội -->
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="mb-0 small">
                        Cài đặt cookies |
                        <a href="#" class="text-dark text-decoration-none">English</a> |
                        <a href="#" class="text-dark text-decoration-none">Tiếng Việt</a>
                    </p>
                </div>
                <div>
                    <a href="#" class="text-dark me-3"><i class="fab fa-facebook fa-lg"></i></a>
                    <a href="#" class="text-dark me-3"><i class="fab fa-instagram fa-lg"></i></a>
                    <a href="#" class="text-dark me-3"><i class="fab fa-youtube fa-lg"></i></a>
                    <a href="#" class="text-dark"><i class="fab fa-tiktok fa-lg"></i></a>
                </div>
            </div>

            <hr class="border-dark my-4" />

            <!-- Bản quyền -->
            <div class="text-center">
                <p class="mb-0 small">BẢN QUYỀN THUỘC CÔNG TY TNHH UNIQLO. BẢO LƯU MỌI QUYỀN.</p>
            </div>
        </div>
    </footer>

    <footer class="footer text-center text-light py-4">
        <div class="container">
            <p class="mb-2">&copy; <?= date('Y') ?> ZSneaker. All rights reserved.</p>
            <div>
                <a href="?url=client/home">Trang chủ</a> |
                <a href="?url=client/product">Sản phẩm</a> |
                <a href="?url=client/news">Tin tức</a> |
                <a href="?url=client/contact">Liên hệ</a>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const variations = <?= json_encode($variations ?? []) ?>;
        const colorSelect = document.getElementById('colorSelect');
        const sizeSelect = document.getElementById('sizeSelect');
        const variationInput = document.getElementById('variation_id');
        const notFound = document.getElementById('notFoundAlert');
        const productPrice = document.getElementById('productPrice');
        let defaultPrice = <?= $p['price'] ?? 0 ?>;
        const formatter = new Intl.NumberFormat('vi-VN', {
            style: 'currency',
            currency: 'VND'
        });
        productPrice.innerHTML = formatter.format(defaultPrice);

        function updateVariation() {
            const color = colorSelect.value;
            const size = sizeSelect.value;
            const found = variations.find(v => v.color === color && v.size === size);
            if (found) {
                variationInput.value = found.id;
                notFound.classList.add('d-none');
                let priceDiff = parseFloat(found.price_diff);
                if (isNaN(priceDiff) || priceDiff < 0) priceDiff = 0;
                const finalPrice = defaultPrice + priceDiff;
                productPrice.innerHTML = formatter.format(finalPrice);
            } else {
                variationInput.value = "";
                if (color && size) notFound.classList.remove('d-none');
                else notFound.classList.add('d-none');
            }
        }
        colorSelect?.addEventListener('change', updateVariation);
        sizeSelect?.addEventListener('change', updateVariation);
    </script>
</body>

</html>