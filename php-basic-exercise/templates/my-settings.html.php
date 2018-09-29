<?php require 'common/admin.header.html.php'; ?>
<div class="container-fluid mb-4">
        <div class="row">
            <div class="col w-100 mt-4">
                <div id="accordion">
                    <div class="card">
                        <div class="card-header" id="headingOne">
                        <h5 class="mb-0">
                            <button class="btn btn-light" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            我的设置
                            </button>
                        </h5>
                        </div>
                    
                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="card-body">
                            <div class="row">
                              <div class="col">
                                <div class="d-flex justify-content-center align-items-center">
                                    <form id="editUserForm" class="w-75" style="font-size:0.8rem;">
                                        <div class="form-group">
                                            <label>用户名</label>
                                            <input type="text" name="username" class="form-control" disabled="disabled" value="<?php printf($userInfo['username'])?>">
                                        </div>
                                        <div class="form-group">
                                            <label>角色</label></br>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="role" value="admin" <?php if($userInfo['role']=='admin'){printf('checked');}?>>
                                                <label class="form-check-label" for="inlineRadio1">管理员</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="role" value="member" <?php if($userInfo['role']=='member'){printf('checked');}?>>
                                                <label class="form-check-label" for="inlineRadio2">成员</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>真实姓名</label>
                                            <input type="text" name="realname" class="form-control" value="<?php printf($userInfo['realname'])?>">
                                        </div>
                                        <div class="form-group">
                                            <label>邮箱</label>
                                            <input type="email" name="mail" class="form-control" value="<?php printf($userInfo['mail'])?>">
                                        </div>
                                        <div class="form-group">
                                            <label>年龄</label>
                                            <input type="text" name="age" class="form-control" value="<?php printf($userInfo['age'])?>">
                                        </div>
                                        <div class="form-group">
                                            <label>职业</label></br>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="work2" value="0" <?php if($userInfo['work']==0){printf('checked');}?>>
                                                <label class="form-check-label" for="inlineRadio1">学生</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="work2" value="1" <?php if($userInfo['work']==1){printf('checked');}?>>
                                                <label class="form-check-label" for="inlineRadio2">上班族</label>
                                                </div>
                                        </div>
                                        <div class="form-group">
                                            <label id="orgName2"><?php if($userInfo['work']==0){printf('学校');}else{printf('公司');}?></label>
                                            <input type="text" id="orgNameInput2" name="<?php if($userInfo['work']==0){printf('schoolName');}else{printf('companyName');}?>" class="form-control" value="<?php printf($userInfo['org'])?>">
                                        </div>
                                        <div class="form-group">
                                            <label>兴趣爱好</label></br>
                                            <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="hobby[]" value="game" <?php if(strstr($userInfo['hobby'],'game')){printf('checked');}?>>
                                                    <label class="form-check-label" >游戏</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="hobby[]" value="football" <?php if(strstr($userInfo['hobby'],'football')){printf('checked');}?>>
                                                    <label class="form-check-label" >足球</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="hobby[]" value="basketball" <?php if(strstr($userInfo['hobby'],'basketball')){printf('checked');}?>>
                                                    <label class="form-check-label" >篮球</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="hobby[]" value="sing" <?php if(strstr($userInfo['hobby'],'sing')){printf('checked');}?>>
                                                    <label class="form-check-label" >唱歌</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="hobby[]" value="dance" <?php if(strstr($userInfo['hobby'],'dance')){printf('checked');}?>>
                                                    <label class="form-check-label" >舞蹈</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="hobby[]" value="music" <?php if(strstr($userInfo['hobby'],'music')){printf('checked');}?>>
                                                    <label class="form-check-label" >听音乐</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="hobby[]" value="novel" <?php if(strstr($userInfo['hobby'],'novel')){printf('checked');}?>>
                                                    <label class="form-check-label" >看小说</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="hobby[]" value="movie" <?php if(strstr($userInfo['hobby'],'movie')){printf('checked');}?>>
                                                    <label class="form-check-label" >看电影</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="hobby[]" value="bodybuilt" <?php if(strstr($userInfo['hobby'],'bodybuilt')){printf('checked');}?>>
                                                    <label class="form-check-label" >撸铁</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="hobby[]" value="run" <?php if(strstr($userInfo['hobby'],'run')){printf('checked');}?>>
                                                    <label class="form-check-label" >跑步</label>
                                            </div></br>
                                            <label id="work-error" class="error" for="hobby[]"></label>
                                        </div>
                                        <button id="save-setting-btn" data-userid="<?php printf($userInfo['id'])?>" type="submit" class="btn btn-success mt-1 w-25">保存</button>
                                    </form>
                                </div>
                              </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="static/js/jquery-1.11.3.min.js"></script>
    <script src="static/js/popper.min.js"></script>
    <script src="static/js/bootstrap.min.js"></script>
    <script src="static/js/jquery.validate.js"></script>
    <script src="static/js/edituser.js"></script>
<?php require 'common/footer.html.php'; ?>