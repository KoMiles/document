define(function(require, exports, module) {

	var $ = require('jquery');
	var common = require('common');
	
	/*�����ɹ�/ʧ����ʾ��Ϣ*/
	(function($){
		jQuery.fn.PositionFixed = function(options){
			var defaults = {
				css:'',
				x:0,
				y:0
			};
			var o = jQuery.extend(defaults, options);
			var isIe6=false;
			if($.browser.msie && parseInt($.browser.version)==6)isIe6=true;			
			var html= $('html');
			if (isIe6 && html.css('backgroundAttachment') !== 'fixed') {
				html.css('backgroundAttachment','fixed') 
			};
			return this.each(function() {
			var domThis=$(this)[0];
			var objThis=$(this);
				if(isIe6){
					var left = parseInt(o.x) - html.scrollLeft(),
						top = parseInt(o.y) - html.scrollTop();
					objThis.css('position' , 'absolute');
					domThis.style.setExpression('left', 'eval((document.documentElement).scrollLeft + ' + o.x + ') + "px"');
					domThis.style.setExpression('top', 'eval((document.documentElement).scrollTop + ' + o.y + ') + "px"');	
				}else{
					objThis.css('position' , 'fixed').css('top',o.y).css('left',o.x);
				}
			});
		};
	})(jQuery)
	
	exports.execution = function(d){
	
		$("html",parent.document).find('.returnover').remove();
		$(document).ready(function() {
			$('body', parent.document).append('<div class="returnover">'+d.html()+'</div>');
			$('.returnover').show();
			var tur_ml = $('.returnover').outerWidth();
			var tur_mt = $('.returnover').outerHeight();
			$('.returnover').hide();
			tur_ml = parseInt(($('html',parent.document)[0].clientWidth-tur_ml)/2);
			tur_mt = parseInt(($('html',parent.document)[0].clientHeight-tur_mt)/2);
			$("html",parent.document).find('.returnover').css({
				top:tur_mt+'px',
				left:tur_ml+'px'
			});
			$("html",parent.document).find('.returnover').PositionFixed({x:tur_ml,y:tur_mt}); 
			setTimeout(function(){ $("html",parent.document).find('.returnover').hide(); }, 5000 );
		});
		
	}
	
});