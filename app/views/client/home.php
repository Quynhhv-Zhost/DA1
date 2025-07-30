<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Trang Chủ - Cửa Hàng</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- SweetAlert2 CSS & JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

<body>
    <!-- Bootstrap Carousel JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow">
        <div class="container">
            <a class="navbar-brand fw-bold text-warning" href="/">
                <i class="fas fa-shoe-prints me-2"></i> Sneaker Shop
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- tìm kiếm sản phẩm -->
                <form method="GET" action="" class="d-flex me-auto">
                    <input type="hidden" name="url" value="client/home">
                    <input type="text" name="search" class="form-control me-2"
                        placeholder="Tìm sản phẩm..."
                        value="<?= htmlspecialchars($data['search'] ?? '') ?>">
                    <button type="submit" class="btn btn-outline-light">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active" href="" ?url="?url=client/home">🏠 Trang chủ</a></li>
                    <li class="nav-item"><a class="nav-link" href="?url=client/list">👟 Sản phẩm</a></li>
                    <li class="nav-item"><a class="nav-link" href="?url=client/about">📖 Giới thiệu</a></li>
                    <li class="nav-item"><a class="nav-link" href="?url=client/contact">📞 Liên hệ</a></li>
                    <li class="nav-item"><a class="nav-link" href="?url=client/cart">🛒 Giỏ hàng</a></li>
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
    <!-- Dang nhap thanh cong -->
    <?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
    <?php if (isset($_SESSION['success'])) : ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: '<?= htmlspecialchars($_SESSION['success'], ENT_QUOTES) ?>',
                showConfirmButton: false,
                timer: 2000
            });
        </script>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>
    <!-- Banner -->
    <!-- Banner (Slideshow) -->
    <div id="bannerCarousel" class="carousel slide mb-4" data-bs-ride="carousel" data-bs-interval="3000">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="/DA1/public/assets/images/banner1.png" class="d-block w-100" style="height: 460px; object-fit: cover;" alt="Banner 1">
            </div>
            <div class="carousel-item">
                <img src="/DA1/public/assets/images/banner2.jpg" class="d-block w-100" style="height: 460px; object-fit: cover;" alt="Banner 2">
            </div>
            <div class="carousel-item">
                <img src="/DA1/public/assets/images/banner3.png" class="d-block w-100" style="height: 460px; object-fit: cover;" alt="Banner 3">
            </div>
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon bg-dark rounded-circle p-3"></span>
            <span class="visually-hidden">Trước</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#bannerCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon bg-dark rounded-circle p-3"></span>
            <span class="visually-hidden">Sau</span>
        </button>
    </div>



    <!-- Sản phẩm nổi bật -->
    <div class="container">
        <div class="container mt-5 text-center">
            <h1 class="display-4">Chào mừng đến Sneaker Shop</h1>
            <p class="lead">Khám phá các mẫu giày hot nhất hiện nay với giá cực hấp dẫn</p>
        </div>

        <!-- Vùng chứa sản phẩm và mũi tên -->
        <div class="arrow-wrapper">
            <!-- Nút trái -->
            <div class="arrow-container me-2">
                <button id="prevBtn" class="arrow-btn" aria-label="Trước">&laquo;</button>
            </div>

            <!-- Danh sách sản phẩm -->
            <div class="row g-4 flex-grow-1" id="productContainer">
                <!-- THÔNG BÁO NẾU KHÔNG TÌM THẤY SẢN PHẨM -->
                <?php if (empty($data['products'])) : ?>
                    <div class="col-12">
                        <div class="alert alert-warning text-center w-100">
                            Không tìm thấy sản phẩm nào phù hợp.
                        </div>
                    </div>
                <?php else : ?>
                <?php endif; ?>
                <?php foreach ($data['products'] as $product) : ?>
                    <div class="col-md-4 product-item">
                        <div class="card product-card h-100 shadow">
                            <img src="/DA1/public/assets/images/<?= htmlspecialchars($product['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($product['name']) ?>" style="height: 250px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>
                                <p class="card-text"><?= htmlspecialchars(mb_substr($product['description'], 0, 80)) ?>...</p>
                                <p class="fw-bold text-danger"><?= number_format($product['price'], 0, ',', '.') ?> VND</p>
                                <a href="?url=client/detail/<?= $product['id'] ?>" class="btn btn-outline-primary w-100">Xem chi tiết</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Nút phải -->
            <div class="arrow-container ms-2">
                <button id="nextBtn" class="arrow-btn" aria-label="Sau">&raquo;</button>
            </div>
        </div>
    </div>

    <!-- Footer -->
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


    <!-- JS -->
    <script>
        const items = document.querySelectorAll('.product-item');
        const perPage = 3;
        let currentPage = 0;
        const totalPages = Math.ceil(items.length / perPage);

        function showPage(page) {
            // Ẩn tất cả sản phẩm
            items.forEach((item, index) => {
                item.style.display = 'none';
            });

            // Hiển thị sản phẩm thuộc page hiện tại
            for (let i = 0; i < perPage; i++) {
                let itemIndex = (page * perPage + i) % items.length;
                items[itemIndex].style.display = 'block';
            }
        }

        document.getElementById('prevBtn').addEventListener('click', () => {
            currentPage = (currentPage - 1 + totalPages) % totalPages;
            showPage(currentPage);
        });

        document.getElementById('nextBtn').addEventListener('click', () => {
            currentPage = (currentPage + 1) % totalPages;
            showPage(currentPage);
        });

        showPage(currentPage); // Hiển thị trang đầu tiên
    </script>
    <!-- JS -->

</body>

</html>