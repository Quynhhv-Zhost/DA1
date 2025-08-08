<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <title>Kết quả tìm kiếm sản phẩm</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Segoe UI', sans-serif;
    }

    .search-header {
      text-align: center;
      padding: 40px 0;
    }

    .search-header h2 {
      font-size: 2.2rem;
      font-weight: bold;
      color: #1f2937;
    }

    .product-card {
      border: none;
      transition: all 0.3s ease;
      background: #fff;
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    }

    .product-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 6px 25px rgba(0, 0, 0, 0.1);
    }

    .product-card img {
      height: 220px;
      object-fit: cover;
    }

    .card-title {
      font-size: 1.1rem;
      font-weight: 600;
      color: #333;
      min-height: 48px;
    }

    .card-price {
      font-size: 1.1rem;
      color: #e63946;
      font-weight: bold;
    }

    .back-home {
      margin-top: 30px;
      text-align: center;
    }

    .btn-dark {
      background-color: #1f2937;
      border: none;
    }

    .btn-dark:hover {
      background-color: #111827;
    }
  </style>
</head>

<body>

  <div class="container">
    <div class="search-header">
      <h2>Kết quả tìm kiếm cho: "<span class="text-primary"><?= htmlspecialchars($query) ?></span>"</h2>
    </div>

    <?php if (empty($products)) : ?>
      <div class="alert alert-warning text-center">
        <i class="fas fa-search-minus fa-lg me-2"></i>Không tìm thấy sản phẩm nào phù hợp.
      </div>
    <?php else : ?>
      <div class="row g-4">
        <?php foreach ($products as $product) : ?>
          <div class="col-12 col-sm-6 col-md-4 col-lg-3">
            <div class="card product-card h-100">
              <img src="/DA1/code/public/assets/images/<?= htmlspecialchars($product['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($product['name']) ?>">
              <div class="card-body d-flex flex-column justify-content-between">
                <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>
                <p class="card-price"><?= number_format($product['price'], 0, ',', '.') ?> VND</p>
                <a href="?url=client/detail/<?= $product['id'] ?>" class="btn btn-dark mt-2 w-100"><i class="fas fa-eye me-1"></i> Xem chi tiết</a>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <div class="back-home">
      <a href="?url=client/home" class="btn btn-outline-secondary mt-5"><i class="fas fa-arrow-left me-2"></i>Quay lại trang chủ</a>
    </div>
  </div>

</body>

</html>