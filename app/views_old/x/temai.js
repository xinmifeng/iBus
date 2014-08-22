define(function(require,exports,module) {
	var $ = require("zepto"),
	    room = $("#showroom a");
	 	
	// var rotate = {
	// 	init:function(obj) {
	// 		obj.find(".front").css({
	// 			"-webkit-transform":"rotateY(0deg)"
	// 		})
	// 		obj.find(".back").css({
	// 			"-webkit-transform":"rotateY(180deg)"
	// 		})
	// 	},
	// 	turn:function(obj) {
	// 		obj.find(".front").animate({
	// 			"-webkit-transform":"rotateY(180deg)"
	// 		},500,"ease-in",function() {
	// 			$(this).removeClass("front").addClass("back")
	// 		})
	// 		obj.find(".back").animate({
	// 			"-webkit-transform":"rotateY(0deg)"
	// 		},500,"ease-in",function() {
	// 			$(this).removeClass("back").addClass("front")
	// 		})
	// 	}
	// }
	


	// rotate.init(room.first());
	// setInterval(function(){rotate.turn(room.first())},5000)

 //  function turnCard() {
	// var isFront = true;
	// 	turn = setInterval(function() {
	// 		var obj = $("#showroom a").first();
	// 		rotate(obj);
	// 		if(!isFront) {clearInterval(turn)};
	// 		return isFront = !isFront
		
	//   	},5000)	
 //  }

 //  turnCard();
 	var rotate = require("rotate.js");
 	
	setTimeout(function(){
			new rotate().init($("#showroom .left"))
	},5000);
})