<?php
require 'classes/common-lib.class.php';
require 'classes/user-model.class.php';
define('SITE_PATH', dirname(__FILE__).'/');
$controllerName = $_GET['controller'];
$controllerPath = SITE_PATH . 'classes/' . $controllerName  . '-controller.class.php';
$className = $controllerName . 'Controller';
$actionName=$_GET['action'].'Action';
set_exception_handler("ErrorException");
session_start();
if (file_exists($controllerPath)) {
    require_once($controllerPath);
    $controller = new $className();
    if (is_callable(array($controller,$actionName))) {
        $controller->{$actionName}();
    } else {
        echo "<b>错误:</b> " . '未找到对应Action : ' . $actionName;
    }
} else {
    echo "<b>错误:</b> " . '未找到对应Controller : ' . $controllerPath;
}
function ErrorException($exception)
{
    $CommonLib = new CommonLib();
    $message = $exception->getMessage();
    $message = $CommonLib->detailErrors($message);
    echo "<b>错误:</b> ", $message;
}
