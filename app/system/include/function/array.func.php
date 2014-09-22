<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved. 

load::sys_func('str.func.php');
/**
	*数组是否为空 
	*@param  array    $arr  要检测的数组
	*@return boolean  $flag   数组为空返回false，否则返回true
*/
function is_arrempty($arr){
	$flag = true;
	if(empty($arr)){
		$flag = false;
	}
	return $flag;
}

/**
	*数组转换为字符串（多维情况）
	*@param  array   $arr  		  要转换的数组
	*@param  string  $delimiter1  一维数组分割符
	*@param  string  $delimiter2  二维数组分割符
	*@param  string  $delimiter3  三维数组分割符
	*@return string  $str		  返回由数组转换后的字符串，输入的数组不正确（数组为混合数组）返回false
*/
function arrayto_string($arr,$decollator1=',',$decollator2='|',$decollator3='&'){
	if(array_level($arr) == 1){
		$str = implode($decollator1,$arr);
	}else if(array_level($arr) == 2){
		$i = 0;
		foreach($arr as $val){
			if(!is_array($val)){
				return false;
			}
			if($i == 0){
				$str = implode($decollator1,$val);
			}else{
				$str .= $decollator2.implode($decollator1,$val);
			}
			$i++;
		}
	}else if(array_level($arr) == 3){
		$i = 0;
		foreach($arr as $val){
			if(!is_array($val)){
				return false;
			}
			if($i == 0){
			
			}else{
				$str = $str.$decollator3;
			}
			foreach($val as $value){
				if(!is_array($value)){
					return false;
				}
				if($i == 0){
					$str = implode($decollator1,$value);
				}else{
					$str .= $decollator2.implode($decollator1,$value);
				}
				$i++;
			}
		}
	}else{
		return false;
	}
	return $str;
}

/**
	*字符串转换为数组（多维情况）
	*@param  string  $str  		  要转换的字符串
	*@param  string  $delimiter1  一维数组分割符
	*@param  string  $delimiter2  二维数组分割符
	*@param  string  $delimiter3  三维数组分割符
	*@return string  $arr		  返回由字符串转换后的数组
	*例如：'图1,路径1|图2,路径2'（两边也可以有竖线）	会转换为：
		array(
			0 => array(
					0 => '图1',
					1 => '路径1'
					),
			1 => array(
					0 => '图2',
					1 => '路径2'
					)
			);
*/
function stringto_array($str, $decollator1 = ',', $decollator2 = '|', $decollator3 = '&'){
	if(is_string($str)){
		$str1 = trim($str,$decollator3);
		$arr1 = explode($decollator3, $str1);
		foreach($arr1 as $key=>$val){
			$str2 = trim($val, $decollator2);
			$arr2 = explode($decollator2, $str2);
			foreach($arr2 as $value){
				$str3 = trim($value, $decollator1);				
				if(is_strinclude($str, $decollator3) == false && is_strinclude($str, $decollator2) == false){
					$arr = explode($decollator1, $str3);
				}else if(is_strinclude($str, $decollator3) == false && is_strinclude($str, $decollator2) != false){
					$arr[] = explode($decollator1, $str3);
				}else{
					$arr[$key][] = explode($decollator1, $str3);
				}				
			}
		}
	}else{
		return false;
	}
	return $arr;
}

/**
	* 判断数组的维数
	* @param  array    $arr    要判断的数组
	* @param  array    $arr1   层数数组
	* @param  array    $level  当前层数
	* @return int              返回数组的维数
*/
function array_level($arr, &$arr1 = array(), $level = 0){
	if(is_array($arr)){
		$level++;
		$arr1[] = $level;
		foreach($arr as $val){
			array_level($val, $arr1, $level);
		}
	}else{
		$arr1[] = 0;
	}
	return max($arr1);
}

/**
	*一维数组/二维数组排序 
	*@param  array			 $arr		要排序的数组
	*@param  string(int)     $sort_key  如果数组是二维数组则代表要排序的键，如果为一维数组 0代表按值排序 1代表按键排序
	*@param  string 		 $sort      SORT_ASC - 按照上升顺序排序    SORT_DESC - 按照下降顺序排序（默认升序）
	*@return array			 $arr		返回排序后的数组，输入的数组不正确时返回false
*/
function arr_sort($arr, $sort_key = 0, $sort = SORT_ASC){
	if(array_level($arr) == 2){
		foreach ($arr as $key=>$val){
			if(is_array($val)){ 
				$key_arr[] = $val[$sort_key];
			}else{
				return false;
			}
		}
		array_multisort($key_arr, $sort, $arr);
		return $arr; 
	}else if(array_level($arr) == 1){
		if($sort_key == 0){
			if($sort == SORT_ASC){
				asort($arr);
			}else{
				arsort($arr);
			}
		}else if($sort_key==1){
			if($sort == SORT_ASC){
				ksort($arr);
			}else{
				krsort($arr);
			}
		}
		return $arr;
	}else{
		return false;
	}
}

/**
	*数组转换成json
	*@param  array	$arr	要转换的数组
	*@return json			返回转换成的json
*/
function jsonencode($arr){
    $parts = array();
    $is_type = false;         //false 关联数组         true 索引数组
    $keys = array_keys($arr);
    $length = count($arr)-1;
    if($keys[0] == 0 && $keys[$length] == $length){//判断是索引数组还是关联数组
        $is_type = true;
        for($i=0; $i<count($keys); $i++){
            if($i != $keys[$i]){
                $is_type = false;
                break;
            }
        }
    }
    foreach($arr as $key=>$val){
        if(is_array($val)){
            if($is_type){
				$parts[] = jsonencode($val);
			}else{
				$parts[] = '"' . $key . '":' . jsonencode($val);
			}
        }else{
            $str = '';
            if(!$is_type){
				$str = '"' . $key . '":';
			}
            if(is_numeric($val)){
				$str .= $val;
			}else if($val === false){
				$str .= 'false';
			}else if($val === true){
				$str .= 'true';
			}else{
				$str .= '"' . addslashes($val) . '"';
			}
            $parts[] = $str;
        }
    }
    $json = implode(',', $parts);
    if($is_type)return '[' . $json . ']';
    return '{' . $json . '}';
}

/**
	*json转换成数组
	*@param  json		$json		要转换的json（只能是json格式）
	*@return array		$arr		返回转换成的数组
*/
function jsondecode($json){
    $convert = false;
    $str = '$arr=';
	//$code = mb_detect_encoding('长沙米拓信息技术有限公司（MetInfo）',"ASCII,UTF-8,GB2312,GBK",true);
    for ($i=0; $i<strlen($json); $i++){
        if (!$convert){
            if (($json[$i] == '{') || ($json[$i] == '[')){
				$str .= ' array(';
			}else if (($json[$i] == '}') || ($json[$i] == ']')){
				$str .= ')';
			}else if ($json[$i] == ':'){
				$str .= '=>';
			}else{
				$str .= $json[$i];
			}                                    
        }else{
			$str .= $json[$i];
		}         
        if ($json[$i] == '"' && $json[($i-1)]!="\\"){
			$convert = !$convert;
		}
    }
	//$str=iconv($code,'utf-8',$str);
    eval($str . ';');
    return $arr;
}

/*
 * 把数组转成JSON，用于ajax返回
 * @param array  $back      输出字符串或数组 
 * @param string $callback  ajax的回调函数的名称
 */
function jsoncallback($back ,$callback = 'callback'){
	global $_M;
	$callback =	$_M['form'][$callback];
	if($_M['form']['callback']){
		echo $callback.'('.json_encode($back).')';
	}else{
		echo json_encode($back);
	}
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>