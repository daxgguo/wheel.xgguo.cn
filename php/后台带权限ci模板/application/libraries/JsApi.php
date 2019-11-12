<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class JsApi{
	protected $CI;
	protected $appId;
	protected $appSecret;
	protected $mchid;
	protected $privatekey;
	protected $log_path;

	public function __construct(){
		$this->CI =& get_instance();
		$this->appId = $this->CI->config->item("appId");
		$this->appSecret = $this->CI->config->item("appSecret");
		$this->mchid = $this->CI->config->item("mchid");
		$this->privatekey = $this->CI->config->item("privatekey");
		$this->log_path = $this->CI->config->item("log_path");
	}


	// 流程：
	// 	1，获取openid
	// 	2，获取prepay_id(统一支付)
	// 	3，再次签名
	// 	4，支付成功



	// 统一支付
	// $params = array(
	// 	"open_id" => $open_id,
	// 	"total_fee" => $total_fee,
	// 	"detail" => array(
	// 		"goods_id" => $goods_id,
	// 		"goods_name" => $goods_name,
	// 		"goods_num" => $goods_num,
	// 		"goods_detail" => $goods_detail,
	// 	),
	// 	"attach_string" => $attach_string,
	// 	"body" => $body,
	// 	"out_trade_no" => $out_trade_no,
	// );
	public function get_prepay_info($params){
		$openid = $params["open_id"];
		//单位：分
		$total_fee = $params["total_fee"]*100;
		$detail = $params["detail"];

		$param = array();
		$param['appid'] = $this->appId;
		$param['attach'] = $params["attach_string"];
		$param['body'] = $params["body"];
		$param['mch_id'] = $this->mchid;
		$param['detail'] = '{ "goods_detail":[ { "goods_id":"'.$detail["goods_id"].'", "goods_name":"'.$detail["goods_name"].'", "quantity":'.$detail["goods_num"].', "price":'.$total_fee.', "body":"'.$detail["goods_detail"].'" }] }';
		$param['nonce_str'] = md5(uniqid());
		$param['notify_url'] = $params["notify_url"];
		$param['openid'] = $openid;
		$param['out_trade_no'] = $params["out_trade_no"];
		$param['spbill_create_ip'] = getenv("REMOTE_ADDR");
		$param['total_fee'] = $total_fee;
		$param['trade_type'] = 'JSAPI';

		$sign = $this->getSign($param);
		$log = $_SERVER;
		$tpl_post = <<<EOL
			<xml>
			   <appid>%s</appid>
			   <attach>%s</attach>
			   <body>%s</body>
			   <mch_id>%s</mch_id>
			   <detail><![CDATA[%s]]></detail>
			   <nonce_str>%s</nonce_str>
			   <notify_url>%s</notify_url>
			   <openid>%s</openid>
			   <out_trade_no>%s</out_trade_no>
			   <spbill_create_ip>%s</spbill_create_ip>
			   <total_fee>%s</total_fee>
			   <trade_type>%s</trade_type>
			   <sign>%s</sign>
			</xml>
EOL;

		$poststr = sprintf($tpl_post,$param['appid'] , $param['attach'] , $param['body'],$param['mch_id'] ,$param['detail'],$param['nonce_str'],$param['notify_url'],$param['openid'], $param['out_trade_no'], $param['spbill_create_ip'] , $param['total_fee'],$param['trade_type'],$sign);
		$log+= array('xml'=>$poststr);
		// 保存记录
		$save_path = $this->log_path.date("Y_m")."_log.txt";
		$save_log = json_encode($log);
		file_put_contents($save_path, $save_log.PHP_EOL,FILE_APPEND);

		$url = 'https://api.mch.weixin.qq.com/pay/unifiedorder';
		// var_dump($poststr);die;
		$xml = do_curl_post_request($url,$poststr,12);

		$resp = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)),true);
		$prepay_id = "";
		if(isset($resp['prepay_id'])){
			$prepay_id = trim($resp['prepay_id']);
		}
		return $prepay_id;
	}


	public function get_pay_sign_data($repay_id){
		
		$param = array();
		$param['appId'] = $this->appId;
		$param['timeStamp'] = trim(time());
		$param['nonceStr'] = md5(uniqid());
		$param['package'] = 'prepay_id='.$repay_id;
		$param['signType'] = 'MD5';
		
		$paySign = $this->getSign($param);
		
		$ret['timeStamp'] =  $param['timeStamp'];
		$ret['nonceStr'] =   $param['nonceStr'];
		$ret['package'] =  $param['package'];
		$ret['signType'] = $param['signType'];
		$ret['paySign'] = $paySign;
		return $ret;
	}


	/**
	 * 格式化参数格式化成url参数
	 */
	public function toUrlParams($data){
	    $buff = "";
	    foreach ($data as $k => $v)
	    {
	        if($k != "sign" && $v != "" && !is_array($v)){
	            $buff .= $k . "=" . $v . "&";
	        }
	    }

	    $buff = trim($buff, "&");
	    return $buff;
	}

	public function getSign($data){
	    //签名步骤一：按字典序排序参数
	    ksort($data);
	    $string = $this->toUrlParams($data);
	    //签名步骤二：在string后加入KEY
	    $string = $string . "&key=".$this->privatekey;
	    //签名步骤三：MD5加密
	    $string = md5($string);
	    //签名步骤四：所有字符转为大写
	    $result = strtoupper($string);
	    return $result;
	}

}