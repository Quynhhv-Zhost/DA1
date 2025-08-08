<?php
class OrderController extends Controller
{
<<<<<<< Updated upstream
  public function index()
  {
    $this->checkAdmin();
    $orderModel = $this->model('Order');
    $orders = $orderModel->getAllOrders();
    $this->view('admin/order-list', ['orders' => $orders]);
  }
=======
    public function index()
    {
        $this->checkAdmin();
        $this->autoCompleteDeliveredOrders();
        $orderModel = $this->model('Order');
        $orders = $orderModel->getAllOrders();
        $this->view('admin/order-list', ['orders' => $orders]);
    }
>>>>>>> Stashed changes

  public function detail($id)
  {
    $this->checkAdmin();
    $orderModel = $this->model('Order');
    $order = $orderModel->getOrderByIdAdmin($id);
    if (!$order) {
      die("Không tìm thấy đơn hàng!");
    }
    $this->view('admin/order-detail', ['order' => $order]);
  }

<<<<<<< Updated upstream
  public function updateStatus($id)
  {
    $this->checkAdmin();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $status = $_POST['status'];
      $orderModel = $this->model('Order');
      $orderModel->updateStatus($id, $status);
      header("Location: ?url=order/detail/$id");
      exit;
    }
  }
=======
    public function updateStatus($id)
    {
        $this->checkAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $newStatus = $_POST['status'];
            $orderModel = $this->model('Order');
            $order = $orderModel->getOrderByIdAdmin($id);

            $validTransitions = [
                'pending'   => 'preparing',
                'preparing' => 'packed',
                'packed'    => 'shipping',
                'shipping'  => 'delivered',
            ];

            if (isset($validTransitions[$order['status']]) && $validTransitions[$order['status']] === $newStatus) {
                $orderModel->updateStatus($id, $newStatus);
            }

            header("Location: ?url=order/detail/$id");
            exit;
        }
    }
    private function autoCompleteDeliveredOrders()
    {
        $orderModel = $this->model('Order');
        $orderModel->autoCompleteDeliveredOrders();
    }


>>>>>>> Stashed changes

  private function checkAdmin()
  {
    if (!isset($_SESSION['admin'])) {
      header('Location: ?url=auth/login');
      exit;
    }
  }
}
