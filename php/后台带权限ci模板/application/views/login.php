<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>登录-<?php echo $project_title; ?></title>
    <link rel="stylesheet" href="/public/layui/css/layui.css">
    <link rel="stylesheet" href="/public/css/login.css">
    <script src="/public/layui/layui.js"></script>
</head>
<body class="login-body body">
    <div class="login-box">
        <form class="layui-form layui-form-pane" method="get" action="">
            <div class="layui-form-item">
                <h3><?php echo $project_title; ?>后台管理系统</h3>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">账号：</label>

                <div class="layui-input-inline">
                    <input type="text" name="account" class="layui-input" lay-verify="account" placeholder="账号"
                           autocomplete="on" maxlength="20"/>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">密码：</label>

                <div class="layui-input-inline">
                    <input type="password" name="password" class="layui-input" lay-verify="password" placeholder="密码"
                           maxlength="20"/>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">验证码：</label>

                <div class="layui-input-inline">
                    <input type="number" name="code" class="layui-input" lay-verify="code" placeholder="验证码" maxlength="4"/><span id="captcha"></span>
                    <!-- <input type="number" name="code" class="layui-input" lay-verify="code" placeholder="验证码" maxlength="4"/><img src="" alt="" id="change_captcha"> -->
                </div>
            </div>
            <div class="layui-form-item">
                <button type="reset" class="layui-btn layui-btn-danger btn-reset">重置</button>
                <button type="button" class="layui-btn btn-submit" lay-submit="" lay-filter="sub">立即登录</button>
            </div>
        </form>
    </div>
</body>
</html>

<script type="text/javascript">
    layui.config({
        base: '/public/js/modules/'
    }).extend({
        commons: 'extends/commons'
    }).use('login');


</script>