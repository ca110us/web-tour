<?php
/**
 * 此文件为用户删除的业务代码
 */

require 'includes/functions.inc.php';
require 'user.php';
header('Content-type: application/json'); 
session_start();
// 此变量在 templates/common/header.html.php 用到，用于设置网页标题
$htmlTitle = '登陆';
$user = new user();
// @todo 在页面上点击“删除"按钮后，使用 Ajax POST 的方式提交，如果非 POST 提交，那么则直接返回错误信息
// @todo 前端在收到此错误提示后，在页面头部区域显示“您无权操作！"的错误提示。
$currentUser = $_SESSION['user'];
$currentRole = $_SESSION['role'];
$currentUserId = $_SESSION['userId'];
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo json_encode([
        'status' => 'error',
        'message' => '请用POST提交！',
    ]);
    exit();
}else{
    if ($currentRole!=='admin') {
        echo json_encode(array('status' => 'forbidden')); 
    }else if($_POST['userId']==$currentUserId){
        echo json_encode(array('status' => 'error','message'=>'不能删除当前登录账户')); 
    }else{
        $user->delUser($_POST['userId']);
        echo json_encode(array('status' => 'success')); 
   }
}


// @todo 判断是否为管理员，如果不是，则输出 JOSN 消息 {"status": "forbidden"}，前端接收到此JSON后，在页面头部区域显示“您无权操作！"的错误提示。
// @todo 如果是，则删除数据
// @todo 如果删除失败，则输出 JSON 消息 {"status": "error", "message": "删除失败"}，前端接收到此JSON后，在页面头部区域显示此错误提示。
// @todo 删除成功，则输出 JSON 消息 {"status":success"}，前端收到此 JSON 后，重载当前页面，并在页面上显示 "删除成功！"的提示。
