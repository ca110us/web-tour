<?php

require 'includes/functions.inc.php';
require 'user.php';
session_start();
// 此变量在 templates/common/header.html.php 用到，用于设置网页标题
$htmlTitle = '登陆';
$user = new user();
// @todo 通过在 users.php 页面上 点击 "编辑"，通过 Ajax GET 的方式加载此文件，显示模态框。

// @todo 在模态框中，点击“保存”按钮时，触发 Ajax POST 请求，提交数据。
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // @todo: 校验数据，如果非法，则输出JSON {"status": "error", "message": "数据格式不正确！"}，前端收到此回应后，在模态框的头部区域显示此错误消息。
    // @todo: 保存用户信息。
    // @todo: 保存失败，则输出 JSON {"status": "error", "message": "保存用户信息失败！"}，前端收到此回应后，在模态框的头部区域显示此错误消息。
    // @todo: 保存成功，则输出 JSON {"status": "ok"}，前端收到此回应后，重载页面，在页面头部区域，显示“编辑用户成功！“的消息提示。 
    header('Content-type: application/json'); 
    $currentUser = $_SESSION['user'];
    $currentRole = $_SESSION['role'];
    $currentUserId = $_SESSION['userId'];
    $user->id = $_POST['userId'];
    $user->role = $_POST['role'];
    $user->realname = $_POST['realname'];
    $user->mail = $_POST['mail'];
    $user->age = $_POST['age'];
    $user->work = $_POST['work2'];
    if (empty($_POST['schoolName'])) {
        $user->org = $_POST['companyName'];
    } else {
        $user->org = $_POST['schoolName'];
    }
    $user->hobby = implode('#',$_POST['hobby']);
    if (($currentRole!=='admin'&&$currentUserId!==$user->id)||($currentRole!=='admin'&&$user->role=="admin")) {
        echo json_encode(array('status' => 'forbidden')); 
    }else{
        $user->updateUser($user);
        echo json_encode(array('status' => 'success')); 
   }
} else {
    header('Content-type: text/html'); 
    $modalUserInfo = $user->getUserByUserId($_GET['userId']);
    require 'templates/user-edit-modal.html.php';
}