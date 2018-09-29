var lastPage = document.getElementById("last-page");
var nextPage = document.getElementById("next-page");
var nowPageLabel = document.getElementById("nowPage");
var totalPageLabel = document.getElementById("totalPage");
var sessionBox = document.getElementById("session");
var currentUser = sessionBox.dataset.currentuser;
var currentRole = sessionBox.dataset.currentrole;
var pageLimit = 10;
$(document).ready(function() {
    $.ajaxSetup({
        statusCode: {
            500: function(data) {
                localStorage.setItem('alert', data.responseJSON);
                localStorage.setItem('alert-type', 'alert-danger');
                self.location = 'index.php?controller=user&action=index';
            }
        }
    });
    $("#settings-btn").click(function() {
        currentMail = '';
    })
    if (localStorage.getItem('alert') != null) {
        $('#message').text(localStorage.getItem('alert'));
        $('.alert').addClass(localStorage.getItem('alert-type'));
        $('.alert').removeAttr('hidden');
        $('.alert').show();
        localStorage.removeItem('alert');
        localStorage.removeItem('alert-type');
    }
    findUsers('all', 1,pageLimit);
    nextPage.dataset.page = 1;
    var page = lastPage.dataset.page
    $("#nav-home-tab").click(function() {
        $('tbody').html("");
        findUsers('all', 1 ,pageLimit);
        lastPage.dataset.view = 'all';
        nextPage.dataset.view = 'all';
        nextPage.dataset.page = 1;
    })

    $("#nav-profile-tab").click(function() {
        $('tbody').html("");
        findUsers('0', 1 ,pageLimit)
        lastPage.dataset.view = '0';
        nextPage.dataset.view = '0';
        nextPage.dataset.page = 1;
    })

    $("#nav-contact-tab").click(function() {
        $('tbody').html("");
        findUsers('1', 1 ,pageLimit);
        lastPage.dataset.view = '1';
        nextPage.dataset.view = '1';
        nextPage.dataset.page = 1;
    })

    $("#next-page").click(function(event) {
        $('tbody').html("");
        currentpage = parseInt(event.target.dataset.page);
        currentview = String(event.target.dataset.view);
        lastPage.dataset.view = currentview;
        nextPage.dataset.view = currentview;
        nextPage.dataset.page = currentpage + 1;
        lastPage.dataset.page = currentpage + 1;
        page = currentpage + 1;
        console.log(currentview);
        findUsers(currentview, currentpage + 1, pageLimit);
    })

    $("#last-page").click(function(event) {
        $('tbody').html("");
        currentpage = parseInt(event.target.dataset.page);
        currentview = String(event.target.dataset.view);
        lastPage.dataset.view = currentview;
        nextPage.dataset.view = currentview;
        nextPage.dataset.page = currentpage - 1;
        lastPage.dataset.page = currentpage - 1;
        page = currentpage - 1;
        console.log(currentview);
        findUsers(currentview, currentpage - 1,pageLimit);
    })

    $("body").on("click", "#del-user-btn", function(event) {
        var req = { userId: event.target.dataset.userid };

        var msg = "您确定要删除吗";
        if (confirm(msg) == true) {
            $.ajax({
                type: "POST",
                url: "index.php?controller=user&action=delete",
                data: req,
                datatype: "json",
                success: function(data) {
                    console.log(data);
                    if (data.status == 'forbidden') {
                        $('#message').text('您无权操作！');
                        $('.alert').addClass('alert-danger');
                        $('.alert').removeAttr('hidden');
                        $('.alert').show();
                    }
                    if (data.status == 'error') {
                        $('#message').text(data.message);
                        $('.alert').addClass('alert-danger');
                        $('.alert').removeAttr('hidden');
                        $('.alert').show();
                    }
                    if (data.status == 'success') {
                        self.location = 'index.php?controller=user&action=index';
                        localStorage.setItem('alert', '用户删除成功');
                        localStorage.setItem('alert-type', 'alert-success');
                    }
                }
            });
        }
    });

    $("body").on("click", "#edit-user-btn", function(event) {
        currentMail = '';
        $("#EditUserModal").remove();
        var req = { userId: event.target.dataset.userid };
        $.ajax({
            type: "GET",
            url: "index.php?controller=user&action=editModal",
            data: req,
            datatype: "json",
            success: function(data) {
                console.log(data);
                $("#modal-content").append(data);
                $("#EditUserModal").modal();
            }
        });
    });

    $("body").on("click", "#show-user-btn", function(event) {
        $("#UserDetailModal").remove();
        var req = { userId: event.target.dataset.userid };
        $.ajax({
            type: "GET",
            url: "index.php?controller=user&action=showModal",
            data: req,
            datatype: "json",
            success: function(data) {
                console.log(data);
                $("#showmodal-content").append(data);
                $("#UserDetailModal").modal();
            }
        });
    });
})

