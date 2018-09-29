<?php
namespace App\Controller;
class RegisterController
{
    public function indexAction()
    {
        $htmlTitle = '注册';
        $userModel = new \App\Model\UserModel();
        $err_message='';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userModel->username = $_POST['username'];
            $userModel->password = md5($_POST['password']);
            $userModel->realname = $_POST['realname'];
            $userModel->mail = $_POST['mail'];
            $userModel->age = $_POST['age'];
            $userModel->work = $_POST['work'];
            if (empty($_POST['schoolName'])) {
                $userModel->org = $_POST['companyName'];
            } else {
                $userModel->org = $_POST['schoolName'];
            }
            $userModel->hobby = implode('#', $_POST['hobby']);
            $CommonLib = new \App\Lib\CommonLib();
            $userModel = $CommonLib->characterFilter($userModel);
            if (!$userModel->checkUser($userModel)) {
                $err_message = '数据格式不正确，注册失败';
                require 'templates/register.html.php';
            } else {
                if ($userModel->addUser($userModel)==null) {
                    $_SESSION['user']=$userModel->username;
                    $_SESSION['role']=$userModel->role;
                    header("Location:index.php?controller=user&action=index");
                } else {
                    $err_message = $userModel->addUser($userModel);
                    require 'templates/register.html.php';
                }
            }
        } else {
            $htmlTitle = '注册';
            require 'templates/register.html.php';
        }
    }
}
