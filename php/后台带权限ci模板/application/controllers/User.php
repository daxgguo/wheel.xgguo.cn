<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends Admin_base {

	public function user_list(){
		$page = !empty($this->input->get("page")) ? $this->input->get("page") : 1;
		$limit = !empty($this->input->get("limit")) ? $this->input->get("limit") : 20;
		$name = $this->input->get("name");
		$phone = $this->input->get("phone");
		$contract_code = $this->input->get("contract_code");

		$where = array();
		if(!empty(trim($phone))){
			$check_phone = check_phone($phone);
			if(!$check_phone){
				$res["is_ok"] = 0;
				$res["msg"] = "手机号码格式不正确";
				echo json_encode($res);
				die;
			}
			$where["user.phone"] = $phone;
		}

		if(!empty(trim($contract_code))){
			$where["contract.contract_code"] = $contract_code;
		}
		

		$this->load->model("common_model");
		$like = array();
		if(!empty(trim($name))){
			$like["user.name"] = $name;
		}
		$condition = array(
			"join" => array(
				array(
					"table" => "contract",
					"on" => "contract.id=user.contract_id",
					"type" => "left"
				),
				array(
					"table" => "meal",
					"on" => "meal.id=user.meal_id",
					"type" => "left"
				),
				array(
					"table" => "user_room",
					"on" => "user_room.user_id=user.id",
					"type" => "left"
				)
			),
			"group_by" => array("user.id"),
			"order_by" => "create_time desc",
			"like" => $like,
			"page" => $page,
			"num" => $limit
		);
		$select = "user.*,contract.contract_code,meal.title,user_room.room_num";
		// $where["user_room.status"] = 1;
		$res_data = $this->common_model->get_db_data($select,"user",$where,$condition);
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



	public function save_user(){
		$save_data = $this->input->post("save_data");
		if(!empty($save_data)){
			$where = array();
			if(isset($save_data["id"]) && $save_data["id"] > 0){
				$where["id"] = $save_data["id"];

				if(!isset($save_data["name"]) || (isset($save_data["name"]) && empty(trim($save_data["name"])))){
					$res["is_ok"] = 0;
					$res["msg"] = "用户姓名不能为空";
					echo json_encode($res);
					die;
				}
				if(!isset($save_data["age"]) || (isset($save_data["age"]) && $save_data["age"] <= 0)){
					$res["is_ok"] = 0;
					$res["msg"] = "用户年龄不正确";
					echo json_encode($res);
					die;
				}
				if(!isset($save_data["birth_num"]) || (isset($save_data["birth_num"]) && $save_data["birth_num"] <= 0)){
					$res["is_ok"] = 0;
					$res["msg"] = "请填写胎次";
					echo json_encode($res);
					die;
				}
				if(isset($save_data["phone"]) && !empty(trim($save_data["phone"]))){
					$check_phone = check_phone($save_data["phone"]);
					if(!$check_phone){
						$res["is_ok"] = 0;
						$res["msg"] = "手机号码格式不正确";
						echo json_encode($res);
						die;
					}
				}

				$save_data["pre_deliver"] = isset($save_data["pre_deliver"]) && !empty($save_data["pre_deliver"]) ? $save_data["pre_deliver"] : "";
				$save_data["birth_time"] = isset($save_data["birth_time"]) && !empty($save_data["birth_time"]) ? $save_data["birth_time"] : "";
				unset($save_data["id"]);
				unset($save_data["contract_id"]);
				unset($save_data["meal_id"]);
				
				$this->load->model("common_model");
				$res = $this->common_model->update_db_data("user",$save_data,2,$where);
			}else{
				$res["is_ok"] = 0;
				$res["msg"] = "参数错误，请刷新重试";
			}
		}else{
			$res["is_ok"] = 0;
			$res["msg"] = "参数错误，请刷新再试";
		}
		echo json_encode($res);
	}


	public function search_user_by_name(){
		$user_name = $this->input->post("user_name");
		if(!empty($user_name)){
			$curr_time = time();
			$this->load->model("common_model");
			$where = array(
				"user_room.status" => 1,
				"user_room.in_date<" => $curr_time,
				"user.plan_out_date>=" => $curr_time
			);
			$like = array("user.name" => $user_name);
			$select = "user.*,room.room_num";
			$condition = array(
				"join" => array(
					array(
						"table" => "user_room",
						"on" => "user_room.user_id=user.id",
						"type" => "left"
					),
					array(
						"table" => "room",
						"on" => "room.id=user_room.room_id",
						"type" => "left"
					)
				),
				"group_by" => array("user_room.id"),
				"like" => $like,
				"order_by" => "user.id desc"
			);
			$res = $this->common_model->get_db_data($select,"user",$where,$condition);
		}else{
			$res["is_ok"] = 0;
			$res["msg"] = "请输入姓名";
		}
		echo json_encode($res);
	}


	public function search_user_list(){
		$user_name = $this->input->post("user_name");
		if(!empty($user_name)){
			$this->load->model("common_model");
			$like = array("name" => $user_name);
			$condition = array(
				"like" => $like,
				"order_by" => "create_time desc"
			);
			$res = $this->common_model->get_db_data("id,name","user",array(),$condition);
		}else{
			$res["is_ok"] = 0;
			$res["msg"] = "请输入姓名";
		}
		echo json_encode($res);
	}
}