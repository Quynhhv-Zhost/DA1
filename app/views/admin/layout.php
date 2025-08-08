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
      margin: 0;
      padding: 0;
    }

    .sidebar {
      background-color: #343a40;
      min-height: 100vh;
      padding-top: 20px;
    }

    .sidebar .logo {
      font-weight: bold;
      font-size: 1.5rem;
      color: #fff;
      text-align: center;
      margin-bottom: 30px;
    }

    .sidebar a {
      color: #ccc;
      text-decoration: none;
      display: block;
      padding: 10px 20px;
      transition: 0.2s;
    }

    .sidebar a.active,
    .sidebar a:hover {
      background-color: #0d6efd;
      color: #fff;
    }

    main {
      background-color: #fff;
      border-radius: 8px;
      min-height: 100vh;
    }
  </style>
</head>

<body>
<<<<<<< Updated upstream
  <div class="container-fluid">
    <div class="row">
      <!-- Sidebar -->
      <nav class="col-md-2 sidebar">
        <div class="logo">ADMIN PANEL</div>
        <a href="?url=product/index" class="<?= (strpos($_GET['url'] ?? '', 'product') !== false) ? 'active' : '' ?>">
          Sản phẩm
        </a>
        <a href="?url=order/index" class="<?= (strpos($_GET['url'] ?? '', 'order') !== false) ? 'active' : '' ?>">
          Đơn hàng
        </a>
        <a href="?url=user/index" class="<?= (strpos($_GET['url'] ?? '', 'user') !== false) ? 'active' : '' ?>">
          Người dùng
        </a>
        <hr class="border-light mx-3">
        <a href="?url=auth/logout">Đăng xuất</a>
      </nav>

      <!-- Main Content -->
      <main class="col-md-10 p-4">
        <?php
        if (!empty($content) && file_exists($content)) {
          require $content;
        } else {
          echo '<div class="alert alert-warning">Không tìm thấy nội dung!</div>';
        }
        ?>
      </main>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
=======
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-2 sidebar py-3">
                <div class="logo text-center mb-4">ADMIN PANEL</div>
                <a href="?url=product/index" class="<?= (strpos($_GET['url'] ?? '', 'product') !== false) ? 'active' : '' ?>">Sản phẩm</a>
                <a href="?url=order/index" class="<?= (strpos($_GET['url'] ?? '', 'order') !== false) ? 'active' : '' ?>">Đơn hàng</a>
                <a href="?url=user/index" class="<?= (strpos($_GET['url'] ?? '', 'user') !== false) ? 'active' : '' ?>">Người dùng</a>
                <a href="?url=chat/adminSupport" class="<?= (strpos($_GET['url'] ?? '', 'chat/adminSupport') !== false) ? 'active' : '' ?>">
                    🛟 Hỗ Trợ
                </a>
                <hr>
                <a href="?url=auth/logout">Đăng xuất</a>
            </nav>
            <!-- Main Content -->
            <main class="col-md-10 px-4 py-4">
                <?php
                if (!empty($content) && file_exists($content)) {
                    require $content;
                }
                ?>
            </main>
        </div>
        <!-- chat popup cho trang chủ -->

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Load SweetAlert2 trước -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



>>>>>>> Stashed changes
</body>

</html>