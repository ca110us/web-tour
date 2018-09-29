<?php
namespace App\Controller;

class AuthController extends BaseController
{
    public function loginAction()
    {
        $errMessage = '';
        $twig = $this->util->getTwig();
        $userModel = $this->userModel;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userModel->username = $this->util->getData('username');
            $userModel->password = $this->util->getData('password');
            if ($userModel->checkLogin($userModel)) {
                $userInfo = $userModel->getUserByUsername($userModel->username);
                $_SESSION['user']=$userInfo['username'];
                $_SESSION['userId']=$userInfo['id'];
                $_SESSION['role']=$userInfo['role'];
                $this->util->redirect('user', 'index');
            } else {
                $errMessage = '用户名或密码错误';
                echo $twig->render('login.html.twig', array(
                    'errMessage' => $errMessage
                ));
            }
        } else {
            echo $twig->render('login.html.twig', array(
                'errMessage' => $errMessage
            ));
        }
        if (isset($_SESSION['user'])) {
            $this->util->redirect('user', 'index');
        }
    }

    public function logoutAction()
    {
        unset($_SESSION['user']);
        unset($_SESSION['role']);
        unset($_SESSION['userId']);
        $this->util->redirect('auth', 'login');
    }
}
