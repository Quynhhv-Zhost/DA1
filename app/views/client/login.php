<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Đăng nhập</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .form-error {
            color: red;
            font-size: 0.875rem;
        }
    </style>
</head>

<body class="bg-light">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow">
                    <div class="card-header text-center bg-primary text-white">
                        <h4>Đăng nhập người dùng</h4>
                    </div>
                    <div class="card-body">
                        <?php if (isset($error)) : ?>
                            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                        <?php endif; ?>
                        <form id="loginForm" method="POST" action="?url=client/login" novalidate>
                            <div class="mb-3">
                                <label class="form-label">Tài khoản</label>
                                <input type="text" class="form-control" id="username" name="username">
                                <div id="usernameError" class="form-error"></div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Mật khẩu</label>
                                <input type="password" class="form-control" id="password" name="password">
                                <div id="passwordError" class="form-error"></div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Đăng nhập</button>
                        </form>
                        <div class="text-center mt-3">
                            <a href="?url=client/showRegisterForm">Chưa có tài khoản? Đăng ký</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JS -->
    <script>
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            let isValid = true;

            // Lấy input
            const username = document.getElementById('username');
            const password = document.getElementById('password');

            // Lấy phần hiển thị lỗi
            const usernameError = document.getElementById('usernameError');
            const passwordError = document.getElementById('passwordError');

            // Reset lỗi
            usernameError.textContent = '';
            passwordError.textContent = '';

            // Validate username
            if (username.value.trim() === '') {
                usernameError.textContent = 'Vui lòng nhập tài khoản.';
                isValid = false;
            }

            // Validate password
            if (password.value.trim() === '') {
                passwordError.textContent = 'Vui lòng nhập mật khẩu.';
                isValid = false;
            }

            if (!isValid) {
                e.preventDefault(); // Chặn submit nếu lỗi
            }
        });
    </script>

</body>

</html>