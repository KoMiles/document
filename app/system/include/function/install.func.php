<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved. 

/**
	*导入应用语言参数的配置文件；
	*@param  string  $route                             指定配置文件路径；
*/
function  language_insert($route){
	global $_M;
	$path = 'language_cn.ini';
	$fp = fopen($path, "r");
	$read = fread($fp, filesize($path));
	fclose($fp);
	$re_urls = explode("\n",$read);
	$i = 0;
	$j = 0;
	foreach($re_urls as $key=>$val){
		if(trim($val) == "#后台语言参数"){
			$back_language=$key;
		}
		if(strstr($val, "#Language-")){
			$parameters=str_replace('#Language-','',$val);
			$parameters=$parameters."-".$i;
			$language_parameters[$parameters]=$key;
			$range[$i] = $key;
			$i++;
		}
		if(strstr($val, "#应用编号-")){
			$parameters = str_replace('#应用编号-','',$val);
			$parameters = $parameters."-".$j;
			$Application_parameters[$parameters] = $key;
			$range1[$j] = $key;
			$j++;
		}
	}
	$x = 0;
	$y = 1;
	foreach($language_parameters as $key=>$val){
		if(!$range[$y]){
			$range[$y] = 10000000;
		}
		$language_parameters[$key] = $range[$x]."-".$range[$y];
		$x++;
		$y++;
	}
	$x = 0;
	$y = 1;
	foreach($Application_parameters as $key=>$val){
		if(!$range1[$y]){
			$range1[$y] = 10000000;
		}
		$Application_parameters[$key] = $range1[$x]."-".$range1[$y];
		$x++;
		$y++;
	}
	foreach($Application_parameters as $key=>$val){
		$query = "delete from {$_M['table']['language']} where app='{$key}'";
		$column = DB::query($query);
	}
	foreach($re_urls as $key=>$val){
		$language_data = array();
		if(strstr($val, "=")){
			$language_data = explode('=', $val);
			if($key>$back_language){
				$language_data['2'] = 1;
			}else{
				$language_data['2'] = 0;
			}
			foreach($Application_parameters as $key2=>$val2){
				$comparison = array();
				$comparison = explode('-', $val2);
				if($comparison['0'] < $key && $key < $comparison['1']){
					$comparison_info = array();
					$comparison_info = explode('-',$key2);
					$language_data['3'] = $comparison_info['0'];
				}
			}
			foreach($language_parameters as $key1=>$val1){
				$comparison = array();
				$comparison = explode('-', $val1);
				if($comparison['0'] < $key && $key < $comparison['1']){
					$comparison_info = array();
					$comparison_info = explode('-',$key1);
					$language_data['4'] = $comparison_info['0'];
				}
			}
			$query = "insert into {$_M['table']['language']} set name='{$language_data['0']}',value='{$language_data['1']}',site='{$language_data['2']}',app='{$language_data['3']}',lang='{$language_data['4']}'";
			$column = DB::query($query);
		}
	}
}

/**
	*添加应用的属性
	*@param  string  $no                               应用编号；
	*@param  string  $filename                         存放应用的文件夹名称；
	*@param  string  $attribute                        相关参数；
	*@param  string  $type                             添加的类型；
*/
function increase_app($no,$filename,$attribute,$type){
	global $_M;
	if($type == 1){
		if(!DB::get_one("select * from {$_M['table']['ifcolumn']} where no='{$no}'")){
			$allidlist=explode('|', $attribute);
			$query = "INSERT INTO {$_M['table']['ifcolumn']} SET no='{$no}', name='{$allidlist['0']}',appname='{$allidlist['1']}',addfile='{$allidlist['2']}',memberleft='{$allidlist['3']}',uniqueness='{$allidlist['4']}',fixed_name='{$allidlist['5']}'";
			DB::query($query);
		}
	}else{
		if($type == 2){
			$allidlist=explode('|', $attribute);
			$query = "INSERT INTO {$_M['table']['ifcolumn_addfile']} SET no='{$no}', filename='{$filename}',m_name='{$allidlist['0']}',m_module='{$allidlist['1']}',m_class='{$allidlist['2']}',m_action='{$allidlist['3']}'";
			DB::query($query);
		}else{
			$allidlist = explode('|', $attribute);
			$query = "INSERT INTO {$_M['table']['ifmember_left']} SET no='{$no}', columnid='{$allidlist['0']}',title='{$allidlist['1']}',foldername='{$allidlist['2']}',filename='{$allidlist['3']}'";
			DB::query($query);
		
		}
	}

}

