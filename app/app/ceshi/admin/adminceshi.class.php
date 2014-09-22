<?php
defined('IN_MET') or exit('No permission');
load::sys_class('admin');
class adminceshi extends admin{
	public function __construct() {
		parent::__construct();
	}

	public function doindex() {
		echo 'this is test files';
	}

}
?>
