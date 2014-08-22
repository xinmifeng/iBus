define(function(require,exports,module) {
	var $ = require('zepto');
	var suggest = {
		retWrap:$("#main-search .result"),
		result:function(data) {
			var retWrap = suggest.retWrap.empty().html("<ul>").find("ul");
			if(data.length > 0 ) {
				for(i in data) {
					var item = $("<li>").text(data[i]);
					retWrap.append(item);
				}
				retWrap.parent().show();
				suggest.take();
			}
		},
		handle:function(data) {
			var list = [],
				ret = data.result;
			for(x in ret) {
				if(x < 6)
				list.push(ret[x][0]);
			}
			suggest.result(list);
		},
		take:function() {
			suggest.retWrap.find("li").bind("click",function() {
				var word = $(this).text();
				$("#main-search .text").val(word);
				$("#main-search form").submit();
			})
		}
	}
	module.exports = {
		handle:suggest.handle
	}
});