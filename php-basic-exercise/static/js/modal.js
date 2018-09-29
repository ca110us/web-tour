function update(obj){/*点击修改按钮，给模态框加载信息并且弹出模态框*/
    var tds= $(obj).parent().parent().find('td');
    $("#username").val(tds.eq(1).text());
    $("#realname").val(tds.eq(3).text());
    $("#mail").val(tds.eq(4).text());
    $("#age").val(tds.eq(7).text());
    $("#orgNameInput2").val(tds.eq(6).text());
    if (tds.eq(2).text()=='admin') {
        $("input[name='role'][value='0']").attr("checked",true);
    }else{
        $("input[name='role'][value='1']").attr("checked",true);
    }
    if (tds.eq(5).text()=='上班族') {
        $("input[name='work2'][value='1']").attr("checked",true);
    }else{
        $("input[name='work2'][value='0']").attr("checked",true);
    }
    var hobbys = tds.eq(8).text();
    $('input:checkbox').each(function() {
        if (hobbys.indexOf($(this).attr('value'))!=-1) {
            $(this).attr("checked",'checked');
        }else{
            $(this).removeAttr("checked");
        }
    });
}
