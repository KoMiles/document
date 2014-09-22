<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved. 

defined('IN_MET') or exit('No permission');

load::sys_class('admin.class.php');

class adminceshi extends admin {
	function __construct() {
		parent::__construct();
	}
	function index() {
		global $_M;
echo PATH_OWN_FILE;
		$control['type'] = 'form';
		
		$control['name'] = '';
		$control['class'] = 'adminceshi';
		$control['action'] = 'modify';
		
		$control['block'][1]['title']=$_M['word']['indexbasicinfo'];
		
		$control['block'][1]['list'][1]['title']=$_M['word']['setbasicWebSite'];
		$control['block'][1]['list'][1]['control']['name'] = 'met_weburl';
		$control['block'][1]['list'][1]['control']['value'] = $_M['config']['met_weburl'];
		$control['block'][1]['list'][1]['control']['type'] = 'input';
		$control['block'][1]['list'][1]['control']['class'] = 'text';
		
		
		$this -> template('ui/php/list', $control);

	}
	function modify() {
		echo "<script type=\"text/javascript\">alert(\"²Ù×÷³É¹¦\");location.href='index.php?n=yanzhengma&c=yanzhengma&a=index&anyid={65}&lang={$_M['lang']}';</script>";
	}
}

//$yanzhengma=new yanzhengma;
# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>