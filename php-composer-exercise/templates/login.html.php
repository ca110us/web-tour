<?php require 'common/header.html.php'; ?>
    <div class="container-fluid content">
        <div class="row justify-content-center align-items-center no-gutters">
            <div class="login-area col-4">
                <div class="login-tab w-100">
                    <a href="index.php?controller=auth&action=login" class="active">登录</a>
                    <a href="index.php?controller=register&action=index">注册</a>
                </div>
                <div class="login-main d-flex justify-content-center align-items-center">
                    <form id="loginForm" method="post" class="w-75 mt-4 mb-5" style="font-size:0.8rem;">
                        <div class="form-group">
                        <div class="alert alert-dismissible <?php if($err_message!==''){printf('alert-danger');}?> fade show" <?php if($err_message==''){printf('hidden="hidden"');}?>  role="alert">
                            <strong id="message"><?php if($err_message!==''){printf($err_message);}?></strong>
                            <button type="button" class="close" style="line-height:1rem;" onclick="$('.alert').hide();" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        </div>
                        <div class="form-group">
                            <label>用户名</label>
                            <input type="text" name="username" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>密码</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="form-check form-check-inline">
                                <input class="form-check-input" id="rememberPassword" type="checkbox" name="rememberPassword" value="bodybuilt">
                                <label class="form-check-label" for="rememberPassword">记住密码</label>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3 w-100">登录</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="static/js/jquery-1.11.3.min.js"></script>
    <script src="static/js/jquery.validate.js"></script>
    <script src="static/js/login.js"></script>
    <script src="static/js/bootstrap.min.js"></script>
<?php require 'common/footer.html.php'; ?>
