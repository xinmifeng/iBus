define(function(require,exports,module) {
	var $ = require('zepto');
	var rotate = function(obj) {
		obj.find("img").animate({
			"-webkit-transform":"rotateY(360deg)"
		},1000,"ease-out")
	}
	$("#entry-list a").bind("click",function() {
		var url = $(this).attr("href");
		rotate($(this));
		setTimeout(function() {
			window.location.href = url;	
		},1000);
		return false;
	})
})