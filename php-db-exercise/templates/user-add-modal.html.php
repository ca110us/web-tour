<div class="modal fade" id="AddUserModal" tabindex="-1" role="dialog" aria-labelledby="AddUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">添加新用户</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="d-flex justify-content-center align-items-center">
                <form id="addUserForm" class="w-75" style="font-size:0.8rem;">
                <label id="err-message" class="error" style="display: none;"></label>
                    <div class="form-group">
                        <label>用户名</label>
                        <input id="usernameInput" type="text" name="username" class="form-control">
                        <label id="usernameError" class="error" style="display:none;"></label>
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
                        <input id="emailInput" type="email" name="mail" class="form-control">
                        <label id="emailError" class="error" style="display:none;"></label>
                    </div>
                    <div class="form-group">
                        <label>年龄</label>
                        <input type="text" name="age" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>职业</label></br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" id="inlineRadio1" type="radio" name="work" value="0" checked>
                            <label class="form-check-label" for="inlineRadio1">学生</label>
                            </div>
                            <div class="form-check form-check-inline">
                            <input class="form-check-input" id="inlineRadio2" type="radio" name="work" value="1">
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
                                <input class="form-check-input" id="gamecheckbox" type="checkbox" name="hobby[]" value="game">
                                <label class="form-check-label" for="gamecheckbox" >游戏</label>
                        </div>
                        <div class="form-check form-check-inline">
                                <input class="form-check-input" id="footballcheckbox" type="checkbox" name="hobby[]" value="football">
                                <label class="form-check-label" for="footballcheckbox">足球</label>
                        </div>
                        <div class="form-check form-check-inline">
                                <input class="form-check-input" id="basketballcheckbox" type="checkbox" name="hobby[]" value="basketball">
                                <label class="form-check-label" for="basketballcheckbox">篮球</label>
                        </div>
                        <div class="form-check form-check-inline">
                                <input class="form-check-input" id="singcheckbox" type="checkbox" name="hobby[]" value="sing">
                                <label class="form-check-label" for="singcheckbox">唱歌</label>
                        </div>
                        <div class="form-check form-check-inline">
                                <input class="form-check-input" id="dancecheckbox" type="checkbox" name="hobby[]" value="dance">
                                <label class="form-check-label" for="dancecheckbox">舞蹈</label>
                        </div>
                        <div class="form-check form-check-inline">
                                <input class="form-check-input" id="musiccheckbox" type="checkbox" name="hobby[]" value="music">
                                <label class="form-check-label" for="musiccheckbox">听音乐</label>
                        </div>
                        <div class="form-check form-check-inline">
                                <input class="form-check-input" id="novelcheckbox" type="checkbox" name="hobby[]" value="novel">
                                <label class="form-check-label" for="novelcheckbox">看小说</label>
                        </div>
                        <div class="form-check form-check-inline">
                                <input class="form-check-input" id="moviecheckbox" type="checkbox" name="hobby[]" value="movie">
                                <label class="form-check-label" for="moviecheckbox">看电影</label>
                        </div>
                        <div class="form-check form-check-inline">
                                <input class="form-check-input" id="bodybuiltcheckbox" type="checkbox" name="hobby[]" value="bodybuilt">
                                <label class="form-check-label" for="bodybuiltcheckbox">撸铁</label>
                        </div>
                        <div class="form-check form-check-inline">
                                <input class="form-check-input" id="runcheckbox" type="checkbox" name="hobby[]" value="run">
                                <label class="form-check-label" for="runcheckbox">跑步</label>
                        </div></br>
                        <label id="work-error" class="error" for="hobby[]"></label>
                    </div>
                
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
          <button type="submit" class="btn btn-primary">添加</button>
        </div>
      </form>
      </div>
    </div>
</div>