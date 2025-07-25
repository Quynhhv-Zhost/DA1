<?php
class ProductController extends Controller
{
    public function index()
    {
        $this->checkAdmin();
        $productModel = $this->model('Product');
        $products = $productModel->getAll();
        // Gọi view con, KHÔNG gọi layout
        $this->view('admin/product-list', [
            'products' => $products
        ]);
    }

    public function add()
    {
        $this->checkAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);
            $price = floatval($_POST['price']);
            $description = trim($_POST['description']);
            $errors = [];

            if (empty($name)) $errors[] = "Tên sản phẩm không được để trống";
            if ($price <= 0) $errors[] = "Giá phải lớn hơn 0";

            $imageName = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $allowTypes = ['image/jpeg', 'image/png', 'image/jpg'];
                $fileType = $_FILES['image']['type'];
                if (!in_array($fileType, $allowTypes)) {
                    $errors[] = "Chỉ cho phép ảnh JPG/PNG";
                } else {
                    $uploadDir = 'public/assets/images/';
                    $originalName = pathinfo($_FILES['image']['name'], PATHINFO_FILENAME);
                    $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                    $cleanName = preg_replace('/[^a-zA-Z0-9_-]/', '_', $originalName);
                    $imageName = $cleanName . '.' . $extension;
                    $targetPath = $uploadDir . $imageName;
                    $i = 1;
                    while (file_exists($targetPath)) {
                        $imageName = $cleanName . "($i)." . $extension;
                        $targetPath = $uploadDir . $imageName;
                        $i++;
                    }
                    move_uploaded_file($_FILES['image']['tmp_name'], $targetPath);
                }
            }

            if (empty($errors)) {
                $this->model('Product')->insert([$name, $price, $description, $imageName]);
                header('Location: ?url=product/index');
                exit;
            } else {
                $this->view('admin/product-add', [
                    'errors' => $errors
                ]);
            }
        } else {
            $this->view('admin/product-add');
        }
    }

    public function edit($id)
    {
        $this->checkAdmin();
        $productModel = $this->model('Product');
        $product = $productModel->getById($id);

        if (!$product) die("Không tìm thấy sản phẩm");

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);
            $price = floatval($_POST['price']);
            $description = trim($_POST['description']);
            $errors = [];
            $imageName = $product['image'];

            if (empty($name)) $errors[] = "Tên sản phẩm không được để trống";
            if ($price <= 0) $errors[] = "Giá phải lớn hơn 0";

            if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                $allowTypes = ['image/jpeg', 'image/png', 'image/jpg'];
                $fileType = $_FILES['image']['type'];
                if (!in_array($fileType, $allowTypes)) {
                    $errors[] = "Chỉ cho phép ảnh JPG/PNG";
                } else {
                    $uploadDir = 'public/assets/images/';
                    $originalName = pathinfo($_FILES['image']['name'], PATHINFO_FILENAME);
                    $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                    $cleanName = preg_replace('/[^a-zA-Z0-9_-]/', '_', $originalName);
                    $imageName = $cleanName . '.' . $extension;
                    $targetPath = $uploadDir . $imageName;
                    $i = 1;
                    while (file_exists($targetPath)) {
                        $imageName = $cleanName . "($i)." . $extension;
                        $targetPath = $uploadDir . $imageName;
                        $i++;
                    }
                    move_uploaded_file($_FILES['image']['tmp_name'], $targetPath);
                }
            }

            if (empty($errors)) {
                $productModel->update($id, [$name, $price, $description, $imageName]);
                header('Location: ?url=product/index');
                exit;
            } else {
                $this->view('admin/product-edit', [
                    'product' => $product,
                    'errors' => $errors
                ]);
            }
        } else {
            $this->view('admin/product-edit', [
                'product' => $product
            ]);
        }
    }

    public function delete($id)
    {
        $this->checkAdmin();
        $this->model('Product')->delete($id);
        header('Location: ?url=product/index');
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
