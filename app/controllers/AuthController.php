<?php
class AuthController extends Controller
{
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $db = new Database();
            // Kiểm tra user trong database (đã có trường role)
            $user = $db->query(
                "SELECT * FROM users WHERE username = ? AND password = ?",
                [$username, md5($password)]
            )->fetch();

            if ($user) {
                if ($user['role'] === 'admin') {
                    // Chỉ admin được set session admin!
                    $_SESSION['admin'] = [
                        'id' => $user['id'],
                        'username' => $user['username'],
                        'role' => $user['role']
                    ];
                    header("Location: ?url=product/index");
                } else {
                    // Nếu là user thường, thông báo không có quyền
                    $error = "Tài khoản của bạn không có quyền truy cập trang quản trị.";
                    $this->view("admin/login", ['error' => $error]);
                    return;
                }
                exit;
            } else {
                $error = "Tài khoản hoặc mật khẩu không đúng";
                $this->view("admin/login", ['error' => $error]);
            }
        } else {
            $this->view('admin/login');
        }
    }

    public function logout()
    {
        unset($_SESSION['admin']);
        session_destroy();
        header('Location: ?url=auth/login');
    }
}
