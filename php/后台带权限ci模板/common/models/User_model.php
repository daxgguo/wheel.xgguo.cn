<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User_model extends CI_Model{
	public function to_login($login_data){
		//check_code
		$this->load->model("common_model");
		$where = array(
			"status" => 1,
			"username" => $login_data["account"]
		);
		$res_data = $this->common_model->get_db_data("","sys_user",$where,array());
		if($res_data["is_ok"] == 1){
			$user_data = $res_data["data"][0];
			$this_password = md5(md5($login_data["password"].$this->config->item("MD5_key")));
			if($this_password == $user_data["password"]){
				$cache_data = array(
					$this->config->item("project_prefix")."sys_user_data" => array(
						"user_id" => $user_data["id"],
						"username" => $user_data["username"]
					)
				);
				$this->session->set_userdata($cache_data);
				$res["is_ok"] = 1;
				$res["msg"] = "登录成功";
			}else{
				$res["is_ok"] = 0;
				$res["msg"] = "密码不正确";
			}
		}else{
			$res["is_ok"] = 0;
			$res["msg"] = "该用户不存在或已经被禁用";
		}
		return $res;
	}


	public function get_user($openid){
		$sql = 'select id,avatar,nickname,openid,unionid from wx_user where openid="'.$openid.'" limit 1';
		$result_obj = $this->db->query($sql);
		$result_data = $result_obj->result_array();
		if($result_data){
			$res["is_ok"] = 1;
			$res["data"] = $result_data[0];
		}else{
			$res["is_ok"] = 0;
			$res["msg"] = "该用户不存在";
		}
		return $res;
	}



	public function create_wx_user($unionid,$nick_name,$avatar_url,$open_id){
		$curr_time = time();
		$insert_data = array(
			"avatar" => $avatar_url,
			"nickname" => $nick_name,
			"openid" => $open_id,
			"unionid" => $unionid,
			"create_time" => $curr_time,
		);

		$this->db->insert("wx_user",$insert_data);
		$insert_id = $this->db->insert_id();
		if($insert_id > 0){
			$res["is_ok"] = 1;
			$res["insert_id"] = $insert_id;
		}else{
			$res["is_ok"] = 0;
			$res["msg"] = "新建用户失败";
		}

		return $res;
	}



	public function get_navigate(){
		$user_cache_key = $this->config->item("project_prefix")."sys_user_data";
		$session_data = $this->session->get_userdata();
		if(isset($session_data["navigate_data"])){
			$res = $session_data["navigate_data"];
		}else{
			$sys_user_data = isset($session_data[$user_cache_key]) ? $session_data[$user_cache_key] : array();
			$navigate_data = array();
			if(!empty($sys_user_data)){
				$user_id = $sys_user_data["user_id"];
				$this->load->model("common_model");
				$select = "node.id,node.title as name,node.name as url,node.pid,role.name as role_name";
				$where = array(
					"sys_user_role.sys_user_id" => $user_id,
					"node.type" => 1
				);
				$condition = array(
					"join" => array(
						array(
							"table" => "sys_user_role",
							"on" => "node_roles.role_id=sys_user_role.role_id",
							"type" => "left"
						),
						array(
							"table" => "node",
							"on" => "node.id=node_roles.node_id",
							"type" => "left"
						),
						array(
							"table" => "role",
							"on" => "role.id=node_roles.role_id",
							"type" => "left"
						)
					)
				);

				$res_data = $this->common_model->get_db_data($select,"node_roles",$where,$condition);
				if($res_data["is_ok"] == 1){
					$navigate_data = $res_data["data"];
				}
			}

			if($navigate_data){
				$res["role_name"] = $navigate_data[0]["role_name"];
				$res["sys_user_name"] = $sys_user_data["username"];
				$res["navigate_list"] = $this->init_navigate($navigate_data);
				$this->session->set_userdata("navigate_data",$res);
			}else{
				$res["role_name"] = "无角色";
				$res["sys_user_name"] = "请联系管理员分配权限";
				$res["navigate_list"] = array();
			}
		}
		return $res;
	}



	private function init_navigate($navigate_data,$pid=0){
		$this_list = array();
		if($navigate_data){
			foreach($navigate_data as $k => $v){
				if($v["pid"] == $pid){
					$v["is_check"] = 0;
					if($pid == 0){
						$v["children"] = $this->init_navigate($navigate_data,$v["id"]);
					}
					$this_list[] = $v;
				}
			}

		}
		return $this_list;
	}


	public function get_auth(){
		$user_cache_key = $this->config->item("project_prefix")."sys_user_data";
		$session_data = $this->session->get_userdata();
		$sys_user_data = isset($session_data[$user_cache_key]) ? $session_data[$user_cache_key] : array();
		$node_user_data = array();
		if(!empty($sys_user_data)){
			$user_id = $sys_user_data["user_id"];
			$this->load->model("common_model");
			$select = "node.*,role.name as role_name";
			$where = array(
				"sys_user_role.sys_user_id" => $user_id
			);
			$condition = array(
				"join" => array(
					array(
						"table" => "sys_user_role",
						"on" => "node_roles.role_id=sys_user_role.role_id",
						"type" => "left"
					),
					array(
						"table" => "node",
						"on" => "node.id=node_roles.node_id",
						"type" => "left"
					),
					array(
						"table" => "role",
						"on" => "role.id=node_roles.role_id",
						"type" => "left"
					)
				)
			);

			$res_data = $this->common_model->get_db_data($select,"node_roles",$where,$condition);
			if($res_data["is_ok"] == 1){
				$node_user_data = $res_data["data"];
			}
		}
		return $node_user_data;
	}



	public function check_auth($type,$temp){
		$out_string = $this->config->item("open_url");
		$res["is_ok"] = 1;
		if(($type == 2 && !in_array($temp, $out_string)) || $type == 1){
			$node_user_data = $this->get_auth();
			$is_permit = 0;
			if($node_user_data){
				foreach($node_user_data as $v){
					if($temp == strtolower($v["name"])){
						$is_permit = 1;
						break;
					}
				}
			}
			if($is_permit == 0){
				$res["is_ok"] = 0;
				$res["msg"] = "没有权限访问(".$temp.")页面";
			}
		}
		
		return $res;
	}
}
