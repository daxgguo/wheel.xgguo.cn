<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Role extends Admin_base {
	public function get_role_list(){
		$where = array(
			"status" => 1
		);
		$condition = array();
		$this->load->model("common_model");
		$res_data = $this->common_model->get_db_data("","role",$where,$condition);
		echo json_encode($res_data);
	}


	public function role_list(){
		$this->load->model("role_model");
		$res_data = $this->role_model->get_role_content();
		echo json_encode($res_data);
	}




	public function update_role_status(){
		$post_data = $this->input->post();
		$role_id = isset($post_data["role_id"]) ? $post_data["role_id"] : 0;
		if($role_id > 0){
			$status = isset($post_data["status"]) && $post_data["status"] == 1 ? 1 : 0;

			$this->load->model("common_model");
			$where = array(
				"id" => $role_id
			);
			$update_data = array(
				"status" => $status
			);
			$res = $this->common_model->update_db_data("role",$update_data,2,$where);
		}else{
			$res["is_ok"] = 0;
			$res["msg"]= "参数错误，请刷新重试";
		}
		echo json_encode($res);
	}


	public function get_role_detail_by_id(){
		$post_data = $this->input->post();
		$role_id = isset($post_data["role_id"]) ? $post_data["role_id"] : 0;
		if($role_id > 0){
			$this->load->model("node_model");
			//获取已选节点
			$node_checked_list = $this->node_model->get_checked_node($role_id);

			$res["is_ok"] = 1;
			$res["node_checked_list"] = $node_checked_list;
		}else{
			$res["is_ok"] = 0;
			$res["msg"]= "参数错误，请刷新重试";
		}
		echo json_encode($res);
	}


	public function save_role(){
		$post_data = $this->input->post();
		$role_id = isset($post_data["role_id"]) ? $post_data["role_id"] : 0;
		$role_name = isset($post_data["role_name"]) ? trim($post_data["role_name"]) : 0;
		$node_ids = isset($post_data["node_ids"]) ? $post_data["node_ids"] : array();
		if(count($node_ids) > 0){
			//去重
			array_unique($node_ids);
			$this->load->model("node_model");
			$count = $this->node_model->check_node_exist($role_name,$role_id);
			if($count > 0){
				$res["is_ok"] = 0;
				$res["msg"] = "角色名称已存在";
			}else{
				$this->load->model("common_model");

				$type = 1;
				$where = array();
				if($role_id > 0){
					$type = 2;
					$where["id"] = $role_id;
				}
				//操作角色
				$save_data = array(
					"name" => $role_name
				);
				$res_data = $this->common_model->update_db_data("role",$save_data,$type,$where);
				if($res_data["is_ok"] == 0 && $role_id <= 0){
					$res["is_ok"] = 0;
					$res["msg"] = "操作失败";
					echo json_encode($res);
					die;
				}elseif($res_data["is_ok"] == 1 && $role_id <= 0){
					$role_id = $res_data["insert_id"];
				}

				if($role_id > 0){
					//删除已有的权限
					$delete_where = array(
						"role_id" => $role_id
					);
					$this->common_model->delete_db_data("node_roles",$delete_where);

					//插入权限
					$save_data = array();
					foreach($node_ids as $m){
						$this_data["node_id"] = $m;
						$this_data["role_id"] = $role_id;
						$save_data[] = $this_data;
					}
					$res = $this->common_model->batch_insert_db("node_roles",$save_data);
				}else{
					$res["is_ok"] = 0;
					$res["msg"] = "操作失败";
				}
			}
		}else{
			$res["is_ok"] = 0;
			$res["msg"] = "请选择节点";
		}
		echo json_encode($res);
	}
}