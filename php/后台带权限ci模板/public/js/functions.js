function is_empty_var(option){
	var is_empty = 1;
	if(option != "" && option != null && option != undefined){
		is_empty = 0;
	}
	return is_empty;
}

function get_query_string(name){
	var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
	var r = window.location.search.substr(1).match(reg);
	if(r!=null)return  unescape(r[2]); return null;
}



//得到事件
function get_event(){
     if(window.event){
     	return window.event;
     }
     func=get_event.caller;
     while(func!=null){
         var arg0=func.arguments[0];
         if(arg0){
             if((arg0.constructor==Event || arg0.constructor ==MouseEvent
                || arg0.constructor==KeyboardEvent)
                ||(typeof(arg0)=="object" && arg0.preventDefault
                && arg0.stopPropagation)){
                 return arg0;
             }
         }
         func=func.caller;
     }
     return null;
}
//阻止冒泡
function cancel_bubble()
{
    var e=get_event();
    if(window.event){
        //e.returnValue=false;//阻止自身行为
        e.cancelBubble=true;//阻止冒泡
     }else if(e.preventDefault){
        //e.preventDefault();//阻止自身行为
        e.stopPropagation();//阻止冒泡
     }
}


function repeat(target,n) {
    if (n == 1) {
        return target;
    }
    var s = repeat(target, Math.floor(n / 2));
    s += s;
    if (n % 2) {
        s += target;
    }
    return s;
}

function str_repeat(str, num){ 
    return new Array( num + 1 ).join( str ); 
}