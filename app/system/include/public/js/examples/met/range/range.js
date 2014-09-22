define(function(require, exports, module) {

	var $ = require('jquery');
	var common = require('common');
		require('examples/met/range/jquery.nouislider.css');
		require('examples/met/range/jquery.nouislider.min');

	exports.range = function(d){
		d.each(function(){
			var m = $(this),
				n=m.attr('name'),
				f=Number(m.val()),
				p=m.attr("data-rangestep")?Number(m.attr("data-rangestep")):1,
				min=Number(m.attr("data-rangemin")),
				max=Number(m.attr("data-rangemax")),
				ds=m.attr("data-rangdecimals")?Number(m.attr("data-rangdecimals")):0;
			m.before("<div id='range-slider-"+n+"' class='range-slider'></div>");
			$("#range-slider-"+n).noUiSlider({
				start: f,//Ĭ��ֵ
				step: p,//�϶�����
				range: {
					'min': min, //��Сֵ
					'max': max //���ֵ
				},
				serialization: {
					lower: [
					  $.Link({
						target: m //��ֵ��䵽ָ��Ԫ��
					  })
					],
					format: {
						decimals: ds,//����С����λ��
						mark: '.'//С����ֱ�ӵļ��
					}
				}
			});
		});
	}
	
});