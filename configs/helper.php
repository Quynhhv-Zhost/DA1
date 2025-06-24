<?php
if (!function_exists('storage')) {
    function storage($fileImage)
    {
        $scriptPath = str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
        return empty($fileImage) ? '' : $scriptPath . 'storage/uploads/' . $fileImage;
    }
}
spl_autoload_register(function ($class) {
    $fileName = "$class.php";

    $fileModel = PATH_MODEL . $fileName;
    $fileController   = PATH_CONTROLLER . $fileName;

    if (is_readable($fileModel)) {
        require_once $fileModel;
    } else if (is_readable($fileController)) {
        require_once $fileController;
    }
});
