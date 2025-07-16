<?php
class AuthController extends Controller
{
    // Hiển thị form đăng nhập
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            // Đơn giản: hardcoded admin
            $db = new Database();
            $user = $db->query("SELECT * FROM users WHERE username = ? AND password = ?", [$username, md5($password)])->fetch();

            if ($user) {
                $_SESSION['admin'] = $user['username'];
                header("Location: ?url=product/index");
                exit; // ❗ RẤT QUAN TRỌNG: giúp dừng chương trình ngay
            } else {
                $error = "Tài khoản hoặc mật khẩu không đúng";
                $this->view("admin/login", ['error' => $error]);
            }
        } else {
            $this->view('admin/login');
        }
    }

    // Đăng xuất
    public function logout()
    {
        unset($_SESSION['admin']);
        session_destroy();
        header('Location: ?url=auth/login');
    }
}
