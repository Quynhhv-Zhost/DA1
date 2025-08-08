<?php
class UserController extends Controller
{
  public function index()
  {
    $this->checkAdmin();
    $userModel = $this->model('User');

    $keyword = $_GET['keyword'] ?? '';

    if (!empty($keyword)) {
      $users = $userModel->searchByUsername($keyword);
    } else {
      $users = $userModel->all();
    }

    $this->view('admin/user-list', [
      'users' => $users,
      'keyword' => $keyword
    ]);
  }


  public function add()
  {
    $this->checkAdmin();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $username = trim($_POST['username']);
      $password = $_POST['password'];
      $role = $_POST['role'];
      $errors = [];

      if (empty($username)) $errors[] = "Tên đăng nhập không được để trống";
      if (strlen($password) < 6) $errors[] = "Mật khẩu phải ít nhất 6 ký tự";

      // ✅ Kiểm tra username đã tồn tại chưa
      $existingUser = $this->model('User')->getUserByUsername($username);
      if ($existingUser) {
        $errors[] = "Tên đăng nhập đã tồn tại. Vui lòng chọn tên khác.";
      }

      if (empty($errors)) {
        $this->model('User')->createUser($username, $password, $role);
        header('Location: ?url=user/index');
        exit;
      } else {
        $this->view('admin/user-add', [
          'errors' => $errors
        ]);
      }
    } else {
      $this->view('admin/user-add');
    }
  }


  public function edit($id)
  {
    $this->checkAdmin();
    $userModel = $this->model('User');
    $user = $userModel->find($id);

    if (!$user) die("Không tìm thấy người dùng");

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $username = trim($_POST['username'] ?? '');
      $role = $_POST['role'] ?? 'user';
      $password = $_POST['password'] ?? ''; // mới thêm
      $errors = [];

      if (empty($username)) $errors[] = "Tên đăng nhập không được để trống";

      $updateData = [
        'username' => $username,
        'role' => $role,
      ];

      // Nếu có nhập mật khẩu mới thì thêm vào dữ liệu cập nhật
      if (!empty($password)) {
        if (strlen($password) < 6) {
          $errors[] = "Mật khẩu phải ít nhất 6 ký tự";
        } else {
          $updateData['password'] = md5($password);
        }
      }

      if (empty($errors)) {
        $userModel->update($id, $updateData);
        header('Location: ?url=user/index');
        exit;
      } else {
        $this->view('admin/user-edit', [
          'user' => $user,
          'errors' => $errors
        ]);
      }
    } else {
      $this->view('admin/user-edit', [
        'user' => $user
      ]);
    }
  }
  public function delete($id)
  {
    $this->checkAdmin();
    try {
      $this->model('User')->delete($id);
      header('Location: ?url=user/index');
    } catch (Exception $e) {
      // Gửi lỗi ra view hoặc dùng session để flash message
      echo "<script>alert('{$e->getMessage()}');window.location.href='?url=user/index';</script>";
    }
  }


  private function checkAdmin()
  {
    if (session_status() === PHP_SESSION_NONE) session_start();
    if (!isset($_SESSION['admin'])) {
      header('Location: ?url=auth/login');
      exit;
    }
  }
}
