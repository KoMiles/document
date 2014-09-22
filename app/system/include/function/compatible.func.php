<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved. 

defined('IN_MET') or exit('No permission');

/*
 * json_encodePHP，版本兼容
 */
if(!function_exists('json_encode')){
    include PATH_WEB.'include/JSON.php';
    function json_encode($val){
        $json = new Services_JSON();
		$json = $json->encode($val);
        return $json;
    }
    function json_decode($val){
        $json = new Services_JSON();
        return $json->decode($val);
    }
}

/*
 * 字段权限控制代码加密后（加密后可用URL传递）
 * @param  string $string    需要加密或解密的字符串
 * @param  string $operation ENCODE:加密，DECODE:解密
 * @param  string $key       密钥
 * @param  int    $expiry    加密有效时间
 * @return string            加密或解密后的字符串
 */
function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0){

        $ckey_length = 4;  
        $key = md5($key ? $key : UC_KEY);
        $keya = md5(substr($key, 0, 16));
        $keyb = md5(substr($key, 16, 16));
        $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';

        $cryptkey = $keya.md5($keya.$keyc);
        $key_length = strlen($cryptkey);

        $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
        $string_length = strlen($string);

        $result = '';
        $box = range(0, 255);

        $rndkey = array();
        for($i = 0; $i <= 255; $i++) {
            $rndkey[$i] = ord($cryptkey[$i % $key_length]);
        }

        for($j = $i = 0; $i < 256; $i++) {
            $j = ($j + $box[$i] + $rndkey[$i]) % 256;
            $tmp = $box[$i];
            $box[$i] = $box[$j];
            $box[$j] = $tmp;
        }

        for($a = $j = $i = 0; $i < $string_length; $i++) {
            $a = ($a + 1) % 256;
            $j = ($j + $box[$a]) % 256;
            $tmp = $box[$a];
            $box[$a] = $box[$j];
            $box[$j] = $tmp;
            $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
        }

        if($operation == 'DECODE') {
            if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
                return substr($result, 26);
            } else {
                return '';
            }
        } else {
            return $keyc.str_replace('=', '', base64_encode($result));
        }

    }
	

/*
 * 以下为兼容前台模板调用函数
 */
function codetra($content,$codetype) {
	if($codetype==1){
		$content = str_replace('+','metinfo',$content);
	}else{
		$content = str_replace('metinfo','+',$content);
	}
	return $content;
}

function imgxytype($list,$type){
	global $met_newsimg_x,$met_newsimg_y,$met_productimg_x,$met_productimg_y,$met_imgs_x,$met_imgs_y;
	$lists=array();
	foreach($list as $key=>$val){
		switch($val['module']){
			case 2:
				$val['img_x']=$met_newsimg_x;
				$val['img_y']=$met_newsimg_y;
			break;
			case 3:
				$val['img_x']=$met_productimg_x;
				$val['img_y']=$met_productimg_y;
			break;
			case 5:
				$val['img_x']=$met_imgs_x;
				$val['img_y']=$met_imgs_y;
			break;
		}
		$lists[$val[$type]]=$val;
	}
	return $lists;
}
function metmodname($module){
	$metmodname='';
	switch($module){
		case 1:
			$metmodname='about';
			break;
		case 2:
			$metmodname='news';
			break;
		case 3:
			$metmodname='product';
		    break;
		case 4:
			$metmodname='download';
		    break;
		case 5:
			$metmodname='img';
		    break;
		case 6:
			$metmodname='job';
		    break;
		case 100:
			$metmodname='product';
		    break;
		case 101:
			$metmodname='img';
		    break;
	}
	return $metmodname;
}

function template($template){
	global $_M;
	$path = PATH_WEB."templates/{$_M['config']['met_skin_user']}/{$template}.html";
	!file_exists($path) && $path=PATH_WEB."templates/{$_M['config']['met_skin_user']}/{$template}.php";
	!file_exists($path) && $path=PATH_WEB."public/ui/met/{$template}.html";
	return $path;
}

function footer(){
	global $output;
	$output = str_replace(array('<!--<!---->','<!---->','<!--fck-->','<!--fck','fck-->','',"\r",substr($admin_url,0,-1)),'',ob_get_contents());
    ob_end_clean();
	echo $output;
	DB::close();
	exit;
}
/*
 * 缓存兼容函数
 */
function cache_online(){
    global $_M;
	$query="SELECT * FROM {$_M['table']['met_online']} WHERE lang='{$_M['lang']}' ORDER BY no_order";
	$result= DB::query($query);
	while($list = DB::fetch_array($result)){
		$data[]=$list;
	}
	return cache_page('online_'.$lang.'.inc.php',$data);
}
function cache_otherinfo($retype=1){
	global $_M;
    $data = DB::get_one("SELECT * FROM {$_M['table']['otherinfo']} WHERE lang='{$_M['lang']}' ORDER BY id");
	return cache_page('otherinfo_'.$lang.'.inc.php',$data,$retype);
}
function cache_str(){
	global $_M;
	$query = "SELECT * FROM {$_M['table']['label']} WHERE lang='{$_M['lang']}' ORDER BY char_length(oldwords) DESC";
	$result = DB::query($query);
	while($list = DB::fetch_array($result)) {
		$str_list_temp[0]=$list['oldwords'];
		if($list[url]){
			$str_list_temp[1]="<a title='$list[newtitle]' target='_blank' href='$list[url]' class='seolabel'>$list[newwords]</a>";
		}else{
			$str_list_temp[1]=$list[newwords];
		}
		$str_list_temp[2]=$list['num'];
		$str_list[]=$str_list_temp;
	}
	return cache_page("str_".$lang.".inc.php",$str_list);
}
function cache_column(){
	global $_M;//mobile
	$query="SELECT * FROM {$_M['table']['column']} WHERE lang='{$_M['lang']}' ORDER BY classtype desc,no_order";
	$result= DB::query($query);
	while($list = DB::fetch_array($result)){
		$cache_column[$list['id']]=$list;
	}
	return cache_page("column_".$lang.".inc.php",$cache_column);
}
function cache_page($file,$string,$retype=1){  
	$return = $string;
	if(is_array($string)) $string = "<?php\n return ".var_export($string, true)."; ?>";
	$string=str_replace('\n','',$string);
	if(!is_dir(PATH_WEB.'cache/'))mkdir(PATH_WEB.'cache/','0777');
	$file = PATH_WEB.'cache/'.$file;
	$strlen = file_put_contents($file, $string);
	if($retype==1){
		return $return;
	}else{
		return $strlen;
	}
}
function met_cache($file){
    $file = PATH_WEB.'cache/'.$file;
	if(!file_exists($file))return array();
	return include $file;
}
# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>