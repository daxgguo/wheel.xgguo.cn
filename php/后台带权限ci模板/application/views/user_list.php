<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>客户管理</title>
    <link rel="stylesheet" href="/public/layui/css/layui.css">
    <link rel="stylesheet" href="/public/css/common.css">
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
            <div class="flex_column top_content">
                <div class="flex_start width_100">
                    <label class="layui-form-label">姓名：</label><input class="layui-input layui-input-sm" type="text" id="search_name">
                    <label class="layui-form-label">合同ID：</label><input class="layui-input layui-input-sm" type="text" id="search_contract_code">
                    <label class="layui-form-label">电话：</label><input class="layui-input layui-input-sm" type="text" id="search_phone">
                    <button class="layui-btn layui-btn-sm search_list" id="search_list">搜索</button>
                </div>
            </div>


            <table id="user_list" lay-filter="user_list"></table>

            <script type="text/html" id="editer">
                <a class="layui-btn layui-btn-xs edit_btn" lay-event="edit_data">编辑/查看详情</a>
                <!-- <a class="layui-btn layui-btn-xs edit_btn" lay-event="baby_health_assess">婴儿日常护理</a>
                <a class="layui-btn layui-btn-xs edit_btn" lay-event="mather_health_assess">孕妇日常护理</a> -->
                <!-- <a class="layui-btn layui-btn-xs edit_btn" lay-event="meal_plan">套餐计划</a>
                <a class="layui-btn layui-btn-xs edit_btn" lay-event="meal_used_list">套餐详情</a> -->
            </script>

            <script type="text/html" id="meal_edit">
                <div class="width_90 edit_padding">
                    <form class="layui-form height_100" action="">
                        <div class="height_100 flex_column_between">
                            <div class="flex_wrap">
                                <div class="layui-form-item width_50">
                                    <label class="layui-form-label">用户姓名</label>
                                    <div class="layui-input-block">
                                        <input type="hidden" name="id" value="{{d.id}}">
                                        <input type="text" name="name" placeholder="请输入姓名" class="layui-input" value="{{d.name}}">
                                    </div>
                                </div>
                                <div class="layui-form-item width_50">
                                    <label class="layui-form-label">用户年龄</label>
                                    <div class="layui-input-block">
                                        <input type="text" name="age" placeholder="请输入年龄" class="layui-input" value="{{d.age}}">
                                    </div>
                                </div>
                                <div class="layui-form-item width_50">
                                    <label class="layui-form-label">合同编码</label>
                                    <div class="layui-input-block">
                                        <input type="text" name="" placeholder="" class="layui-input" value="{{d.contract_code==null ? '':d.contract_code}}" disabled="disabled">
                                    </div>
                                </div>
                                <div class="layui-form-item width_50">
                                    <label class="layui-form-label">用户电话</label>
                                    <div class="layui-input-block">
                                        <input type="text" name="phone" placeholder="请输入电话" class="layui-input" value="{{d.phone}}">
                                    </div>
                                </div>
                                <div class="layui-form-item width_50">
                                    <label class="layui-form-label">余额</label>
                                    <div class="layui-input-block">
                                        <input type="text" name="balance" placeholder="请输入余额" class="layui-input" value="{{d.balance}}">
                                    </div>
                                </div>
                                <div class="layui-form-item width_50">
                                    <label class="layui-form-label">套餐名称</label>
                                    <div class="layui-input-block">
                                        <input type="text" name="" placeholder="" class="layui-input" value="{{d.title}}" disabled="disabled">
                                    </div>
                                </div>
                                <div class="layui-form-item width_50">
                                    <label class="layui-form-label">预产期</label>
                                    <div class="layui-input-block">
                                        <input type="text" name="pre_deliver" placeholder="请选择预产期" class="layui-input" value="{{d.pre_deliver}}" id="pre_deliver">
                                    </div>
                                </div>
                                <div class="layui-form-item width_50">
                                    <label class="layui-form-label">生产医院</label>
                                    <div class="layui-input-block">
                                        <input type="text" name="birth_hospital" placeholder="请输入医院名称" class="layui-input" value="{{d.birth_hospital}}">
                                    </div>
                                </div>
                                <div class="layui-form-item width_50">
                                    <label class="layui-form-label">生产方式</label>
                                    <div class="layui-input-block">
                                        <select name="birth_type" class="width_50">
                                            <option value="1" {{ d.birth_type == 1 ? "selected" : "" }}>顺产</option>
                                            <option value="2" {{ d.birth_type == 1 ? "" : "selected" }}>破腹生产</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="layui-form-item width_50">
                                    <label class="layui-form-label">生产时间</label>
                                    <div class="layui-input-block">
                                        <input type="text" name="birth_time" placeholder="请选择生产时间" class="layui-input" value="{{d.birth_time}}" id="birth_time">
                                    </div>
                                </div>
                                <div class="layui-form-item width_50">
                                    <label class="layui-form-label">胎次</label>
                                    <div class="layui-input-block">
                                        <input type="text" name="birth_num" placeholder="请输入胎次" class="layui-input" value="{{d.birth_num}}">
                                    </div>
                                </div>
                                <div class="layui-form-item width_50">
                                    <label class="layui-form-label">婴儿性别</label>
                                    <div class="layui-input-block">
                                        <select name="baby_sex" class="width_50">
                                            <option value="1" {{ d.baby_sex == 1 ? "selected" : "" }}>男</option>
                                            <option value="2" {{ d.baby_sex == 2 ? "selected" : "" }}>女</option>
                                            <option value="3" {{ d.baby_sex == 3 ? "selected" : "" }}>其他</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="layui-form-item width_50">
                                    <label class="layui-form-label">婴儿体重</label>
                                    <div class="layui-input-block">
                                        <input type="text" name="birth_weight" placeholder="" class="layui-input" value="{{d.birth_weight}}">
                                    </div>
                                </div>
                                <div class="layui-form-item width_50">
                                    <label class="layui-form-label">签约客服</label>
                                    <div class="layui-input-block">
                                        <input type="text" name="sign_name" placeholder="" class="layui-input" value="{{d.sign_name}}">
                                    </div>
                                </div>
                                <div class="layui-form-item width_50">
                                    <label class="layui-form-label">负责客服</label>
                                    <div class="layui-input-block">
                                        <input type="text" name="duty_name" placeholder="" class="layui-input" value="{{d.duty_name}}">
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
    }).use('user_list');

  
</script>