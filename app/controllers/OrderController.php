<?php
class OrderController extends Controller
{
    public function index()
    {
        $this->checkAdmin();
        $orderModel = $this->model('Order');
        $orders = $orderModel->getAllOrders();
        $this->view('admin/order-list', ['orders' => $orders]);
    }

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

    private function checkAdmin()
    {
        if (!isset($_SESSION['admin'])) {
            header('Location: ?url=auth/login');
            exit;
        }
    }
}
