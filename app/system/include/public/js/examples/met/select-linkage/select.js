define(function(require, exports, module) {

	var $ = require('jquery');
	var common = require('common');
		require('examples/met/select-linkage/jquery.cityselect');
	
	exports.select = function(d){
		d.each(function(){
			var p = $(this).find(".prov").attr("data-checked"),
				c = $(this).find(".city").attr("data-checked"),
				s = $(this).find(".dist").attr("data-checked");
				p = p?p:'';
				c = c?c:undefined;
				s = s?s:undefined;
			$(this).citySelect({prov:p, city:c, dist:s, nodata:"none"});
			
		});
	}
	
});