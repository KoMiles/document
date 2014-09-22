<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved. 

defined('IN_MET') or exit('No permission');

/** 
 * 分页类
 * @param string $total		    总个数
 * @param string $pagesize		每一页多少
 * @param string $pages			一共多少页
 * @param string $_cur_page		当前页
 * @param string $SELF			当前页的链接
 * @param string $table			查询的表名
 * @param string $where			where条件
 * @param string $order			order条件
 * @param string $link			分页链接
 * @param string $seolink		首页链接是否完整，1完整，0或空不完整
 * @param string $page			后台跳转到的页码
 * @param string $met_pageskin	分页样式：前台默认样式5，后台的固定了。
 */
class Pager {
	private $total;				
	private $pagesize;				
	private $pages;					
	private $_cur_page;				
	private $SELF;					
	private $table;					
	private $where;					
	private $order;					
	private $link;				
	private $seolink;				
	private $page;	
	private $met_pageskin;
	
	/** 
	 * 初始化函数
	 */
	public function setpage($table, $where, $order, $link, $seolink, $page, $pagesize){
		global $_M;	
		if($page == ''){
			$this->_cur_page = (isset($_M['form']['page']) && $_M['form']['page'] > 0) ? intval($_M['form']['page']) : 1;
		}else{
			$this->_cur_page = $page;
		}		
		if(IN_ADMIN == '1'){
			$this->met_pageskin = '';
		}else{
			$this->met_pageskin = 5;
		}		
		if($pagesize == ''){
			$this->pagesize = 16;	
		}else{
			$this->set('pagesize', $pagesize);
		}		
		if($seolink == ''){
			$this->seolink = 0;	
		}else{
			$this->seolink = 1;	
		}		
		$SELFs = explode('/', $_SERVER['PHP_SELF']);
		$this->SELF = $SELFs[count($SELFs)-2];		
		$this->set('table', $table);
		$this->set('where', $where);
		$this->set('order', $order);
		$this->set('link', $link);		
		$this->total = DB::counter($table, $where, '*');
	}
	
	/** 
	 * 设置常用属性
	 */
	public function set($name, $value){
		global $_M;		
		if($value === NULL){
			return false;
		}	
		switch($name){
			case 'table';
				$this->table =  $value;
			break;
			
			case 'where';
				$this->where = $value;
			break;
			
			case 'order';
				$this->order = $value;
			break;
			
			case 'link';
				$this->link = $value;
			break;
			
			case 'total';
				$this->total =  $value;
			break;
			
			case 'pagesize';
				$this->pagesize = $value;
			break;
			
			case 'pages';
				$this->pages = $value;
			break;
		}	
	}
	
	/** 
	 * 获取一共多少页
	 * @return string 一共多少页
	 */	
    public function _pager(){ 
		return $this->pages = ceil($this->total / $this->pagesize);
    }

	/** 
	 * 获取分页html函数
	 * @return string 分页html   
	 */
	public function get_array(){	
		if(IN_ADMIN == '1'){
			$str = $this->adminlink();
		}else{
			$str = $this->weblink();
		}
		return $str;
	}
	
	/** 
	 * 获取内容数组函数
	 * @return array 内容数组
	 */
	public function get_html(){
		global $_M;	
		if(strtolower(substr($this->where, 0, 5)) != 'where' && $this->where) $this->where = "WHERE ".$this->where;
		if(strtolower(substr($this->order, 0, 5)) != 'order' && $this->order) $this->order = "ORDER BY ".$this->order;	
		$start = ($this->_cur_page-1) * $this->pagesize;	
		$query = "SELECT * FROM {$this->table} {$this->where} {$this->order} DESC LIMIT {$start},{$this->pagesize}";
		$orders = DB::get_all($query);
		return $orders;
	}
	
