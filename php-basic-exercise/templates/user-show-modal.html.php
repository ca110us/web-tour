<div class="modal fade" id="UserDetailModal" tabindex="-1" role="dialog" aria-labelledby="UserDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">用户详情</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-3">
              <label class="ml-3 float-right">用户名</label>
            </div>
            <div class="col-9">
              <label class="ml-3 float-left"><?php printf($modalUserInfo['username'])?></label>
            </div>
          </div>
          <div class="row">
            <div class="col-3">
              <label class="ml-3 float-right">角 色</label>
            </div>
            <div class="col-9">
              <label class="ml-3 float-left"><?php printf($modalUserInfo['role'])?></label>
            </div>
          </div>
          <div class="row">
            <div class="col-3">
              <label class="ml-3 float-right">真实姓名</label>
            </div>
            <div class="col-9">
              <label class="ml-3 float-left"><?php printf($modalUserInfo['realname'])?></label>
            </div>
          </div>          
          <div class="row">
            <div class="col-3">
              <label class="ml-3 float-right">邮箱</label>
            </div>
            <div class="col-9">
              <label class="ml-3 float-left"><?php printf($modalUserInfo['mail'])?></label>
            </div>
          </div>
          <div class="row">
            <div class="col-3">
              <label class="ml-3 float-right">年龄</label>
            </div>
            <div class="col-9">
              <label class="ml-3 float-left"><?php printf($modalUserInfo['age'])?></label>
            </div>
          </div>
          <div class="row">
            <div class="col-3">
              <label class="ml-3 float-right">职业</label>
            </div>
            <div class="col-9">
              <label class="ml-3 float-left"><?php if ($modalUserInfo['work']==0) {printf('学生');}else{printf('上班族');}?></label>
            </div>
          </div>
          <div class="row">
            <div class="col-3">
              <label class="ml-3 float-right">学校/公司</label>
            </div>
            <div class="col-9">
              <label class="ml-3 float-left"><?php printf($modalUserInfo['org'])?></label>
            </div>
          </div>          
          <div class="row">
            <div class="col-3">
              <label class="ml-3 float-right">兴趣爱好</label>
            </div>
            <div class="col-9">
              <label class="ml-3 float-left"><?php printf($modalUserInfo['hobby'])?></label>
            </div>
          </div>                    
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" data-dismiss="modal">确定</button>
        </div>
      </form>
      </div>
    </div>
</div>