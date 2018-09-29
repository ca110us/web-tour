<!doctype html>
<html lang="zh-cn">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="static/css/bootstrap.min.css">
    <link rel="stylesheet" href="static/css/userManage.css">
    <title><?php echo isset($htmlTitle) ? $htmlTitle : 'Page Title' ?></title>
  </head>
  <body>
    <div class="container-fluid">
        <div class="row align-items-center header">
          <div class="col-8">
            <a href="" class="navbar-brand">bootcamp</a>
            <div class="btn-group mb-1 ml-3" role="group" aria-label="Basic example">
              <a class="btn btn-outline-success" href="users.php" role="button">用户</a>
              <a class="btn btn-outline-success" href="#" role="button">讨论区</a>
              <a class="btn btn-outline-success" href="my-settings.php" role="button">我的设置</a>
            </div>
          </div>
          <div class="col-4">
            <ul class="nav justify-content-end">
                <span class="navbar-text">
                    <?php echo $currentUser ?> 
                </span>
                <a class="nav-link" href="logout.php">退出</a>
              </ul>
          </div>
        </div>
    </div>
    <p id="session" hidden="hidden" data-currentUser="<?php echo $currentUser ?>" data-currentRole="<?php echo $currentRole ?>" data-currentUserId="<?php echo $currentUserId ?>"></p>