<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <title>Trang Chủ - Cửa Hàng</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .banner {
      background: url('/DA1/code/public/assets/images/banner.jpg') no-repeat center center;
      background-size: cover;
      height: 400px;
      margin-bottom: 30px;
    }


    .product-card {
      transition: transform 0.2s ease-in-out;
    }

    .product-card:hover {
      transform: scale(1.03);
    }

    /* about.css */

    h1.text-center {
      font-size: 2.5rem;
      color: #222;
      font-weight: 700;
    }

    .fw-bold {
      color: #333;
    }

    p {
      font-size: 1.05rem;
      color: #555;
      line-height: 1.7;
    }

    img.img-fluid {
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    i.fas {
      transition: transform 0.3s ease, color 0.3s ease;
    }

    i.fas:hover {
      transform: scale(1.2);
      color: #000;
    }

    .btn-outline-dark {
      border-radius: 30px;
      font-weight: 600;
      transition: 0.3s ease;
    }

    .btn-outline-dark:hover {
      background-color: #111;
      color: white;
    }


    footer {
      background: #333;
      color: white;
      padding: 20px 0;
      margin-top: 40px;
    }

    .arrow-btn {
      background-color: #f8f9fa;
      border: 1px solid #ccc;
      border-radius: 50%;
      width: 48px;
      height: 48px;
      font-size: 20px;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: background 0.3s;
    }

    .arrow-btn:hover {
      background-color: #e2e6ea;
    }

    .arrow-container {
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .arrow-wrapper {
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    @media (max-width: 768px) {
      .arrow-wrapper {
        flex-direction: column;
      }

      .arrow-btn {
        margin: 10px 0;
      }
    }
  </style>
</head>

<body>
  <!-- Bootstrap Carousel JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Navbar -->
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
  <!-- Dang nhap thanh cong -->
  <?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
  <?php if (isset($_SESSION['success'])) : ?>
    <script>
      Swal.fire({
        icon: 'success',
        title: '<?= htmlspecialchars($_SESSION['success'], ENT_QUOTES) ?>',
        showConfirmButton: false,
        timer: 2000
      });
    </script>
    <?php unset($_SESSION['success']); ?>
  <?php endif; ?>

  <h1 class="text-center mb-4">Về UNIQLO</h1>

  <div class="row align-items-center mb-5">
    <div class="col-md-6">
      <img src="/DA1/public/assets/images/banner1.png" class="img-fluid rounded shadow" alt="Uniqlo Store" />
    </div>
    <div class="col-md-6">
      <h3 class="fw-bold">Sứ mệnh của chúng tôi</h3>
      <p>
        UNIQLO không chỉ đơn thuần là thời trang. Chúng tôi mang đến những sản phẩm thiết yếu giúp cuộc sống trở nên thoải mái, tiện ích và tinh tế hơn. Với công nghệ vải tiên tiến và thiết kế tối giản, chúng tôi hướng tới việc mang lại giá trị thật cho mọi khách hàng.
      </p>
      <p>
        Chúng tôi tin rằng thời trang không chỉ là vẻ ngoài, mà còn là cách sống.
      </p>
    </div>
  </div>

  <div class="row text-center mb-5">
    <div class="col-md-4">
      <i class="fas fa-globe fa-3x text-primary mb-3"></i>
      <h5 class="fw-bold">Toàn cầu</h5>
      <p>UNIQLO có mặt tại hơn 25 quốc gia với hơn 2000 cửa hàng toàn cầu.</p>
    </div>
    <div class="col-md-4">
      <i class="fas fa-leaf fa-3x text-success mb-3"></i>
      <h5 class="fw-bold">Bền vững</h5>
      <p>Cam kết thời trang thân thiện với môi trường và tái chế vải cũ.</p>
    </div>
    <div class="col-md-4">
      <i class="fas fa-users fa-3x text-warning mb-3"></i>
      <h5 class="fw-bold">Con người</h5>
      <p>Tạo cơ hội việc làm và môi trường làm việc công bằng cho mọi người.</p>
    </div>
  </div>

  <div class="row mb-5">
    <div class="col-md-12 text-center">
      <h3 class="fw-bold">Giá trị cốt lõi</h3>
      <p class="lead">
        Chúng tôi lấy khách hàng làm trung tâm và không ngừng đổi mới để tạo ra giá trị bền vững.
      </p>
    </div>
  </div>

  <div class="text-center">
    <a href="?url=client/contact" class="btn btn-outline-dark px-4 py-2">Liên hệ với chúng tôi</a>
  </div>


  <!-- Footer -->
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

</body>

</html>