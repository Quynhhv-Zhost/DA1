<?php
class ProductController
{
    // Hiện thị
    public function index()
    {
        // Gọi model tương ứng
        $modelPro = new Product();
        // var_dump($modelPro->getAllProduct());
        $products = $modelPro->getAllProduct();
        // Giao diện 
        include_once 'views/product/list.php';
    }
    public function create()
    {
        // Tiền hành xử lý thêm
        // var_dump($_POST);
        if (isset($_POST['btnSave'])) {
            // echo "1122";
            // nhận dữ liệu từ from
            $name = $_POST['name'];
            $price = $_POST['price'];
            $quantity = $_POST['quantity'];
            $image = $_FILES['image'];
            // var_dump($name);
            // var_dump($price);
            // var_dump($quantity);
            // var_dump($_FILES['image']);
            // Xử lý hình ảnh
            $targetDir = 'storage/uploads/';
            $newFileName = time() . "_" . basename($image['name']);
            $targetFile = $targetDir . $newFileName;
            move_uploaded_file($image['tmp_name'],  $targetFile);
            $modelPro = new Product();
            $modelPro->addProduct(null, $name, $price, $newFileName, $quantity);
            header("Location: index.php");
        }
        include_once 'views/product/add.php';
    }
    // Xóa 
    public function delete($id)
    {
        $modelPro = new Product();
        $modelPro->deleteProduct($id);
        header("Location: index.php");
    }
    // Sửa
    public function update($id)
    {
        // Hiển thị kết quả của
        $modelPro = new Product();
        $product = $modelPro->getIDProduct($id);
        if (isset($_POST['btnSave'])) {
            // echo "1122";
            // nhận dữ liệu từ from
            $name = $_POST['name'];
            $price = $_POST['price'];
            $quantity = $_POST['quantity'];
            $image = $_FILES['image'];
            // var_dump($name);
            // var_dump($price);
            // var_dump($quantity);
            // var_dump($_FILES['image']);
            if ($image['error'] == 0) {
                // Xử lý hình ảnh
                $targetDir = 'storage/uploads/';
                $newFileName = time() . "_" . basename($image['name']);
                $targetFile = $targetDir . $newFileName;
                move_uploaded_file($image['tmp_name'],  $targetFile);
            } else {
                $newFileName =  $product->image;
            }
            $modelPro = new Product();
            $modelPro->editProduct($name, $price, $newFileName, $quantity, $id);
            header("Location: index.php");
        }
        include_once 'views/product/edit.php';
    }
}
