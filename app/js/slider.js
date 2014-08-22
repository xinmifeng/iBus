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
});
