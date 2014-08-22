define(function(require,exports,module) {
	var $ = require('zepto'),
		suggest = require("./suggest");
	var searcher = {
		tab: $("#main-search .tab li"),
		cleaner:$("#main-search .clear"),
		input:$("#main-search .text"),
		fakeInput:$("#fake-search button"),
		closer:$("#main-search .close"),
		resultWrap:$("#main-search .result"),
		changeType:function(type) {
			$("#J_ST").attr("name",type)
		},
		clearInput:function() {
			searcher.input.val("").focus();
			searcher.resultWrap.hide();
		},
		fake:function() {
			$("#content .region").show();
			$("footer").show();
			$("#main-search").hide().find(".text").blur();
		},
		display:function() {
			$("#content .region").hide();
			$("footer").hide();
			$("#main-search").show().find(".text").focus().val(" ");
		},
		suggest:{
			ajax:function(kwd) {
				$.ajax({
					url:'http://suggest.taobao.com/sug?area=b2c&code=utf-8&q=' + kwd,
					type:"GET",
					dataType:"jsonp",
					success:function(json){
						suggest.handle(json);
					}
				});
			}
		}
	}

	searcher.tab.bind("click",function() {
		var name = $(this).attr("data-st");
		searcher.changeType(name);
		$(this).addClass("on").siblings().removeClass("on")
	})


//	searcher.input.get(0).oninput = function() {
//		var kwd = this.value;
//		searcher.suggest.ajax(kwd);
//	}

//	searcher.cleaner.bind("click",function(){
//		searcher.clearInput();
//	})

//	searcher.closer.bind("click",function() {
//		searcher.fake();
//	})

//	searcher.fakeInput.bind("click",function() {
//		searcher.display();
//	})

})