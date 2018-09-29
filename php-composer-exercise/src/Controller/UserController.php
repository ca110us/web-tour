<?php
namespace App\Controller;
use App\Model\UserModel;
use App\Lib\CommonLib;
class UserController
{
    public function indexAction()
    {
        $htmlTitle = '用户管理';
        $userModel = new UserModel();
        $active = 'usersPage';
        if (isset($_SESSION['user'])) {
            $currentUser = $_SESSION['user'];
            $currentRole = $_SESSION['role'];
            if (isset($_SESSION['userId'])) {
                $currentUserId = $_SESSION['userId'];
            } else {
                $user = $userModel->getUserByUsername($currentUser);
                $currentUserId = $user['id'];
                $_SESSION['userId'] = $currentUserId;
            }
            require 'templates/users.html.php';
        } else {
            header("Location:index.php?controller=auth&action=login");
        }
    }

    public function showModalAction()
    {
        $userModel = new UserModel();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        } else {
            header('Content-type: text/html');
            $hobbyArrayMap = array(
                '#' => '/',
                'game' => '游戏',
                'football' => '足球',
                'basketball' => '篮球',
                'sing' => '唱歌',
                'dance' => '舞蹈',
                'music' => '听音乐',
                'novel' => '看小说',
                'movie' => '看电影',
                'bodybuilt' => '撸铁',
                'run' => '跑步'
            );
            $modalUserInfo = $userModel->getUserByUserId($_GET['userId']);
            foreach ($hobbyArrayMap as $hobbyEN => $hobbyCN) {
                $modalUserInfo['hobby'] = str_replace($hobbyEN, $hobbyCN, $modalUserInfo['hobby']);
            }
            require 'templates/user-show-modal.html.php';
        }
    }

    public function findUsersAction()
    {
        header('Content-type: application/json');
        $userModel = new UserModel();
        if (isset($_POST['userType'])) {
            $users = $userModel->findUsersByWork($_POST['userType'], $_POST['page']);
            $pages = $userModel->getPagesNumByWork($_POST['userType']);
            $data = array('data' => $users, 'pages'=>$pages);
            echo json_encode($data);
        }
    }

    public function addModalAction()
    {
        header('Content-type: application/json');
        $userModel = new UserModel();
        $CommonLib = new CommonLib();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $currentUser = $_SESSION['user'];
            $currentRole = $userModel->getUserByUsername($currentUser)['role'];
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
            if (is_null($currentUser)) {
                echo $CommonLib->returnJson('unlogin', '');
                exit();
            }
            if ($currentRole!=='admin') {
                echo $CommonLib->returnJson('forbidden', '');
                exit();
            }
            if (!is_null($userModel->isUserExist($userModel))) {
                $message = $userModel->isUserExist($userModel);
                echo $CommonLib->returnJson('error', $message);
            } else {
                if ($userModel->addUser($userModel)==null) {
                    echo $CommonLib->returnJson('success', '');
                } else {
                    echo $CommonLib->returnJson('error', '添加失败');
                }
            }
        } else {
            require 'templates/user-add-modal.html.php';
        }
    }

    public function editModalAction()
    {
        $userModel = new UserModel();
        $CommonLib = new CommonLib();
        $currentUserId = $_SESSION['userId'];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            header('Content-type: application/json');
            $currentUser = $_SESSION['user'];
            $currentRole = $userModel->getUserByUsername($currentUser)['role'];
            $userModel->id = $_POST['userId'];
            if (!isset($_POST['role'])) {
                $userModel->role = '';
            }else{
                $userModel->role = $_POST['role'];
            }
            $userModel->realname = $_POST['realname'];
            $userModel->mail = $_POST['mail'];
            $userModel->age = $_POST['age'];
            $userModel->work = $_POST['work2'];
            if (empty($_POST['schoolName'])) {
                $userModel->org = $_POST['companyName'];
            } else {
                $userModel->org = $_POST['schoolName'];
            }
            $userModel->hobby = implode('#', $_POST['hobby']);
            if (($currentRole!=='admin'&&$currentUserId!==$userModel->id)||($currentRole!=='admin'&&$userModel->role=="admin")) {
                echo $CommonLib->returnJson('forbidden', '');
            } elseif ($userModel->getUserByMail($userModel->mail)!=null&&$userModel->getUserByMail($userModel->mail)['id']!= $userModel->id) {
                echo $CommonLib->returnJson('error', $userModel->isUserExist($userModel));
            } else {
                $userModel->updateUser($userModel);
                echo $CommonLib->returnJson('success', '');
            }
        } else {
            header('Content-type: text/html');
            $modalUserInfo = $userModel->getUserByUserId($_GET['userId']);
            require 'templates/user-edit-modal.html.php';
        }
    }

    public function deleteAction()
    {
        header('Content-type: application/json');
        $userModel = new UserModel();
        $CommonLib = new CommonLib();
        $currentUser = $_SESSION['user'];
        $currentRole = $userModel->getUserByUsername($currentUser)['role'];
        $currentUserId = $_SESSION['userId'];
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            echo $CommonLib->returnJson('error', '请用POST提交！');
            exit();
        } else {
            if ($currentRole!=='admin') {
                echo $CommonLib->returnJson('forbidden', '');
            } elseif ($_POST['userId']==$currentUserId) {
                echo $CommonLib->returnJson('error', '不能删除当前登录账户');
            } else {
                $userModel->delUser($_POST['userId']);
                echo $CommonLib->returnJson('success', '');
            }
        }
    }

    public function checkUsernameAction()
    {
        header('Content-type: application/json');
        $userModel = new UserModel();
        $CommonLib = new CommonLib();
        if (isset($_POST['username'])) {
            $user = $userModel->getUserByUsername($_POST['username']);
            if (!empty($user)) {
                echo $CommonLib->returnJson('error', '');
            }else{
                echo $CommonLib->returnJson('success', '');
            }
        }
    }

    public function checkMailAction()
    {
        header('Content-type: application/json');
        $userModel = new UserModel();
        $CommonLib = new CommonLib();
        if (isset($_POST['mail'])) {
            $user = $userModel->getUserByMail($_POST['mail']);
            if (!empty($user)) {
                echo $CommonLib->returnJson('error', '');
            }else{
                echo $CommonLib->returnJson('success', '');
            }
        }
    }

}
