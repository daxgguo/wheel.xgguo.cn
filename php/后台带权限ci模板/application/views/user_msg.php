<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>后台管理</title>
    <link rel="stylesheet" href="/public/layui/css/layui.css">
    <link rel="stylesheet" href="/public/css/common.css">
    <style type="text/css">
        .btn_content{
            padding-top: 20px;
        }
        .content>div{
            margin: 0 20px;
        }
        .main_content{
            border: 1px solid #00802b;
            border-radius: 3px;
            padding: 40px 20px;
        }
        .layui-input{
            width: 80%;
        }
        .confirm{
            margin-top: 20px;
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
            <div class="width_100 height_100 flex_column">
                <div class="flex_column main_content">
                    <div class="flex_row content">
                        <div class="flex_row">
                            <div>账号：</div>
                            <div>admin</div>
                        </div>
                        <div class="flex_row">
                            <div>角色：</div>
                            <div>超级管理员</div>
                        </div>
                    </div>
                    <div class="btn_content">
                        <button class="layui-btn layui-btn-sm" id="edit_password">修改密码</button>
                    </div>
                </div>
            </div>

            <script type="text/html" id="editer">
                <div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">输入密码</label>
                        <div class="layui-input-block">
                            <input type="password" id="password" required  placeholder="请输入密码" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">再次输入</label>
                        <div class="layui-input-block">
                            <input type="password" id="t_password" required placeholder="请再次输入密码" class="layui-input">
                        </div>
                    </div>
                    <div class="confirm flex_end width_100">
                        <button class="layui-btn layui-btn-sm layui-btn-danger" id="confirm_btn">确认修改</button>
                    </div>
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
    }).use('user_msg');

  
</script>