/**
	*应用模块创建时生成相应文件
	*@param  string  $no                               应用编号；
	*@param  string  $foldername                       存放应用的文件夹名称；
*/
function establish_appmodule($no,$foldername){
	global $_M;
	$addfile_type = DB::get_one("select * from {$_M['table']['ifcolumn']} where no='{$no}'");
	if($addfile_type['addfile'] == 1){
		$path = '../'.$foldername;
		mkdir($path, 0777);
		$structure = DB::get_all("select distinct filename from {$_M['table']['ifcolumn_addfile']} where no='{$no}'");
		foreach($structure as $key=>$val){
			$path = '../'.$foldername.'/'.$val['filename'];
			$fp = fopen($path, "w+");
		$str="<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved. 
"."\n";
			fputs($fp,$str);
			fclose($fp);
		}
		$structure1 = DB::get_all("select * from {$_M['table']['ifcolumn_addfile']} where no='{$no}'");
		foreach($structure1 as $key=>$val){
			$straction[$val[filename]].= "define('M_NAME', '".$val['m_name']."');\ndefine('M_MODULE', '".$val['m_module']."');\ndefine('M_PATH', '');\ndefine('M_CLASS', '".$val['m_class']."');\n";
			if(substr($val['m_action'], 0, 1) == '$'){
				$straction[$val['filename']].= "define('M_ACTION', ".$val['m_action'].");\n";
			}else{
				$straction[$val['filename']].= "define('M_ACTION', '".$val['m_action']."');\n";
			}
			$straction[$val['filename']].= "require_once '../app/app/entrance.php';\n";
		}
		foreach($structure as $key=>$val){
			$path = '../'.$foldername.'/'.$val['filename'];
			$fp = fopen($path, "r");
			$read = fread($fp, filesize($path));
			fclose($fp);
			$fp = fopen($path, "w");
			$str = $read.$straction[$val['filename']]."# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>";
			fputs($fp, $str);
			fclose($fp);
		}
	}
}

/**
	*添加后台侧导航
	*@param  string  $name                           语言变量名称；
	*@param  string  $value                          语言变量的值；
	*@param  string  $bigclass                       所属的主导航；
	*@param  string  $order                          排序；
	*@param  string  $url                            链接的网址；
*/
function lateral_navigation($name,$value,$bigclass,$order,$url){
	global $_M;
	$allidlist = explode('|', $value);
	if(!DB::get_one("select * from {$_M['table']['language']} where name='{$name}' and lang='cn'")){
		$query = "INSERT INTO {$_M['table']['language']} SET name='{$name}',value='{$allidlist['0']}',site='1',no_order='0',array='8',app='0',lang='cn'";
		DB::query($query);
	}
	if(!DB::get_one("select * from {$_M['table']['language']} where name='{$name}' and lang='en'")){
		$query = "INSERT INTO {$_M['table']['language']} SET name='{$name}',value='{$allidlist['1']}',site='1',no_order='0',array='8',app='0',lang='en'";
		DB::query($query);
	}
	if(!DB::get_one("select * from {$_M['table']['language']} where name='{$name}' and lang='tc'")){
		$query = "INSERT INTO {$_M['table']['language']} SET name='{$name}',value='{$allidlist['2']}',site='1',no_order='0',array='8',app='0',lang='tc'";
		DB::query($query);
	}
	$name1='lang_'.$name;
	if(!DB::get_one("select * from {$_M['table']['admin_column']} where name='{$name1}' and type='2'")){
		$query = "INSERT INTO {$_M['table']['admin_column']} SET name='{$name1}',url='{$url}',bigclass='{$bigclass}',type='2',list_order='{$order}'";
		DB::query($query);
	}
}

/**
	*创建新的应用
	*@param  string  $no                               应用编号；
	*@param  string  $filename                         存放应用的文件夹名称；
	*@param  string  $add_attribute                    应用的参数；
	*@param  string  $left_attribute                   会员侧导航的参数；
	*@param  string  $column_attribute                 应用栏目的参数；
	*@param  string  $lateral_attribute                后台侧导航的参数；
*/
function appmodule_install($no,$filename,$add_attribute,$left_attribute,$column_attribute,$lateral_attribute){
	global $_M;
	
	if($no && $add_attribute){
		increase_app($no,'',$add_attribute,'1');
		$allidlist = array();
		$allidlist = explode('|', $add_attribute);
		if($allidlist['2'] == 1){
			if($no&&$filename){
			$path = '../'.$filename;
			mkdir($path, 0777);
			$path='../'.$filename.'/index.php';
			$fp = fopen($path, "w+");
			$str = "<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved. 


# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>";
			fputs($fp,$str);
			fclose($fp);
			}
		}
		if($allidlist['3'] == 1){
			if($no&&$left_attribute){
				increase_app($no,'',$left_attribute,'3');
			}
		}
	}
	if($no&&$column_attribute){
		$allidlist = array();
		$allidlist = explode('|', $column_attribute);
		$out_url = $_M['url']['site'].$filename;
		$query = "INSERT INTO {$_M['table']['column']} SET name='{$allidlist['0']}',foldername='{$filename}',module='{$no}',if_in='1',classtype='1',out_url='{$out_url}',display='{$allidlist['1']}',lang='{$_M['lang']}'";
		DB::query($query);
	}
	
	$allidlist = array();
	$allidlist = explode('[*]', $lateral_attribute);
	if($allidlist){
		lateral_navigation($allidlist['0'],$allidlist['1'],$allidlist['2'],$allidlist['3'],$allidlist['4']);
	}
}
# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>