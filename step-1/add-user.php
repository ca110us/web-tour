<?php
    require_once "user.php";
    require_once "functions.php";
    var_dump(PHP_OS);
    if (isset($_POST['submit'])) {
     $user = new user();
     $user->username=$_POST['username'];
     $user->sex=$_POST['sex'];
     $user->age=$_POST['age'];
     $user->profile=$_POST['profile'];
     if (!$user->check_user($user)){
         echo message("fail",'请输入完整信息');
     }else{
         echo '<script>window.location.href="list-user.php";</script>';
         $user->add_user($user);}
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Manage</title>
</head>
<body>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <label for="username">姓名:</label>
    <input type="text" id="username" name="username" /><br/>
    <label for="sex">性别:</label>
    <input type="radio" name="sex" value="男" checked="checked" />男
    <input type="radio" name="sex" value="女" />女<br/>
    <label for="age">年龄:</label>
    <input type="text" id="age" name="age" /><br/>
    <label for="profile">信息:</label>
    <textarea id="profile" name="profile" /></textarea><br/>
    <input type="submit" value="新增" name="submit"/>
</form>
</body>
</html>