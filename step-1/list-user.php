<?php
require_once "user.php";
    $user = new user();
    $page = 1;
    $pages = $user->get_pages();
    if (isset($_GET['page'])) {
        $page=$_GET['page'];
        if(floor($_GET['page'])==$_GET['page']&&$_GET['page']>0){
            $users = $user->get_users($_GET['page']);
            $pages = $user->get_pages();
        }else{
            $page=1;
            $users = $user->get_users(1);
            $pages = $user->get_pages();
            echo '<script>javascript:window.location.href="list-user.php?page=1";</script>';
        }

    }else{
        $users = $user->get_users(1);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Manage</title>
</head>
<body>
<table border="1px">
    <tr>
        <th>ID</th>
        <th>姓名</th>
        <th>性别</th>
        <th>年龄</th>
        <th>个人简介</th>
        <th>操作</th>
    </tr>
    <?php foreach ($users as $key => $value){ ?>
    <tr>
        <td><?php printf($users[$key]["id"])?></td>
        <td><?php printf($users[$key]["username"])?></td>
        <td><?php printf($users[$key]["sex"])?></td>
        <td><?php printf($users[$key]["age"])?></td>
        <td><?php printf($users[$key]["profile"])?></td>
        <td><a href="del-user.php?id=<?php printf($users[$key]["id"])?>" onclick="return confirm('确定要删除吗?')">删除</a>/<a href="modify-user.php?id=<?php printf($users[$key]["id"])?>">编辑</a></td>
    </tr>
    <?php } ?>
    <button onclick="window.location.href='list-user.php?page=<?php if($page>1){printf($page - 1);}else{printf(1);}?>'" <?php if($page==1){printf('disabled="disabled"');} ?>>上一页</button>-<button onclick="window.location.href='list-user.php?page=<?php printf($page+1)?>'" <?php if($page>=$pages){printf('disabled="disabled"');} ?>>下一页</button>-<button onclick="window.location.href='add-user.php'">新增用户</button>
</table>
</body>
</html>