	/** 
	 * 获取后台分页html函数
	 * @return string 后台分页html  
	 */
	public function adminlink(){
		global $_M;
		$this->_pager();
		if($this->seolink == '0'){	
			$langnums = '1';
		}else{
			$langnums = '0';
		}
		$url=$this->link.'&page=';
		$firestpage = $langnums == 1 ? '../'.$this->SELF.'/' : $url.'1';
		$prepage = $langnums == 1 ? '../'.$this->SELF.'/' : $url.($this->_cur_page - 1) ;
		
		$text = "<style>";
		$text .= ".digg4 { padding:3px; margin:3px; text-align:center; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px;}";
		$text .= ".digg4  a,.digg4 span.miy{ border:1px solid #ccdbe4; padding:2px 8px 2px 8px; background-position:50%; margin:2px; color:#0061de; text-decoration:none;}";
		$text .= ".digg4  a:hover { border:1px solid #2b55af; color:#fff; background-color:#3666d4;}";
		$text .= ".digg4  a:active {border:1px solid #000099; color:#000000;}";
		$text .= ".digg4  span.current { padding:2px 8px 2px 8px; margin:2px; color:#000; text-decoration:none;}";
		$text .= ".digg4  span.disabled { border:1px solid #ccdbe4; padding:2px 8px 2px 8px; margin:2px; color:#ddd;}";
		$text .= ".digg4 .disabledfy { font-family: Tahoma, Verdana;}"; 
		$text .= " </style>";			
		
		if($this->pages > 12 ){
			$startnum = floor(($this->_cur_page / 10)) * 10 + 1;
			if(floor(($this->_cur_page / 10)) == ($this->_cur_page / 10))$startnum = floor(($this->_cur_page / 10)) * 10 + 1 - 10;
			if(($this->pages-$startnum) >= 12){
				if($startnum != 1){
					$endnum = $startnum + 9;
					$middletext = "...";
					$prepagenow = "<a href='".$url.($startnum - 1) ."' class='disabledfy'>‹</a>";
					$nextpagenow = "<a href='".$url.($startnum + 10) ."' class='disabledfy'>›</a>";
				}else{
					$endnum = $startnum + 9;
					$middletext = "...";
					$prepagenow = "<span class='disabled disabledfy'>‹</span>";
					$nextpagenow = "<a href='".$url.($startnum + 10) ."' class='disabledfy'>›</a>";
				}
			}else{
				$prepagenow = "<a href='".$url.($startnum - 1) ."' class='disabledfy'>‹</a>";
				$nextpagenow = "<span class='disabled disabledfy'>›</span>";
				$endnum = $this->pages - 2;
				$middletext = "";
			}
		}else{
			$startnum = 1;
			$endnum = $this->pages - 2;	
			$middletext = "";
			$prepagenow = "<span class='disabled disabledfy'>‹</span>";
			$nextpagenow = "<span class='disabled disabledfy'>›</span>";
		}
			
		$text .= "<form method='POST' action='{$link}'>";	
		$text .= "<div class='digg4'>";		
		if ($this->_cur_page == 1){
			$text .= "<span class='disabled disabledfy'><b>«</b></span>".$prepagenow;
		}else{
			$text .= "<a class='disabledfy' href=".$firestpage."><b>«</b></a>".$prepagenow;
		}  
		for($i = $startnum;$i <= $endnum;$i++){
			if($search != "search"){
				$pageurl = $i == 1 ? $firestpage:$url.$i ;
			}else{
				$pageurl = $i == 0 ? $firestpage:$url.$i ;
			}
			if($i == $this->_cur_page){
				$text .= "<span class='current'>".$i."</span>";
			}else{
				$text .= " <a href=".$pageurl.">".$i."</a> ";
			}
		}   
		$text .= $middletext;
		if($this->pages > 1){
			if(($this->pages - 1) == $this->_cur_page){
				$text .= "<span class='current'>".($this->pages - 1)."</span>";
			}else{
				if($search!="search"){
					$pageurl = $this->pages-1 == 1 ? $firestpage:$url.($this->pages - 1) ;
				}else{
					$pageurl = $this->pages-1 == 0 ? $firestpage:$url.($this->pages-1) ;
				}
				$text .= " <a href=".$pageurl.">".($this->pages - 1)."</a> ";
			 }
		}
		if($this->pages == $this->_cur_page){
			$text .= "<span class='current'>".$this->pages."</span>";
		}else{
			if($this->pages == 0){
				$text .= " <span class='disabled'>".$this->pages."</a></span> ";
			}else{
				$text .= " <a href=".$url.$this->pages .">".$this->pages."</a> ";
			}
		}
		if ($this->_cur_page == $this->pages){
			$text .= $nextpagenow."<span class='disabled disabledfy'><b>»</b></span>";
		}else{
			if($this->pages == 0){
				$text .= $nextpagenow."<span class='disabled disabledfy'><b>»</b></span>";
			}else{
				$text .= $nextpagenow."<a class='disabledfy' href=".$url.$this->pages ."><b>»</b></a>";
			}
		}  	
		$text .= "转到<input name='page_input' size='5' class='page_input' />页 <input type='submit'  name='Submit3' value=' go ' class='submit' /></form></div>";
		return $text; 
	}

