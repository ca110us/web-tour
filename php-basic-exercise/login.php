<?php
/**
 * 此文件为"登陆页"的代码
 */

 require 'includes/functions.inc.php';
 require 'user.php';
 // 此变量在 templates/common/header.html.php 用到，用于设置网页标题
 $htmlTitle = '登陆';



 // @todo 已经登陆的用户，不能再次注册，直接跳转到 users.php 页面。
 $user = new user();
 // 通过表单的 POST 方式提交
// @todo 通过表单的 POST 方式提交数据
 session_start();
 $err_message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // @todo 查询用户名、密码是否在数据文件中
    // @todo 如果存在，则登陆成功，设置 $_SESSION['user'] 的值为:
    // @todo    ['id' => '{CURRENT_USER_ID}', 'username' => '{CURRENT_USERNAME}', 'role' => '{CURRENT_ROLE}']
    // @todo    其中 'role' 的值表示当前用户的角色，可选的值有 'member': 普通成员, 'admin': 管理员
    // @todo 设置 SESSION 成功后，跳转到 users.php 页面
    // @todo 如果不存在，则登陆失败，仍旧停留在当前页，在登陆表单上方显示“用户名或密码不正确”的错误提示。
    $username = $_POST['username'];
    $password = $_POST['password'];
    $userInfo = $user->getUserByUsername($username);
    if (is_null($userInfo)) {
        $err_message = '该用户未注册';
        require 'templates/login.html.php';
    } else if($userInfo['password']==md5($password)){
        $_SESSION['user']=$userInfo['username'];
        $_SESSION['userId']=$userInfo['id'];
        $_SESSION['role']=$userInfo['role'];
        header("Location:users.php");  
    }else{
        $err_message = '用户名或密码错误';
        require 'templates/login.html.php';
    }
    
} else {
    require 'templates/login.html.php';
}

if (isset($_SESSION['user'])) {
    header("Location:users.php");
}
