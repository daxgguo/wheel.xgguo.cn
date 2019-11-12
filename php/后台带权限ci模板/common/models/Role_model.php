<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Role_model extends CI_Model{
	public function get_role_content(){
		$sql = 'select role.id,role.name,role.status,group_concat(node.title) as node_list from role left join node_roles on role.id=node_roles.role_id left join node on node.id=node_roles.node_id group by role.id';
		$role_obj = $this->db->query($sql);
		$role_data = $role_obj->result_array();

		if($role_data){
			$this->db->select("id");
			$this->db->from("role");
			$count = $this->db->count_all_results();
			
			$res = array(
				'code' => 0,
				'msg' => '',
				'count' => $count,
				'data' => $role_data
			);
		}else{
			$res["is_ok"] = 0;
			$res["msg"] = "列表为空";
		}
		return $res;
	}
}