function findUsers(userType, page, limit) {
    $.post('index.php?controller=user&action=findUsers', { userType: userType, page: page , limit:pageLimit }, function(data) {
        if (currentRole == 'admin') {
            for (i in data.data) {
                if (data.data[i].work == 0) {
                    data.data[i].work = '学生';
                } else {
                    data.data[i].work = '上班族';
                }
                if (data.data[i].role == 'admin') {
                    data.data[i].role = '管理员';
                } else {
                    data.data[i].role = '成员';
                }
                $("tbody").append(
                    "<tr>" +
                    "<td>" + data.data[i].id + "</td>" +
                    "<td>" + data.data[i].username + "</td>" +
                    "<td>" + data.data[i].role + "</td>" +
                    "<td>" + data.data[i].realname + "</td>" +
                    "<td>" + data.data[i].mail + "</td>" +
                    "<td>" + data.data[i].work + "</td>" +
                    "<td>" + data.data[i].org + "</td>" +
                    '<td hidden="hidden">' + data.data[i].age + '</td>' +
                    '<td hidden="hidden">' + data.data[i].hobby + '</td>' +
                    '<td><a id="del-user-btn" href="#" data-userid="' + data.data[i].id + '">删除</a><a class="ml-2" id="edit-user-btn" href="" data-userid="' + data.data[i].id + '" data-toggle="modal" data-target="#EditUserModal">编辑</a><a class="ml-2" id="show-user-btn" data-userid="' + data.data[i].id + '" href="" data-toggle="modal" data-target="#UserDetailModal">详情</a></td>' +
                    "</tr>"
                );
            }
            if (JSON.stringify(data.data) == "[]") {
                $("tbody").append('<tr><td colspan="8" align="center">暂无数据</td></tr>');
            }
        } else {
            for (i in data.data) {
                if (data.data[i].work == 0) {
                    data.data[i].work = '学生';
                } else {
                    data.data[i].work = '上班族';
                }
                if (data.data[i].role == 'admin') {
                    data.data[i].role = '管理员';
                } else {
                    data.data[i].role = '成员';
                }
                $("tbody").append(
                    "<tr>" +
                    "<td>" + data.data[i].id + "</td>" +
                    "<td>" + data.data[i].username + "</td>" +
                    "<td>" + data.data[i].role + "</td>" +
                    "<td>" + data.data[i].realname + "</td>" +
                    "<td>" + data.data[i].mail + "</td>" +
                    "<td>" + data.data[i].work + "</td>" +
                    "<td>" + data.data[i].org + "</td>" +
                    '<td><a id="show-user-btn" data-userid="' + data.data[i].id + '" href="" data-toggle="modal" data-target="#UserDetailModal">详情</a></td>' +
                    "</tr>"
                );
            }
            if (JSON.stringify(data.data) == "[]") {
                $("tbody").append('<tr><td colspan="8" align="center">暂无数据</td></tr>');
            }
        }
        if (page == 1) {
            lastPage.setAttribute("disabled", "disabled");
        } else {
            lastPage.removeAttribute("disabled");
        }
        if (page >= data.pages) {
            nextPage.setAttribute("disabled", "disabled");
        } else {
            nextPage.removeAttribute("disabled");
        }
        if (data.pages == 0) {
            nowPageLabel.innerHTML = 0;
            totalPageLabel.innerHTML = data.pages;
        } else {
            nowPageLabel.innerHTML = page;
            totalPageLabel.innerHTML = data.pages;
        }
    })
}