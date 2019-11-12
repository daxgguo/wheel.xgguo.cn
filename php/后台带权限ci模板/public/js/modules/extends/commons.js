// 公共方法
layui.define(['jquery'], function(exports){
    var layer = layui.layer;
    var $ = layui.jquery;
    var ajax_post = function(url,data,cb){
    	$.post(url,data,function(res){
    		var res_data = JSON.parse(res);
    		typeof cb == "function" && cb(res_data);
    	})
    }

    var body_width = $(window).width();
    var body_height = $(window).height();

    // var timestamp3 = 1403058804;
    // var newDate = new Date();
    // newDate.setTime(timestamp3 * 1000);
    Date.prototype.format = function(format) {
        var date = {
            "M+": this.getMonth() + 1,
            "d+": this.getDate(),
            "h+": this.getHours(),
            "m+": this.getMinutes(),
            "s+": this.getSeconds(),
            "q+": Math.floor((this.getMonth() + 3) / 3),
            "S+": this.getMilliseconds()
        };
        if (/(y+)/i.test(format)) {
            format = format.replace(RegExp.$1, (this.getFullYear() + '').substr(4 - RegExp.$1.length));
        }
        for (var k in date) {
            if (new RegExp("(" + k + ")").test(format)) {
                format = format.replace(RegExp.$1, RegExp.$1.length == 1 ? date[k] : ("00" + date[k]).substr(("" + date[k]).length));
            }
        }
        return format;
    }
    // console.log(newDate.format('yyyy-MM-dd h:m:s'));



    $.getUrlParam = function (name) {
        var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
        var r = window.location.search.substr(1).match(reg);
        if (r != null) return unescape(r[2]); return null;
    }
    // var user_id = $.getUrlParam("user_id");


    var check_mobile = function(sMobile){
        var is_ok = 1;
        if(!(/^1[3|4|5|8][0-9]\d{4,8}$/.test(sMobile))){ 
            is_ok = 0;
        }
        return is_ok;
    }

    var is_empty = function(data){
        if(data == "" || data == null || data == undefined){
            return false;
        }
        return true;
    }

    var time_to_timestamp = function(time){
      var date = new Date(time);
      var times = Date.parse(date);
      times = parseInt(times/1000);
      return times;
    }


    var generateMixed = function(n,cb) {
       var res = "";
       for(var i = 0; i < n ; i ++) {
         res += Math.floor(Math.random()*10+1)+"";
       }
       typeof cb && cb(res);
    }

    obj = {
    	ajax_post:ajax_post,
        check_mobile:check_mobile,
        is_empty:is_empty,
        time_to_timestamp:time_to_timestamp,
        body_width:body_width,
        body_height:body_height,
        generateMixed:generateMixed
    }
    exports('commons', obj);
});