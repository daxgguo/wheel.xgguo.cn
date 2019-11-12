<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sys_user extends Admin_base {

	public function get_user_msg(){
		$user_cache_key = $this->config->item("project_prefix")."sys_user_data";
		$session_data = $this->session->get_userdata();
		if(isset($session_data[$user_cache_key])){
			$user_data = $session_data[$user_cache_key];
			$user_id = $user_data["user_id"];

			$this->load->model("common_model");
			$where["id"] = $user_id;
			$select = "";
			$res_data = $this->common_model->get_db_data($select,"sys_user",$where,array());
			if($res_data["is_ok"] == 1){
				$res_data = $res_data["data"][0];
				unset($res_data["password"]);
			}
			$res = $res_data;
		}else{
			$res["is_ok"] = 0;
			$res["msg"] = "登陆过期";
		}
		echo json_encode($res);
	}


	public function save_user_msg(){
		$user_cache_key = $this->config->item("project_prefix")."sys_user_data";
		$session_data = $this->session->get_userdata();
		if(isset($session_data[$user_cache_key])){
			$user_data = $session_data[$user_cache_key];
			$user_id = $user_data["user_id"];

			$password = $this->input->post("password");
			if(isset($password) && !empty(trim($password)))
			$this->load->model("common_model");
			$where["id"] = $user_id;
			$update_data = array(
				"password" => md5(md5(trim($password).$this->config->item("MD5_key")))
			);
			$res = $this->common_model->update_db_data("sys_user",$update_data,$where,2);
		}else{
			$res["is_ok"] = 0;
			$res["msg"] = "登陆过期";
		}
		echo json_encode($res);
	}


	public function sys_user_list(){
		$page = !empty($this->input->get("page")) ? $this->input->get("page") : 1;
		$limit = !empty($this->input->get("limit")) ? $this->input->get("limit") : 20;
		$name = $this->input->get("name");

		$this->load->model("common_model");
		$where = array();
		$where["sys_user.status"] = 1;
		$like = array();
		if(!empty(trim($name))){
			$where["sys_user.username"] = $name;
		}
		$condition = array(
			"join" => array(
				array(
					"table" => "sys_user_role",
					"on" => "sys_user_role.sys_user_id=sys_user.id",
					"type" => "left"
				)
			),
			"order_by" => "sys_user.create_time desc",
			"like" => $like,
			"page" => $page,
			"num" => $limit
		);
		$select = "sys_user.*,sys_user_role.role_id";
		$res_data = $this->common_model->get_db_data($select,"sys_user",$where,$condition);
		if($res_data["is_ok"] == 1){
			$data = $res_data["data"];
			$res = array(
				'code' => 0,
				'msg' => '',
				'count' => $res_data["count"],
				'data' => $data
			);
		}else{
			$res = $res_data;
		}
		echo json_encode($res);
	}


	public function update_sys_suer_status(){
		$sys_user_id = $this->input->post("sys_user_id");
		if($sys_user_id > 0){
			$this->load->model("common_model");
			$update_data = array(
				"status" => 0
			);
			$where = array(
				"id" => $sys_user_id
			);
			$res = $this->common_model->update_db_data("sys_user",$update_data,$where,2);
		}else{
			$res["is_ok"] = 0;
			$res["msg"] = "参数错误，请刷新重试";
		}
		echo json_encode($res);
	}



	public function save_sys_user(){
		$save_data = $this->input->post("save_data");
		if(!empty($save_data)){
			$sys_user_id = $save_data["id"];
			$where = array();
			if(isset($save_data["id"]) && $save_data["id"] > 0){
				$type = 2;
				$where["id"] = $save_data["id"];
			}else{
				$type = 1;
				$insert_data["create_time"] = time();
			}

			if(empty(trim($save_data["username"]))){
				$res["is_ok"] = 0;
				$res["msg"] = "请输入账号";
				echo json_encode($res);
				die;
			}

			if($type == 1 && empty(trim($save_data["password"]))){
				$res["is_ok"] = 0;
				$res["msg"] = "请输入密码";
				echo json_encode($res);
				die;
			}
			

			$insert_data["branch_id"] = $save_data["branch_id"];
			if(!empty(trim($save_data["password"]))){
				$insert_data["password"] = md5(md5($save_data["password"].$this->config->item("MD5_key")));
			}
			$insert_data["username"] = trim($save_data["username"]);
			$insert_data["remark"] = $save_data["remark"];

			$this->load->model("common_model");
			$res = $this->common_model->update_db_data("sys_user",$insert_data,$type,$where);
			if($res["is_ok"] == 1 && $type == 1){
				$sys_user_id = $res["insert_id"];
			}
			$this->init_sys_user_role($sys_user_id,$save_data["role_id"]);
		}else{
			$res["is_ok"] = 0;
			$res["msg"] = "参数错误，请刷新再试";
		}
		echo json_encode($res);
	}


	private function init_sys_user_role($user_id,$role_id){
		$this->load->model("common_model");
		$where = array(
			"sys_user_id" => $user_id
		);
		$this->common_model->delete_db_data("sys_user_role",$where);

		//更新
		$update_data = array(
			"sys_user_id" => $user_id,
			"role_id" => $role_id
		);
		$this->common_model->update_db_data("sys_user_role",$update_data,1,array());
	}
}