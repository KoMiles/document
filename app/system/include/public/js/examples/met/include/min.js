define(function(require, exports, module) {

	var $ = require('jquery');
	var common = require('common');
		require('examples/met/font-awesome/css/font-awesome.min.css');//图标字体
		
	common.defaultjs();//页面初始效果处理
	
	/*操作成功/失败提示信息*/
	var i = $('.returnover');
		if(i.length>0){	
			var ptips = require('examples/met/include/ptips');
				ptips.execution(i);
		}
		
	/*表单验证*/
	var f = $('form.ui-from');
	if(f.length>0){	
		var ff = require('examples/met/form/form');
			ff.form(f);
	}
	
	/*上传组件*/
	var c = $('.ftype_upload .fbox input');
	if(c.length>0){	
		var cf = require('examples/met/uploadify/upload');
			cf.upload(c);
	}
	
	/*编辑器*/
	var a = $('.ftype_ckeditor .fbox textarea');
	if(a.length>0){
		var af = require('examples/met/ckeditor/ckeditor');
			af.ckeditor(a);
	}
	
	/*颜色选择器*/
	var b = $('.ftype_color');
	if(b.length>0){
		var bf = require('examples/met/colorpicker/colorpicker');
			bf.colorpicker(b);
	}
	
	/*标签增加器*/
	var d = $('.ftype_tags');
	if(d.length>0){	
		var df = require('examples/met/tags/tags');
			df.tags(d);
	}
	
	/*滑块*/
	var e = $('.ftype_range .fbox input');
	if(e.length>0){	
		var ef = require('examples/met/range/range');
			ef.range(e);
	}
	
	/*日期选择器*/
	var g = $('.ftype_day input');
	if(g.length>0){	
		var gf = require('examples/met/time/time');
			gf.time(g);
	}
	
	/*城市联动菜单*/
	var h = $('.ftype_select-linkage .fbox');
	if(h.length>0){	
		var hf = require('examples/met/select-linkage/select');
			if(hf)hf.select(h);
	}
	
});
