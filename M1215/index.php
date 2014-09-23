<?php
/**
 *description:前台模块入口
 *date 2014-09-23 21:46:00
 *author komiles<komiles@163.com>
 **/

	define('M_NAME', 'M1215');
	define('M_MODULE', 'web');
	define('M_CLASS', 'M1215');
	define('M_ACTION', 'doindex');//或define('M_ACTION', $GET[‘action’]);
	require_once '../app/app/entrance.php';//因为入口是app所以不要赋值M_TYPE。
?>
