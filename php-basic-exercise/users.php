<?php
/**
 * 此文件为用户管理页的代码
 */

require 'includes/functions.inc.php';
require 'user.php';

session_start();
// 此变量在 templates/common/header.html.php 用到，用于设置网页标题
$htmlTitle = '登陆';
$user = new user();
if (isset($_SESSION['user'])) {
    $currentUser = $_SESSION['user'];
    $currentRole = $_SESSION['role'];
    if (isset($_SESSION['userId'])) {
        $currentUserId = $_SESSION['userId'];
    }else{
        $user = $user->getUserByUsername($currentUser);
        $currentUserId = $user['id'];
        $_SESSION['userId'] = $currentUserId;
    }
    require 'templates/users.html.php';
}else{
    header("Location:login.php"); 
}



// TODO: 判断用户是否登录，如果未登陆，则跳转到 login.php
// TODO: 如果已登陆，则从$_GET['page']参数中获取当前页数，从数据文件中取出当前页的用户，赋值到 $users 变量，每页显示10个用户。
// TODO: 输出用户管理页的HTML，如果当前登录用户为管理员，那么显示"新增用户"，"编辑"，"删除"按钮，如果不是，则不显示。
// TODO: 用户列表底部，显示"上一页"、"下一页"的链接。
// TODO: 在 users.html.php 代码中，可直接使用 $users 变量，循环输出每一行数据。

