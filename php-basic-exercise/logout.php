<?php
/**
 * 此文件为"退出登录"的代码
 */

 require 'includes/functions.inc.php';
 session_start();
 unset($_SESSION['user']);
 unset($_SESSION['role']);
 unset($_SESSION['userId']);
 header("Location:login.php"); 