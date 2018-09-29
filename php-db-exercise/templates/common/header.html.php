<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo isset($htmlTitle) ? $htmlTitle : 'Page Title' ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="static/css/bootstrap.min.css">
    <link rel="stylesheet" href="static/css/sytle.css">
</head>
<body>
<div class="container-fluid">
    <div class="row align-items-center header">
        <div class="col-6">
        <a href="" class="navbar-brand">bootcamp</a>
        </div>
        <div class="col-6">
        <ul class="nav justify-content-end">
            <li class="nav-item">
                    <a class="nav-link" href="index.php?controller=register&action=index">注册</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link pr-0" href="index.php?controller=auth&action=login">登录</a>
            </li>
            </ul>
        </div>
    </div>
</div>