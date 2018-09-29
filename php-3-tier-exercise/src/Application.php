<?php
namespace App;
use App\Util\Util;

class Application
{
    public function run()
    {
        $util = new Util();
        $controller = $util->getData('controller');
        $actionName = $util->getData('action').'Action';
        session_start();
        
        $controllerClass = "App\\Controller\\" . ucfirst($controller) . "Controller";
        if (class_exists($controllerClass)) {
            $controller = new $controllerClass();
        }else{
            throw new \Exception('Controller不存在'); 
        }
        if (is_callable(array($controller,$actionName))) {
            $controller->{$actionName}();
        } else {
            throw new \Exception('Action不存在');
        }
    }
}
