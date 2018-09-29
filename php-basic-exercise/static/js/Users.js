var lastPage = document.getElementById("last-page");
var nextPage = document.getElementById("next-page");
var nowPageLabel = document.getElementById("nowPage");
var totalPageLabel = document.getElementById("totalPage");
var sessionBox = document.getElementById("session");
var currentUser = sessionBox.dataset.currentuser;
var currentRole = sessionBox.dataset.currentrole;
$(document).ready(function(){
    getUsers('all',1);
    nextPage.dataset.page=1;
    var page = lastPage.dataset.page
    $("#nav-home-tab").click(function(){
        $('tbody').html("");
        getUsers('all',1);
        lastPage.dataset.view='all';
        nextPage.dataset.view='all';
        nextPage.dataset.page=1;
    })

    $("#nav-profile-tab").click(function(){
        $('tbody').html("");
        getUsers('0',1)
        lastPage.dataset.view='0';
        nextPage.dataset.view='0';
        nextPage.dataset.page=1;
    })

    $("#nav-contact-tab").click(function(){
        $('tbody').html("");
        getUsers('1',1);
        lastPage.dataset.view='1';
        nextPage.dataset.view='1';
        nextPage.dataset.page=1;
    })

    $("#next-page").click(function(event){
        $('tbody').html("");
        currentpage = parseInt(event.target.dataset.page);
        currentview = String(event.target.dataset.view);
        lastPage.dataset.view=currentview;
        nextPage.dataset.view=currentview;
        nextPage.dataset.page=currentpage+1;
        lastPage.dataset.page=currentpage+1;
        page = currentpage +1;
        console.log(currentview);
        getUsers(currentview,currentpage+1);
    })

    $("#last-page").click(function(event){
        $('tbody').html("");
        currentpage = parseInt(event.target.dataset.page);
        currentview = String(event.target.dataset.view);
        lastPage.dataset.view=currentview;
        nextPage.dataset.view=currentview;
        nextPage.dataset.page=currentpage-1;
        lastPage.dataset.page=currentpage-1;
        page = currentpage - 1;
        console.log(currentview);
        getUsers(currentview,currentpage-1);
    })

    $("body").on("click","#del-user-btn",function(event){
        var req = { userId:event.target.dataset.userid};

        var msg = "您确定要删除吗";
        if (confirm(msg)==true){
            $.ajax({
                type:"POST",
                url:"index.php?controller=user&action=delete",
                data:req,  
                datatype:"json",      
                success:function(data){
                    console.log(data);
                    if (data.status=='forbidden') {
                        alert('您无权操作');
                    }
                    if (data.status=='error') {
                        alert(data.message);
                    }
                    if (data.status=='success') {
                        alert('删除成功');
                        self.location='index.php?controller=user&action=index'; 
                    }        
                }       
            });
        }
    });

    $("body").on("click","#edit-user-btn",function(event){
        $("#EditUserModal").remove();
        var req = { userId:event.target.dataset.userid};
        $.ajax({
            type:"GET",
            url:"index.php?controller=user&action=editModal",
            data:req,  
            datatype:"json",      
            success:function(data){
                console.log(data);
                $("#modal-content").append(data);
                $("#EditUserModal").modal();  
            }       
    });
    });

    $("body").on("click","#show-user-btn",function(event){
        $("#UserDetailModal").remove();
        var req = { userId:event.target.dataset.userid};
        $.ajax({
            type:"GET",
            url:"index.php?controller=user&action=showModal",
            data:req,  
            datatype:"json",      
            success:function(data){
                console.log(data);
                $("#showmodal-content").append(data);
                $("#UserDetailModal").modal();  
            }       
    });
    });
})

function getUsers(userType,page) {
    $.post('index.php?controller=user&action=getUsers',{userType:userType,page:page},function(data) { 
        if (currentRole=='admin') {
            for (i in data.data) {
                if (data.data[i].work==0) {
                    data.data[i].work='学生';
                }else{
                    data.data[i].work='上班族';
                }
                $("tbody").append(
                    "<tr>" 
                    + "<td>"+data.data[i].id+"</td>" +
                    "<td>"+data.data[i].username+"</td>" +
                    "<td>"+data.data[i].role+"</td>" +
                    "<td>"+data.data[i].realname+"</td>" +
                    "<td>"+data.data[i].mail+"</td>" +
                    "<td>"+data.data[i].work+"</td>" +
                    "<td>"+data.data[i].org+"</td>" +
                    '<td hidden="hidden">' + data.data[i].age + '</td>' +
                    '<td hidden="hidden">' + data.data[i].hobby + '</td>' +
                    '<td><a id="del-user-btn" href="#" data-userid="' + data.data[i].id + '">删除</a>|<a id="edit-user-btn" href="" data-userid="' + data.data[i].id + '" data-toggle="modal" data-target="#EditUserModal">编辑</a>|<a id="show-user-btn" data-userid="' + data.data[i].id + '" href="" data-toggle="modal" data-target="#UserDetailModal">详情</a></td>'
                    + "</tr>"
                );
            }
            if (JSON.stringify(data.data) == "[]") {
                $("tbody").append('<tr><td colspan="8" align="center">暂无数据</td></tr>');
            }
        } else {
            for (i in data.data) {
                if (data.data[i].work==0) {
                    data.data[i].work='学生';
                }else{
                    data.data[i].work='上班族';
                }
                $("tbody").append(
                    "<tr>" 
                    + "<td>"+data.data[i].id+"</td>" +
                    "<td>"+data.data[i].username+"</td>" +
                    "<td>"+data.data[i].role+"</td>" +
                    "<td>"+data.data[i].realname+"</td>" +
                    "<td>"+data.data[i].mail+"</td>" +
                    "<td>"+data.data[i].work+"</td>" +
                    "<td>"+data.data[i].org+"</td>" +
                    '<td><a id="show-user-btn" data-userid="' + data.data[i].id + '" href="" data-toggle="modal" data-target="#UserDetailModal">详情</a></td>'
                    + "</tr>"
                );
                if (JSON.stringify(data.data) == "[]") {
                    $("tbody").append('<tr><td colspan="8" align="center">暂无数据</td></tr>');
                }
            }
        }
        if (page==1) {
            lastPage.setAttribute("disabled","disabled");
        }else{
            lastPage.removeAttribute("disabled");
        }
        if(page>=data.pages){
            nextPage.setAttribute("disabled","disabled");
        }else{
            nextPage.removeAttribute("disabled");
        }
        if (data.pages==0) {
            nowPageLabel.innerHTML = 0;
            totalPageLabel.innerHTML = data.pages;
        }else{
            nowPageLabel.innerHTML = page;
            totalPageLabel.innerHTML = data.pages;
        }
    })
}