<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved. 

defined('IN_MET') or exit('No permission');
defined('IN_ADMIN') or exit('No permission');

load::sys_class('common');

/**
 * 后台基类
 */
class admin extends common {
	
	/**
	  * 初始化
	  */
	public function __construct() {
		parent::__construct();
		$this->check();
		$this->load_language();
		load::plugin('admin');
	}
	
	/**
	  * 重写common类的load_url_site方法，获取前台与后台网址
	  */
	protected function load_url_site() {
		global $_M;
		$_M['url']['site_admin'] = 'http://'.str_replace('/index.php', '', HTTP_HOST.PHP_SELF).'/';
		$_M['url']['site'] = preg_replace('/(\/[^\/]*\/$)/', '', $_M[url][site_admin]).'/';
	}
	
	/**
	  * 重写common类的load_url_unique方法，获取后台台特有URL
	  */
	protected function load_url_unique() {
		global $_M;
		$_M['url']['ui'] = $_M[url][site].'app/system/include/public/ui/admin/';
	}
	
	/**
	  * 获取当前语言参数
	  */
	protected function load_language() {
		global $_M;
		$_M['langset'] = get_met_cookie('languser');
		$this->load_word($_M['langset'], 1);
	}
	
	/**
	 * 检测是否登陆
	 * 有权限则程序向后运行，无权限则提示物权限
	 */	
	protected function check() {
		global $_M;
		met_cooike_start();
		$current_url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		if (strstr($current_url, $_M['url']['site_admin']."index.php")) {
			$admin_index = 1;
		} else {
			$admin_index = '';
		}
		$met_adminfile = $_M['config']['met_adminfile'];
		$met_admin_table = $_M['table']['admin_table'];
		$metinfo_admin_name = get_met_cookie('metinfo_admin_name');
		$metinfo_admin_pass = get_met_cookie('metinfo_admin_pass');
		if (!$metinfo_admin_name || !$metinfo_admin_pass) {
			if ($admin_index) {
				met_cooike_unset();
				met_setcookie("re_url", $re_url,time()-3600);
				Header("Location: ".$_M['url']['site_admin']."login/login.php");
			} else {
				if (!$re_url) {
					$re_url = $_SERVER[HTTP_REFERER];
					$HTTP_REFERERs = explode('?', $_SERVER[HTTP_REFERER]);
					$admin_file_len1 = strlen("/{$met_adminfile}/");
					$admin_file_len2 = strlen("/{$met_adminfile}/index.php");
					if(strrev(substr(strrev($HTTP_REFERERs[0]), 0, $admin_file_len1)) == "/{$met_adminfile}/" || strrev(substr(strrev($HTTP_REFERERs[0]), 0,$admin_file_len2)) == "/{$met_adminfile}/index.php"||!$HTTP_REFERERs[0]) {
						$re_url = "http://{$_SERVER[SERVER_NAME]}{$_SERVER[REQUEST_URI]}";
					}
				}
				if (!$_COOKIE[re_url]&&!strstr($re_url, "return.php")) met_setcookie("re_url", $re_url,time()+3600);
				met_cooike_unset();
				Header("Location: ".$_M['url']['site_admin']."login/login.php");
			}
			exit;
		} else {
			$query = "SELECT * FROM {$_M['table']['admin_table']} WHERE admin_id = '{$metinfo_admin_name}' AND admin_pass = '{$metinfo_admin_pass}' AND usertype = '3'";
			$admincp_ok = DB::get_one($query);
			if (!$admincp_ok) {
				if ($admin_index) {
					met_cooike_unset();
					met_setcookie("re_url",$re_url,time()-3600);
					Header("Location: ".$_M['url']['site_admin']."login/login.php");
				} else {
					if (!$re_url) {
						$re_url = $_SERVER[HTTP_REFERER];
						$HTTP_REFERERs = explode('?',$_SERVER[HTTP_REFERER]);
						$admin_file_len1 = strlen("/{$met_adminfile}/");
						$admin_file_len2 = strlen("/{$met_adminfile}/index.php");
						if(strrev(substr(strrev($HTTP_REFERERs[0]), 0, $admin_file_len1)) == "/$met_adminfile/" || strrev(substr(strrev($HTTP_REFERERs[0]),0,$admin_file_len2)) == "/{$met_adminfile}/index.php" || !$HTTP_REFERERs[0]){
							$re_url = "http://{$_SERVER[SERVER_NAME]}{$_SERVER[REQUEST_URI]}";
						}
					}
					if (!strstr($re_url, "return.php")) {
						if (!$_COOKIE['re_url']) met_setcookie("re_url", $re_url,time()+3600);
					}
					met_cooike_unset();
					Header("Location: ".$_M['url']['site_admin']."login/login.php");
				}
				exit;
			}
		}
		$query = "SELECT * FROM {$_M['table']['admin_table']} WHERE admin_id='{$metinfo_admin_name}' AND admin_pass='{$metinfo_admin_pass}'";
		$membercp_ok = DB::get_one($query);
		if (!strstr($membercp_ok['admin_op'], "metinfo")) {
			switch (M_ACTION) {
				case "add";
					if (!strstr($membercp_ok['admin_op'], "add")) okinfo('javascript:window.history.back();', $_M['word']['loginadd']);
					break;
				case "editor";
					if (!strstr($membercp_ok['admin_op'], "editor")) okinfo('javascript:window.history.back();', $_M['word']['loginedit']);
					break;
				case "del";
					if (!strstr($membercp_ok['admin_op'], "del")) okinfo('javascript:window.history.back();', $_M['word']['logindelete']);
					break;
				case "all";
					if (!strstr($membercp_ok['admin_op'], "metinfo")) okinfo('javascript:window.history.back();', $_M['word']['loginall']);
					break;
			}
		}
	}
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>