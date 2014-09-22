<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved. 

defined('IN_MET') or exit('No permission');

/**
  * 获取COOKIE值
  * @param  string  $key                             指定键值
  * @return string  $_M['user']['cookie'][$key]	  返回对应COOKIE值
*/
function get_met_cookie($key){
	global $_M;
	if($key == 'metinfo_admin_name' || $key == 'metinfo_member_name'){
		$val = urldecode($_M['user']['cookie'][$key]);
		$val = sqlinsert($val);
		return $val;
	}
	return $_M['user']['cookie'][$key];
}

/**
  * 判断COOKIE是否超过一个小时，如果没有超过则更新$_M['user']['cookie']中的信息
*/
function met_cooike_start(){
	global $_M;
	$_M['user']['cookie'] = array();
	$met_webkeys = $_M['config']['met_webkeys'];
	list($username, $password) = explode("\t",authcode($_M['form']['met_auth'], 'DECODE', $met_webkeys.$_COOKIE['met_key']));
	$username=sqlinsert($username);
	$query = "SELECT * from {$_M['table']['admin_table']} WHERE admin_id = '{$username}'";
	$user = DB::get_one($query);
	$usercooike = json_decode($user['cookie']);
	if(md5($user['admin_pass']) == $password && time()-$usercooike->time<3600){
		foreach($usercooike as $key=>$val){
			$_M['user']['cookie'][$key] = $val;
		}
		$_M['user']['cookie']['time'] = time();
		$json = json_encode($_M['user']['cookie']);
		$query = "update {$_M['table']['admin_table']} set cookie = '{$json}' WHERE admin_id = '{$username}'";
		$user = DB::query($query);
	}
}

/**
  * 清除COOKIE
  * @param  int  用户ID    
*/
function met_cooike_unset($userid){
	global $_M;
	$met_admin_table = $_M['table']['admin_table'];
	$userid = sqlinsert($userid);
	$query = "UPDATE {$_M['table']['admin_table']} set cookie = '' WHERE admin_id='{$userid}' AND usertype = '3'";
	DB::query($query);
	met_setcookie("met_auth",'',time()-3600);
	met_setcookie("met_key",'',time()-3600);
	met_setcookie("appsynchronous",0,time()-3600,'');
	unset($_M['user']['cookie']);
}

/**
  * 页面跳转
*/
function turnover($url, $text) {
	echo("<script type='text/javascript'>location.href='{$url}&turnovertext={$text}';</script>");
	exit;
}

/**
  * 获取当前管理员信息
  * @return array  $user	   返回记录当前管理员信息的数组
*/
function admin_information(){
	global $_M;
	met_cooike_start();
	$met_admin_table = $_M['table']['admin_table'];
	$met_column = $_M['table']['column'];
	$metinfo_admin_name = get_met_cookie('metinfo_admin_name');
	$query = "SELECT * from {$_M['table']['admin_table']} WHERE admin_id = '{$metinfo_admin_name}'";
	$user = DB::get_one($query);
	$query = "SELECT id,name from {$_M['table']['column']} WHERE access <= '{$user['usertype']}' AND lang = '{$_M['lang']}'";
	$column = DB::get_all($query);
	$user['column'] = $column;
	return $user;
}

/**
  * 获取当前会员信息；
  * @return array  $user	   返回记录当前会员信息的数组
*/
function member_information(){
	global $_M;
	met_cooike_start();
	$met_admin_table = $_M['table']['admin_table'];
	$met_column = $_M['table']['column'];
	$metinfo_member_name = get_met_cookie('metinfo_admin_name');
	if(!$metinfo_member_name){
		$metinfo_member_name = get_met_cookie('metinfo_member_name');
	}
	$query = "SELECT * from {$_M['table']['admin_table']} WHERE admin_id = '{$metinfo_member_name}'";
	$user = DB::get_one($query);
	$query = "SELECT id,name from {$_M['table']['column']} WHERE access <= '{$user['usertype']}' AND lang = '{$_M['lang']}'";
	$column = DB::get_all($query);
	$user['column'] = $column;
	return $user;
}

