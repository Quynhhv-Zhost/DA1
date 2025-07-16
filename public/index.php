<?php
session_start(); // ❗ BẮT BUỘC để sử dụng $_SESSION
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Nạp file autoload và config
require_once '../config.php';
require_once '../core/Route.php';
require_once '../core/Controller.php';
require_once '../core/Database.php';

// Chạy route => điều hướng URL vào đúng controller/action
$route = new Route();
$route->handleRequest();
