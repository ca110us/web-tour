<?php
/**
 * 此文件为"添加新用户"模态框的代码
 */
require 'includes/functions.inc.php';
require 'user.php';
header('Content-type: application/json'); 
$user = new user();
session_start();
// @todo 通过在 users.php 页面上 点击 "新增用户"，通过 Ajax GET 的方式加载此文件，显示模态框。
// @todo 在模态框中，点击“保存”按钮时，触发 Ajax POST 请求，提交数据。
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // @todo 判断是否登录，如果未登陆，则输出 JSON {"status": "unlogin"}，前端接收到此JSON时，引导页面跳转到 login.php。
    // @todo 判断是否为管理员，如果不是，则输出 JSON {"status": "forbidden"}，前端接收到此JSON时，在模态框的头部区域显示“您无权操作！”。
    // @todo 如果是管理员，则验证数据是否合法，如果不合法，则输出JSON {"status": "error", "message": "数据格式不正确"}，前端接收到此JSON时，在模态框头部区域显示此错误。
    // @todo 如果数据格式正确，检查用户名、电子邮箱是否存在，如果存在，则输出JSON {"status": "error", "message": "用户名或邮箱已存在，添加失败"}，前端接收到此JSON时，在模态框头部区域显示此错误。
    // @todo 如果用户名、邮箱不存在，则保存用户数据到文件。
    // @todo 如果保存失败，则输出JSON {"status": "error", "message": "保存新用户失败"}，前端接收到此JSON时，在模态框头部区域显示此错误。
    // @todo 如果保存成功，则输出JSON {"status": "success"}，前端接收到此JSON时，重载当前页面，并在页面头部区域显示“添加用户成功！"。
    $currentUser = $_SESSION['user'];
    $currentRole = $_SESSION['role'];
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
    if (is_null($currentUser)) {
        echo json_encode(array('status' => 'unlogin'));
    }else{
        if ($currentRole!=='admin') {
             echo json_encode(array('status' => 'forbidden')); 
        }else{
            if (!is_null($user->existUser($user))) {
                $message = $user->existUser($user);
                echo json_encode(array('status' => 'error' , 'message' => $message));
            }else{
                if ($user->addUser($user)=='') {
                    echo json_encode(array('status' => 'success'));
                }else{
                    echo json_encode(array('status' => 'error' , 'message' => '添加失败'));
                }
            }
        }
    }

} else {
    // @todo 判断是否为管理员，如果不是，则在输出的模态框中显示“您无权操作！"的错误提示。
    // @todo 如果是，则在模态框中，显示添加新用户的表单。
    require 'templates/user-add-modal.html.php';
}
