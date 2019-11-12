layui.define(['jquery','navigation','commons','element','laytpl','table'], function(exports){
    var $ = layui.jquery;
    var element = layui.element;
    var navigation = layui.navigation;
    var commons = layui.commons;
    var laytpl = layui.laytpl;
    var table = layui.table;

    var init_page = function(){
        document.title = document.title+'-'+navigation.main_data.project_title;
        $("#header").html(navigation.header_data);
        $("#navigation").html(navigation.navigate_data);
        $("#footer").html(navigation.footer_data);
        element.init();
    }

    $("#edit_password").click(function(){
        var getTpl = editer.innerHTML;
        laytpl(getTpl).render({}, function(html){
            layer.open({
                title: '修改密码',
                area:["400px"],
                btn:[],
                content: html
            });
            $("#confirm_btn").click(function(){
                var password = $("#password").val();
                var t_password = $("#t_password").val();
                if(commons.is_empty(password) && password == t_password){
                    var loading = layer.load(2);
                    commons.ajax_post("/index.php/Sys_user/save_user_msg",{password:password},function(res_data){
                        layer.close(loading);
                        layer.msg(res_data.msg);
                    });
                }else{
                    layer.msg("输入两次密码不一致");
                }
            })
        });
    })

  init_page();
  exports('user_msg',{});
});
