<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class System_model extends CI_Model{
	public function get_system_data(){
		$res["is_ok"] = 1;
		$res["data"] = array(
			"service_phone" => "07363993822"
		);
		return $res;
	}


	public function get_static_data($static_type){
		$where = array(
			"slug" => $static_type,
			"status" => 1
		);
		$this->db->where($where);
		$res_data_obj = $this->db->get("static_page");
		$res_data = $res_data_obj->result_array();
		if($res_data){
			$res["is_ok"] = 1;
			$res["data"] = $res_data[0];
		}else{
			$res["is_ok"] = 0;
			$res["msg"] = "內容為空";
		}
		return $res;
	}

}