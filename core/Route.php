<?php

class Route
{
    public function handleRequest()
    {
        // Lấy URL: ?url=product/add
        $url = isset($_GET['url']) ? $_GET['url'] : 'client/home';
        $arr = explode("/", trim($url, "/"));

        $controllerName = ucfirst($arr[0]) . 'Controller'; // ProductController
        $action = $arr[1] ?? 'index'; // phương thức
        $params = array_slice($arr, 2); // các tham số

        // Load controller tương ứng
        require_once "../app/controllers/$controllerName.php";
        $controller = new $controllerName();
        call_user_func_array([$controller, $action], $params);
    }
}
