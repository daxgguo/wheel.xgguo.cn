var domain_url = document.location.toString();
var arr_url = domain_url.split("//");
var pre = arr_url[0];
var domain = document.domain;
var curr_base_url = pre+"//"+domain;

var config = {
	base_url:curr_base_url,
	index_page:"home.php",
	share_title:"贷款就来贷款超市",
	share_desc:"贷款就来贷款超市",
	item_name:"贷款超市"
}