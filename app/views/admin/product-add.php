<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Thêm sản phẩm - Admin</title>
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
        <h3 class="mb-4">Thêm sản phẩm mới</h3>
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
                <input type="text" name="name" class="form-control" placeholder="Nhập tên sản phẩm" required>
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Giá (VND)</label>
                <input type="number" name="price" class="form-control" placeholder="Nhập giá sản phẩm" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Mô tả</label>
                <textarea name="description" class="form-control" rows="4" placeholder="Thêm mô tả cho sản phẩm (tuỳ chọn)"></textarea>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Ảnh (jpeg, jpg, png)</label>
                <input type="file" name="image" class="form-control">
            </div>

            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-success">+ Thêm sản phẩm</button>
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
                     <?php include 'admin_chat.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>