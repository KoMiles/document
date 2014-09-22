define(function(require, exports, module) {

	var $ = require('jquery');
	var common = require('common');

	/*语言文字*/
	var err = new Array();
		err[1] = common.langtxt('formerror1');
		err[2] = common.langtxt('formerror2');
		err[3] = common.langtxt('formerror3');
		err[4] = common.langtxt('formerror4');
		err[5] = common.langtxt('formerror5');
		err[6] = common.langtxt('formerror6');
		err[7] = common.langtxt('formerror7');
		err[8] = common.langtxt('formerror8');
		
	function ftn(m){ //验证
		var f='';
			m.each(function(i){
				var d=$(this),e='|*|',v = d.attr('data-size'),l=d.val(),j=0,t=d.attr('type');//最小字数
				
				/*字数限制*/
				if(v){
					v = v.split('-');
					if(v[1]=='min'){
						if(l.length<v[0])j=1;e+=err[6]+'|$|';
					}else if(v[1]=='max'){
						if(l.length>v[0])j=1;e+=err[7]+'|$|';
					}else{
						if(l.length<v[0]||l.length>v[1])j=1;e+=err[8]+'|$|';
					}
				}
				
				/*不为空*/
				if(d.attr('data-required')){
					if(t=='input'||t=='text'||t=='password'||d[0].tagName=='TEXTAREA'){
						if(l=='')j=1;e+=err[1]+'|$|';
					}
					if(d[0].tagName=='SELECT'){
						if(l=='')j=1;e+=err[2]+'|$|';
					}
					if(t=='radio'){
						if($("input[name='"+d.attr('name')+"']:checked").length<1)j=1;e+=err[2]+'|$|';
					}
				}
				if(t=='checkbox'){
					if(d.parents('div.fbox').find("input").eq(0).attr('data-required')){
						if(d.parents('div.fbox').find("input:checked").length<1)j=1;e+=err[2]+'|$|';
					}
				}
				
				/*手机号码*/
				if(d.attr('data-mobile')){
					if(l=='')j=1;
					var regexp=/^1[0-9]{10}$/;
					if(!regexp.test(l))j=1;e+=err[3]+'|$|';
				}
				
				/*邮箱地址*/
				if(d.attr('data-email')){
					if(l=='')j=1;
					var regexp=/^[-a-zA-Z0-9_\.]+@([0-9A-Za-z][0-9A-Za-z-]+\.)+[A-Za-z]{2,5}$/;
					if(!regexp.test(l))j=1;e+=err[4]+'|$|';
				}
				
				/*密码*/
				if(d.attr("data-password")){
					var p = $("input[name='"+d.attr("data-password")+"']");
					if(l==''||l!=p.val())j=1;e+=err[5]+'|$|';
				}
				
				/*异步验证*/
				if(d.attr('data-ajaxcheck-url')){
					if(l!=''){
						$.ajax({
							type: "GET",
							url: d.attr('data-ajaxcheck-url')+'&'+d.attr('name')+'='+l,
							success: function(msg){
								var m = msg.split('|');
								var fa = Number(m[0])==0?'':'fa fa-check';
								zchuli(d,m[1],0,fa);
							}
						});
					}
				}
				
				if(j==1)f += d.attr('name')+e+'|#|';
			});
		return f;
	}
	
	/*报错处理*/
	function errtxt(d,fv){ //错误文字提取
		var t;
		var f = fv.split("|$|");
		t = f[0];
		return t;
	}
	function zchuli(d,txt,g,fa){//报错执行
		var o = d.parents('div.fbox'),fs=fa?fa:'fa fa-times';
		if(o.find(".formerror").length>0){
			o.find(".formerror").remove();
		}else{
			
		}
		o.append("<div class='formerror'><i class='"+fs+"'></i>"+txt+"</div>");
		common.ifreme_methei();//改变页面内容后重置高度
		if(d[0].tagName=='INPUT'||d[0].tagName=='TEXTAREA'){
			d.addClass("formerrorbox");
			if(fs!='fa fa-times')d.removeClass('formerrorbox');
		}
		if(g==1)d.focus();
	}
	function chuli(f,t){ //报错信息分解
		f = f.split("|#|");
		var n = '',d,txt;
		for(var i=0;i<f.length;i++){
			if(f[i]!=''){
				var fv = f[i].split("|*|");
				d = $("*[name='"+fv[0]+"']").eq(0);
				txt = d.attr("data-errortxt")?d.attr("data-errortxt"):errtxt(d,fv[1]);
				if(txt.indexOf('&metinfo&')!=-1&&d.attr("data-size")){
					var x,v = d.attr("data-size").split('-');
					if(v[1]=='min'||v[1]=='max'){
						x = v[0];
					}else{
						x = d.attr("data-size");
					}
					txt = txt.replace("&metinfo&",x);
				}
				var g = 0;
				if(i==0&&!t)g = 1;
				zchuli(d,txt,g);
			}
		}
	}
	function hfbc(d){ 
		/*清除提示信息*/
		d.removeClass('formerrorbox');
		d.parents('div.fbox').find(".formerror").remove();
		common.ifreme_methei();
		/*多选赋值*/
		d.each(function(){
			var d=$(this),l=d.val(),t=d.attr('type');
			if(t=='checkbox'){
				if($("input[name='"+d.attr('name')+"']").length>1){
					var v='',c = d.parents('div.fbox').find("input[name='"+d.attr('name')+"']:checked");
					var z = $("input[data-checkbox='"+d.attr('name')+"']");
					if(c.length==0){
						z.remove();
					}else{
						c.each(function(i){
							v+=(i+1)==c.length?$(this).val():$(this).val()+'|';
						});
						if(z.length>0){
							z.val(v);
						}else{
							d.parents('div.fbox').prepend("<input name='"+d.attr('name')+"' data-checkbox='"+d.attr('name')+"' type='hidden' value='"+v+"' />");
						}
					}
				}
			}
		});
	}
	function fsut(d,t){ //表单提交处理
		var f=ftn(d),r;
		if(f){
			chuli(f,t);//验证失败处理
			r = false;
		}else{
			hfbc(d);//验证成功处理
			r = true;
		}
		if(!t)return r;
	}

	/*默认选择项*/
	function defaultoption(){
		/*默认选中*/
		function ckchuli(n,v){
			$("input[name='"+n+"'][value='"+v+"']").attr('checked',true);
		}
		var cklist = $("input[data-checked],select[data-checked]");
		if(cklist.length>0){
			cklist.each(function(){
				var v = $(this).attr('data-checked'),n=$(this).attr('name'),t=$(this).attr('type');
				if(v!=''){
					if($(this)[0].tagName=='SELECT'){
						$(this).val(v);
					}
					if(t=='radio')ckchuli(n,v);
					if(t=='checkbox'){
						if(v.indexOf("|")==-1){
							ckchuli(n,v);
						}else{
							v = v.split("|");
							for (var i = 0; i < v.length; i++) {
								if(v[i]!=''){
									ckchuli(n,v[i]);
								}
							}
						}
					}
				}
			});
		}	
	}
	
	exports.form = function(d){
	
		defaultoption();//默认选择项
	
		/*表单验证*/
		d.each(function(){
			var t = $(this);
			//点击保存时验证
			t.submit(function(){ return fsut(t.find("input,textarea,select")); });
			//失去焦点时验证
			t.find("input,textarea").focusout(function(){ 
				if($(this).parents('dd.ftype_day').length==0){
					var d=$(this); fsut(d,1); 
				}
			});
			//单选多选获得焦点时验证
			t.find("input[type='radio'],input[type='checkbox']").focusout(function(){
				var d=$("input[name='"+$(this).attr('name')+"']").eq(0); fsut(d,1);
			});
			//特殊情况处理
			t.find("input[type='radio'],input[type='checkbox']").change(function(){
				var d=$("input[name='"+$(this).attr('name')+"']").eq(0); fsut(d,1);
			});
			t.find("select").change(function(){
				var d=$(this); fsut(d,1);
			});
		});
		
		/*提交按钮效果*/
		$(document).ready(function(){ 
			$(".submit").focus(function(){
				this.blur();
			}).mousedown(function(){
				$(this).addClass("active");
			}).mouseup(function(){
				$(this).removeClass("active");
			}).mouseleave(function(){
				$(this).removeClass("active");
			});
		}); 

		/*快捷提交*/
		Array.prototype.unique = function() {
			var o = {};
			for (var i = 0, j = 0; i < this.length; ++i) {
				if (o[this[i]] === undefined) {
					o[this[i]] = j++;
				}
			}
			this.length = 0;
			for (var key in o) {
				this[o[key]] = key;
			}
			return this;
		};
		var keys = [];
		$(document).keydown(function(event) {
			keys.push(event.keyCode);
			keys.unique();
		}).keyup(function(event) {
			if (keys.length > 2) keys = [];
			keys.push(event.keyCode);
			keys.unique();
			if (keys.join('') == '1713') {
				var input = $("input[type='submit']");
				if (input.length == 1) {
					if (!input.attr('disabled')) {
						input.click();
					}
				}
			}
			keys = [];
		});
		
	}
	
});
