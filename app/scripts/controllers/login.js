define(function(require,exports,module){
	var ex = {};
	ex.islog=function(name,pwd){
		return name==="zjliu" && pwd === "123";
	}
	ex.dolog=function(name,pwd){
		return true;
	}
	exports.result = ex;
});
