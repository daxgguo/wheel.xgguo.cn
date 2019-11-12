layui.define(['jquery','navigation','commons','element','laytpl','table','form','laydate'], function(exports){
    var $ = layui.jquery;
    var element = layui.element;
    var navigation = layui.navigation;
    var commons = layui.commons;
    var laytpl = layui.laytpl;
    var table = layui.table;
    var form = layui.form;
    var laydate = layui.laydate;

    var init_page = function(){
        document.title = document.title+'-'+navigation.main_data.project_title;
        $("#header").html(navigation.header_data);
        $("#navigation").html(navigation.navigate_data);
        $("#footer").html(navigation.footer_data);
        element.init();
    }




    //搜索条件
    // where = {name:"",phone:""};
    var where = {};
    var newDate = new Date();
    var role_list = [];
    var branch_list = [];




    var get_role_list = function(cb){
        commons.ajax_post("/index.php/Role/get_role_list",{},function(res_data){
            if(res_data.is_ok == 1){
                role_list = res_data.data;
                typeof cb == "function" && cb(res_data.data);
            }
        });
    }


    var show_edit_data = function(show_data){
        var getTpl = sys_user_edit.innerHTML;
        show_data.role_list = role_list;
        laytpl(getTpl).render(show_data, function(html){
          layer.open({
            title: '编辑系统用户',
            type:1,
            area:[commons.body_width*0.6+"px",commons.body_height*0.5+"px"],
            btn:["立即提交"],
            content: html,
            yes:function(){
              $("#submit_data").click();
            }
          });
          form.render();
        });
    }

    get_role_list(function(){
        table.render({
          elem: '#sys_user_list',
          url:'/index.php/Sys_user/sys_user_list',
          where:where,
          loading:true,
          limit:30,
          cols: [[
            {field:'username', title: '账号',align:"center"}
            // ,{field:'nickname', title: '昵称',align:"center"}
            ,{field:'role_id', title: '角色',align:"center",templet:function(d){
                var this_role_name = "";
                for(var i=0;i<role_list.length;i++){
                    if(role_list[i].id == d.role_id){
                        this_role_name = role_list[i].name;
                        break;
                    }
                }
                return this_role_name;
            }}
            ,{field:'remark', title: '备注',align:"center"}
            ,{field:'create_time', width:95, title: '注册时间',templet:function(d){
              newDate.setTime(d.create_time * 1000);
              return newDate.format('yyyy-MM-dd');
            },align:"center"}
            ,{field:'right',title:"操作",toolbar:'#editer',align:"center"}
          ]]
          ,page: true,
          size: 'sm'
        });
    })



    $("#add").click(function(){
        var show_data = {
            id : 0,
            username : "",
            nickname : "",
            remark : "",
            role_id : 0
        };
        show_edit_data(show_data);
    })


    table.on('tool(sys_user_list)', function(obj){
      var data = obj.data;
      var layEvent = obj.event;
      var tr = obj.tr;
      var that = $(this);

      var curr_id = data.id;
      if(layEvent === 'edit_data'){
        var show_data = data;
        show_edit_data(show_data);
      }else if(layEvent === 'delete_data'){
        var this_tips = layer.open({
          content: '确定删除吗？',
          closeBtn:1
          ,btn: ['确定', '取消']
          ,yes: function(index, layero){
            layer.close(this_tips);
            var sys_user_data = table.cache.sys_user_list;
            var loading = layer.load(2);
            commons.ajax_post("/index.php/Sys_user/update_sys_suer_status",{sys_user_id:curr_id},function(res_data){
                layer.close(loading);
                if(res_data.is_ok == 1){
                    $.each(sys_user_data,function(j){
                      if(sys_user_data[j]["id"] == curr_id){
                        sys_user_data.splice(j, 1);
                      }
                    })
                    table.reload("sys_user_list",{
                      data:sys_user_data,
                      url:''
                    })
                }
                layer.msg(res_data.msg);
            });
          },
          btn2: function(index, layero){
            layer.close(this_tips)
          }
        });
      }
    });



    form.on('submit(submit_data)', function(data){
        var save_data = data.field;
        if(save_data.username != ""){
            var loading = layer.load(2,{tipsMore:true});
            commons.ajax_post("/index.php/Sys_user/save_sys_user",{save_data:save_data},function(res_data){
                layer.close(loading);
                layer.msg(res_data.msg,{tipsMore:true});
                if(res_data.is_ok == 1){
                    setTimeout(function(){
                      layer.closeAll();
                    },1500);
                    table.reload("sys_user_list");
                }
            });
        }
        return false;
    });


    $("#user_name").change(function(){
      var curr_data = $(this).val();
      where.name = curr_data;
    });
    $("#search_list").click(function(){
      table.reload("sys_user_list",{
        where:where
      });
    })



  init_page();
  exports('sys_user',{});
});
