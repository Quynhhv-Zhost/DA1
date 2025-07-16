<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Quản lý sản phẩm - Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding-top: 70px;
        }

        .table th,
        .table td {
            vertical-align: middle;
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

    <!-- Nội dung -->
    <div class="container mt-4">
        <h3 class="mb-4">Danh sách sản phẩm</h3>
        <a href="?url=product/add" class="btn btn-success mb-3">+ Thêm sản phẩm</a>

        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Ảnh</th>
                    <th>Tên</th>
                    <th>Giá</th>
                    <th>Mô tả</th>
                    <th style="width: 160px;">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $products = $data['products'];
                usort($products, function ($a, $b) {
                    return $a['id'] - $b['id'];
                });
                foreach ($products as $product) :
                ?>
                    <tr>
                        <td><?= $product['id'] ?></td>
                        <td>
                            <?php if (!empty($product['image'])) : ?>
                                <img src="/DA1/code/public/assets/images/<?= $product['image'] ?>" alt="Ảnh" width="80" height="60" style="object-fit: cover;">
                                <!-- <small><?= BASE_URL ?>assets/images/<?= $product['image'] ?></small> -->

                            <?php else : ?>
                                <span class="text-muted">Không ảnh</span>
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($product['name']) ?></td>
                        <td><?= number_format($product['price'], 0, ',', '.') ?> VND</td>
                        <td><?= htmlspecialchars($product['description'] ?? '-') ?></td>
                        <td>
                            <a href="?url=product/edit/<?= $product['id'] ?>" class="btn btn-sm btn-warning">Sửa</a>
                            <a href="?url=product/delete/<?= $product['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn xoá?')">Xoá</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <footer class="text-center">
        <div class="container">
            <p>&copy; <?= date('Y') ?> Admin Shop. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>