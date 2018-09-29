<?php require 'common/admin.header.html.php'; ?>
    <div class="container-fluid">
      <div class="row">
        <div class="col-8 d-flex flex-row">
            <div class="dropdown mt-4 mb-4">
                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  用户名
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                  <a class="dropdown-item" href="#">用户名</a>
                  <a class="dropdown-item" href="#">角色</a>
                  <a class="dropdown-item" href="#">职业</a>
                </div>
            </div>
            <div class="input-group mt-4 mb-4 ml-3 search-text">
                <input type="text" class="form-control" placeholder="请输入" aria-label="Recipient's username" aria-describedby="basic-addon2">
                <div class="input-group-append">
                  <button class="btn btn-primary" type="button">搜索</button>
                </div>
            </div>
        </div>
        <div class="col-4">
          <div class="addUser justify-content-end"  <?php if($currentRole!=='admin'){echo('hidden="hidden"');}?>>
            <button type="button" class="btn btn-primary mt-4 mb-4 float-right" data-toggle="modal" data-target="#AddUserModal">添加用户</button>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col">
        <div class="alert alert-dismissible fade show" hidden="hidden" role="alert">
          <strong id="message">用户添加成功</strong>
          <button type="button" class="close" style="line-height:1rem;" onclick="$('.alert').hide();" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <div class="tagContent">
              <nav>
                  <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">全部</a>
                    <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">学生</a>
                    <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">上班族</a>
                  </div>
              </nav>
              <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                  <table class="table table-bordered table-hover">
                      <thead>
                        <tr>
                          <th scope="col">ID</th>
                          <th scope="col">用户名</th>
                          <th scope="col">角色</th>
                          <th scope="col">姓名</th>
                          <th scope="col">邮箱</th>
                          <th scope="col">职业</th>
                          <th scope="col">学校/公司</th>
                          <th scope="col">操作</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                  </table>
                </div>

                <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                    <table class="table table-bordered table-hover">
                        <thead>
                          <tr>
                            <th scope="col">ID</th>
                            <th scope="col">用户名</th>
                            <th scope="col">角色</th>
                            <th scope="col">姓名</th>
                            <th scope="col">邮箱</th>
                            <th scope="col">职业</th>
                            <th scope="col">学校/公司</th>
                            <th scope="col">操作</th>
                          </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                    <table class="table table-bordered table-hover">
                        <thead>
                          <tr>
                            <th scope="col">ID</th>
                            <th scope="col">用户名</th>
                            <th scope="col">角色</th>
                            <th scope="col">姓名</th>
                            <th scope="col">邮箱</th>
                            <th scope="col">职业</th>
                            <th scope="col">学校/公司</th>
                            <th scope="col">操作</th>
                          </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="col d-flex justify-content-center">
                    <div class="btn-group mr-2" role="group">
                      <button id="last-page" type="button" class="btn btn-primary" data-view="all" data-page="1" onclick="">上一页</button>
                      <button id="next-page" type="button" class="btn btn-primary" data-view="all" data-page="1" onclick="">下一页</button>
                    </div>
                </div>
                <div class="col d-flex justify-content-center mt-3">
                    <p id="nowPage">1</p>/<p id="totalPage">2</p>
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>

<!-- Modal -->

<?php require 'user-add-modal.html.php'; ?>
<div id="modal-content">
<?php require 'user-edit-modal.html.php'; ?>
</div>
<div id="showmodal-content">
<?php require 'user-show-modal.html.php'; ?>
</div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="static/js/jquery-1.11.3.min.js"></script>
    <script src="static/js/popper.min.js"></script>
    <script src="static/js/bootstrap.min.js"></script>
    <script src="static/js/jquery.validate.js"></script>
    <script src="static/js/register.js"></script>
    <script src="static/js/edit-user.js"></script>
    <script src="static/js/users.js"></script>
    <script src="static/js/add-user.js"></script>
<?php require 'common/footer.html.php'; ?>