<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Node extends Admin_base {

	public function node_list(){
		$this->load->model("node_model");
		$res = $this->node_model->get_node_list();
		echo json_encode($res);
	}


	public function update_node_status(){
		$post_data = $this->input->post();
		$node_id = isset($post_data["node_id"]) ? $post_data["node_id"] : 0;
		if($node_id > 0){
			$status = isset($post_data["status"]) && $post_data["status"] == 1 ? 1 : 0;

			$this->load->model("common_model");
			$where = array(
				"id" => $node_id
			);
			$update_data = array(
				"status" => $status
			);
			$res = $this->common_model->update_db_data("node",$update_data,2,$where);
		}else{
			$res["is_ok"] = 0;
			$res["msg"]= "参数错误，请刷新重试";
		}
		echo json_encode($res);
	}


	public function save_node(){
		$save_data = $this->input->post("save_data");
		if(!empty($save_data)){
			$node_id = $save_data["id"];
			$where = array();
			if(isset($save_data["id"]) && $save_data["id"] > 0){
				$type = 2;
				$where["id"] = $save_data["id"];
			}else{
				$type = 1;
			}

			if(empty(trim($save_data["title"]))){
				$res["is_ok"] = 0;
				$res["msg"] = "请填写节点名称";
				echo json_encode($res);
				die;
			}

			if(empty(trim($save_data["name"]))){
				$res["is_ok"] = 0;
				$res["msg"] = "请填写节点链接";
				echo json_encode($res);
				die;
			}

			$pid = isset($save_data["pid"]) ? $save_data["pid"] : 0;
			$node_type = isset($save_data["node_type"]) ? $save_data["node_type"] : 2;

			//检测是否存在相同名称
			$this->load->model("node_model");
			$is_exist = $this->node_model->check_node_exist($save_data["title"],$node_id);
			if($is_exist > 0){
				$res["is_ok"] = 0;
				$res["msg"] = "节点已经存在";
				echo json_encode($res);
				die;
			}

			

			$insert_data = array(
				"title" => trim($save_data["title"]),
				"name" => trim($save_data["name"]),
				"pid" => $pid,
				"type" => $node_type
			);

			$this->load->model("common_model");
			$res = $this->common_model->update_db_data("node",$insert_data,$type,$where);
		}else{
			$res["is_ok"] = 0;
			$res["msg"] = "参数错误，请刷新再试";
		}
		echo json_encode($res);
	}
}