$(document).ready(function() {
    $.ajaxSetup({
        statusCode: {
            500: function() {
                alert('数据格式错误');
            }
        }
    });
    currentMail = '';
    $("input:radio").click(function() {
        var a = $("input[name='work']:checked").val();
        if (a == 0) {
            $("#orgName").text("学校");
            $("#orgNameInput").attr("name", "schoolName");
        } else {
            $("#orgName").text("公司");
            $("#orgNameInput").attr("name", "companyName");
        }
    });
    $("#registerForm").validate({
        rules: {
            username: {
                required: true, // 必填
                correctUsername: true,
                stringMaxLength: [4, 16, "请输入合格的用户名(4-16个字符)"]
            },
            password: {
                required: true, // 必填
                minlength: 6,
                maxlength: 18,
                // correctPassword:true
            },
            passwordAgain: {
                equalTo: "#password",
            },
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
                required: true,
            }
        },
        errorPlacement: function(error, element) {
            error.appendTo(element.parent());
        },
        messages: {
            username: {
                required: "用户名不能为空"
            },
            password: {
                required: "密码不能为空",
                minlength: "请输入合格的密码(6-18个字符)",
                maxlength: "请输入合格的密码(6-18个字符)"
            },
            passwordAgain: {
                equalTo: "两次密码不一致"
            },
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
        }
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

    $("#usernameInput").on("change", function(e) {
        $.ajax({
            type: "POST",
            url: "index.php?controller=user&action=checkUsername",
            data: 'username=' + e.delegateTarget.value,
            datatype: "json",
            success: function(data) {
                console.log(data);
                if (data.status == 'error') {
                    $("#usernameError").text('用户已存在');
                    $("#usernameError").removeAttr('style');
                }
                if (data.status == 'success') {
                    $("#usernameError").text('');
                    $("#usernameError").attr('style', 'display:none;');
                }
            }
        });
    });

    $("#emailInput").on("change", function(e) {
        $.ajax({
            type: "POST",
            url: "index.php?controller=user&action=checkMail",
            data: 'mail=' + e.delegateTarget.value,
            datatype: "json",
            success: function(data) {
                console.log(data);
                if (data.status == 'error') {
                    $("#emailError").text('邮箱已存在');
                    $("#emailError").removeAttr('style');
                }
                if (data.status == 'success') {
                    $("#emailError").text('');
                    $("#emailError").attr('style', 'display:none;');
                }
            }
        });
    });

    $("body").on("focus", "#mailInput", function(e) {
        if (typeof currentMail == 'undefined' || currentMail == '') {
            currentMail = $("#mailInput").val();
        }
    });

    $("body").on("focus", "#emailInput", function(e) {
        if (typeof currentMail == 'undefined' || currentMail == '') {
            currentMail = $("#emailInput").val();
        }
    });

    $("body").on("change", "#mailInput", function(e) {
        $.ajax({
            type: "POST",
            url: "index.php?controller=user&action=checkMail",
            data: 'mail=' + e.currentTarget.value,
            datatype: "json",
            success: function(data) {
                if (data.status == 'error' && $("#mailInput").val() !== currentMail) {
                    $("#mailError").text('邮箱已存在');
                    $("#mailError").removeAttr('style');
                }
                if ($("#mailInput").val() == currentMail) {
                    $("#mailError").text('');
                    $("#mailError").attr('style', 'display:none;');
                }
                if (data.status == 'success') {
                    $("#mailError").text('');
                    $("#mailError").attr('style', 'display:none;');
                }
            }
        });
    });

});