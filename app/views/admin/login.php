<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Đăng nhập quản trị </title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .login-box {
            max-width: 400px;
            margin: 80px auto;
            padding: 30px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #343a40;
        }

        footer {
            text-align: center;
            margin-top: 60px;
            color: #888;
        }
    </style>
</head>

<body>

    <div class="login-box">
        <h2>Đăng nhập quản trị</h2>

        <?php if (!empty($data['error'])) : ?>
            <div class="alert alert-danger"><?= $data['error'] ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Tên đăng nhập</label>
                <input type="text" name="username" id="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mật khẩu</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <div class="d-grid">
                <button class="btn btn-primary">Đăng nhập</button>
            </div>
        </form>
    </div>

    <footer>
        &copy; <?= date('Y') ?> Admin Panel
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>