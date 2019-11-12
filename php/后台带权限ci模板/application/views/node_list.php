<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>节点管理</title>
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
                    <button class="layui-btn layui-btn-sm" id="to_add">新建节点</button>
                </div>
            </div>

            <table id="node_list" lay-filter="node_list"></table>

            <script type="text/html" id="editer">
                <a class="layui-btn layui-btn-xs edit_btn" lay-event="edit_data">编辑</a>
                <a class="layui-btn layui-btn-xs edit_btn" lay-data="{{d.status}}" lay-event="update_status">{{d.status == 1 ? "禁用" : "启用"}}</a>
            </script>

            <script type="text/html" id="node_edit">
                <div class="width_90 edit_padding">
                    <form class="layui-form height_100" action="">
                        <div class="height_100 flex_column_between">
                            <div class="width_100">
                                <div class="flex_wrap">
                                    <div class="layui-form-item width_33">
                                        <label class="layui-form-label">节点名称</label>
                                        <div class="layui-input-block">
                                            <input type="hidden" name="id" value="{{d.id}}">
                                            <input type="text" name="title" placeholder="请输入名称" class="layui-input" value="{{d.title}}">
                                        </div>
                                    </div>
                                    <div class="layui-form-item width_33">
                                        <label class="layui-form-label">节点链接</label>
                                        <div class="layui-input-block">
                                            <input type="text" name="name" placeholder="请输入链接" class="layui-input" value="{{d.name}}">
                                        </div>
                                    </div>
                                    <div class="layui-form-item width_33">
                                        <label class="layui-form-label">父级节点</label>
                                        <div class="layui-input-block">
                                          <select name="pid" lay-verify="required">
                                            <option value="">请选择</option>
                                            {{# for(var i=0;i < d.curr_node_list.length;i++){ }}
                                                <option value="{{d.curr_node_list[i].id}}" {{d.pid==d.curr_node_list[i].id ? "selected":""}}>{{str_repeat("-",6*d.curr_node_list[i].level)+d.curr_node_list[i].title}}</option>
                                            {{# } }}
                                          </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex_end width_100 tmp_submit_btn">
                                <button class="layui-btn" lay-submit lay-filter="submit_data" id="submit_data">立即提交</button>
                            </div>
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
    }).use('node_list');

  
</script>