<?php
class ClientController extends Controller
{

    public function home()
    {
        $productModel = $this->model('Product');
        $products = $productModel->getAll();
        $this->view('client/home', ['products' => $products]);
    }
    public function detail($id)
    {
        $productModel = $this->model('Product');
        $product = $productModel->getById($id);

        $reviewModel = $this->model('Review');
        $limit = 3;

        // ✅ Luôn load trang 1 khi mở sản phẩm
        $reviews = $reviewModel->getReviewsByProductId((int)$id, $limit, 0);
        $totalReviews = $reviewModel->countReviewsByProductId((int)$id);
        $totalPages = ceil($totalReviews / $limit);

        $this->view('client/product-detail', [
            'product' => $product,
            'reviews' => $reviews,
            'totalPages' => $totalPages
        ]);
    }


    // ✅ Hiển thị form đăng nhập
    public function showLoginForm()
    {
        // $this->view('client/login');
        $this->view('client/login');
    }

    // ✅ Xử lý đăng nhập
    public function login()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        if (empty($username) || empty($password)) {
            $error = "Vui lòng nhập đầy đủ thông tin.";
            $this->view('client/login', ['error' => $error]);
            return;
        }

        $userModel = $this->model('User');
        $user = $userModel->getUserByUsername($username);

        if ($user && $user['role'] === 'user' && $user['password'] === md5($password)) {
            $_SESSION['user'] = $user;
            $_SESSION['success'] = "Đăng nhập thành công!";
            header('Location: ?url=client/home');
            exit;
        } else {
            $error = "Tài khoản hoặc mật khẩu không đúng.";
            $this->view('client/login', ['error' => $error]);
        }
    }
    public function logout()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        unset($_SESSION['user']); // Xóa session đăng nhập
        unset($_SESSION['success']);
        header('Location: ?url=client/home'); // Quay về trang chủ
        exit;
    }
    // ✅ Hiển thị form đăng ký
    public function showRegisterForm()
    {
        $this->view('client/register');
    }

    // ✅ Xử lý đăng ký
    public function register()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $username = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if (empty($username) || empty($password)) {
            $error = "Vui lòng nhập đầy đủ thông tin.";
            $this->view('client/register', ['error' => $error]);
            return;
        }

        $userModel = $this->model('User');
        $existing = $userModel->getUserByUsername($username);

        if ($existing) {
            $error = "Tài khoản đã tồn tại.";
            $this->view('client/register', ['error' => $error]);
            return;
        }

        $userModel->createUser($username, $password);
        $success = "Đăng ký thành công! Vui lòng đăng nhập.";
        $this->view('client/register', ['success' => $success]);
    }
    public function addToCart($id)
    {
        var_dump($_POST['variation_id']);
        exit;

        if (session_status() === PHP_SESSION_NONE) session_start();

        $productModel = $this->model('Product');
        $product = $productModel->getById($id);

        if (!$product) {
            header('Location: ?url=client/home');
            exit;
        }

        // Lấy thông tin biến thể từ POST (màu sắc và size)
        $variationId = $_POST['variation_id'] ?? null;

        // Tìm biến thể của sản phẩm
        $variation = null;
        if ($variationId) {
            foreach ($product['variations'] as $v) {
                if ($v['id'] == $variationId) {
                    $variation = $v;
                    break;
                }
            }
        }

        // Nếu không tìm thấy biến thể, điều hướng về trang chi tiết sản phẩm
        if (!$variation) {
            header('Location: ?url=client/product/detail/' . $id);
            exit;
        }

        // Tính giá cuối cùng của biến thể (giá gốc cộng với price_diff)
        $finalPrice = $product['price'] + $variation['price_diff'];
        // Khởi tạo giỏ hàng nếu chưa có
        if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

        $found = false;
        // Kiểm tra nếu sản phẩm và biến thể đã có trong giỏ hàng
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['id'] == $product['id'] && $item['variation_id'] == $variationId) {
                // Nếu đã có sản phẩm và biến thể trong giỏ hàng, tăng số lượng
                $item['quantity']++;
                $item['price'] = $finalPrice;  // Cập nhật giá biến thể
                $found = true;
                break;
            }
        }

        // Nếu không tìm thấy sản phẩm trong giỏ hàng, thêm mới
        if (!$found) {
            $_SESSION['cart'][] = [
                'id' => $product['id'],
                'name' => $product['name'],
                'price' => $finalPrice,  // Lưu giá cuối cùng của biến thể
                'image' => $product['image'],
                'quantity' => 1,
                'variation_id' => $variationId,
                'variation_name' => $variation['variation_name'],
                'final_price' => $finalPrice // Lưu giá cuối cùng
            ];
        }

        header('Location: ?url=client/cart');
        exit;
    }

    public function cart()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $this->view('client/cart', ['cart' => $_SESSION['cart'] ?? []]);
    }
    public function orderDetail($id)
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user'])) {
            header('Location: ?url=client/showLoginForm');
            exit;
        }

        $orderModel = $this->model('Order');
        $order = $orderModel->getOrderById($id, $_SESSION['user']['id']); // kiểm tra đúng user

        if (!$order) {
            die("Không tìm thấy đơn hàng hoặc bạn không có quyền xem đơn này.");
        }

        $this->view('client/orderDetail', ['order' => $order]);
    }
    public function orders()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user'])) {
            header('Location: ?url=client/showLoginForm');
            exit;
        }

        $orderModel = $this->model('Order');
        $userId = $_SESSION['user']['id'];

        // ✅ Lấy dữ liệu lọc
        $status = $_GET['status'] ?? null;
        $q = $_GET['q'] ?? null;

        // ✅ Truyền vào hàm lọc
        $orders = $orderModel->getOrdersByFilter($userId, $status, $q);

        $this->view('client/orders', ['orders' => $orders]);
    }

    public function updateDeliveryInfo($orderId)
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user'])) {
            header('Location: ?url=client/showLoginForm');
            exit;
        }

        $orderModel = $this->model('Order');
        $order = $orderModel->getOrderById($orderId, $_SESSION['user']['id']);
        if (!$order || $order['status'] !== 'preparing') {
            die("Không thể cập nhật đơn hàng này.");
        }

        $fullname = $_POST['fullname'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $province = $_POST['province'];
        $district = $_POST['district'];
        $address = $_POST['address'];
        $note = $_POST['note'];

        $orderModel->updateDeliveryInfo($orderId, $fullname, $email, $phone, $province, $district, $address, $note);
        header("Location: ?url=client/orderDetail/$orderId");
        exit;
    }
    private function checkLogin()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: ?url=client/login");
            exit;
        }
    }

    public function confirmReceived($id)
    {
        $this->checkLogin();
        $orderModel = $this->model('Order');

        // ⚠️ Sửa tại đây: thêm tham số thứ 2 là user_id
        $order = $orderModel->getOrderById($id, $_SESSION['user']['id']);

        if ($order && $order['status'] === 'delivered') {
            $orderModel->updateStatus($id, 'completed');
        }

        header("Location: ?url=client/orderDetail/$id");
        exit;
    }
    public function listOrders()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        $this->checkLogin();

        $orderModel = $this->model('Order');
        $userId = $_SESSION['user']['id'];

        // Nhận các tham số lọc
        $status = $_GET['status'] ?? null;
        $q = $_GET['q'] ?? null;

        // Gọi model
        $orders = $orderModel->getOrdersByFilter($userId, $status, $q);

        // Trả về view
        $this->view('client/orders', [
            'orders' => $orders
        ]);
    }
    public function search()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $q = $_GET['q'] ?? '';

        $productModel = $this->model('Product');
        $products = $productModel->searchProducts($q);

        $this->view('client/search-results', ['products' => $products, 'query' => $q]);
    }
}
