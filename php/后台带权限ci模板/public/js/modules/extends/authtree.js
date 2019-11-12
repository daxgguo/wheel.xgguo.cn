/*
* @Author: 94468
* @Date:   2018-03-16 18:24:47
* @Last Modified by:   94468
* @Last Modified time: 2018-03-23 17:03:38
*/
// 节点树
layui.define(['jquery', 'form'], function(exports){
	$ = layui.jquery;
	form = layui.form;

	obj = {
		// 渲染 + 绑定事件
		/**
		 * 渲染DOM并绑定事件
		 * @param  {[type]} dst       [目标ID，如：#test1]
		 * @param  {[type]} trees     [数据，格式：{}]
		 * @param  {[type]} inputname [上传表单名]
		 * @return {[type]}           [description]
		 */
		render: function(dst, trees, inputname){
			var inputname = inputname ? inputname : 'menuids[]';
			$(dst).html(obj.renderAuth(trees, 0, inputname));
			form.render();
			form.on('checkbox(checkauths)', function(data){
				/*属下所有权限状态跟随，如果选中，往上走全部选中*/
				var childs = $(data.elem).parent().next().find('input[type="checkbox"]').prop('checked', data.elem.checked);
				if(data.elem.checked){
					/*查找child的前边一个元素，并将里边的checkbox选中状态改为true。*/
					$(data.elem).parents('.auth-child').prev().find('input[type="checkbox"]').prop('checked', true);
				}
				/*console.log(childs);*/
				form.render('checkbox');
			});

			/*动态绑定展开事件*/
			$(dst).unbind('click').on('click', '.auth-icon', function(){
				var origin = $(this);
				var child = origin.parent().parent().find('.auth-child:first');
				if(origin.is('.active')){
					/*收起*/
					origin.removeClass('active').html('');
					child.slideUp('fast');
				} else {
					/*展开*/
					origin.addClass('active').html('');
					child.slideDown('fast');
				}
				return false;
			})
		},
		// 递归创建格式
		renderAuth: function(tree, dept, inputname){
			var str = '<div class="auth-single">';
			layui.each(tree, function(index, item){
				var hasChild = item.list ? 1 : 0;
				// 注意：递归调用时，this的环境会改变！
				var append = hasChild ? obj.renderAuth(item.list, dept+1, inputname) : '';

				// '+new Array(dept * 4).join(' ')+'
				str += '<div><div class="auth-status"> '+(hasChild?'<i class="layui-icon auth-icon" style="cursor:pointer;"></i>':'')+(dept > 0 ? '<span>├─ </span>':'')+'<input type="checkbox" name="'+inputname+'" title="'+item.name+'" value="'+item.value+'" lay-skin="primary" lay-filter="checkauths" '+(item.checked?'checked="checked"':'')+'> </div> <div class="auth-child" style="display:none;padding-left:40px;"> '+append+'</div></div>'
			});
			str += '</div>';
			return str;
		}
	}
	exports('authtree', obj);
});