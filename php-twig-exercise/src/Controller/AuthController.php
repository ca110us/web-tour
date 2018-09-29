<?php
namespace App\Controller;

class AuthController extends BaseController
{
    public function loginAction()
    {
        $htmlTitle = '登陆';
        $err_message = '';
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
                $err_message = '用户名或密码错误';
                echo $twig->render('login.html.twig', array(
                    'htmlTitle' => $htmlTitle,
                    'err_message' => $err_message
                ));
            }
        } else {
            echo $twig->render('login.html.twig', array(
                'htmlTitle' => $htmlTitle,
                'err_message' => $err_message
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
