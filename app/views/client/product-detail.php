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
    <style>
        .star-display .star {
            color: #ccc;
            /* sao mặc định xám */
            font-size: 18px;
        }

        .star-display .star.active {
            color: #f39c12;
            /* sao được chọn vàng */
        }
    </style>

</head>

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

    <div class="container py-5">
        <?php if (isset($data['product'])) :
            $p = $data['product'];
            $variations = $p['variations'] ?? [];
            $colors = array_unique(array_column($variations, 'color'));
            $sizes = array_unique(array_column($variations, 'size'));
        ?>
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
            <br>
            <?php if (isset($_SESSION['user'])) : ?>
                <h4>Đánh giá sản phẩm</h4>
                <form action="?url=review/store" method="POST">
                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                    <input type="hidden" name="rating" id="rating-value" value="5"><!-- Mặc định 5 sao -->

                    <!-- Vùng chọn sao -->
                    <div class="mb-2">
                        <label>Chọn số sao:</label>
                        <div class="star-rating">
                            <?php for ($i = 1; $i <= 5; $i++) : ?>
                                <span class="star" data-value="<?= $i ?>">&#9733;</span>
                            <?php endfor; ?>
                        </div>
                    </div>

                    <div class="mb-2">
                        <label for="comment">Bình luận:</label>
                        <textarea name="comment" id="comment" rows="3" class="form-control" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Gửi đánh giá</button>
                </form>

                <!-- CSS cho sao -->
                <style>
                    .star-rating {
                        font-size: 28px;
                        color: #ccc;
                        cursor: pointer;
                    }

                    .star-rating .star.selected,
                    .star-rating .star.hover {
                        color: #f39c12;
                    }
                </style>

                <!-- JS xử lý click -->
                <script>
                    const stars = document.querySelectorAll('.star-rating .star');
                    const ratingValue = document.getElementById('rating-value');

                    stars.forEach(star => {
                        star.addEventListener('mouseover', function() {
                            resetStars();
                            highlightStars(this.dataset.value);
                        });
                        star.addEventListener('mouseout', function() {
                            resetStars();
                            highlightStars(ratingValue.value);
                        });
                        star.addEventListener('click', function() {
                            ratingValue.value = this.dataset.value;
                            resetStars();
                            highlightStars(ratingValue.value);
                        });
                    });

                    function highlightStars(count) {
                        stars.forEach(star => {
                            if (star.dataset.value <= count) {
                                star.classList.add('selected');
                            }
                        });
                    }

                    function resetStars() {
                        stars.forEach(star => star.classList.remove('selected'));
                    }

                    // Khởi tạo mặc định 5 sao
                    highlightStars(ratingValue.value);
                </script>
            <?php else : ?>
                <p class="text-danger">Vui lòng <a href="?url=client/showLoginForm">đăng nhập</a> để gửi đánh giá.</p>
            <?php endif; ?>
            <!-- ✅ Danh sách đánh giá -->
            <div id="review-list">
                <?php foreach ($data['reviews'] as $review) : ?>
                    <div class="border p-3 rounded mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <strong><?= htmlspecialchars($review['username'] ?? 'Khách') ?></strong>
                            <div class="star-display">
                                <?php for ($i = 1; $i <= 5; $i++) : ?>
                                    <span class="star <?= $i <= (int)$review['rating'] ? 'active' : '' ?>">&#9733;</span>
                                <?php endfor; ?>
                            </div>
                        </div>
                        <p class="mb-0"><?= nl2br(htmlspecialchars($review['comment'])) ?></p>
                        <small class="text-muted"><?= date('d/m/Y H:i', strtotime($review['created_at'])) ?></small>
                    </div>
                <?php endforeach; ?>
            </div>

            <?php if ($data['totalPages'] > 1) : ?>
                <nav>
                    <ul class="pagination">
                        <?php for ($i = 1; $i <= $data['totalPages']; $i++) : ?>
                            <li class="page-item">
                                <a href="#" class="page-link review-page" data-page="<?= $i ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </nav>
            <?php endif; ?>

            <script>
                const links = document.querySelectorAll('.review-page');
                const reviewList = document.getElementById('review-list');

                links.forEach(link => {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        const page = this.dataset.page;
                        fetch(`?url=review/paginate&product_id=<?= $p['id'] ?>&page=${page}`)
                            .then(res => res.text())
                            .then(html => {
                                reviewList.innerHTML = html;
                            });
                    });
                });
            </script>

        <?php else : ?>
            <div class="alert alert-warning">Không tìm thấy sản phẩm.</div>
        <?php endif; ?>
    </div>

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