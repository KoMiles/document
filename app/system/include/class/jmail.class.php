<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved. 

/**
 * 发送邮件类
 * @param string $fromuser		发件人账号
 * @param string $fromname		发件人姓名
 * @param string $touser		收件人帐号
 * @param string $title			邮件标题
 * @param string $body			内容
 * @param string $usename		邮箱账号
 * @param string $usepassword	邮箱密码
 * @param string $smtp			smtp服务器
 * @param string $errorcode     出错信息	
 */
class jmail{
	public $fromuser;	
	public $fromname;	
	public $touser;	
	public $title;		
	public $body;		
	public $usename;	
	public $usepassword;
	public $smtp;		
	public $errorcode; 	
	public function __construct(){
		$this->set_email();
	}
	
	/**
	 * 为字段赋值
	 * @param  string  $name    字段名称
	 * @param  mixed   $value   要赋给字段的值
	 * @return boolean  		属性名不正确或值没有返回false
	 */
	public function set($name,$value){
		if($value == null){
			return false;
		}
		switch($name){
			case 'fromuser':
				$this->fromuser = $value;
			break;
			case 'fromname':
				$this->fromname = $value;
			break;
			case 'touser':
				$this->touser = $value;
			break;
			case 'title':
				$this->title = $value;
			break;
			case 'body':
				$this->body = $value;
			break;
			case 'usename':
				$this->usename = $value;
			break;
			case 'usepassword':
				$this->usepassword = $value;
			break;
			case 'smtp':
				$this->smtp = $value;
			break;
			default:
				return false;
			break;
		}
	}
	
	/** 
	 * 设置发件邮箱为王站后台设置邮箱
	 */	
	public function set_email(){
		global $_M;
		$this->set('fromuser',$_M['config']['met_fd_usename']);
		$this->set('fromname',$_M['config']['met_fd_fromname']);
		$this->set('usename',$_M['config']['met_fd_usename']);
		$this->set('usepassword',$_M['config']['met_fd_password']);
		$this->set('smtp',$_M['config']['met_fd_smtp']);
	}
	
	/**
	 * 发送邮件
	 * @param  string  $touser  收件人帐号
	 * @param  string  $title   邮件标题
	 * @param  string  $body    邮件内容
	 * @return boolean			发送成功返回true，否则返回false
	 */
	public function send_email($touser,$title,$body){
		global $_M;
		$this->touser = $touser;
		$this->title = $title;
		$this->body = $body;
		$mail=load::sys_class('PHPMailer','new');
		$mail->CharSet = "UTF-8";
		$mail->Encoding = "base64";
		$mail->Timeout = 15; 
		$mail->IsSMTP();
		if(stripos($this->smtp,'.gmail.com') === false){
			$mail->Port = $_M['config']['met_fd_port'];
			$mail->Host = $this->smtp;
			if($_M['config']['met_fd_way'] == 'ssl'){
				$mail->SMTPSecure = "ssl";
			}else{
				$mail->SMTPSecure = "";
			}
		}
		else{
			$mail->Port = 465;
			$mail->Host = $this->smtp;
			$mail->SMTPSecure = "ssl";
		}
		$mail->SMTPAuth = true;
		$mail->Username = $this->usename;    
		$mail->Password = $this->usepassword; 
		$mail->From = $this->fromuser;			 
		$mail->FromName = $this->fromname; 		  
		if($this->repto!=""){
			$name = isset($this->repname) ? $this->repname : $this->repto;
			$mail->AddReplyTo($this->repto, $name);
		}
		$mail->WordWrap = 50; // line 
		$mail->Subject = (isset($this->title)) ? $this->title : '';//title
		$body = eregi_replace("[\]",'',$this->body);
		$mail->MsgHTML($this->body);
		if($this->touser){
			$address = explode("|",$this->touser);
			foreach($address as $key => $val){
				$mail->AddAddress($val, '');
			}
		}
		if(!$mail->Send()) {
			$mail->SmtpClose();
			$this->errorcode = $mail->ErrorInfo;
			return false;
		}else{
			$mail->SmtpClose();
			return true;
		}		
	}
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>