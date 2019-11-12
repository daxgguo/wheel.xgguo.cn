// 导航栏
layui.define(['layer','jquery','commons'], function(exports){
    var layer = layui.layer;
    var $ = layui.jquery;
    var commons = layui.commons;


    //获取基本信息
    var main_data = {},navigate_list = [];

    var loading = layer.load(2);
    commons.ajax_post("/index.php/Admin/get_main_data",{},function(res_data){
        layer.close(loading);
        if(res_data.is_ok == 1){
            navigate_list = res_data.navigate_list;
            main_data = res_data.main_data;

            var header = '<a href="/"><div class="layui-logo"><img src="'+main_data.project_logo+'" class="layui-nav-img">'+main_data.project_title+'</div></a><ul class="layui-nav layui-layout-right"><li class="layui-nav-item"><a href="/?temp=user_msg"><span>'+main_data.user_role+'：</span>'+main_data.user_name+'</a></li><li class="layui-nav-item"><a href="/index.php/Login/to_logout">退出</a></li></ul>';

            var navigate_data = '';
            if(navigate_list.length > 0){
                $.each(navigate_list,function(i){
                    var is_check_parent = "";
                    if(navigate_list[i]["is_check"] == 1){
                        is_check_parent = "layui-nav-itemed";
                    }
                    navigate_data += '<li class="layui-nav-item '+is_check_parent+'"><a href="javascript:;">'+navigate_list[i]["name"]+'</a>';
                    if(navigate_list[i]["children"].length > 0){
                        navigate_data += '<dl class="layui-nav-child">';
                        $.each(navigate_list[i]["children"],function(j){
                            var is_check_children = "";
                            if(navigate_list[i]["children"][j]["is_check"] == 1){
                                is_check_children = "layui-this";
                            }
                            navigate_data += '<dd class="'+is_check_children+'"><a href="/?temp='+navigate_list[i]["children"][j]["url"]+'">'+navigate_list[i]["children"][j]["name"]+'</a></dd>';
                        })
                        navigate_data += '</dl>';
                    }
                    navigate_data += '</li>';
                })
            }

            var date=new Date;
            var year=date.getFullYear();
            var footer_data = '<div>© '+year+' '+main_data.domain+'</div>';

            obj = {
                main_data:main_data,
                header_data:header,
                navigate_data:navigate_data,
                footer_data:footer_data
            }
            exports('navigation', obj);
        }
    });
});