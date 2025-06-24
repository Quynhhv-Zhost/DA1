<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'web2041.02');
define('DB_OPTIONS', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"
]);
define('PATH_MODEL', 'models/');
define('PATH_CONTROLLER', 'controllers/');
// Tại sao lại cần phải định nghĩa các hằng số này?
// Mô phỏng lại cái file .env trong thư viện
// Dùng hằng để chỉ thay đổi giá trị tại hằng
