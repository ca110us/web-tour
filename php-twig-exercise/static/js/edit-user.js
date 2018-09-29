var sessionBox = document.getElementById("session");
var currentUserId = sessionBox.dataset.currentuserid;
$(document).ready(function() {
    $.ajaxSetup({
        statusCode: {
            500: function() {
                alert('数据格式错误');
            }
        }
    });
    if (localStorage.getItem('alert') != null) {
        $('#message').text(localStorage.getItem('alert'));
        $('.alert').addClass(localStorage.getItem('alert-type'));
        $('.alert').removeAttr('hidden');
        $('.alert').show();
        localStorage.removeItem('alert');
        localStorage.removeItem('alert-type');
    }
    $("body").on("click", "input:radio", function(event) {
        var a = $("input[name='work2']:checked").val();
        if (a == 0) {
            $("#orgName2").text("学校");
            $("#orgNameInput2").attr("name", "schoolName");
        } else {
            $("#orgName2").text("公司");
            $("#orgNameInput2").attr("name", "companyName");
        }
    });

    $("body").on("click", "#edit-submit-btn", function(event) {
        var userId = event.target.dataset.userid;
        $("#editUserForm").validate({
            rules: {
                realname: {
                    required: true,
                    correctName: true
                },
                mail: {
                    required: true, // 必填
                    email: true
                },
                age: {
                    required: true, // 必填
                    correctAge: true
                },
                work: {
                    required: true, // 必填
                },
                schoolName: {
                    required: true,
                    stringMaxLength: [1, 100, "请输入合格的学校名称(1-100个字符)"]
                },
                companyName: {
                    required: true,
                    stringMaxLength: [1, 100, "请输入合格的公司名称(1-100个字符)"]
                },
                "hobby[]": {
                    required: true
                }
            },
            errorPlacement: function(error, element) {
                error.appendTo(element.parent());
            },
            messages: {
                realname: {
                    required: "真实姓名不能为空"
                },
                mail: {
                    required: "邮箱不能为空",
                    email: "请输入正确的邮箱地址"
                },
                age: {
                    required: "年龄不能为空",
                },
                work: {
                    required: "请选择职业",
                },
                schoolName: {
                    required: "学校名称不能为空"
                },
                companyName: {
                    required: "公司名称不能为空"
                },
                "hobby[]": {
                    required: "请选择至少一个兴趣爱好"
                }
            },
            submitHandler: function(form) {
                var postData = $("#editUserForm").serialize();
                $.ajax({
                    type: "POST",
                    url: "index.php?controller=user&action=editModal",
                    data: postData + '&userId=' + userId,
                    datatype: "json",
                    success: function(data) {
                        console.log(data);
                        if (data.status == 'forbidden') {
                            localStorage.setItem('alert', '您无权操作！');
                            localStorage.setItem('alert-type', 'alert-danger');
                            self.location = 'index.php?controller=user&action=index';
                        }
                        if (data.status == 'error') {
                            localStorage.setItem('alert', '修改失败！' + data.message);
                            localStorage.setItem('alert-type', 'alert-danger');
                            self.location = 'index.php?controller=user&action=index';
                        }
                        if (data.status == 'success') {
                            localStorage.setItem('alert', '用户修改成功！');
                            localStorage.setItem('alert-type', 'alert-success');
                            self.location = 'index.php?controller=user&action=index';
                        }
                    }
                });
            }
        });
        $("#editUserForm").valid()
        $("#editUserForm").submit()
    });

    $("body").on("click", "#save-setting-btn", function(event) {
        var userId = event.target.dataset.userid;
        $("#editUserForm").validate({
            rules: {
                realname: {
                    required: true,
                    correctName: true
                },
                mail: {
                    required: true, // 必填
                    email: true
                },
                age: {
                    required: true, // 必填
                    correctAge: true
                },
                work: {
                    required: true, // 必填
                },
                schoolName: {
                    required: true,
                    stringMaxLength: [1, 100, "请输入合格的学校名称(1-100个字符)"]
                },
                companyName: {
                    required: true,
                    stringMaxLength: [1, 100, "请输入合格的公司名称(1-100个字符)"]
                },
                "hobby[]": {
                    required: true
                }
            },
            errorPlacement: function(error, element) {
                error.appendTo(element.parent());
            },
            messages: {
                realname: {
                    required: "真实姓名不能为空"
                },
                mail: {
                    required: "邮箱不能为空",
                    email: "请输入正确的邮箱地址"
                },
                age: {
                    required: "年龄不能为空",
                },
                work: {
                    required: "请选择职业",
                },
                schoolName: {
                    required: "学校名称不能为空"
                },
                companyName: {
                    required: "公司名称不能为空"
                },
                "hobby[]": {
                    required: "请选择至少一个兴趣爱好"
                }
            },
            submitHandler: function(form) {
                var postData = $("#editUserForm").serialize();
                $.ajax({
                    type: "POST",
                    url: "index.php?controller=user&action=editModal",
                    data: postData + '&userId=' + currentUserId,
                    datatype: "json",
                    success: function(data) {
                        console.log(data);
                        if (data.status == 'forbidden') {
                            localStorage.setItem('alert', '您无权操作！');
                            localStorage.setItem('alert-type', 'alert-danger');
                            self.location = 'index.php?controller=my&action=settings';
                        }
                        if (data.status == 'error') {
                            localStorage.setItem('alert', '修改失败！' + data.message);
                            localStorage.setItem('alert-type', 'alert-danger');
                            self.location = 'index.php?controller=my&action=settings';
                        }
                        if (data.status == 'success') {
                            localStorage.setItem('alert', '修改成功！');
                            localStorage.setItem('alert-type', 'alert-success');
                            self.location = 'index.php?controller=my&action=settings';
                        }
                    }
                });
            }
        });
        $("#editUserForm").valid()
    });

    $.validator.addMethod("correctUsername", function(value, element, params) {
        var correctUsername = /^[A-Za-z0-9\u4e00-\u9fa5]+$/;
        return (correctUsername.test(value));
    }, "只能包含数字、英文和中文");
    $.validator.addMethod("stringMaxLength", function(value, element, params) {
        var length = value.length;
        var that = this;
        for (var i = 0; i < value.length; i++) {
            if (value.charCodeAt(i) > 19967) {
                length++;
            }
        }
        return length >= params['0'] && length <= params['1'] ? true : false;
    }, $.validator.format("{2}"));
    //  $.validator.addMethod("correctPassword",function(value,element,params){
    //     var correctPassword = /^.*(?=.*\d)(?=.*[a-zA-Z])(?=.*[!@#$%^&*?,. ]).*$/;
    //     return (correctPassword.test(value));
    //  },"必须包含英文字母，数字及符号");
    $.validator.addMethod("correctName", function(value, element, params) {
        var correctName = /^[\u4e00-\u9fa5]+$/;
        return (correctName.test(value));
    }, "请输入正确的中文名");
    $.validator.addMethod("correctAge", function(value, element, params) {
        return value >= 1 && value <= 100 && /^\d+$/.test(value) ? true : false;
    }, "请输入正确的年龄(1-100)");
    $.validator.addMethod("correctOrgName", function(value, element, params) {
        return value >= 1 && value <= 100 && /^\d+$/.test(value) ? true : false;
    }, "请输入正确的年龄(1-100)");
});