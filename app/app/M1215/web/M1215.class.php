<?php
/**
 *description:前台模块
 *date 2014-09-23 21:46:00
 *author komiles<komiles@163.com>
 **/

defined('IN_MET') or exit('No permission');
load::sys_class('web');
class M1215 extends web {
	public function __construct() {
        parent::__construct();
        global $_M;
        define('PATH_TEM', PATH_WEB."templates/".$_M['config']['met_skin_user'].'/');//模板根目录
        $this->load_language();//语言加载
        met_cooike_start();//读取已登陆会员信息
        $this->load_publuc_data();//加载公共数据
        load::plugin('doweb');//加载插件
	}

	public function doindex() {
		$num = 1215;
		echo '学号为'.$num.'web应用模块';
        $this->custom_template('own/index', 1);
	}
}
?>
