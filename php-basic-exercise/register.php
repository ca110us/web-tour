<?php
/**
 * 此文件为"用户注册页"的代码
 */

require 'includes/functions.inc.php';
require 'user.php';

// 此变量在 templates/common/header.html.php 用到，用于设置网页标题
$htmlTitle = '登陆';
// @todo 已经登陆的用户，不能再次注册，直接跳转到 users.php 页面。
$user = new user();
// 通过表单的 POST 方式提交数据
$err_message='';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user->username = $_POST['username'];
    $user->password = md5($_POST['password']);
    $user->realname = $_POST['realname'];
    $user->mail = $_POST['mail'];
    $user->age = $_POST['age'];
    $user->work = $_POST['work'];
    if (empty($_POST['schoolName'])) {
        $user->org = $_POST['companyName'];
    } else {
        $user->org = $_POST['schoolName'];
    }
    $user->hobby = implode('#',$_POST['hobby']);
    if ($user->checkObj($user)) {
        $err_message = '数据格式不正确，注册失败';
        require 'templates/register.html.php';
    }else{
        if ($user->addUser($user)=='') {
            session_start();
            $_SESSION['user']=$user->username;
            $_SESSION['role']=$user->role;
            header("Location:users.php");   
        }else{
            $err_message = $user->addUser($user);
            require 'templates/register.html.php';
        }
    }
    // @todo 校验数据，如果非法，则在页面的头部区域显示"数据格式不正确，注册失败！"的错误提示。
    // @todo 如果数据格式正确，检查用户名、电子邮箱是否已被注册，如果被注册，则在页面头部区域显示“用户名或邮箱已存在，注册失败！”的错误提示。
    // @todo 如果用户名、邮箱未被注册，则保存用户数据到文件。
    // @todo 如果保存失败，则在页面头部区域显示“保存数据失败，注册失败”。
    // @todo 如果保存成功，则 跳转到 users.php 页面，并在 users.php 页面的头部区域显示"恭喜您，注册成功！"。
    // @todo 系统中第一个注册用户的角色设置为管理员(admin)，其他注册用户的角色设置为普通成员(member)。
} else {
    // @todo 显示注册表单
    $htmlTitle = '注册';
    require 'templates/register.html.php';
}
