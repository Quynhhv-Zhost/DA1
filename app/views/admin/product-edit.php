<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Chỉnh sửa sản phẩm - Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
        }

        .img-preview {
            max-width: 180px;
            max-height: 180px;
            border-radius: 10px;
            border: 1px solid #ddd;
            background: #fff;
            object-fit: cover;
        }

        .card {
            border-radius: 16px;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-7 col-md-9">
                <div class="card shadow-sm p-4">
                    <h3 class="mb-4 text-center">Chỉnh sửa sản phẩm</h3>

                    <?php if (!empty($data['errors'])) : ?>
                        <div class="alert alert-danger">
                            <?php foreach ($data['errors'] as $error) : ?>
                                <div>• <?= $error ?></div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="name" class="form-label">Tên sản phẩm</label>
                            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($data['product']['name']) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="price" class="form-label">Giá (VND)</label>
                            <input type="number" name="price" class="form-control" value="<?= $data['product']['price'] ?>" min="0" required>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Mô tả</label>
                            <textarea name="description" class="form-control" rows="4" required><?= htmlspecialchars($data['product']['description'] ?? '') ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Ảnh hiện tại</label><br>
                            <?php if (!empty($data['product']['image'])) : ?>
                                <img src="/DA1/code/public/assets/images/<?= htmlspecialchars($data['product']['image']) ?>" class="img-preview mb-2" alt="Ảnh hiện tại">
                            <?php else : ?>
                                <p class="text-muted">Chưa có ảnh</p>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Chọn ảnh mới (nếu muốn đổi)</label>
                            <input type="file" name="image" id="image" class="form-control">
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <button type="submit" class="btn btn-success px-4">💾 Lưu thay đổi</button>
                            <a href="?url=product/index" class="btn btn-secondary">⬅️ Quay lại</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-center mt-5">
        <div class="container">
            <small class="text-muted">&copy; <?= date('Y') ?> Admin Shop. All rights reserved.</small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>