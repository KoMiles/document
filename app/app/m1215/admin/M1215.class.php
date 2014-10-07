<?php
/**
 *description:后台模块
 *date 2014-09-23 21:46:00
 *author komiles<komiles@163.com>
 **/

defined('IN_MET') or exit('No permission');
load::sys_class('admin');
class m1215 extends admin {
	public function __construct() {
		parent::__construct();
	}

	public function doindex() {
        global $_M;
        $num = 1215;
        require $this->template('own/index');
	}
}
?>
