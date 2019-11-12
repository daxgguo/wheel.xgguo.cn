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
    var curr_node_list = [];


    var get_node_list = function(cb){
        commons.ajax_post("/index.php/Node/node_list",{},function(res_data){
            if(res_data.is_ok == 1){
                curr_node_list = res_data.data;
                typeof cb == "function" && cb(res_data.data);
            }
        });
    }

    var get_role_detail_by_id = function(role_id,cb){
        commons.ajax_post("/index.php/Role/get_role_detail_by_id",{role_id:role_id},function(res_data){
            var node_checked_list = [];
            if(res_data.is_ok == 1){
                node_checked_list = res_data.node_checked_list;
            }
            typeof cb == "function" && cb(node_checked_list);
        });
    }



    var show_edit_data = function(show_data){
        var getTpl = role_edit.innerHTML;
        get_role_detail_by_id(show_data.id,function(node_checked_list){
            show_data.curr_node_list = curr_node_list;
            show_data.node_checked_list = node_checked_list;
            laytpl(getTpl).render(show_data, function(html){
              layer.open({
                title: '编辑角色',
                area:[commons.body_width*0.8+"px",commons.body_height*0.8+"px"],
                btn:["立即提交"],
                content: html,
                yes:function(){
                  $("#submit_data").click();
                }
              });
              form.render();
            });
        })
    }


    var reg_node_id = function(string){
        var res = string.search(/node_id/);
        return res;
    }


    get_node_list(function(){
        table.render({
          elem: '#role_list',
          url:'/index.php/Role/role_list',
          where:where,
          loading:true,
          limit:20,
          cols: [[
            {field:'', title: '序号',align:"center",type:"numbers"}
            ,{field:'name', title: '名称',align:'center'}
            ,{field:'node_list', title: '拥有的权限',align:"center",minWidth:150}
            ,{field:'status', title: '状态',align:"center",templet:function(d){
                return d.status == 1 ? "启用中":"禁用中";
            }}
            ,{field:'right',title:"操作",toolbar:'#editer',align:"center"}
          ]],
          page: true,
          size: 'sm'
        });
    })



    $("#to_add").click(function(){
        var curr_time = Date.parse(newDate)/1000;
        var show_data = {
            id:0,
            name:"",
            status:"1"
        };
        show_edit_data(show_data);
    })

    table.on('tool(role_list)', function(obj){
      var data = obj.data;
      var layEvent = obj.event;
      var tr = obj.tr;
      var that = $(this);

      var curr_id = data.id;
      if(layEvent === 'edit_data'){
        var show_data = data;
        delete show_data.node_list;
        show_edit_data(show_data);
      }else if(layEvent === 'update_status'){
        var status = 1;
        var status_string = "禁用";
        if(that.attr("lay-data") == 1){
            //去禁用
            status = 0;
            status_string = "启用";
        }
        var loading = layer.load(2);
        commons.ajax_post("/index.php/Role/update_role_status",{role_id:curr_id,status:status},function(res_data){
            layer.close(loading);
            if(res_data.is_ok == 1){
                that.attr("lay-data",status);
                that.html(status_string);
                data.status=status;
                // obj.update(data);
            }
            layer.msg(res_data.msg);
        });
      }
    });



    form.on('submit(submit_data)', function(data){
        var role_id = data.field.role_id;
        var role_name = data.field.role_name;
        var all_data = data.field;
        var node_ids = [];
        $.each(all_data,function(i){
            var res = reg_node_id(i);
            if(res >= 0){
                node_ids.push(all_data[i]);
            }
        })
        if(role_id == undefined || role_id == null){
            layer.msg("参数错误，请刷新重试");
            return false;
        }
        if(node_ids.length <= 0){
           layer.msg("请分类权限");
           return false; 
        }
        $.post("/index.php/Role/save_role",{role_id:role_id,role_name:role_name,node_ids:node_ids},function(res){
            var res_data = JSON.parse(res);
            layer.msg(res_data.msg);
            if(res_data.is_ok == 1){
                setTimeout(function(){
                    location.reload();
                },1500);
            }
        })

        return false;
    });




  init_page();
  exports('role_list',{});
});
