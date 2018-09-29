<?php
/**
 * Created by PhpStorm.
 * User: edb
 * Date: 18-7-9
 * Time: 下午5:32
 */
    require_once "user.php";
    if (isset($_GET['id'])) {
     $user = new user();
     $id=$_GET['id'];
     if (empty($id)){
         echo message("fail",'参数不能为空');
     }else{
         if($user->del_user($id)){
             echo "<script>alert('删除成功');</script>";
             echo '<script>javascript:self.location=document.referrer;</script>"';
         }else{
             echo "<script>alert('用户不存在');</script>";
             echo '<script>javascript:self.location=document.referrer;</script>"';
         }
     }
    }
?>