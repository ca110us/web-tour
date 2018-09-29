<?php
use App\Lib\CommonLib;
require 'vendor/autoload.php';
$controller = $_GET['controller'];
$actionName=$_GET['action'].'Action';
session_start();
// set_exception_handler("ErrorException");
$controllerClass = "App\\Controller\\" . ucfirst($controller) . "Controller";
$controller = new $controllerClass();
if (is_callable(array($controller,$actionName))) {
    $controller->{$actionName}();
} else {
    echo "<b>错误:</b> " . '未找到对应Action : ' . $actionName;
}
// function ErrorException($exception)
// {
//     $CommonLib = new CommonLib();
//     $message = $exception->getMessage();
//     $message = $CommonLib->detailErrors($message);
//     echo "<b>错误:</b> ", $message;
// }
