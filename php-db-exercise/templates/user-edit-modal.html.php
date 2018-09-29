<div class="modal fade" id="EditUserModal" tabindex="-1" role="dialog" aria-labelledby="EditUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">编辑用户</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="d-flex justify-content-center align-items-center">
                <form id="editUserForm" class="w-75" style="font-size:0.8rem;">
                    <div class="form-group">
                        <label>用户名</label>
                        <input id="username" type="text" name="username" class="form-control" disabled="disabled" value="<?php echo($modalUserInfo['username'])?>">
                    </div>
                    <div class="form-group" <?php if($currentUserId==$modalUserInfo['id']){echo('style="display:none;"');}?>>
                        <label>角色</label></br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" id="eRadio11" type="radio" name="role" value="admin" <?php if($modalUserInfo['role']=='admin'){echo('checked');}?>>
                            <label class="form-check-label" for="eRadio11">管理员</label>
                            </div>
                            <div class="form-check form-check-inline">
                            <input class="form-check-input" id="eRadio12" type="radio" name="role" value="member" <?php if($modalUserInfo['role']=='member'){echo('checked');}?>>
                            <label class="form-check-label" for="eRadio12">成员</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>真实姓名</label>
                        <input id="realname" type="text" name="realname" class="form-control" value="<?php echo($modalUserInfo['realname'])?>">
                    </div>
                    <div class="form-group">
                        <label>邮箱</label>
                        <input id="mailInput" type="email" name="mail" class="form-control" value="<?php echo($modalUserInfo['mail'])?>">
                        <label id="mailError" class="error" style="display:none;"></label>
                    </div>
                    <div class="form-group">
                        <label>年龄</label>
                        <input id="age" type="text" name="age" class="form-control" value="<?php echo($modalUserInfo['age'])?>">
                    </div>
                    <div class="form-group">
                        <label>职业</label></br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" id="inline11" type="radio" name="work2" value="0" <?php if($modalUserInfo['work']==0){echo('checked');}?>>
                            <label class="form-check-label" for="inline11">学生</label>
                            </div>
                            <div class="form-check form-check-inline">
                            <input class="form-check-input" id="inline12" type="radio" name="work2" value="1" <?php if($modalUserInfo['work']==1){echo('checked');}?>>
                            <label class="form-check-label" for="inline12">上班族</label>
                            </div>
                    </div>
                    <div class="form-group">
                        <label id="orgName2"><?php if($modalUserInfo['work']==0){echo('学校');}else{echo('公司');}?></label>
                        <input type="text" id="orgNameInput2" name="<?php if($modalUserInfo['work']==0){echo('schoolName');}else{echo('companyName');}?>" class="form-control" value="<?php echo($modalUserInfo['org'])?>">
                    </div>
                    <div class="form-group">
                        <label>兴趣爱好</label></br>
                        <div class="form-check form-check-inline">
                                <input class="form-check-input" id="gamecheckbox1" type="checkbox" name="hobby[]" value="game" <?php if(strstr($modalUserInfo['hobby'],'game')){echo('checked');}?>>
                                <label class="form-check-label" for="gamecheckbox1" >游戏</label>
                        </div>
                        <div class="form-check form-check-inline">
                                <input class="form-check-input" id="footballcheckbox1" type="checkbox" name="hobby[]" value="football" <?php if(strstr($modalUserInfo['hobby'],'football')){echo('checked');}?>>
                                <label class="form-check-label" for="footballcheckbox1">足球</label>
                        </div>
                        <div class="form-check form-check-inline">
                                <input class="form-check-input" id="basketballcheckbox1" type="checkbox" name="hobby[]" value="basketball" <?php if(strstr($modalUserInfo['hobby'],'basketball')){echo('checked');}?>>
                                <label class="form-check-label" for="basketballcheckbox1">篮球</label>
                        </div>
                        <div class="form-check form-check-inline">
                                <input class="form-check-input" id="singcheckbox1" type="checkbox" name="hobby[]" value="sing" <?php if(strstr($modalUserInfo['hobby'],'sing')){echo('checked');}?>>
                                <label class="form-check-label" for="singcheckbox1">唱歌</label>
                        </div>
                        <div class="form-check form-check-inline">
                                <input class="form-check-input" id="dancecheckbox1" type="checkbox" name="hobby[]" value="dance" <?php if(strstr($modalUserInfo['hobby'],'dance')){echo('checked');}?>>
                                <label class="form-check-label" for="dancecheckbox1">舞蹈</label>
                        </div>
                        <div class="form-check form-check-inline">
                                <input class="form-check-input" id="musiccheckbox1" type="checkbox" name="hobby[]" value="music" <?php if(strstr($modalUserInfo['hobby'],'music')){echo('checked');}?>>
                                <label class="form-check-label" for="musiccheckbox1">听音乐</label>
                        </div>
                        <div class="form-check form-check-inline">
                                <input class="form-check-input" id="novelcheckbox1" type="checkbox" name="hobby[]" value="novel" <?php if(strstr($modalUserInfo['hobby'],'novel')){echo('checked');}?>>
                                <label class="form-check-label" for="novelcheckbox1">看小说</label>
                        </div>
                        <div class="form-check form-check-inline">
                                <input class="form-check-input" id="moviecheckbox1" type="checkbox" name="hobby[]" value="movie" <?php if(strstr($modalUserInfo['hobby'],'movie')){echo('checked');}?>>
                                <label class="form-check-label" for="moviecheckbox1">看电影</label>
                        </div>
                        <div class="form-check form-check-inline">
                                <input class="form-check-input" id="bodybuiltcheckbox1" type="checkbox" name="hobby[]" value="bodybuilt" <?php if(strstr($modalUserInfo['hobby'],'bodybuilt')){echo('checked');}?>>
                                <label class="form-check-label" for="bodybuiltcheckbox1">撸铁</label>
                        </div>
                        <div class="form-check form-check-inline">
                                <input class="form-check-input" id="runcheckbox1" type="checkbox" name="hobby[]" value="run" <?php if(strstr($modalUserInfo['hobby'],'run')){echo('checked');}?>>
                                <label class="form-check-label" for="runcheckbox1">跑步</label>
                        </div></br>
                        <label id="work-error" class="error" for="hobby[]"></label>
                    </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
          <button id="edit-submit-btn" data-userid="<?php echo($modalUserInfo['id'])?>" type="submit" class="btn btn-primary">修改</button>
        </div>
      </form>
      </div>
    </div>
</div>
