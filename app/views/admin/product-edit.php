<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Chỉnh sửa sản phẩm - Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding-top: 70px;
        }

        footer {
            background: #343a40;
            color: white;
            padding: 20px 0;
            margin-top: 40px;
        }

        .img-preview {
            max-height: 120px;
            object-fit: cover;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container-fluid px-4">
            <a class="navbar-brand" href="#">Admin Panel</a>
            <div class="d-flex">
                <a href="?url=auth/logout" class="btn btn-outline-light">Đăng xuất</a>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h3 class="mb-4">Chỉnh sửa sản phẩm</h3>

        <?php if (!empty($data['errors'])) : ?>
            <div class="alert alert-danger">
                <?php foreach ($data['errors'] as $error) : ?>
                    <div>• <?= $error ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data" class="card p-4 shadow-sm border rounded-3 bg-light">
            <div class="mb-3">
                <label for="name" class="form-label">Tên sản phẩm</label>
                <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($data['product']['name']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Giá (VND)</label>
                <input type="number" name="price" class="form-control" value="<?= $data['product']['price'] ?>" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Mô tả</label>
                <textarea name="description" class="form-control" rows="4"><?= htmlspecialchars($data['product']['description'] ?? '') ?></textarea>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Ảnh hiện tại</label><br>
                <?php if (!empty($data['product']['image'])) : ?>
                    <img src="/DA1/public/assets/images/<?= $data['product']['image'] ?>" class="img-preview mb-2" alt="Ảnh hiện tại">
                <?php else : ?>
                    <p class="text-muted">Chưa có ảnh</p>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Chọn ảnh mới (nếu muốn đổi)</label>
                <input type="file" name="image" class="form-control">
            </div>

            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">Cập nhật sản phẩm</button>
                <a href="?url=product/index" class="btn btn-secondary">⬅️ Quay lại</a>
            </div>
        </form>
    </div>

    <!-- Footer -->
    <footer class="text-center mt-5">
        <div class="container">
            <p>&copy; <?= date('Y') ?> Admin Shop. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>