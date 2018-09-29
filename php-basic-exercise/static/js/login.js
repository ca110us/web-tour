$(document).ready(function(){
    $("#loginForm").validate({
        rules:{
            username:{
               required : true, // 必填
            },
            password:{
               required : true, // 必填
            }
         },
         messages:{
             username:{
              required:"用户名不能为空"
             },
             password:{
              required:"密码不能为空" // 必填
             }
        }
     });
});