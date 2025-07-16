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
                            <img src="/DA1/code/public/assets/images/<?= htmlspecialchars($p['image']) ?>" class="product-image img-fluid" alt="<?= htmlspecialchars($p['name']) ?>">
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>