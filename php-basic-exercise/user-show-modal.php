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

} else {
    header('Content-type: text/html'); 
    $modalUserInfo = $user->getUserByUserId($_GET['userId']);
    // str_replace("world","Shanghai","Hello world!");
    $modalUserInfo['hobby'] = str_replace("#","/",$modalUserInfo['hobby']);
    $modalUserInfo['hobby'] = str_replace("game","游戏",$modalUserInfo['hobby']);
    $modalUserInfo['hobby'] = str_replace("football","足球",$modalUserInfo['hobby']);
    $modalUserInfo['hobby'] = str_replace("basketball","篮球",$modalUserInfo['hobby']);
    $modalUserInfo['hobby'] = str_replace("sing","唱歌",$modalUserInfo['hobby']);
    $modalUserInfo['hobby'] = str_replace("dance","舞蹈",$modalUserInfo['hobby']);
    $modalUserInfo['hobby'] = str_replace("music","听音乐",$modalUserInfo['hobby']);
    $modalUserInfo['hobby'] = str_replace("novel","看小说",$modalUserInfo['hobby']);
    $modalUserInfo['hobby'] = str_replace("movie","看电影",$modalUserInfo['hobby']);
    $modalUserInfo['hobby'] = str_replace("bodybuilt","撸铁",$modalUserInfo['hobby']);
    $modalUserInfo['hobby'] = str_replace("run","跑步",$modalUserInfo['hobby']);
    require 'templates/user-show-modal.html.php';
}