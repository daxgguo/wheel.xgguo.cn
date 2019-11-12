<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Loader extends CI_Loader{
	public function __construct() {
		parent::__construct();
		//指定可以从 APPPATH 和 FCPATH 这两个目录下获取模型文件
		$this->_ci_model_paths = array(APPPATH, MODEL_PATH);
	}
}