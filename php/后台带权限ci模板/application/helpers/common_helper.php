<?php
/**
** @desc 封装 curl 的调用接口，post的请求方式
**/
function do_curl_post_request($url,$requestString=array(),$timeout = 6){
    if($url == '' || $timeout <=0){
        return false;
    }
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_HEADER,0);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch,CURLOPT_POST,1);
    curl_setopt($ch,CURLOPT_TIMEOUT,$timeout);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$requestString);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}


/**
** @desc 封装 curl 的调用接口，get的请求方式
**/
function do_curl_get_request($url,$timeout = 6){
    if($url == '' || $timeout <=0){
        return false;
    }
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_HEADER,0);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch,CURLOPT_TIMEOUT,$timeout);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}


function array_to_xml($arr){ 
    $xml = "<xml>"; 
    foreach ($arr as $key=>$val){ 
        if(is_array($val)){ 
            $xml.="<".$key.">".arrayToXml($val)."</".$key.">"; 
        }else{ 
            $xml.="<".$key.">".$val."</".$key.">"; 
        } 
    } 
    $xml.="</xml>";
    return $xml; 
}

function get_curr_time(){
    $time = date("Y-m-d H:i:s",time());
    return $time;
}

function add_date($d,$some_time){
    $new_date = date("Y-m-d",strtotime("$d + $some_time"));
    return $new_date;
}


function rand_chars($num=6){
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $res = "";
    for($i=0;$i<$num;$i++){
        $res .= substr($chars,mt_rand(0,strlen($chars)-1),1);
    }
    return $res;
}

function rand_num($num=6){
    $chars = "0123456789";
    $res = "";
    for($i=0;$i<$num;$i++){
        $res .= substr($chars,mt_rand(0,strlen($chars)-1),1);
    }
    return $res;
}


function res_sort($data, $parent_id=0, $level=0, $isClear=TRUE){
    static $ret = array();
    if($isClear)
        $ret = array();
    foreach ($data as $k => $v){
        if($v['pid'] == $parent_id){
            $v['level'] = $level;
            $ret[] = $v;
            res_sort($data, $v['id'], $level+1, FALSE);
        }
    }
    return $ret;
}


function get_children($data,$parent_id = 0){
    $res = array();
    if($data){
        foreach($data as $k => $v){
            if($v["pid"] == $parent_id){
                $res[$k] = $v;
                foreach($data as $m => $n){
                    if($n["pid"] == $v["id"]){
                        $res[$k]["children"] = get_children($data,$v["id"]);
                    }
                }
            }
        }
    }
    return $res;
}

function get_file_list($dir){
    $dir_list = array();
    if (is_dir($dir)) {
        if ($dh = opendir($dir)) {
            while (($file = readdir($dh)) !== false) {
                if($file !="." && $file != ".."){
                    $dir_list[] = $dir . $file;
                }
            }
            closedir($dh);
        }
    }
    return $dir_list;
}


//将XML转为array
function xml_to_array($xml){    
    //禁止引用外部xml实体
    libxml_disable_entity_loader(true);
    $values = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);        
    return $values;
}


function get_base_url() {
    $sys_protocal = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
    $php_self = $_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
    return $sys_protocal.(isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '');
}


