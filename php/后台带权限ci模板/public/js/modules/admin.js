layui.define(['jquery','navigation','element','laytpl'], function(exports){
    var $ = layui.jquery;
    var element = layui.element;
    var navigation = layui.navigation;
    var laytpl = layui.laytpl;

    var init_page = function(){
        document.title = document.title+'-'+navigation.main_data.project_title;
        $("#header").html(navigation.header_data);
        $("#navigation").html(navigation.navigate_data);
        $("#footer").html(navigation.footer_data);
        element.init();
    }



    // 新增方法

    // var data = { //数据
    //   "title":"Layui常用模块",
    //   "my_name":"雄蝈蝈"
    //   ,"list":[{"modname":"弹层","alias":"layer","site":"layer.layui.com"},{"modname":"表单","alias":"form"}]
    // }
    // var view = document.getElementById('body');
    // var getTpl = body_templete.innerHTML;
    // laytpl(getTpl).render(data, function(html){
    //   view.innerHTML = html;
    // });







    init_page();
    exports('admin',{});
});