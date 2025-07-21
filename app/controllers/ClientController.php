<?php
class ClientController extends Controller
{
    public function home()
    {
        $productModel = $this->model('Product');
        // Lấy từ khóa tìm kiếm từ URL (thông qua biến $_GET), nếu không có thì gán chuỗi rỗng
        $search = $_GET['search'] ?? '';
        // Kiểm tra nếu người dùng có nhập từ khóa tìm kiếm
        if(!empty($search)){
            // Nếu có từ khóa tìm kiếm, gọi hàm searchByname trong model để tìm sản phẩm theo tên
            $products = $productModel->searchByname($search);
        }else{
            // Nếu không có từ khóa, lấy tất cả sản phẩm từ database
            $products = $productModel->getAll();
        }
                // Gọi view 'client/home' và truyền dữ liệu (danh sách sản phẩm và từ khóa tìm kiếm) vào view
        $this->view('client/home', [
            'products' => $products,
            'search' => $search
        ]);
    }
    //hàm chi tiết sản phẩm
    public function detail($id)
{
    $productModel = $this->model('Product');
    $product = $productModel->getById($id);

    if (!$product) {
        // Có thể chuyển hướng hoặc báo lỗi nếu không tìm thấy sản phẩm
        echo "Sản phẩm không tồn tại.";
        return;
    }

    $this->view('client/product-detail', [
        'product' => $product
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
        if (session_status() === PHP_SESSION_NONE) session_start();

        $productModel = $this->model('Product');
        $product = $productModel->getById($id);

        if (!$product) {
            header('Location: ?url=client/home');
            exit;
        }

        if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

        $found = false;
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['id'] == $product['id']) {
                $item['quantity']++;
                $found = true;
                break;
            }
        }

        if (!$found) {
            $_SESSION['cart'][] = [
                'id' => $product['id'],
                'name' => $product['name'],
                'price' => $product['price'],
                'image' => $product['image'],
                'quantity' => 1
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
        $orders = $orderModel->getOrdersByUser($_SESSION['user']['id']);

        $this->view('client/orders', ['orders' => $orders]);
    }
    public function contact()
    {
        $this->view('client/contact');
    }
    public function about()
    {
        $this->view('client/about');
    }
}
