<?php
namespace App\Controller;

class RegisterController extends BaseController
{
    public function indexAction()
    {
        $util = $this->util;
        $userModel = $this->userModel;
        $errMessage='';
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
            if (!$userModel->checkUser($userModel)) {
                $errMessage = '数据格式不正确，注册失败';
                echo $twig->render('register.html.twig', array(
                    'errMessage' => $errMessage
                ));
            } else {
                if (is_array($userModel->addUser($userModel))) {
                    $_SESSION['user']=$userModel->username;
                    $_SESSION['role']=$userModel->role;
                    $util->redirect('user', 'index');
                } else {
                    $errMessage = $userModel->addUser($userModel);
                    echo $twig->render('register.html.twig', array(
                        'errMessage' => $errMessage
                    ));
                }
            }
        } else {
            echo $twig->render('register.html.twig', array(
                'errMessage' => $errMessage
            ));
        }
    }
}
