<?php
/**
 * 此文件为"我的设置"页的代码
 */

require 'includes/functions.inc.php';
require 'user.php';

session_start();
// 此变量在 templates/common/header.html.php 用到，用于设置网页标题
$htmlTitle = '登陆';
$user = new user();

// @todo 判断用户是否登录，如果未登陆，则跳转到 login.php

// @todo 通过表单的 POST 方式提交数据
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // @todo 校验数据，如果非法，则在页面的头部显示 "数据格式不正确，更新个人资料失败！"。
    // @todo 如果合法，则保存用户数据到文件。
    // @todo 如果保存失败，则在页面头部显示“保存用户数据失败。”。
    // @todo 如果保存成功，则 停留在当前页面，并在页面的头部区域显示"更新个人资料成功！"。
} else {
    // @todo 从 SESSIION 中，读取当前用户的ID，通过ID在数据文件中查找到该用户信息，设置到 $user 变量。
    // @todo 将 $user 变量的数据填入到 my-settings.html.php 的输入框中，并输出 HTML。

    if (isset($_SESSION['user'])) {
        $currentUser = $_SESSION['user'];
        $currentRole = $_SESSION['role'];
        $currentUserId = $_SESSION['userId'];
        $userInfo = $user->getUserByUserId($currentUserId);
        require 'templates/my-settings.html.php';
    }else{
        header("Location:login.php"); 
    }
}
