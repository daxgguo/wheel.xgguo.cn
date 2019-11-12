<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Common_model extends CI_Model{
	// $select = string;
	// $table_name = string;//主表放第一，用,隔开
	// $where = array();
	// $condition = array(
	// 	"join" => array(
	// 		array(
	// 			"table" => "user_room",
	// 			"on" => "user_room.user_id=user.id",
	// 			"type" => "left"
	// 		)
	// 	),
	// 	"group_by" => array("A","B"),
	// 	"like" => array("A"=>"B","C" => "D"),
	// 	"order_by" => "A desc,B asc",
	// 	"page" => 1,
	// 	"num" => 20,
	//  "limit" => 5
	// );
	public function get_db_data($select,$table_name,$where,$condition){
		
		if(empty($table_name)){
			$res["is_ok"] = 0;
			$res["msg"] = "数据库名称不能为空";
			return $res;
		}

		$page = -1;
		$select = empty($select) ? "*" : $select;
		$this->db->select($select);

		$this->db->from($table_name);

		if(isset($condition["join"]) && count($condition["join"]) > 0){
			foreach($condition["join"] as $v){
				$this->db->join($v["table"], $v["on"], $v["type"]);
			}
		}

		if(is_array($where) && count($where) > 0){
			$this->db->where($where);
		}

		if(isset($condition["like"]) && count($condition["like"]) > 0){
			$this->db->like($condition["like"]);
		}

		if(isset($condition["group_by"]) && count($condition["group_by"]) > 0){
			$this->db->group_by($condition["group_by"]);
		}

		if(isset($condition["order_by"]) && !empty($condition["order_by"])){
			$this->db->order_by($condition["order_by"]);
		}

		if(isset($condition["limit"]) && $condition["limit"] > 0){
			$this->db->limit($condition["limit"],0);
		}

		if(isset($condition["page"]) && $condition["page"] > 0){
			$page = $condition["page"];
			$num = isset($condition["num"])&&($condition["num"] > 0) ? $condition["num"] : 20;
			$begin = ($page-1)*$num;
			$this->db->limit($num,$begin);
		}
		$res_data_obj = $this->db->get();
		$res_data = $res_data_obj->result_array();

		if($page > 0){
			if($res_data){
				//总数
				$tables = explode(",", $table_name);
				$this->db->select($tables[0].".id");
				$this->db->from($table_name);

				if(isset($condition["join"]) && count($condition["join"]) > 0){
					foreach($condition["join"] as $v){
						$this->db->join($v["table"], $v["on"], $v["type"]);
					}
				}

				if(is_array($where) && count($where) > 0){
					$this->db->where($where);
				}

				if(isset($condition["group_by"]) && count($condition["group_by"]) > 0){
					$this->db->group_by($condition["group_by"]);
				}
				$count = $this->db->count_all_results();
			}else{
				$count = 0;
			}
			
			$res["page"] = $page;
			$res["count"] = $count;
		}
		
		if($res_data){
			$res["is_ok"] = 1;
			$res["data"] = $res_data;
		}else{
			$res["is_ok"] = 0;
			$res["msg"] = "列表为空";
		}
		return $res;
	}


	//更新或插入
	public function update_db_data($table_name,$update_data,$type,$where=array()){
		if(empty($table_name)){
			$res["is_ok"] = 0;
			$res["msg"] = "数据库名称不能为空";
			return $res;
		}

		if(is_array($update_data) && count($update_data) > 0){
			foreach($update_data as $k => $v){
				//不转义
				$this->db->set($k,$v);
			}
		}else{
			$res["is_ok"] = 0;
			$res["msg"] = "操作字段不能为空";
			return $res;
		}

		$insert_id = 0;
		if($type == 1){
			//插入
			$this->db->insert($table_name);
			$insert_id = $this->db->insert_id();
		}else{
			if(is_array($where) && count($where) > 0){
				$this->db->where($where);
			}
			//更新
			$this->db->update($table_name);
		}

		$affected_rows = $this->db->affected_rows();
		if($affected_rows){
			$res["is_ok"] = 1;
			$res["insert_id"] = $insert_id;
			$res["msg"] = "操作成功";
		}else{
			$res["is_ok"] = 0;
			$res["msg"] = "操作失败";
		}
		return $res;
	}


	public function batch_update_db($table_name,$primary_key,$update_data){
		$this->db->update_batch($table_name, $update_data, $primary_key);
		$res["is_ok"] = 1;
		$res["msg"] = "操作成功";

		// $affected_rows = $this->db->affected_rows();
		// if($affected_rows){
		// 	$res["is_ok"] = 1;
		// 	$res["msg"] = "操作成功";
		// }else{
		// 	$res["is_ok"] = 0;
		// 	$res["msg"] = "操作失败";
		// }
		return $res;
	}


	public function batch_insert_db($table_name,$insert_data){
		$this->db->insert_batch($table_name,$insert_data);
		$affected_rows = $this->db->affected_rows();
		if($affected_rows){
			$res["is_ok"] = 1;
			$res["msg"] = "操作成功";
		}else{
			$res["is_ok"] = 0;
			$res["msg"] = "操作失败";
		}
		return $res;
	}


	public function delete_db_data($table_name,$where){
		$this->db->where($where);
		$this->db->delete($table_name);
		$res["is_ok"] = 1;
		$res["msg"] = "操作成功";

		// $affected_rows = $this->db->affected_rows();
		// if($affected_rows){
		// 	$res["is_ok"] = 1;
		// 	$res["msg"] = "操作成功";
		// }else{
		// 	$res["is_ok"] = 0;
		// 	$res["msg"] = "操作失败";
		// }
		return $res;
	}


	public function db_query($sql,$type=1){
		// $type=1查询 2执行
		$result = $this->db->query($sql);
		$res_data = array();
		if($type == 1){
			$res_data = $result->result_array();
			if($res_data){
				$res["is_ok"] = 1;
				$res["data"] = $res_data;
			}else{
				$res["is_ok"] = 0;
				$res["msg"] = "列表为空";
			}
		}else{
			$affected_rows = $this->db->affected_rows();
			if($affected_rows){
				$res["is_ok"] = 1;
			}else{
				$res["is_ok"] = 0;
			}
		}
		return $res;
	}


	public function get_captcha(){
		$this->load->helper('captcha');
		$vals = array(
		    'word'      => rand_num(4),
		    'img_path'  => './public/captcha/',
		    'img_url'   => '/public/captcha/',
		    'img_width' => '88',
		    'img_height'    => 38,
		    'expiration'    => 7200,
		    'word_length'   => 4,
		    'font_size' => 26,
		    'img_id'    => 'Imageid',
		    'pool'      => '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',

		    // White background and border, black text and red grid
		    'colors'    => array(
		        'background' => array(255, 255, 255),
		        'border' => array(255, 255, 255),
		        'text' => array(0, 0, 0),
		        'grid' => array(255, 40, 40)
		    )
		);

		$cap = create_captcha($vals);
		return $cap;
	}
}