/**
* Create CAPTCHA
*
* @access        public
* @param        array        array of data for the CAPTCHA
* @param        string        path to create the image in
* @param        string        URL to the CAPTCHA image folder
* @param        string        server path to font
* @return        string
*/
function self_create_captcha($data = '', $font_path = ''){
    $defaults = array('word' => '', 'word_length' => 4, 'img_width' => '150', 'img_height' => '30', 'font_path' => '', 'expiration' => 7200);

    foreach ($defaults as $key => $val){
        if ( ! is_array($data)){
                if ( ! isset($$key) OR $$key == ''){
                        $$key = $val;
                }
        }else{
                $$key = ( ! isset($data[$key])) ? $val : $data[$key];
        }
    }

   if ($word == ''){
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $str = '';
        for ($i = 0; $i < $word_length; $i++){
                $str .= substr($pool, mt_rand(0, strlen($pool) -1), 1);
        }

        $word = $str;
   }

    // -----------------------------------
    // Determine angle and position
    // -----------------------------------

    $length        = strlen($word);
    $angle        = ($length >= 6) ? rand(-($length-6), ($length-6)) : 0;
    $x_axis        = rand(6, (360/$length)-16);
    $y_axis = ($angle >= 0 ) ? rand($img_height, $img_width) : rand(6, $img_height);

    // -----------------------------------
    // Create image
    // -----------------------------------

    // PHP.net recommends imagecreatetruecolor(), but it isn't always available
    if (function_exists('imagecreatetruecolor')){
            $im = imagecreatetruecolor($img_width, $img_height);
    }else{
            $im = imagecreate($img_width, $img_height);
    }

    // -----------------------------------
    //  Assign colors
    // -----------------------------------

    $bg_color                = imagecolorallocate ($im, 255, 255, 255);
    $border_color        = imagecolorallocate ($im, 153, 102, 102);
    $text_color                = imagecolorallocate ($im, 204, 153, 153);
    $grid_color                = imagecolorallocate($im, 255, 182, 182);
    $shadow_color        = imagecolorallocate($im, 255, 240, 240);

    // -----------------------------------
    //  Create the rectangle
    // -----------------------------------

    ImageFilledRectangle($im, 0, 0, $img_width, $img_height, $bg_color);

    // -----------------------------------
    //  Create the spiral pattern
    // -----------------------------------

    $theta                = 1;
    $thetac                = 7;
    $radius                = 16;
    $circles        = 20;
    $points                = 32;

    for ($i = 0; $i < ($circles * $points) - 1; $i++){
            $theta = $theta + $thetac;
            $rad = $radius * ($i / $points );
            $x = ($rad * cos($theta)) + $x_axis;
            $y = ($rad * sin($theta)) + $y_axis;
            $theta = $theta + $thetac;
            $rad1 = $radius * (($i + 1) / $points);
            $x1 = ($rad1 * cos($theta)) + $x_axis;
            $y1 = ($rad1 * sin($theta )) + $y_axis;
            imageline($im, $x, $y, $x1, $y1, $grid_color);
            $theta = $theta - $thetac;
    }

    // -----------------------------------
    //  Write the text
    // -----------------------------------

    $use_font = ($font_path != '' AND file_exists($font_path) AND function_exists('imagettftext')) ? TRUE : FALSE;

    if ($use_font == FALSE){
            $font_size = 5;
            $x = rand(0, $img_width/($length/3));
            $y = 0;
    }else{
            $font_size        = 16;
            $x = rand(0, $img_width/($length/1.5));
            $y = $font_size+2;
    }

    for ($i = 0; $i < strlen($word); $i++){
            if ($use_font == FALSE){
                    $y = rand(0 , $img_height/2);
                    imagestring($im, $font_size, $x, $y, substr($word, $i, 1), $text_color);
                    $x += ($font_size*2);
            }else{
                    $y = rand($img_height/2, $img_height-3);
                    imagettftext($im, $font_size, $angle, $x, $y, $text_color, $font_path, substr($word, $i, 1));
                    $x += $font_size;
            }
    }


    // -----------------------------------
    //  Create the border
    // -----------------------------------

    imagerectangle($im, 0, 0, $img_width-1, $img_height-1, $border_color);

    // -----------------------------------
    //  Generate the image
    // -----------------------------------

    // $img_name = $now.'.jpg';

    // ImageJPEG($im, $img_path.$img_name);

    // $img = "<img src=\"$img_url$img_name\" width=\"$img_width\" height=\"$img_height\" style=\"border:0;\" alt=\" \" />";
    #直接输出
    header("Content-Type:image/jpeg");
    imagejpeg($im);

    ImageDestroy($im);
    #返回生成的验证码字符串
    return $word;
}



function check_phone($tel){
    if(strlen($tel) == "11"){
        $n = preg_match_all("/1[34578]{1}\d{9}/", $tel, $array);
        $is_ok = $n;
    }else{
        $is_ok = 0;
    }
    return $is_ok;
}


/*递归建立多层目录函数*/
function MkFolder($path){
    if(!is_readable($path)){
        MkFolder( dirname($path) );
        if(!is_file($path)){
            mkdir($path);
            chmod($path,0777);  
        }
    }
}