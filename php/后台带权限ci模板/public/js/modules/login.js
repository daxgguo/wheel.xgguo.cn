layui.define(['form', 'layer','commons'], function(exports){

    // 操作对象
    var commons = layui.commons;
    var form = layui.form
            , layer = layui.layer
            , $ = layui.jquery;

    // 验证
    form.verify({
        account: function (value) {
            if (value == "") {
                return "请输入用户名";
            }
        },
        password: function (value) {
            if (value == "") {
                return "请输入密码";
            }
        },
        code: function (value) {
            if (value == "") {
                return "请输入验证码";
            }
        }
    });


    var get_captcha = function(cb){
        commons.ajax_post("/index.php/Login/get_captcha",{},function(res_data){
            typeof cb == "function" && cb(res_data.img);
        });
    }
    get_captcha(function(img){
        $("#captcha").html(img)
    })

    $("#captcha").click(function(){
        get_captcha(function(img){
            $("#captcha").html(img)
        })
    })

    // 提交监听
    form.on('submit(sub)', function (data) {
        var login_data = data.field;
        commons.ajax_post("/index.php/Login/to_login",{login_data:login_data},function(res_data){
            if(res_data.is_ok == 1){
                window.location.href="/";
            }else{
                layer.msg(res_data.msg);
            }
        });
    });
    exports('login',{});
});
