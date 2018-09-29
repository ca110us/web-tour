<?php require 'common/header.html.php'; ?>
    <div class="container-fluid content">
        <div class="row justify-content-center align-items-center no-gutters">
            <div class="login-area col-4 mb-5">
                <div class="login-tab w-100">
                    <a href="login.php">登录</a>
                    <a href="register.php" class="active">注册</a>
                </div>
                <div class="login-main d-flex justify-content-center align-items-center">
                    <form method="post" id="registerForm" class="w-75 mt-5 mb-5" style="font-size:0.8rem;">
                    <label id="work-error" class="error" <?php if($err_message==''){printf('hidden="hidden"');}?> ><?php if($err_message!==''){printf($err_message);}?></label>
                        <div class="form-group">
                            <label>用户名</label>
                            <input type="text" name="username" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>密码</label>
                            <input id="password" type="password" name="password" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>确认密码</label>
                            <input type="password" name="passwordAgain" class="form-control">
                        </div>
                        <div class="form-group">
                                <label>真实姓名</label>
                                <input type="text" name="realname" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>邮箱</label>
                            <input type="email" name="mail" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>年龄</label>
                            <input type="text" name="age" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>职业</label></br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="work" value="0" checked>
                                <label class="form-check-label" for="inlineRadio1">学生</label>
                                </div>
                                <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="work" value="1">
                                <label class="form-check-label" for="inlineRadio2">上班族</label>
                                </div>
                        </div>
                        <div class="form-group">
                            <label id="orgName">学校</label>
                            <input type="text" id="orgNameInput" name="schoolName" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>兴趣爱好</label></br>
                            <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="hobby[]" value="game">
                                    <label class="form-check-label" >游戏</label>
                            </div>
                            <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="hobby[]" value="football">
                                    <label class="form-check-label" >足球</label>
                            </div>
                            <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="hobby[]" value="basketball">
                                    <label class="form-check-label" >篮球</label>
                            </div>
                            <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="hobby[]" value="sing">
                                    <label class="form-check-label" >唱歌</label>
                            </div>
                            <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="hobby[]" value="dance">
                                    <label class="form-check-label" >舞蹈</label>
                            </div>
                            <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="hobby[]" value="music">
                                    <label class="form-check-label" >听音乐</label>
                            </div>
                            <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="hobby[]" value="novel">
                                    <label class="form-check-label" >看小说</label>
                            </div>
                            <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="hobby[]" value="movie">
                                    <label class="form-check-label" >看电影</label>
                            </div>
                            <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="hobby[]" value="bodybuilt">
                                    <label class="form-check-label" >撸铁</label>
                            </div>
                            <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="hobby[]" value="run">
                                    <label class="form-check-label" >跑步</label>
                            </div></br>
                            <label id="work-error" class="error" for="hobby[]"></label>
                        </div>
                        <button type="submit" class="btn btn-success mt-3 w-100">注册</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="static/js/jquery-1.11.3.min.js"></script>
    <script src="static/js/jquery.validate.js"></script>
    <script src="static/js/register.js"></script>
    <script src="static/js/bootstrap.min.js"></script>
<?php require 'common/footer.html.php'; ?>