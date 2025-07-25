<?php
class Controller
{
    // Load model (Product, User, etc.)
    public function model($model)
    {
        require_once "../app/models/$model.php";
        return new $model;
    }

    // Load view (admin/product-list, client/home)
    public function view($view, $data = [])
    {
        extract($data);

        // Nếu là view admin, nhưng KHÔNG phải trang login
        if (strpos($view, 'admin/') === 0 && $view !== 'admin/login') {
            $content = "../app/views/$view.php";
            require_once "../app/views/admin/layout.php";
        } else {
            require_once "../app/views/$view.php";
        }
    }
}