	/** 
	 * 获取前台分页html函数
	 * @return string 前台分页html  
	 */	
	public function weblink(){
		global $_M;
		$this->_pager();	
		if($this->seolink == '0'){	
			$langnums = '1';
		}else{
			$langnums = '0';
		}
		$url=$this->link.'&page=';
		$met_pageskin = $this->met_pageskin;
		$firestpage = $langnums == 1 ? '../'.$this->SELF.'/' : $url.'1' ;
		$prepage = $langnums == 1 ? '../'.$this->SELF.'/' : $url.($this->_cur_page-1) ;
		
		switch($met_pageskin){	
			case 1:
			
				$metpgs = $this->pages == 0 ? 1 : $this->pages;
				$text= "<div class='metpager_1'>{$_M['word']['PageTotal']}<span>{$metpgs}</span>{$_M['word']['Page']} {$_M['word']['PageLocation']}<span style='color:#990000'>{$this->_cur_page}</span>{$_M['word']['Page']} ";
				if ($this->_cur_page == 1 && $this->pages>1){
					//first page
					$text.= "{$_M['word']['PageHome']} {$_M['word']['PagePre']} <a href=".$url.($this->_cur_page+1) .">{$_M['word']['PageNext']}</a>  <a href=".$url.$this->pages .">{$_M['word']['PageEnd']}</a>";
				}elseif($this->_cur_page == $this->pages && $this->pages>1){
					//last page
					$pageurl=$this->_cur_page-1==1?$firestpage:$url.($this->_cur_page-1) ;
					$text.= "<a href=".$firestpage.">{$_M['word']['PageHome']}</a> <a href=".$pageurl.">{$_M['word']['PagePre']}</a> {$_M['word']['PageNext']} {$_M['word']['PageEnd']}";
				}elseif ($this->_cur_page > 1 && $this->_cur_page <= $this->pages){
					//middle
					if($this->_cur_page == 2){
						$text .= "<a href=".$firestpage.">{$_M['word']['PageHome']}</a> <a href=".$prepage.">{$_M['word']['PagePre']}</a> <a href=".$url.($this->_cur_page+1) .">{$_M['word']['PageNext']}</a>  <a href=".$url.$this->pages .">{$_M['word']['PageEnd']}</a>";
					}else{
						 $text .= "<a href=".$firestpage.">{$_M['word']['PageHome']}</a> <a href=".$url.($this->_cur_page-1) .">{$_M['word']['PagePre']}</a> <a href=".$url.($this->_cur_page + 1) .">{$_M['word']['PageNext']}</a>  <a href=".$url.$this->pages .">{$_M['word']['PageEnd']}</a>";
					}
				}
				$text .= " {$_M['word']['PageGo']} <select onchange='javascript:window.location.href=this.options[this.selectedIndex].value'>";
				for($i = 1;$i <= $metpgs;$i++){
					$pageurl = $i == 1 ? $firestpage : $url.$i ;
					if($i == $this->_cur_page){
						$text .= "<option selected='selected' value='".$pageurl."' >".$i."</option>";
					}else{
						$text .= "<option value='".$pageurl."' >".$i."</option>";
					}
				}
				$text .= "</select> {$_M['word']['Page']} </div>";
			break;
		  
			case 2:
		 
				if($this->_cur_page == 1 && $this->pages>1){
					$text = "<div class='metpager_2'>{$_M['word']['PageHome']} {$_M['word']['PagePre']} <a href=".$url.($this->_cur_page+1) .">{$_M['word']['PageNext']}</a>  <a href=".$url.$this->pages .">{$_M['word']['PageEnd']}</a>";
				}elseif($this->_cur_page == $this->pages && $this->pages>1){
					$pageurl = $this->_cur_page-1 == 1 ? $firestpage : $url.($this->_cur_page-1) ;
					$text .= "<a href=".$firestpage.">{$_M['word']['PageHome']}</a> <a href=".$pageurl.">{$_M['word']['PagePre']}</a> {$_M['word']['PageNext']} {$_M['word']['PageEnd']}";
				}elseif ($this->_cur_page > 1 && $this->_cur_page <= $this->pages){
					if($this->_cur_page == 2){
						$text .=  "<a href=".$firestpage.">{$_M['word']['PageHome']}</a> <a href=".$prepage.">{$_M['word']['PagePre']}</a> <a href=".$url.($this->_cur_page+1) .">{$_M['word']['PageNext']}</a>  <a href=".$url.$this->pages .">{$_M['word']['PageEnd']}</a>";
					}else{
						$text .= "<a href=".$firestpage.">{$_M['word']['PageHome']}</a> <a href=".$url.($this->_cur_page-1) .">{$_M['word']['PagePre']}</a> <a href=".$url.($this->_cur_page+1) .">{$_M['word']['PageNext']}</a>  <a href=".$url.$this->pages .">{$_M['word']['PageEnd']}</a>";
					}
				}
				$metpgs = $this->pages == 0 ? 1 : $this->pages;
				$text .="&nbsp;&nbsp;".$_M['word']['PageTotal']."<span>{$this->total}</span>{$_M['word']['Total']} {$_M['word']['PageLocation']}<span style='color:#990000'>{$this->_cur_page}</span>/".$metpgs.$_M['word']['Pagenum'];
				$text .="</div>";			
			break;
		  
			case 3:
			
				$text = "<div class='metpager_3'>";
				if ($this->_cur_page == 1){
					if($this->pages == 0){
						$text .= "<span style='font-family: Tahoma, Verdana;'><b>«</b></span> <span style='font-size:12px;font-family: Tahoma, Verdana;'>‹</span>";
					}else{
						$text .= "<a style='font-family: Tahoma, Verdana;' href=".$firestpage."><b>«</b></a> <a style='font-size:12px;font-family: Tahoma, Verdana;' href=".$firestpage.">‹</a>";
					}
				}else{
					if($this->_cur_page == 2){
						$text .= "<a style='font-family: Tahoma, Verdana;' href=".$firestpage."><b>«</b></a> <a style='font-family: Tahoma, Verdana;' href=".$prepage.">‹</a>";				
					}else{
						$text .= "<a style='font-family: Tahoma, Verdana;' href=".$firestpage."><b>«</b></a> <a style='font-family: Tahoma, Verdana;' href=".$url.($this->_cur_page-1) .">‹</a>";
					}
				}
				if($this->pages >10 ){
					if($this->_cur_page>5){
						if(($this->pages - $this->_cur_page) > 5){
							$startnum = $this->_cur_page - 4;
							$endnum = $this->_cur_page + 5;
						}else{
							$startnum = $this->pages - 9;
							$endnum = $this->pages;
						}
					}else{
						$startnum = 1;
						$endnum = 10;		
					}
				}else{
					$startnum = 1;
					$endnum = $this->pages;	
				}
				for($i = $startnum;$i <= $endnum;$i++){
					$pageurl  = $i == 1 ? $firestpage : $url.$i ;
					if($i == $this->_cur_page)$page_stylenow = "style='font-weight:bold;'";
					$text .= " <a {$page_stylenow} href=".$pageurl.">[".$i."]</a> ";
					$page_stylenow = '';
				}
				if ($this->_cur_page == $this->pages){
					$text .= "<a style='font-family: Tahoma, Verdana;' href=".$url.$this->pages .">›</a> <a style='font-family: Tahoma, Verdana;' href=".$url.$this->pages ."><b>»</b></a>";
				}else{
					if($this->pages == 0){
						$text .= "<span style='font-family: Tahoma, Verdana;'>›</span> <span style='font-family: Tahoma, Verdana;'><b>»</b></span>";
					}else{
						$text .= "<a style='font-family: Tahoma, Verdana;' href=".$url.($this->_cur_page+1) .">›</a> <a style='font-family: Tahoma, Verdana;'  href=".$url.$this->pages ."><b>»</b></a>";
					}
				}
				$text .= "</div>";				
			break;
		  
			case 4 or 5 or 6 or 7 or 8 or 9:
			
				if(!$metinfouiok){
					if($met_pageskin == 4){
						$text .= "<style>";
						$text .= ".digg4 { padding:3px; margin:3px; text-align:center; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px;}";
						$text .= ".digg4 a,.digg4 span.miy{ border:1px solid #aaaadd; padding:2px 5px 2px 5px; margin:2px; color:#000099; text-decoration:none;}";
						$text .= ".digg4 a:hover { border:1px solid #000099; color:#000000;}";
						$text .= ".digg4 a:active {border:1px solid #000099; color:#000000;}";
						$text .= ".digg4 span.current { border:1px solid #000099; background-color:#000099; padding:2px 5px 2px 5px; margin:2px; color:#FFFFFF; text-decoration:none;}";
						$text .= ".digg4 span.disabled { border:1px solid #eee; padding:2px 5px 2px 5px; margin:2px; color:#ddd;}";
						$text .= ".digg4 .disabledfy { font-family: Tahoma, Verdana;}"; 
						$text .= "</style>";
					}elseif($met_pageskin == 5){
						$text .= "<style>";
						$text .= ".digg4 { padding:3px; margin:3px; text-align:center; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px;}";
						$text .= ".digg4  a,.digg4 span.miy{ border:1px solid #ccdbe4; padding:2px 8px 2px 8px; background-position:50%; margin:2px; color:#0061de; text-decoration:none;}";
						$text .= ".digg4  a:hover { border:1px solid #2b55af; color:#fff; background-color:#3666d4;}";
						$text .= ".digg4  a:active {border:1px solid #000099; color:#000000;}";
						$text .= ".digg4  span.current { padding:2px 8px 2px 8px; margin:2px; color:#000; text-decoration:none;}";
						$text .= ".digg4  span.disabled { border:1px solid #ccdbe4; padding:2px 8px 2px 8px; margin:2px; color:#ddd;}";
						$text .= ".digg4 .disabledfy { font-family: Tahoma, Verdana;}"; 
						$text .= " </style>";
					}elseif($met_pageskin == 6){
						$text .= "<style>";
						$text .= ".digg4 { padding:3px; color:#ff6500; margin:3px; text-align:center; font-family: Tahoma, Arial, Helvetica, Sans-serif; font-size: 12px;}";
						$text .= ".digg4 a,.digg4 span.miy{ border:1px solid  #ff9600; padding:2px 7px 2px 7px; background-position:50% bottom; margin:2px; color:#ff6500; background-image:url(".$met_url."images/page6.jpg); text-decoration:none;}";
						$text .= ".digg4 a:hover { border:1px solid #ff9600; color:#ff6500; background-color:#ffc794;}";
						$text .= ".digg4 a:active {border:1px solid #ff9600; color:#ff6500; background-color:#ffc794;}";
						$text .= ".digg4 span.current {border:1px solid #ff6500; padding:2px 7px 2px 7px; margin:2px; color:#ff6500; background-color:#ffbe94; text-decoration:none;}";
						$text .= ".digg4 span.disabled { border:1px solid #ffe3c6; padding:2px 7px 2px 7px; margin:2px; color:#ffe3c6;}";
						$text .= ".digg4 .disabledfy { font-family: Tahoma, Verdana;}"; 
						$text .= " </style>";  
					}elseif($met_pageskin == 7){
					   $text .= "<style>";
					   $text .= ".digg4  { padding:3px; margin:3px; text-align:center; font-family: Tahoma, Arial, Helvetica, Sans-serif, sans-serif; font-size: 12px;}";
					   $text .= ".digg4  a,.digg4 span.miy{ border:1px solid  #2c2c2c; padding:2px 5px 2px 5px; background:url(".$met_url."images/page7.gif) #2c2c2c; margin:2px; color:#fff; text-decoration:none;}";
					   $text .= ".digg4  a:hover { border:1px solid #aad83e; color:#fff;background:url(".$met_url."images/page7_2.gif) #aad83e;}";
					   $text .= ".digg4  a:active { border:1px solid #aad83e; color:#fff;background:urlurl(".$met_url."images/page7_2.gif) #aad83e;}";
					   $text .= ".digg4  span.current {border:1px solid #aad83e; padding:2px 5px 2px 5px; margin:2px; color:#fff;background:url(".$met_url."images/page7_2.gif) #aad83e; text-decoration:none;}";
					   $text .= ".digg4  span.disabled { border:1px solid #f3f3f3; padding:2px 5px 2px 5px; margin:2px; color:#ccc;}";
					   $text .= ".digg4 .disabledfy { font-family: Tahoma, Verdana;}"; 
					   $text .= " </style>";  
					}elseif($met_pageskin == 8){
					   $text .= "<style>";
					   $text .= ".digg4  { padding:3px; margin:3px; text-align:center; font-family:Tahoma, Arial, Helvetica, Sans-serif;  font-size: 12px;}";
					   $text .= ".digg4  a,.digg4 span.miy{ border:1px solid #ddd; padding:2px 5px 2px 5px; margin:2px; color:#aaa; text-decoration:none;}";
					   $text .= ".digg4  a:hover { border:1px solid #a0a0a0; }";
					   $text .= ".digg4  a:hover { border:1px solid #a0a0a0; }";
					   $text .= ".digg4  span.current {border:1px solid #e0e0e0; padding:2px 5px 2px 5px; margin:2px; color:#aaa; background-color:#f0f0f0; text-decoration:none;}";
					   $text .= ".digg4  span.disabled { border:1px solid #f3f3f3; padding:2px 5px 2px 5px; margin:2px; color:#ccc;}";
					   $text .= ".digg4 .disabledfy { font-family: Tahoma, Verdana;}"; 
					   $text .= " </style>";  
					}elseif($met_pageskin == 9){
					   $text .= "<style>";
					   $text .= ".digg4 { padding:3px; margin:3px; text-align:center; font-family:Tahoma, Arial, Helvetica, Sans-serif;  font-size: 12px;}"; 
					   $text .= ".digg4  a,.digg4 span.miy{ border:1px solid #ddd; padding:2px 5px 2px 5px; margin:2px; color:#88af3f; text-decoration:none;}"; 
					   $text .= ".digg4  a:hover { border:1px solid #85bd1e; color:#638425; background-color:#f1ffd6; }"; 
					   $text .= ".digg4  a:hover { border:1px solid #85bd1e; color:#638425; background-color:#f1ffd6; }"; 
					   $text .= ".digg4  span.current {border:1px solid #b2e05d; padding:2px 5px 2px 5px; margin:2px; color:#fff; background-color:#b2e05d; text-decoration:none;}"; 
					   $text .= ".digg4  span.disabled { border:1px solid #f3f3f3; padding:2px 5px 2px 5px; margin:2px; color:#ccc;}"; 
					   $text .= ".digg4 .disabledfy { font-family: Tahoma, Verdana;}"; 
					   $text .= " </style>";  
					}
				}
						
				if($this->pages >12 ){
					$startnum = floor(($this->_cur_page/10)) * 10 + 1;
					if(floor(($this->_cur_page / 10)) == ($this->_cur_page / 10))$startnum = floor(($this->_cur_page/10))*10+1-10;
					if(($this->pages-$startnum) >= 12){
						if($startnum != 1){
							$endnum = $startnum + 9;
							$middletext = "...";
							$prepagenow = "<a href='".$url.($startnum - 1) ."' class='disabledfy'>‹</a>";
							$nextpagenow = "<a href='".$url.($startnum + 10) ."' class='disabledfy'>›</a>";
						}else{
							$endnum = $startnum + 9;
							$middletext = "...";
							$prepagenow = "<span class='disabled disabledfy'>‹</span>";
							$nextpagenow = "<a href='".$url.($startnum + 10) ."' class='disabledfy'>›</a>";
						}
					}else{
						$prepagenow = "<a href='".$url.($startnum - 1) ."' class='disabledfy'>‹</a>";
						$nextpagenow = "<span class='disabled disabledfy'>›</span>";
						$endnum = $this->pages - 2;
						$middletext = "";
					}
				}else{
					$startnum = 1;
					$endnum = $this->pages - 2;	
					$middletext = "";
					$prepagenow = "<span class='disabled disabledfy'>‹</span>";
					$nextpagenow = "<span class='disabled disabledfy'>›</span>";
				}	
				$text .= "<div class='digg4 metpager_{$met_pageskin}'>";
						
				if ($this->_cur_page == 1){
					$text .= "<span class='disabled disabledfy'><b>«</b></span>".$prepagenow;
				}else{
					$text .= "<a class='disabledfy' href=".$firestpage."><b>«</b></a>".$prepagenow;
				}  
				for($i = $startnum;$i <= $endnum;$i++){
					if($search != "search"){
						$pageurl = $i == 1 ? $firestpage:$url.$i ;
					}else{
						$pageurl = $i == 0 ? $firestpage:$url.$i ;
					}
					if($i == $this->_cur_page){
						$text .= "<span class='current'>".$i."</span>";
					}else{
						$text .= " <a href=".$pageurl.">".$i."</a> ";
					}
				}   
				$text .= $middletext;
				if($this->pages > 1){
					if(($this->pages - 1) == $this->_cur_page){
						$text .= "<span class='current'>".($this->pages - 1)."</span>";
					}else{
						if($search!="search"){
							$pageurl = $this->pages-1 == 1 ? $firestpage:$url.($this->pages - 1) ;
						}else{
							$pageurl = $this->pages-1 == 0 ? $firestpage:$url.($this->pages-1) ;
						}
						$text .= " <a href=".$pageurl.">".($this->pages - 1)."</a> ";
					 }
				}
				if($this->pages == $this->_cur_page){
					$text .= "<span class='current'>".$this->pages."</span>";
				}else{
					if($this->pages == 0){
						$text .= " <span class='disabled'>".$this->pages."</a></span> ";
					}else{
						$text .= " <a href=".$url.$this->pages .">".$this->pages."</a> ";
					}
				}
				if ($this->_cur_page == $this->pages){
					$text .= $nextpagenow."<span class='disabled disabledfy'><b>»</b></span>";
				}else{
					if($this->pages == 0){
						$text .= $nextpagenow."<span class='disabled disabledfy'><b>»</b></span>";
					}else{
						$text .= $nextpagenow."<a class='disabledfy' href=".$url.$this->pages ."><b>»</b></a>";
					}
				}  	
					break;  
				}
				
		return $text; 
	}
 }


# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>