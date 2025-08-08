<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Trang Chủ - ZSneaker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f6f9;
        }

        .navbar-brand span {
            color: #dc3545;
            font-weight: bold;
        }

        .carousel-inner img {
            height: 500px;
            object-fit: cover;
        }

        .carousel-caption {
            background-color: rgba(0, 0, 0, 0.4);
            border-radius: 8px;
            padding: 20px;
        }

        .section-title {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 30px;
        }

        .product-card {
            transition: transform 0.2s ease-in-out;
        }

        .product-card:hover {
            transform: scale(1.03);
        }

        .category-card,
        .news-card {
            border-radius: 10px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
            background-color: white;
            text-align: center;
            padding: 20px;
        }

        .news-card img {
            height: 200px;
            width: 100%;
            object-fit: cover;
        }

        .footer {
            background-color: #212529;
            color: #fff;
            padding: 40px 0;
        }

        .footer a {
            color: white;
            margin-right: 10px;
        }

        .btn-cta {
            background-color: #dc3545;
            color: white;
            border-radius: 30px;
            padding: 12px 30px;
            font-weight: bold;
        }

        .btn-cta:hover {
            background-color: #c82333;
        }

        #productSliderInner {
            display: flex;
            width: 100%;
        }
    </style>
</head>

<body>
    <?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4 sticky-top">
        <a class="navbar-brand" href="?url=client/home"><i class="fas fa-shoe-prints"></i> <span>ZSneaker</span></a>
        <div class="d-flex justify-content-center flex-grow-1">
            <form class="d-flex" action="?url=client/search" method="GET" style="width: 400px;">
                <input type="hidden" name="url" value="client/search">
                <input class="form-control me-2" type="search" name="q" placeholder="Tìm sản phẩm..." aria-label="Search">
                <button class="btn btn-outline-light" type="submit"><i class="fas fa-search"></i></button>
            </form>
        </div>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link active" href="?url=client/home">Trang chủ</a></li>
                <li class="nav-item"><a class="nav-link" href="#category">Danh mục</a></li>
                <li class="nav-item"><a class="nav-link" href="#products">Sản phẩm</a></li>
                <li class="nav-item"><a class="nav-link" href="#news">Tin tức</a></li>
                <li class="nav-item"><a class="nav-link" href="#about">Giới thiệu</a></li>
                <li class="nav-item"><a class="nav-link" href="#contact">Liên hệ</a></li>
                <?php if (isset($_SESSION['user']['username'])) : ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="fas fa-user"></i> <?= htmlspecialchars($_SESSION['user']['username']) ?></a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="?url=cart/show"><i class="fa fa-shopping-cart me-2"></i>Giỏ hàng</a></li>
                            <li><a class="dropdown-item" href="?url=client/logout">Đăng xuất</a></li>
                        </ul>
                    </li>
                <?php else : ?>
                    <li class="nav-item"><a class="nav-link" href="?url=client/showLoginForm">Đăng nhập</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <!-- Banner Carousel -->
    <div id="bannerCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="1500" data-bs-pause="false">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="/DA1/code/public/assets/images/banner1.png" class="d-block w-100" alt="Banner 1">
                <div class="carousel-caption">
                    <h1>Chào mừng đến với ZSneaker</h1>
                    <p class="lead">Thế giới giày thể thao - Sneaker thời thượng chính hãng</p>
                    <a href="#products" class="btn btn-cta mt-3">Khám phá ngay</a>
                </div>
            </div>
            <div class="carousel-item">
                <img src="/DA1/code/public/assets/images/banner2.jpg" class="d-block w-100" alt="Banner 2">
                <div class="carousel-caption">
                    <h1>Khám phá BST mới</h1>
                    <p class="lead">Giảm giá đặc biệt cho khách hàng thân thiết</p>
                    <a href="#products" class="btn btn-cta mt-3">Xem ngay</a>
                </div>
            </div>
            <div class="carousel-item">
                <img src="/DA1/code/public/assets/images/banner3.png" class="d-block w-100" alt="Banner 3">
                <div class="carousel-caption">
                    <h1>Đừng bỏ lỡ siêu ưu đãi</h1>
                    <p class="lead">Giày chất lượng cao - giá tốt nhất</p>
                    <a href="#products" class="btn btn-cta mt-3">Mua ngay</a>
                </div>
            </div>
        </div>
    </div>

    <section class="container py-5" id="products">
        <h2 class="text-center section-title">Sản phẩm nổi bật</h2>
        <div id="productSlider" class="position-relative overflow-hidden">
            <div class="d-flex transition" id="productSliderInner">
                <?php $chunks = array_chunk($data['products'], 8);
                foreach ($chunks as $group) : ?>
                    <div class="w-100 flex-shrink-0 px-3">
                        <div class="row g-4">
                            <?php foreach ($group as $product) : ?>
                                <div class="col-md-3">
                                    <div class="card product-card h-100">
                                        <img src="/DA1/code/public/assets/images/<?= htmlspecialchars($product['image']) ?>" class="card-img-top">
                                        <div class="card-body">
                                            <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>
                                            <p class="text-danger fw-bold"><?= number_format($product['price'], 0, ',', '.') ?> VND</p>
                                            <a href="?url=client/detail/<?= $product['id'] ?>" class="btn btn-outline-dark w-100">Chi tiết</a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <footer class="footer mt-5" id="contact">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>ZSneaker</h5>
                    <p>Giày chính hãng - Phong cách trẻ trung - Phù hợp mọi đối tượng.</p>
                </div>
                <div class="col-md-4">
                    <h5>Liên hệ</h5>
                    <p>Email: support@zsneaker.vn</p>
                    <p>Hotline: 1900 8888</p>
                </div>
                <div class="col-md-4">
                    <h5>Kết nối</h5>
                    <a href="#"><i class="fab fa-facebook fa-lg"></i></a>
                    <a href="#"><i class="fab fa-instagram fa-lg"></i></a>
                    <a href="#"><i class="fab fa-youtube fa-lg"></i></a>
                </div>
            </div>
            <hr>
            <p class="text-center mb-0">&copy; <?= date('Y') ?> ZSneaker. All rights reserved.</p>
        </div>

    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const slider = document.getElementById("productSliderInner");
        const slides = slider.children.length;
        let index = 0;
        let interval;

        function showSlide(i) {
            slider.style.transform = `translateX(-${i * 100}%)`;
            slider.style.transition = "transform 0.6s ease-in-out";
        }

        function startSlider() {
            interval = setInterval(() => {
                index = (index + 1) % slides;
                showSlide(index);
            }, 2000);
        }

        function stopSlider() {
            clearInterval(interval);
        }
        document.getElementById("productSlider").addEventListener("mouseenter", stopSlider);
        document.getElementById("productSlider").addEventListener("mouseleave", startSlider);
        startSlider();
    </script>
    <!-- Load SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Chat popup -->
    <?php include 'C:/laragon/www/DA1/app/views/client/chat_popup.php'; ?>



</body>

</html>