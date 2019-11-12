<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Node_model extends CI_Model{
	public function check_node_exist($node_name,$node_id){
		if(!empty($node_id)){
			$this->db->where("id<>",$node_id);
		}
		$this->db->where("title",$node_name);
		$count = $this->db->count_all_results("node");
		return $count;
	}


	public function get_node_list($type=1){
		$where = array();
		if($type == 2){
			$where["status"] = 1;
		}
		$condition = array();
		$this->load->model("common_model");
		$node_data_res = $this->common_model->get_db_data("","node",$where,$condition);
		if($node_data_res["is_ok"] == 1){
			$res_data = array();
			if($node_data_res["data"]){
				$res_data = res_sort($node_data_res["data"]);
			}
			$res["is_ok"] = 1;
			$res["data"] = $res_data;
		}else{
			$res = $node_data_res;
		}
		return $res;
	}


	public function get_checked_node($role_id){
		$sql = 'select node.id,node.title from node,node_roles where node.id=node_roles.node_id and node.status=1 and node_roles.role_id='.$role_id;
		$role_obj = $this->db->query($sql);
		$role_data = $role_obj->result_array();
		$res_data = array();
		if($role_data){
			$res_data = $role_data;
		}
		return $res_data;
	}
}