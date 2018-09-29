<?php
namespace App\Controller;
class MyController
{
    public function settingsAction()
    {
        $htmlTitle = '我的设置';
        $userModel = new \App\Model\UserModel();
        $active = 'settingsPage';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        } else {
            if (isset($_SESSION['user'])) {
                $currentUser = $_SESSION['user'];
                $currentRole = $_SESSION['role'];
                $currentUserId = $_SESSION['userId'];
                $userInfo = $userModel->getUserByUserId($currentUserId);
                require 'templates/my-settings.html.php';
            } else {
                header("Location:index.php?controller=auth&action=login");
            }
        }
    }
}
