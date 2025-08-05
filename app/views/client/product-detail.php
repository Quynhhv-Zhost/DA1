<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Chi tiết sản phẩm</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .product-image {
            max-height: 500px;
            width: 100%;
            object-fit: cover;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .form-select,
        .form-control {
            border-radius: 8px;
        }

        .product-card {
            border: 1px solid #ddd;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 30px;
            background-color: #fff;
        }
    </style>
</head>

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

    <div class="container my-5">
        <?php if (isset($data['product'])) :
            $p = $data['product'];
            $variations = $p['variations'] ?? [];
            if (empty($variations)) echo "<div class='alert alert-warning'>Sản phẩm chưa có biến thể!</div>";
            $colors = array_unique(array_column($variations, 'color'));
            $sizes = array_unique(array_column($variations, 'size'));
        ?>
            <div class="row justify-content-center">
                <div class="col-lg-10 product-card">
                    <div class="row g-5 align-items-center">
                        <!-- Hình ảnh -->
                        <div class="col-md-6 text-center">
                            <img src="/DA1/public/assets/images/<?= htmlspecialchars($p['image']) ?>" class="product-image img-fluid" alt="<?= htmlspecialchars($p['name']) ?>">
                        </div>

                        <!-- Thông tin sản phẩm -->
                        <div class="col-md-6">
                            <h2 class="fw-bold mb-3"><?= htmlspecialchars($p['name']) ?></h2>
                            <p class="fs-5 mb-2"><strong>Giá:</strong> <?= number_format($p['price'], 0, ',', '.') ?> VND</p>
                            <p class="mb-4"><?= nl2br(htmlspecialchars($p['description'])) ?></p>

                            <form method="POST" action="?url=cart/add">
                                <input type="hidden" name="product_id" value="<?= $p['id'] ?>">
                                <input type="hidden" id="variation_id" name="variation_id" value="">

                                <div class="row g-3 mb-3">
                                    <div class="col">
                                        <label class="form-label fw-semibold">Màu sắc:</label>
                                        <select id="colorSelect" class="form-select" required>
                                            <option value="">-- Chọn màu --</option>
                                            <?php foreach ($colors as $color) : ?>
                                                <option value="<?= htmlspecialchars($color) ?>"><?= ucfirst($color) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="col">
                                        <label class="form-label fw-semibold">Size:</label>
                                        <select id="sizeSelect" class="form-select" required>
                                            <option value="">-- Chọn size --</option>
                                            <?php foreach ($sizes as $size) : ?>
                                                <option value="<?= htmlspecialchars($size) ?>"><?= $size ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Số lượng:</label>
                                    <input type="number" name="quantity" value="1" min="1" class="form-control" required>
                                </div>

                                <div id="notFoundAlert" class="alert alert-warning d-none">Không có biến thể phù hợp</div>

                                <button type="submit" class="btn btn-primary w-100 mt-2 py-2 fs-5">Thêm vào giỏ</button>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- đánh giá sản phẩm -->
                <?php if (isset($_SESSION['user'])): ?>
                    <h4>Đánh giá sản phẩm</h4>
                    <form action="?url=review/store" method="POST">
                        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                        <input type="hidden" name="user_id" value="<?= $_SESSION['user']['id'] ?? 0 ?>">
                        <div class="mb-2">
                            <label for="rating">Số sao (1–5):</label>
                            <select name="rating" id="rating" required class="form-select w-auto">
                                <?php for ($i = 5; $i >= 1; $i--): ?>
                                    <option value="<?= $i ?>"><?= $i ?> ⭐</option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label for="comment">Bình luận:</label>
                            <textarea name="comment" id="comment" rows="3" class="form-control" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Gửi đánh giá</button>
                    </form>
                <?php else: ?>
                    <p class="text-danger">Vui lòng <a href="?url=client/showLoginForm">đăng nhập</a> để gửi đánh giá.</p>
                <?php endif; ?>

                <!-- danh sách người dùng đánh giá -->
                <?php if (!empty($data['reviews'])): ?>
                    <hr>
                    <h5 class="mt-4">Bình luận từ người dùng khác</h5>
                    <?php foreach ($data['reviews'] as $review): ?>
                        <div class="border p-3 rounded mb-3">
                            <div class="d-flex justify-content-between">
                                <strong><?= htmlspecialchars($review['username'] ?? 'Khách') ?></strong>
                                <span><?= str_repeat('⭐', (int)$review['rating']) ?></span>
                            </div>
                            <p class="mb-0"><?= nl2br(htmlspecialchars($review['comment'])) ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted mt-3">Chưa có đánh giá nào.</p>
                <?php endif; ?>


            </div>

            <script>
                const variations = <?= json_encode($variations) ?>;
                const colorSelect = document.getElementById('colorSelect');
                const sizeSelect = document.getElementById('sizeSelect');
                const variationInput = document.getElementById('variation_id');
                const notFound = document.getElementById('notFoundAlert');

                function updateVariation() {
                    const color = colorSelect.value;
                    const size = sizeSelect.value;
                    const found = variations.find(v => v.color === color && v.size === size);
                    if (found) {
                        variationInput.value = found.id;
                        notFound.classList.add('d-none');
                    } else {
                        variationInput.value = "";
                        if (color && size) notFound.classList.remove('d-none');
                        else notFound.classList.add('d-none');
                    }
                }
                colorSelect.addEventListener('change', updateVariation);
                sizeSelect.addEventListener('change', updateVariation);
            </script>

        <?php else : ?>
            <div class="alert alert-warning text-center">Không tìm thấy sản phẩm.</div>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>