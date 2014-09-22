define(function(require, exports, module) {

	var $ = require('jquery');
		require('examples/met/include/jquery-migrate-1.2.1.min');//增加对$.browser.msie的支持
		
	function ifreme_methei(mh){
		mh=mh?mh:0;
		$('#metleft', parent.document).attr('style','');
		$('#metleft .floatl_box', parent.document).attr('style','');
		var m = $("body").height();
		var k = parseInt($("#metcmsbox", parent.document).attr('jiluht'));
		var l = $('#metleft', parent.document).height()+35;
		l = m < l ? l : m;
		if (m < k && l < k) l = k;
		l=l+10;
		l=l<mh?mh:l;
		$('#metleft', parent.document).height(l);
		$('#metleft .floatl_box', parent.document).height(l);
		$('#metright', parent.document).height(l);
		$(window.parent.document).find("#main").height(l);
	}
	
	/*等高*/
	exports.ifreme_methei = function(mh){
		ifreme_methei(Number(mh));
	}
	
	/*语言文字*/
	exports.langtxt = function(w){
		var bol='';
		var url = basepath + 'index.php?c=getword&m=include&a=dogetword&site=1&word='+w+'&lang='+lang;
		$.ajax({
			type: "GET",
			async:false,
			url: url,
			success: function(msg){
				var obj = eval('('+msg+')');
				if(obj.error==0){
					bol = obj.word;
				}else{
					//uperror(obj.errorcode,t);
				}
			}
		});
		return bol;
	}

	/*页面效果调整*/
	exports.defaultjs = function(){
		/*顶部边框*/
		var hr0 = $(".v52fmbx_hr").eq(0);
		hr0.css('border-top','1px solid #ddd');	
		
		/*输入状态*/
		$("input[type='text'],input[type='password'],textarea").focus(function(){
			$(this).addClass('met-focus');
		});
		$("input[type='text'],input[type='password'],textarea").focusout(function(){
			$(this).removeClass('met-focus');
		});
		
		/*初始化高度，页面加载完成后执行*/
		$(document).ready(function(){ 
			ifreme_methei();
		});
		
		var dlp = '';
		/*浏览器兼容*/
		if($.browser.msie || ($.browser.mozilla && $.browser.version == '11.0')){  
			var v = Number($.browser.version);
			if(v<10){
				function dlie(dl){
					dl.each(function(){
						var dt = $(this).find("dt"),dd = $(this).find("dd");
						if(dt.length>0){
							dt.css({"float":"left","overflow":"hidden"});
							dd.css({"float":"left","overflow":"hidden"});
							var wd = $(this).width() - dt.outerWidth() - 17;
							dd.width(wd);
						}
					});
					ifreme_methei();
				}
				var dl = $(".v52fmbx dl");
				dlie(dl);
				dlp = 1;
			}
			if(v<12){
				/*提示文字兼容*/
				function searchzdx(dom,label,color1){
					if(dom.val()=='')label.show();
					dom.keyup(function(){
						if($(this).val()==''){
							label.show();
						}else{
							label.hide();
						}
					});
					label.click(function(){
						$(this).next().focus();
					});
				}
				var pd = $("input[placeholder],textarea[placeholder]");
				pd.each(function(){
					var t = $(this).attr("placeholder");
					$(this).removeAttr("placeholder");
					$(this).before("<label>"+t+"</label>");
					$(this).parent("div.fbox").addClass("placeholder-ie");
					searchzdx($(this),$(this).prev("label"),"#999");
				});
			}
		}
		
		/*宽度变化后调整*/
		$("body").attr("data-body-wd",$("body").width());
		$(window).resize(function() {
			if($("body").attr("data-body-wd")!=$("body").width()){
				if(dlp==1){
					dlie(dl);
				}else{
					ifreme_methei();
				}
				$("body").attr("data-body-wd",$("body").width());
			}
		});
		
	}
});
