<?php
$controller = $_GET['controller'];
$actionName=$_GET['action'].'Action';
define('SITE_PATH', dirname(__FILE__).'/');
session_start();
set_exception_handler("ErrorException");
spl_autoload_register(function ($class) {
    if(strstr($class,'Controller')){
        $class = findClass($class,'controller');
    }
    if(strstr($class,'Model')){
        $class = findClass($class,'model');
    }
    if(strstr($class,'Lib')){
        $class = findClass($class,'lib');
    }
    include 'classes/' . $class . '.class.php';
});
$controllerClass = "App\\Controller\\" . ucfirst($controller) . "Controller";
$controllerPath = SITE_PATH . 'classes/' . $controller  . '-controller.class.php';
if (file_exists($controllerPath)) {
    $controller = new $controllerClass();
    if (is_callable(array($controller,$actionName))) {
        $controller->{$actionName}();
    } else {
        echo "<b>错误:</b> " . '未找到对应Action : ' . $actionName;
    }
} else {
    echo "<b>错误:</b> " . '未找到对应Controller : ' . $controllerPath;
}
function findClass($class,$type)
{
    switch ($type) {
        case 'controller':
            $class = strtolower($class);
            $class = explode("\\",$class);
            $class = str_replace("controller","-controller",array_pop($class));
            return $class;
            break;
        case 'model':
            $class = strtolower($class);
            $class = explode("\\",$class);
            $class = str_replace("model","-model",array_pop($class));
            return $class;
        break;
        case 'lib':
            $class = strtolower($class);
            $class = explode("\\",$class);
            $class = str_replace("lib","-lib",array_pop($class));
            return $class;
            break;
        default:
            break;
    }
}
function ErrorException($exception)
{
    $CommonLib = new \App\Lib\CommonLib();
    $message = $exception->getMessage();
    $message = $CommonLib->detailErrors($message);
    echo "<b>错误:</b> ", $message;
}
