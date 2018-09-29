<?php
namespace App\Controller;
use App\Model\UserModel;
class AuthController
{
    public function loginAction()
    {
        $htmlTitle = '登陆';
        $userModel = new UserModel();
        $err_message = '';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $userInfo = $userModel->getUserByUsername($username);
            if (is_null($userInfo)) {
                $err_message = '该用户未注册';
                require 'templates/login.html.php';
            } elseif ($userInfo['password']==md5($password)) {
                $_SESSION['user']=$userInfo['username'];
                $_SESSION['userId']=$userInfo['id'];
                $_SESSION['role']=$userInfo['role'];
                header("Location:index.php?controller=user&action=index");
            } else {
                $err_message = '用户名或密码错误';
                require 'templates/login.html.php';
            }
        } else {
            require 'templates/login.html.php';
        }
        if (isset($_SESSION['user'])) {
            header("Location:index.php?controller=user&action=index");
        }
    }

    public function logoutAction()
    {
        unset($_SESSION['user']);
        unset($_SESSION['role']);
        unset($_SESSION['userId']);
        header("Location:index.php?controller=auth&action=login");
    }
}
