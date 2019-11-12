<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>角色管理</title>
    <link rel="stylesheet" href="/public/layui/css/layui.css">
    <link rel="stylesheet" href="/public/css/common.css">
    <script src="/public/layui/layui.js"></script>
    <script src="/public/js/functions.js"></script>
</head>
<body class="layui-layout-body">
    <div class="layui-layout layui-layout-admin">
        <!-- 头部 -->
        <div class="layui-header" id="header">
        </div>

        <!-- 导航栏 -->
        <div class="layui-side layui-bg-black">
            <ul class="layui-nav layui-nav-tree" id="navigation">
            </ul>
        </div>

        <!-- 内容 -->


        <div class="layui-body">
            <div class="flex_cloumn top_content">
                <div class="flex_start width_100">
                </div>
                <div class="add_delete width_100 flex_end">
                    <button class="layui-btn layui-btn-sm" id="to_add">新建角色</button>
                </div>
            </div>

            <table id="role_list" lay-filter="role_list"></table>

            <script type="text/html" id="editer">
                <a class="layui-btn layui-btn-xs edit_btn" lay-event="edit_data">编辑</a>
                <a class="layui-btn layui-btn-xs edit_btn" lay-data="{{d.status}}" lay-event="update_status">{{d.status == 1 ? "禁用" : "启用"}}</a>
            </script>

            <script type="text/html" id="role_edit">
                <div class="width_90 edit_padding">
                    <form class="layui-form">
                        <div class="layui-form-item">
                            <label class="layui-form-label">角色名称</label>
                            <div class="layui-input-block">
                                <input type="text" name="role_name" required  lay-verify="required" placeholder="请输入名称" autocomplete="off" class="layui-input input_length_middle width_50" value="{{d.name}}">
                                <input  type="hidden" name="role_id" value="{{d.id}}" >
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">节点列表</label>
                            <div class="layui-input-block">
                                {{# for(var i in d.curr_node_list){ 
                                    var repeat = str_repeat("-",16*d.curr_node_list[i].level);

                                    var is_checked = '';
                                    if(d.node_checked_list.length > 0){
                                        for(var k in d.node_checked_list){
                                            if(d.node_checked_list[k].id == d.curr_node_list[i].id){
                                                is_checked = 'checked="checked"';
                                            }
                                        }
                                    }
                                }}
                                    {{repeat}}<input level = "{{d.curr_node_list[i].level}}" type="checkbox" name="node_id[{{d.curr_node_list[i].id}}]" value="{{d.curr_node_list[i].id}}" {{is_checked}}>{{d.curr_node_list[i].title}}<br/>
                                {{# } }}

                            </div>
                        </div>

                        <div class="flex_end width_100 tmp_submit_btn">
                            <button class="layui-btn" lay-submit lay-filter="submit_data" id="submit_data">立即提交</button>
                        </div>
                    </form>
                </div>
            </script>
        </div>



        <!-- 底部 -->
        <div class="layui-footer flex_row" id="footer">
        </div>
    </div>
</body>
</html>


<script type="text/javascript">
    layui.config({
        base: '/public/js/modules/'
    }).extend({
        navigation: 'extends/navigation',
        commons: 'extends/commons'
    }).use('role_list');

  
</script>