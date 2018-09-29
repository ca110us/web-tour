<?php
namespace App\Controller;

class MyController extends BaseController
{
    public function settingsAction()
    {
        $active = 'settingsPage';
        $twig = $this->util->getTwig();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        } else {
            if (isset($_SESSION['user'])) {
                $currentUser = $_SESSION['user'];
                $currentRole = $_SESSION['role'];
                $currentUserId = $_SESSION['userId'];
                $userInfo = $this->userModel->getUserByUserId($currentUserId);
                echo $twig->render('my-settings.html.twig', array(
                    'active' => $active,
                    'currentUser' => $currentUser,
                    'currentUserId' => $currentUserId,
                    'userInfo' => $userInfo
                ));
            } else {
                $this->util->redirect('auth', 'login');
            }
        }
    }
}
