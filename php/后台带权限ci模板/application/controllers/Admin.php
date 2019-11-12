<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends Admin_base {

	public function index(){
		$segment = $this->input->get();
		$temp = isset($segment["temp"]) ? $segment["temp"] : "";
		$parent_temp = isset($segment["parent_temp"]) ? $segment["parent_temp"] : "";
		$temp = empty($temp) ? "admin" : $temp;
		$save_data = array(
			$this->config->item("project_prefix")."sys_user_temp" => $temp,
			$this->config->item("project_prefix")."sys_user_parent_temp" => $parent_temp
		);
		$this->session->set_userdata($save_data);
		$this->load->view($temp,$segment);
	}

	public function get_main_data(){
		$this->load->model("user_model");
		$auth_data = $this->user_model->get_navigate();
		// echo json_encode($auth_data);die;

		$res["main_data"] = array(
			"project_logo" => "/public/images/logo.jpg",
			"project_title" => $this->config->item("item_title"),
			"user_role" => $auth_data["role_name"],
			"user_name" => $auth_data["sys_user_name"],
			"domain" => $this->config->item("domain")
		);
		$res["navigate_list"] = $auth_data["navigate_list"];


		$temp_cache_key = $this->config->item("project_prefix")."sys_user_temp";
		$parent_temp_cache_key = $this->config->item("project_prefix")."sys_user_parent_temp";
		if($this->session->has_userdata($temp_cache_key)){
			$temp_data = $this->session->get_userdata();
			$this->session->unset_userdata($temp_cache_key);
			$club_user_temp = $temp_data[$temp_cache_key];
			$club_user_parent_temp = $temp_data[$parent_temp_cache_key];
			$navigate_list = $res["navigate_list"];
			foreach($navigate_list as $k => $v){
				if(isset($v["children"]) && count($v["children"]) > 0){
					foreach($v["children"] as $m => $n){
						if($n["is_check"] == 1 && $n["url"] != $club_user_temp){
							$navigate_list[$k]["children"][$m]["is_check"] = 0;
							$navigate_list[$k]["is_check"] = 0;
						}elseif($n["is_check"] == 1 && $n["url"] == $club_user_temp){
							break;
						}elseif(($n["is_check"] == 0 && $n["url"] == $club_user_temp) || $n["url"] == $club_user_parent_temp){
							$navigate_list[$k]["children"][$m]["is_check"] = 1;
							$navigate_list[$k]["is_check"] = 1;
						}
					}
				}
			}
			$res["navigate_list"] = $navigate_list;
		}

		$res["is_ok"] = 1;
		echo json_encode($res);
	}


	public function welcome(){
		echo "欢迎光临";
	}
}


