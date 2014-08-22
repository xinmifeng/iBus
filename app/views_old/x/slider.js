define(function(require){
	var $ = require('zepto'),
	 slider = require('slidernew.js');

	$('.content').slider({
		wrap:".slider-outer",
		wrapUl:".slider-wrap",
		wrapStatus:'.slider-status',
		isLoop:true,
		isPlay:true
	});
/*  需求方暂不支持多屏，因此注释掉 by 舒文.
	$('#hot-channel .showroom').slider({
		wrap:".bd",
		wrapUl:".wrap",
		wrapStatus:'.slider-status',
		isLoop:true,
		isPlay:true,
		prev:'.prev',
		next:'.next'
	});
*/
});

$(document).on("click", "li.xxx", function (e) {
    var $target = $(e.target);
    alert($target.index());
});

function bindLi($li) {
    $li.bind("click", function () {
        alert($(this).attr("id"));
    });
}