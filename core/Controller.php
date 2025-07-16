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
        require_once "../app/views/$view.php";
    }
}
