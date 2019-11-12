<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>系统用户</title>
    <link rel="stylesheet" href="/public/layui/css/layui.css">
    <link rel="stylesheet" href="/public/css/common.css">
    <style type="text/css">
        .textarea{
            height: 120px;
        }
    </style>
    <script src="/public/layui/layui.js"></script>
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
                    <label class="layui-form-label">用户名：</label><input class="layui-input layui-input-sm" type="text" id="user_name">
                    <button class="layui-btn layui-btn-sm search_list" id="search_list">搜索</button>
                </div>

                <div class="add_delete width_100 flex_end">
                    <button class="layui-btn layui-btn-sm" id="add">添加</button>
                </div>
            </div>

            <table id="sys_user_list" lay-filter="sys_user_list"></table>

            <script type="text/html" id="editer">
                <a class="layui-btn layui-btn-xs edit_btn" lay-event="edit_data">修改</a>
                <a class="layui-btn layui-btn-xs edit_btn" lay-event="delete_data">删除</a>
            </script>



            <script type="text/html" id="sys_user_edit">
                <form class="layui-form height_100" action="">
                    <div class="height_100 flex_column_between">
                        <div class="width_90 edit_padding">
                            <div class="flex_wrap">
                                <div class="layui-form-item width_50">
                                    <label class="layui-form-label">账号</label>
                                    <div class="layui-input-block">
                                        <input type="hidden" name="id" value="{{d.id}}">
                                        <input type="text" name="username" placeholder="请输入账号" class="layui-input" value="{{d.username}}">
                                    </div>
                                </div>
                                <div class="layui-form-item width_50">
                                    <label class="layui-form-label">密码</label>
                                    <div class="layui-input-block">
                                        <input type="password" name="password" placeholder="请输入密码" class="layui-input" value="">
                                    </div>
                                </div>
                                <div class="layui-form-item width_50">
                                    <label class="layui-form-label">角色</label>
                                    <div class="layui-input-block">
                                      <select name="role_id">
                                        <!-- <option value="">请选择</option> -->
                                        {{# for(var i=0;i < d.role_list.length;i++){ }}
                                            <option value="{{d.role_list[i].id}}" {{d.role_id==d.role_list[i].id ? "selected":""}}>{{d.role_list[i].name}}</option>
                                        {{# } }}
                                      </select>
                                    </div>
                                </div>
                                <div class="layui-form-item width_80">
                                    <label class="layui-form-label">备注</label>
                                    <div class="layui-input-block">
                                        <textarea name="remark" class="width_100 textarea">{{d.remark==null ? "" : d.remark}}</textarea>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="flex_end width_100 tmp_submit_btn">
                            <button class="layui-btn" lay-submit lay-filter="submit_data" id="submit_data">立即提交</button>
                        </div>
                    </div>
                </form>
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
    }).use('sys_user');

  
</script>