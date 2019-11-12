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




    var show_edit_data = function(show_data){
        var getTpl = meal_edit.innerHTML;
        newDate.setTime(show_data.pre_deliver * 1000);
        show_data.pre_deliver = newDate.format('yyyy-MM-dd');
        newDate.setTime(show_data.birth_time * 1000);
        show_data.birth_time = newDate.format('yyyy-MM-dd');
        laytpl(getTpl).render(show_data, function(html){
          layer.open({
            title: '编辑客户',
            type:1,
            area:[commons.body_width*0.5+"px",commons.body_height*0.8+"px"],
            btn:["立即提交"],
            content: html,
            yes:function(){
              $("#submit_data").click();
            }
          });
          laydate.render({
              elem: '#birth_time' //指定元素
          });
          laydate.render({
              elem: '#pre_deliver' //指定元素
          });
          form.render();
        });
    }


    table.render({
      elem: '#user_list',
      url:'/index.php/User/user_list',
      where:where,
      loading:true,
      limit:30,
      cols: [[
        {field:'name', title: '用户姓名',align:"center"},
        {field:'room_num', title: '房间号',align:"center"},
        {field:'age', title: '年龄',align:"center"},
        {field:'birth_num', title: '胎次',align:"center"},
        {field:'phone', title: '电话',align:"center"},
        {field:'balance', title: '余额',align:"center"},
        {field:'contract_code', title: '合同编码',align:"center"},
        {field:'title', title: '套餐名称',align:"center"},
        {field:'right',title:"操作",toolbar:'#editer',align:"center"}
      ]]
      ,page: true,
      size: 'sm'
    });


    table.on('tool(user_list)', function(obj){
      var data = obj.data;
      var layEvent = obj.event;
      var tr = obj.tr;
      var that = $(this);
      var curr_id = data.id;

      var curr_id = data.id;
      if(layEvent === 'edit_data'){
        var show_data = data;
        show_edit_data(show_data);
      }else if(layEvent === 'baby_health_assess'){
        location.href="/?temp=baby_health_assess&user_id="+curr_id;
      }else if(layEvent === 'mather_health_assess'){
        location.href="/?temp=mather_health_assess&user_id="+curr_id;
      }else if(layEvent === 'meal_plan'){
        location.href="/?temp=meal_plan&user_id="+curr_id;
      }else if(layEvent === 'meal_used_list'){
        location.href="/?temp=meal_used_list&user_id="+curr_id;
      }
    });



    form.on('submit(submit_data)', function(data){
        var save_data = data.field;
        var loading = layer.load(2,{tipsMore:true});
        save_data.pre_deliver = commons.time_to_timestamp(save_data.pre_deliver).toString();
        save_data.birth_time = commons.time_to_timestamp(save_data.birth_time).toString();
        commons.ajax_post("/index.php/User/save_user",{save_data:save_data},function(res_data){
            layer.close(loading);
            layer.msg(res_data.msg,{tipsMore:true});
            if(res_data.is_ok == 1){
                table.reload("user_list");
                setTimeout(function(){
                  layer.closeAll();
                },1500);
            }
        });
        return false;
    });


    $("#search_name").change(function(){
      var curr_data = $(this).val();
      where.name = curr_data;
    });
    $("#search_contract_code").change(function(){
      var curr_data = $(this).val();
      where.contract_code = curr_data;
    });
    $("#search_phone").change(function(){
      var curr_data = $(this).val();
      where.phone = curr_data;
    });
    $("#search_list").click(function(){
      table.reload("user_list",{
        where:where
      });
    })




  init_page();
  exports('user_list',{});
});
