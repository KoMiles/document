<?php
/**
 *description:后台模块
 *date 2014-09-23 21:46:00
 *author komiles<komiles@163.com>
 **/

defined('IN_MET') or exit('No permission');
load::sys_class('admin');
class M1215 extends admin {
	public function __construct() {
		parent::__construct();
	}

	public function doindex() {
		$num = 1215;
		echo '学号为'.$num.'admin应用模块';
	}
}
?>
