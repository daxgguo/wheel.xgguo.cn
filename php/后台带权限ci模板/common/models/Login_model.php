<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Login_model extends CI_Model{
	protected $appId;
	protected $appSecret;
	protected $rd_session_deadline;
	public function __construct(){
		$this->appId = $this->config->item("appId");
		$this->appSecret = $this->config->item("appSecret");
		$this->rd_session_deadline = $this->config->item("rd_session_deadline");
	}

	public function do_login_by_session($rd_session){
		if($rd_session){
			//检测re_session是否存在缓存中
			$this->load->driver('cache', array('adapter' => 'redis', 'backup' => 'file'));
			$result = $this->cache->redis->get($rd_session);
			
			if(!empty($result)){
				//更新缓存
				if($result["open_id"] && $result["wx_user_id"]>0){
					$this->cache->redis->save($rd_session,$result,$this->rd_session_deadline);
					$res["is_ok"] = 1;
					$res["rd_session"] = $rd_session;
				}else{
					$res["is_ok"] = 0;
					$res["msg"] = "empty open_id or user_detail_id or user_id";
				}
			}else{
				//不存在
				$res["is_ok"] = 0;
				$res["msg"] = "not exist login_log";
			}
		}else{
			$res["is_ok"] = 0;
			$res["msg"] = "empty rd_session";
		}
		return $res;
	}

	public function do_login_by_code($code,$encryptedData,$iv,$signature,$rawData){
		$res_data_obj = $this->get_session($code);
		$open_id = isset($res_data_obj->openid) ? $res_data_obj->openid : "";
		if($open_id){
			$session_key = $res_data_obj->session_key;

			//保存数据
			$this->load->model("user_model");
			$user_data_arr = $this->user_model->get_user($open_id);
			$prefex = $this->config->item("project_prefix");
			$rd_session_key = uniqid($prefex.time()."_");

			if($user_data_arr["is_ok"] == 0){
				//签名验证
				$signature_new = sha1($rawData.$session_key);
				if($signature == $signature_new){
					//解码算法获取用户绝密信息
					$conf = array(
						"appid" => $this->appId,
						"sessionKey"=> $session_key
					);
					$this->load->library("WXBizDataCrypt",$conf);
					$pc = $this->wxbizdatacrypt;
					$errCode = $pc->decryptData($encryptedData,$iv,$data);

					if($errCode == 0) {
						$data = json_decode($data);
						//新建用户
						$nick_name = $data->nickName;
						$avatar_url = $data->avatarUrl;
						$unionid = isset($data->unionid) ? $data->unionid : "";
						$user_res_data = $this->user_model->create_wx_user($unionid,$nick_name,$avatar_url,$open_id);
						if($user_res_data["is_ok"] == 1){
							//保存rd_session
							$user_id = $user_res_data["insert_id"];
							$this->save_rd_session($rd_session_key,$open_id,$user_id);
							$res["is_ok"] = 1;
							$res["rd_session"] = $rd_session_key;
						}else{
							$res = $user_res_data;
						}
					}else{
					    // print($errCode . "\n");
					    $res["is_ok"] = 0;
					    $res["msg"] = $errCode;
					}
				}else{
					$res["is_ok"] = 0;
					$res["msg"] = "signature error";
				}
			}else{
				$user_data_arr = $user_data_arr["data"];
				$user_id = $user_data_arr["id"];
				//保存rd_session
				$this->save_rd_session($rd_session_key,$open_id,$user_id);
				
				$res["is_ok"] = 1;
				$res["rd_session"] = $rd_session_key;
			}
		}else{
			$res["is_ok"] = 0;
			$res["msg"] = "bad network";
		}
		return $res;
		exit;
	}


	protected function get_session($code){
		$url = "https://api.weixin.qq.com/sns/jscode2session?appid=".$this->appId."&secret=".$this->appSecret."&js_code=".$code."&grant_type=authorization_code";
		$res_data = do_curl_get_request($url);
		$res_data_obj = json_decode($res_data);
		return $res_data_obj;
	}

	protected function save_rd_session($rd_session_key,$open_id,$user_id){
		$cache = array(
			"open_id" => $open_id,
			"wx_user_id" => $user_id,
			"login_time" => time()
		);
		$this->load->driver('cache', array('adapter' => 'redis', 'backup' => 'file'));
		$this->cache->redis->save($rd_session_key,$cache,$this->rd_session_deadline);
	}
}
