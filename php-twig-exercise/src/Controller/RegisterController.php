<?php
namespace App\Controller;

class RegisterController extends BaseController
{
    public function indexAction()
    {
        $util = $this->util;
        $userModel = $this->userModel;
        $err_message='';
        $twig = $util->getTwig();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userModel->username = $util->getData('username');
            $userModel->password = md5($util->getData('password'));
            $userModel->realname = $util->getData('realname');
            $userModel->mail = $util->getData('mail');
            $userModel->age = $util->getData('age');
            $userModel->work = $util->getData('work');
            if ($userModel->work==0) {
                $userModel->org = $util->getData('schoolName');
            }
            if ($userModel->work==1) {
                $userModel->org = $util->getData('companyName');
            }
            $userModel->hobby = implode('#', $util->getData('hobby'));
            $userModel = $util->characterFilter($userModel);
            if (!$userModel->checkUser($userModel)) {
                $err_message = '数据格式不正确，注册失败';
                echo $twig->render('register.html.twig', array(
                    'err_message' => $err_message
                ));
            } else {
                if ($userModel->addUser($userModel)==null) {
                    $_SESSION['user']=$userModel->username;
                    $_SESSION['role']=$userModel->role;
                    $util->redirect('user', 'index');
                } else {
                    $err_message = $userModel->addUser($userModel);
                    echo $twig->render('register.html.twig', array(
                        'err_message' => $err_message
                    ));
                }
            }
        } else {
            echo $twig->render('register.html.twig', array(
                'err_message' => $err_message
            ));
        }
    }
}
