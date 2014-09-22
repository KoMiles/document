<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved. 

//�汾��
define ('SYS_VER', 'beta 1.00');
define ('SYS_VER_TIME', '20140916');

header("Content-type: text/html;charset=utf-8");

error_reporting(E_ERROR | E_PARSE);
//error_reporting(E_ALL);
PHP_VERSION >= '5.1' && date_default_timezone_set('Asia/Shanghai');
		
define('IN_MET', true);

//MODULE_TYPE
if (M_TYPE) {
	define('M_TYPE', 'system');
}
if (M_MODULE) {
	define ('M_MODULE', 'include');
	define ('M_CLASS', $_GET['c']);
	define ('M_ACTION', $_GET['a']);
}
//��վ��Ŀ¼
define ('PATH_WEB', str_replace('app\system','',dirname(__FILE__)));
//Ӧ�ø�Ŀ¼
define ('PATH_APP', PATH_WEB."app/");
//�����ļ���Ŀ¼
define ('PATH_CONFIG', PATH_WEB."config/");
//�����ļ���Ŀ¼
define ('PATH_CACHE', PATH_WEB."cache/");
//ϵͳ��Ŀ¼
define ('PATH_SYS', PATH_APP."system/");

//ϵͳ���Ŀ¼
define ('PATH_SYS_CLASS', PATH_WEB."app/system/include/class/");
//ϵͳ������Ŀ¼
define ('PATH_SYS_FUNC', PATH_WEB."app/system/include/function/");
//ϵͳģ�幫���ļ���Ŀ¼
define ('PATH_SYS_PUBLIC', PATH_WEB."app/system/include/public/");
//ϵͳģ���Ŀ¼
define ('PATH_SYS_MODULE', PATH_WEB."app/system/include/module/");


//��ǰ�ļ��е�ַ
if(M_TYPE == 'system'){
	if(M_MODULE == 'include'){
		define ('PATH_OWN_FILE', PATH_APP.M_TYPE.'/'.M_MODULE.'/module/');
	}else{
		define ('PATH_OWN_FILE', PATH_APP.M_TYPE.'/'.M_MODULE.'/');
	}
}else{
	define ('PATH_OWN_FILE', PATH_APP.M_TYPE.'/'.M_NAME.'/'.M_MODULE.'/');
}

//�������п�ʼʱ��
define ('TIME_SYS_START', time());
//�������Զ�����
define ('MAGIC_QUOTES_GPC', get_magic_quotes_gpc());

//��ǰ���ʵ�������
define ('HTTP_HOST', $_SERVER['HTTP_HOST']);
//��Դҳ��
define('HTTP_REFERER', $_SERVER['HTTP_REFERER']);
//�ű�·��
define ('PHP_SELF', $_SERVER['PHP_SELF']);

if (!preg_match('/[A-Za-z0-9_]/', M_TYPE.M_NAME.M_MODULE.M_CLASS.M_ACTION)) {
	echo 'Constants must be numbers or letters or underlined';
}

require_once PATH_SYS_CLASS.'load.class.php';

load::module();

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>