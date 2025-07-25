<?php
class UserController extends Controller
{
  public function index()
  {
    $userModel = $this->model('User');
    $users = $userModel->getAllUsers();
    $this->view('admin/user-list', ['users' => $users]);
  }


  public function detail($id)
  {
    $userModel = $this->model('User');
    $user = $userModel->getUserById($id);
    if (!$user) {
      die("Không tìm thấy người dùng");
    }
    $this->view('admin/user-detail', ['user' => $user]);
  }

  public function delete($id)
  {
    $userModel = $this->model('User');
    $userModel->deleteUser($id);
    header('Location: ?url=user/index');
    exit;
  }
}
