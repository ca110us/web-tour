<?php
use App\Util\Util;
error_reporting(0);
require 'vendor/autoload.php';
$controller = $_GET['controller'];
$actionName = $_GET['action'].'Action';
session_start();
set_exception_handler("ErrorException");
$controllerClass = "App\\Controller\\" . ucfirst($controller) . "Controller";
if (class_exists($controllerClass)) {
    $controller = new $controllerClass();
}else{
    throw new Exception('Controller不存在'); 
}
if (is_callable(array($controller,$actionName))) {
    $controller->{$actionName}();
} else {
    throw new Exception('Action不存在');
}
function ErrorException($exception)
{
    $util = new Util();
    $util->handleError($exception);
}
