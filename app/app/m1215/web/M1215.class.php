<?php
/**
 *description:前台模块
 *date 2014-09-23 21:46:00
 *author komiles<komiles@163.com>
 **/

defined('IN_MET') or exit('No permission');
load::sys_class('web');
class m1215 extends web {
	public function __construct() {
        parent::__construct();
        load::plugin('doweb');//加载插件

	}
    /**
     * doindex方法
     * 普通左侧栏方式输出文字
     */
	public function doindex() {
        global $_M;
		$test = '1215:doindex';
        require $this->custom_template('own/index', 1);
	}
    /**
     * dosave方法
     */
    public function dosave() {
        global $_M;
		$test = '1215:dosave';
        require $this->custom_template('own/index', 1);
	}
}
?>
