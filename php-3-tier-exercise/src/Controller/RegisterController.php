<?php
namespace App\Controller;

class RegisterController extends BaseController
{
    public function indexAction()
    {
        $util = $this->util;
        $userService = $this->userService;
        $errMessage='';
        $twig = $util->getTwig();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userService->username = $util->getData('username');
            $userService->password = md5($util->getData('password'));
            $userService->realname = $util->getData('realname');
            $userService->mail = $util->getData('mail');
            $userService->age = $util->getData('age');
            $userService->work = $util->getData('work');
            if ($userService->work==0) {
                $userService->org = $util->getData('schoolName');
            }
            if ($userService->work==1) {
                $userService->org = $util->getData('companyName');
            }
            $userService->hobby = implode('#', $util->getData('hobby'));
            if (!$userService->checkUser($userService)) {
                $errMessage = '数据格式不正确，注册失败';
                echo $twig->render('register.html.twig', array(
                    'errMessage' => $errMessage
                ));
            } else {
                if (is_array($userService->addUser($userService))) {
                    $_SESSION['user']=$userService->username;
                    $_SESSION['role']=$userService->role;
                    $util->redirect('user', 'index');
                } else {
                    $errMessage = $userService->addUser($userService);
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