/**
	*获取当前管理员的权限
	*@return array  $privilege          返回记录对应权限的数组
*/
function background_privilege(){
	global $_M;
	met_cooike_start();
	$metinfo_admin_name = get_met_cookie('metinfo_admin_name');
	$query = "SELECT * from {$_M['table']['admin_table']} WHERE admin_id = '{$metinfo_admin_name}'";
	$user = DB::get_one($query);
	$privilege = array();
	if(strstr($user['admin_type'], "metinfo")){
		$privilege['navigation'] = "metinfo";
		$privilege['column'] = "metinfo";
		$privilege['application'] = "metinfo";
		$privilege['see'] = "metinfo";
	}else{
		$allidlist = explode('-', $user['admin_type']);
		foreach($allidlist as $key=>$val){
			if(strstr($val, "s")){
				$privilege['navigation'].= str_replace('s','',$val)."|";
				
			}
			if(strstr($val, "c")){
				$privilege['column'].= str_replace('c','',$val)."|";
			}
			if(strstr($val, "a")){
				$privilege['application'].= str_replace('a','',$val)."|";
			}
			if($val == 9999){
				$privilege['see'] = "metinfo";
			}
		}
		
	}
	return $privilege;
}

/**
	*获取当前管理员有权限操作的栏目信息
	*@return array  $column          返回栏目数组
*/
function operation_column(){
	global $_M;
	$jurisdiction = background_privilege();
	if($jurisdiction['column'] == "metinfo"){
		$query = "SELECT * from {$_M['table']['column']} WHERE lang = '{$_M['lang']}' AND module < 9";
		$admin_column = DB::get_all($query);
	}else{
		$column_id = explode('|', $jurisdiction['column']);
		$i = 0;
		foreach($column_id as $key=>$val){
			if($val){
				if($i==0){
					$sql_id = "AND (id = '{$val}' ";
				}else{
					$sql_id.= "OR id = '{$val}' ";
				}
			}
			$i++;
		}
		$sql_id.= ")";
		$query = "SELECT * from {$_M['table']['column']} WHERE lang = '{$_M['lang']}'{$sql_id} AND module < 9";
		$admin_column = DB::get_all($query);
	}
	foreach($admin_column as $key=>$val){
		$column[$val['id']] = $admin_column[$key];
	}
	return $column;
}

/**
	*对当前管理员有权限操作的栏目信息进行整理；
	*@param  int    $type        1；按模块生成;2：按栏目生成
	*@return array  $column      返回生成的数组
*/
function column_sorting($type){
	global $_M;
	$information = operation_column();
	if($type == 1){
		foreach($information as $key=>$val){
			if($val['releclass'] != 0){
				$sorting[$val['module']]['class1'][$key] = $information[$key];
				$column_classtype[] = $val['id'];
			}else{
				if($val['classtype'] == 1){
					$sorting[$val['module']]['class1'][$key] = $information[$key];
				}
				if($val['classtype'] == 2){
					$sorting[$val['module']]['class2'][$key] = $information[$key];
				}
			}
		}
		foreach($information as $key=>$val){
			$i = 0;
			if($val['classtype'] == 3){
				foreach($column_classtype as $key1=>$val1){
					if($val['bigclass'] == $val1){
						$i = 1;
					}
				}
				if($i == 1){
					$sorting[$val['module']]['class2'][$key] = $information[$key];
				}else{
					$sorting[$val['module']]['class3'][$key] = $information[$key];
				}
			}
		}
	}else{
		foreach($information as $key=>$val){
			if($val['classtype'] == 1){
				$sorting['class1'][$key] = $information[$key];
			}
			if($val['classtype'] == 2){
				$sorting['class2'][$val['bigclass']][$key] = $information[$key];
			}
			if($val['classtype'] == 3){
				$sorting['class3'][$val['bigclass']][$key] = $information[$key];
			}
		}
	}
	return $sorting;
}
# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>