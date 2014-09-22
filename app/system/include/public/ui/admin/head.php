<!--<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved. 

defined('IN_MET') or exit('No permission');
$lang_fontfamily=str_replace("'","\"",$lang_fontfamily);
$lang_fontfamily=str_replace("&quot;","\"",$lang_fontfamily);
$jsrand=str_replace('.','',$_M[config][metcms_v]).$_M[config][met_patch];
echo <<<EOT
--><!DOCTYPE HTML>
<html>
<head>
<meta name="renderer" content="webkit">
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<link rel="stylesheet" href="{$_M[url][pub]}ui/admin/css/metinfo.css?{$jsrand}" />
<script>var lang  = '{$_M[lang]}', metimgurl = '{$_M[url][site]}', pubjspath = '{$_M[url][pub]}', basepath  = '{$_M[url][site_admin]}',own='{$_M[url][own]}';</script>
</head>
<body>
<!--
EOT;
if($_M['form']['turnovertext']){
echo <<<EOT
-->
	<div class="returnover none">{$_M['form']['turnovertext']}</div>
<!--
EOT;
}
echo <<<EOT
-->
<!--
EOT;
//require $this->template('ui/nav');
# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>