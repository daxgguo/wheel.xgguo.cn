<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function to_login(){
		$post_data = $this->input->post();
		if($post_data){
			$login_data = $post_data["login_data"];
			$login_captcha = $this->session->login_captcha;
			if($login_captcha == $login_data["code"]){
				$this->session->unset_userdata('login_captcha');
				$this->load->model("user_model");
				$res = $this->user_model->to_login($login_data);
			}else{
				$res["is_ok"] = 0;
				$res["msg"] = "验证码错误";
			}
			
			echo json_encode($res);
		}else{
			$this->load->model("common_model");
			$captcha_img = $this->common_model->get_captcha();
			$main_data = array(
				"project_title" => $this->config->item("item_title"),
				"captcha_img" => $captcha_img
			);

			$this->load->view("login",$main_data);
		}
	}

	public function to_logout(){
		$this->session->unset_userdata($this->config->item("project_prefix")."sys_user_data");
		$main_data = array(
			"project_title" => $this->config->item("item_title"),
		);

		$this->load->view("login",$main_data);
	}


	public function get_captcha(){
		$this->load->model("common_model");
		$captcha_img = $this->common_model->get_captcha();
		$this->session->set_userdata(array("login_captcha"=>$captcha_img["word"]));
		$res["img"] = $captcha_img["image"];
		echo json_encode($res);
	}
}