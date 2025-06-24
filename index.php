<?php
// Trong MVC 
// M - Model => tầng kết nối với csdl và thực thao tác với CSDL
// Thao tác (Thực câu lênh truy vấn, thêm, chỉnh sửa, xóa )
// include_once 'models/Model.php';
// Khởi tạo đối tượng
// $model = new Model();
// var_dump($model->getConnection());
include_once 'configs/env.php';
include_once 'configs/helper.php';
// $model = new Model();
// var_dump($model->getConnection());
// include 'views/product/add.php';
// điều hướng
$action = isset($_GET['action']) ? $_GET['action'] : '/';
switch ($action) {
    case '/':
        $controPro = new ProductController();
        $controPro->index();
        break;
    case 'add':
        $controPro = new ProductController();
        $controPro->create();
        break;
    case 'update':
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        $controPro = new ProductController();
        $controPro->update($id);
        break;
    case 'delete':
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        $controPro = new ProductController();
        $controPro->delete($id);
        break;
    default:
        http_response_code(404);
        echo "Đường dẫn không tồn tại";
        break;
}
