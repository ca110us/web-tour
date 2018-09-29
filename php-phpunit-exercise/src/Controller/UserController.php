<?php
namespace App\Controller;

class UserController extends BaseController
{
    public function indexAction()
    {
        $util = $this->util;
        $userModel = $this->userModel;
        $active = 'usersPage';
        $twig = $util->getTwig();
        if (!isset($_SESSION['user'])) {
            $util->redirect('auth', 'login');
            return;
        }
        $currentUser = $_SESSION['user'];
        $currentRole = $_SESSION['role'];
        if (isset($_SESSION['userId'])) {
            $currentUserId = $_SESSION['userId'];
        } else {
            $user = $userModel->getUserByUsername($currentUser);
            $currentUserId = $user['id'];
            $_SESSION['userId'] = $currentUserId;
        }
        echo $twig->render('users.html.twig', array(
            'currentRole' => $currentRole,
            'currentUser' => $currentUser,
            'currentUserId' => $currentUserId,
            'active' => $active,
        ));
    }

    public function showModalAction()
    {
        $util = $this->util;
        $userModel = $this->userModel;
        $twig = $util->getTwig();
        header('Content-type: text/html');
        $modalUserInfo = $userModel->getUserByUserId($util->getData('userId'));
        echo $twig->render('user-show-modal.html.twig', array(
            'modalUserInfo' => $modalUserInfo
        ));
    }

    public function findUsersAction()
    {
        header('Content-type: application/json');
        $util = $this->util;
        $userModel = $this->userModel;
        $userType = $util->getData('userType');
        $page = $util->getData('page');
        $limit = $util->getData('limit');
        $users = $userModel->findUsersByWork($userType, $page, $limit);
        $pages = $userModel->getPagesNumByWork($userType, $limit);
        $data = array('data' => $users, 'pages'=>$pages);
        echo json_encode($data);
    }

    public function deleteAction()
    {
        $util = $this->util;
        $userModel = $this->userModel;
        $util->setHeader('json');
        $currentUser = $_SESSION['user'];
        $currentRole = $userModel->getUserByUsername($currentUser)['role'];
        $currentUserId = $_SESSION['userId'];
        if ($currentRole!=='admin') {
            echo $util->returnJson('forbidden', '');
            return;
        }
        if ($util->getData('userId')==$currentUserId) {
            echo $util->returnJson('error', '不能删除当前登录账户');
            return;
        }
        $userModel->delUser($util->getData('userId'));
        echo $util->returnJson('success', '');
    }

    public function addModalAction()
    {
        $util = $this->util;
        $userModel = $this->userModel;
        $util->setHeader('json');
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $currentUser = $_SESSION['user'];
            $currentRole = $userModel->getUserByUsername($currentUser)['role'];
            $userModel->username = $util->getData('username');
            $userModel->password = $util->getData('password');
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
            if (is_null($currentUser)) {
                echo $util->returnJson('unlogin', '');
                return;
            }
            if ($currentRole!=='admin') {
                echo $util->returnJson('forbidden', '');
                return;
            }
            if (!is_null($userModel->isUserExist($userModel))) {
                $message = $userModel->isUserExist($userModel);
                echo $util->returnJson('error', $message);
                return;
            }
            if (is_array($userModel->addUser($userModel))) {
                echo $util->returnJson('success', '');
            } else {
                echo $util->returnJson('error', '添加失败');
            }
        } else {
            require 'templates/user-add-modal.html.php';
        }
    }

    public function editModalAction()
    {
        $util = $this->util;
        $userModel = $this->userModel;
        $currentUserId = $_SESSION['userId'];
        $twig = $util->getTwig();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $currentUser = $_SESSION['user'];
            $currentRole = $userModel->getUserByUsername($currentUser)['role'];
            $userModel->id = $util->getData('userId');
            if (!isset($_POST['role'])) {
                $userModel->role = '';
            } else {
                $userModel->role = $util->getData('role');
            }
            $userModel->realname = $util->getData('realname');
            $userModel->mail = $util->getData('mail');
            $userModel->age = $util->getData('age');
            $userModel->work = $util->getData('work2');
            if ($userModel->work==0) {
                $userModel->org = $util->getData('schoolName');
            }
            if ($userModel->work==1) {
                $userModel->org = $util->getData('companyName');
            }
            $userModel->hobby = implode('#', $util->getData('hobby'));
            $util->setHeader('json');
            if (($currentRole!=='admin'&&$currentUserId!==$userModel->id)||($currentRole!=='admin'&&$userModel->role=="admin")) {
                echo $util->returnJson('forbidden', '');
                return;
            }
            if ($userModel->getUserByMail($userModel->mail)!=null&&$userModel->getUserByMail($userModel->mail)['id']!= $userModel->id) {
                echo $util->returnJson('error', $userModel->isUserExist($userModel));
                return;
            }
            $userModel->updateUser($userModel);
            echo $util->returnJson('success', '');
        } else {
            $modalUserInfo = $userModel->getUserByUserId($util->getData('userId'));
            echo $twig->render('user-edit-modal.html.twig', array(
                'currentUserId' => $currentUserId,
                'modalUserInfo' => $modalUserInfo
            ));
        }
    }

    public function checkUsernameAction()
    {
        $util = $this->util;
        $userModel = $this->userModel;
        $util->setHeader('json');
        if (isset($_POST['username'])) {
            $user = $userModel->getUserByUsername($util->getData('username'));
            if (!empty($user)) {
                echo $util->returnJson('error', '');
                return;
            }
            echo $util->returnJson('success', '');
        }
    }

    public function checkMailAction()
    {
        $util = $this->util;
        $userModel = $this->userModel;
        $util->setHeader('json');
        if (isset($_POST['mail'])) {
            $user = $userModel->getUserByMail($util->getData('mail'));
            if (!empty($user)) {
                echo $util->returnJson('error', '');
                return;
            }
            echo $util->returnJson('success', '');
        }
    }
}
