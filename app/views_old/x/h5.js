seajs.config({
  alias: {
    'zepto': 'zepto.js'
  },
  debug: 1
});
define(function(require,exports,module) {
		setTimeout(function(){ window.scrollTo(0, 1); }, 100);//hide the address bar
		var $ = require("zepto");
		require("./slider");
})