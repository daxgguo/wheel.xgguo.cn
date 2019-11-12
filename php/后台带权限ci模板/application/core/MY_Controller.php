<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller{
	public function  __construct(){
		parent::__construct();
	}
}

class Admin_base extends MY_Controller {
	public function __construct(){
		parent::__construct();


		$user_cache_key = $this->config->item("project_prefix")."sys_user_data";
		$is_login = $this->session->has_userdata($user_cache_key);
		if(!$is_login){
			header("Location:/".index_page()."/Login/to_login");
		}

		// $segment = $this->input->get();
		// $temp = isset($segment["temp"]) ? $segment["temp"] : "";
		// $type = 1;
		// if(empty($temp)){
		// 	$type = 2;

		// 	$url_string = uri_string();
		// 	$url_prex = explode("?", $url_string);
		// 	$temp = strtolower($url_prex[0]);
		// }

		// $this->load->model("user_model");
		// $res_data = $this->user_model->check_auth($type,$temp);
		// if($res_data["is_ok"] == 0){
		// 	show_error("没有权限访问(".$temp.")页面");
		// 	die;
		// }elseif($res_data["is_ok"] == 2){
		// 	// redirect('/Login/to_login');
		// 	header("Location:/".index_page()."/Login/to_login");
		// }
	}
}