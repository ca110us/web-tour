<?php
require_once "user.php";
require_once "functions.php";
$user = new user();
if (isset($_POST['submit'])) {
    $user->id=$_POST['id'];
    $user->username=$_POST['username'];
    $user->sex=$_POST['sex'];
    $user->age=$_POST['age'];
    $user->profile=$_POST['profile'];
    if (empty($user->check_user($user))){
        echo "<script>alert('字段不能为空');</script>";
        echo '<script>javascript:self.location=document.referrer;</script>"';
    }else if (empty($user->get_user($user->id))){
        echo "<script>alert('用户不存在');</script>";
        echo '<script>javascript:self.location=document.referrer;</script>"';
    }else{
        $user->modify_user($user->id,$user);
        echo "<script>alert('修改成功');</script>";
        echo '<script>window.location.href="list-user.php";</script>';
    }
}
if (isset($_GET['id'])) {
    if (empty($user->get_user($_GET['id']))) {
        echo "<script>alert('用户不存在');</script>";
        echo '<script>javascript:self.location=document.referrer;</script>"';
    }else{
        $user = $user->get_user($_GET['id']);
    }
}else{
    $user=array();
    $user['id']='';
    $user['username']='';
    $user['age']='';
    $user['sex']='';
    $user['profile']='';
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
<label for="username">ID:</label>
    <input type="text" id="id" name="id" value='<?php printf($user["id"])?>' readonly="readonly"/><br/>
    <label for="username">姓名:</label>
    <input type="text" id="username" name="username" value='<?php printf($user["username"])?>' /><br/>
    <label for="sex">性别:</label>
    <input type="radio" name="sex" value="男" <?php if($user['sex']=='男'){printf('checked="checked"');} ?> />男
    <input type="radio" name="sex" value="女" <?php if($user['sex']=='女'){printf('checked="checked"');} ?> />女<br/>
    <label for="age">年龄:</label>
    <input type="text" id="age" name="age" value='<?php printf($user["age"])?>' /><br/>
    <label for="profile">信息:</label>
    <textarea id="profile" name="profile"/><?php printf($user["profile"])?></textarea><br/>
    <input type="submit" value="修改" name="submit"/>
</form>
</body>
</html>