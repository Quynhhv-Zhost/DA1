<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Quản trị hệ thống</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
        }

        .sidebar {
            background: #222;
            color: #fff;
            min-height: 100vh;
        }

        .sidebar a {
            color: #ccc;
            text-decoration: none;
            display: block;
            padding: 10px 20px;
        }

        .sidebar a.active,
        .sidebar a:hover {
            background: #0d6efd;
            color: #fff;
        }

        .logo {
            font-weight: bold;
            font-size: 1.3rem;
            padding: 16px 0;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-2 sidebar py-3">
                <div class="logo text-center mb-4">ADMIN PANEL</div>
                <a href="?url=product/index" class="<?= (strpos($_GET['url'] ?? '', 'product') !== false) ? 'active' : '' ?>">Sản phẩm</a>
                <a href="?url=order/index" class="<?= (strpos($_GET['url'] ?? '', 'order') !== false) ? 'active' : '' ?>">Đơn hàng</a>
                <a href="?url=user/index" class="<?= (strpos($_GET['url'] ?? '', 'user') !== false) ? 'active' : '' ?>">Người dùng</a>
                <hr>
                <a href="?url=auth/logout">Đăng xuất</a>
            </nav>
            <!-- Main Content -->
            <main class="col-md-10 px-4 py-4">
                <?php
                // Nạp view con tương ứng
                if (!empty($content)) require __DIR__ . '/' . basename($content);
                ?>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>