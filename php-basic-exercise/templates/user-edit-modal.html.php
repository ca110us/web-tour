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
                        <input id="username" type="text" name="username" class="form-control" disabled="disabled" value="<?php printf($modalUserInfo['username'])?>">
                    </div>
                    <div class="form-group">
                        <label>角色</label></br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="role" value="admin" <?php if($modalUserInfo['role']=='admin'){printf('checked');}?>>
                            <label class="form-check-label" for="inlineRadio1">管理员</label>
                            </div>
                            <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="role" value="member" <?php if($modalUserInfo['role']=='member'){printf('checked');}?>>
                            <label class="form-check-label" for="inlineRadio2">成员</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>真实姓名</label>
                        <input id="realname" type="text" name="realname" class="form-control" value="<?php printf($modalUserInfo['realname'])?>">
                    </div>
                    <div class="form-group">
                        <label>邮箱</label>
                        <input id="mail" type="email" name="mail" class="form-control" value="<?php printf($modalUserInfo['mail'])?>">
                    </div>
                    <div class="form-group">
                        <label>年龄</label>
                        <input id="age" type="text" name="age" class="form-control" value="<?php printf($modalUserInfo['age'])?>">
                    </div>
                    <div class="form-group">
                        <label>职业</label></br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="work2" value="0" <?php if($modalUserInfo['work']==0){printf('checked');}?>>
                            <label class="form-check-label" for="inlineRadio1">学生</label>
                            </div>
                            <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="work2" value="1" <?php if($modalUserInfo['work']==1){printf('checked');}?>>
                            <label class="form-check-label" for="inlineRadio2">上班族</label>
                            </div>
                    </div>
                    <div class="form-group">
                        <label id="orgName2"><?php if($modalUserInfo['work']==0){printf('学校');}else{printf('公司');}?></label>
                        <input type="text" id="orgNameInput2" name="<?php if($modalUserInfo['work']==0){printf('schoolName');}else{printf('companyName');}?>" class="form-control" value="<?php printf($modalUserInfo['org'])?>">
                    </div>
                    <div class="form-group">
                        <label>兴趣爱好</label></br>
                        <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="hobby[]" value="game" <?php if(strstr($modalUserInfo['hobby'],'game')){printf('checked');}?>>
                                <label class="form-check-label" >游戏</label>
                        </div>
                        <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="hobby[]" value="football" <?php if(strstr($modalUserInfo['hobby'],'football')){printf('checked');}?>>
                                <label class="form-check-label" >足球</label>
                        </div>
                        <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="hobby[]" value="basketball" <?php if(strstr($modalUserInfo['hobby'],'basketball')){printf('checked');}?>>
                                <label class="form-check-label" >篮球</label>
                        </div>
                        <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="hobby[]" value="sing" <?php if(strstr($modalUserInfo['hobby'],'sing')){printf('checked');}?>>
                                <label class="form-check-label" >唱歌</label>
                        </div>
                        <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="hobby[]" value="dance" <?php if(strstr($modalUserInfo['hobby'],'dance')){printf('checked');}?>>
                                <label class="form-check-label" >舞蹈</label>
                        </div>
                        <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="hobby[]" value="music" <?php if(strstr($modalUserInfo['hobby'],'music')){printf('checked');}?>>
                                <label class="form-check-label" >听音乐</label>
                        </div>
                        <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="hobby[]" value="novel" <?php if(strstr($modalUserInfo['hobby'],'novel')){printf('checked');}?>>
                                <label class="form-check-label" >看小说</label>
                        </div>
                        <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="hobby[]" value="movie" <?php if(strstr($modalUserInfo['hobby'],'movie')){printf('checked');}?>>
                                <label class="form-check-label" >看电影</label>
                        </div>
                        <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="hobby[]" value="bodybuilt" <?php if(strstr($modalUserInfo['hobby'],'bodybuilt')){printf('checked');}?>>
                                <label class="form-check-label" >撸铁</label>
                        </div>
                        <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="hobby[]" value="run" <?php if(strstr($modalUserInfo['hobby'],'run')){printf('checked');}?>>
                                <label class="form-check-label" >跑步</label>
                        </div></br>
                        <label id="work-error" class="error" for="hobby[]"></label>
                    </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
          <button id="edit-submit-btn" data-userid="<?php printf($modalUserInfo['id'])?>" type="submit" class="btn btn-primary">修改</button>
        </div>
      </form>
      </div>
    </div>
</div>
