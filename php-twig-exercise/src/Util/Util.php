<?php
namespace App\Util;

class Util
{
    public function returnJson($status, $message)
    {
        $returnMessage = array('status' => $status,'message'=>$message);
        return json_encode($returnMessage);
    }
    
    public function redirect($controller, $action)
    {
        header("Location:index.php?controller=" . $controller . "&action=" . $action);
    }

    public function getData($name)
    {
        $_GET = array_change_key_case($_GET, CASE_LOWER);
        $name = strtolower($name);
        $value = isset($_GET [$name]) ? $_GET [$name] : "";
        if ($value == "") {
            $_POST = array_change_key_case($_POST, CASE_LOWER);
            $value = isset($_POST [$name]) ? $_POST [$name] : "";
        }
        if ($value == "") {
            throw new \Exception($name . " can not be empty");
        }
        if (is_array($value)) {
            foreach ($value as $k => $v) {
                $v = trim($v);
            }
            return $value;
        }
        $value = trim($value);
        return $value;
    }

    public function getTwig()
    {
        $loader = new \Twig_Loader_Filesystem(dirname(dirname(dirname(__FILE__)))."/templates");
        $twig = new \Twig_Environment($loader, array());
        return $twig;
    }

    public function getDbh()
    {
        $mysqlConfig = require dirname(dirname(dirname(__FILE__)))."/config.php";
        $dbh = new \PDO("mysql:host={$mysqlConfig['host']};dbname={$mysqlConfig['dbname']}", $mysqlConfig['user'], $mysqlConfig['password'], array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES'utf8';"));
        $dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        return $dbh;
    }

    public function handleError($exception)
    {
        $twig = $this->getTwig();
        $errorFile = $exception->getFile();
        $errorMessage = $exception->getMessage();
        $errorLine = $exception->getLine();
        echo $twig->render('error.html.twig', array(
            'errorMessage' => $errorMessage,
            'errorFile' => $errorFile,
            'errorLine' => $errorLine
        ));
    }

    public function characterFilter($obj)
    {
        foreach ($obj as $key=>$val) {
            $obj->$key = str_replace("<", "#", $obj->$key);
            $obj->$key = str_replace(">", "#", $obj->$key);
        }
        return $obj;
    }
}
