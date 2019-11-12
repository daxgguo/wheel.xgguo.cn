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



    var show_edit_data = function(show_data){
        var getTpl = node_edit.innerHTML;
        show_data.curr_node_list = curr_node_list;
        laytpl(getTpl).render(show_data, function(html){
          layer.open({
            title: '编辑节点',
            area:[commons.body_width*0.6+"px",commons.body_height*0.6+"px"],
            btn:["立即提交"],
            content: html,
            yes:function(){
              $("#submit_data").click();
            }
          });
          form.render();
        });
    }


    get_node_list(function(){
        table.render({
          elem: '#node_list',
          url:'',
          data:curr_node_list,
          where:where,
          loading:true,
          limit:1000,
          cols: [[
            {field:'', title: '序号',align:"center",type:"numbers"}
            ,{field:'title', title: '名称',templet:function(d){
                var name_string = str_repeat("-",8*d.level)+d.title;
                return name_string;
            }}
            ,{field:'name', title: '节点链接',align:"center"}
            ,{field:'status', title: '状态',align:"center",templet:function(d){
                return d.status == 1 ? "启用中":"禁用中";
            }}
            ,{field:'right',title:"操作",toolbar:'#editer',align:"center"}
          ]]
        });
    })



    $("#to_add").click(function(){
        var curr_time = Date.parse(newDate)/1000;
        var show_data = {
            id:0,
            level:0,
            name:"",
            pid:"0",
            remark:null,
            status:"1",
            title:"",
            type:"1"
        };
        show_edit_data(show_data);
    })

    table.on('tool(node_list)', function(obj){
      var data = obj.data;
      var layEvent = obj.event;
      var tr = obj.tr;
      var that = $(this);

      var curr_id = data.id;
      if(layEvent === 'edit_data'){
        var show_data = data;
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
        commons.ajax_post("/index.php/Node/update_node_status",{node_id:curr_id,status:status},function(res_data){
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
        var save_data = data.field;
        
        var loading = layer.load(2);
        commons.ajax_post("/index.php/Node/save_node",{save_data:save_data},function(res_data){
            layer.close(loading);
            layer.msg(res_data.msg);
            if(res_data.is_ok == 1){
                setTimeout(function(){
                    location.reload();
                },1000)
            }
        });
        return false;
    });



  init_page();
  exports('node_list',{});
});
