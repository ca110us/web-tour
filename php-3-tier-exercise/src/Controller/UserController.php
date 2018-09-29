<?php
namespace App\Controller;

class UserController extends BaseController
{
    public function indexAction()
    {
        $util = $this->util;
        $userService = $this->userService;
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
            $user = $userService->getUserByUsername($currentUser);
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
        $userService = $this->userService;
        $twig = $util->getTwig();
        header('Content-type: text/html');
        $modalUserInfo = $userService->getUserByUserId($util->getData('userId'));
        echo $twig->render('user-show-modal.html.twig', array(
            'modalUserInfo' => $modalUserInfo
        ));
    }

    public function findUsersAction()
    {
        header('Content-type: application/json');
        $util = $this->util;
        $userService = $this->userService;
        $userType = $util->getData('userType');
        $page = $util->getData('page');
        $limit = $util->getData('limit');
        $users = $userService->findUsersByWork($userType, $page, $limit);
        $pages = $userService->getPagesNumByWork($userType, $limit);
        $data = array('data' => $users, 'pages'=>$pages);
        echo json_encode($data);
    }

    public function deleteAction()
    {
        $util = $this->util;
        $userService = $this->userService;
        $util->setHeader('json');
        $currentUser = $_SESSION['user'];
        $currentRole = $userService->getUserByUsername($currentUser)['role'];
        $currentUserId = $_SESSION['userId'];
        if ($currentRole!=='admin') {
            echo $util->returnJson('forbidden', '');
            return;
        }
        if ($util->getData('userId')==$currentUserId) {
            echo $util->returnJson('error', '不能删除当前登录账户');
            return;
        }
        $userService->delUser($util->getData('userId'));
        echo $util->returnJson('success', '');
    }

    public function addModalAction()
    {
        $util = $this->util;
        $userService = $this->userService;
        $util->setHeader('json');
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $currentUser = $_SESSION['user'];
            $currentRole = $userService->getUserByUsername($currentUser)['role'];
            $userService->username = $util->getData('username');
            $userService->password = $util->getData('password');
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
            if (is_null($currentUser)) {
                echo $util->returnJson('unlogin', '');
                return;
            }
            if ($currentRole!=='admin') {
                echo $util->returnJson('forbidden', '');
                return;
            }
            if (!is_null($userService->isUserExist($userService))) {
                $message = $userService->isUserExist($userService);
                echo $util->returnJson('error', $message);
                return;
            }
            if (is_array($userService->addUser($userService))) {
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
        $userService = $this->userService;
        $currentUserId = $_SESSION['userId'];
        $twig = $util->getTwig();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $currentUser = $_SESSION['user'];
            $currentRole = $userService->getUserByUsername($currentUser)['role'];
            $userService->id = $util->getData('userId');
            if (!isset($_POST['role'])) {
                $userService->role = '';
            } else {
                $userService->role = $util->getData('role');
            }
            $userService->realname = $util->getData('realname');
            $userService->mail = $util->getData('mail');
            $userService->age = $util->getData('age');
            $userService->work = $util->getData('work2');
            if ($userService->work==0) {
                $userService->org = $util->getData('schoolName');
            }
            if ($userService->work==1) {
                $userService->org = $util->getData('companyName');
            }
            $userService->hobby = implode('#', $util->getData('hobby'));
            $util->setHeader('json');
            if (($currentRole!=='admin'&&$currentUserId!==$userService->id)||($currentRole!=='admin'&&$userService->role=="admin")) {
                echo $util->returnJson('forbidden', '');
                return;
            }
            if ($userService->getUserByMail($userService->mail)!=null&&$userService->getUserByMail($userService->mail)['id']!= $userService->id) {
                echo $util->returnJson('error', $userService->isUserExist($userService));
                return;
            }
            $userService->updateUser($userService);
            echo $util->returnJson('success', '');
        } else {
            $modalUserInfo = $userService->getUserByUserId($util->getData('userId'));
            echo $twig->render('user-edit-modal.html.twig', array(
                'currentUserId' => $currentUserId,
                'modalUserInfo' => $modalUserInfo
            ));
        }
    }

    public function checkUsernameAction()
    {
        $util = $this->util;
        $userService = $this->userService;
        $util->setHeader('json');
        if (isset($_POST['username'])) {
            $user = $userService->getUserByUsername($util->getData('username'));
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
        $userService = $this->userService;
        $util->setHeader('json');
        if (isset($_POST['mail'])) {
            $user = $userService->getUserByMail($util->getData('mail'));
            if (!empty($user)) {
                echo $util->returnJson('error', '');
                return;
            }
            echo $util->returnJson('success', '');
        }
    }
}
