/*
	从Modernizr.js中移植出来
*/
define(function(require,exports,module){
	var $ = require('zepto'), 
	css3 = require('./css3'),
	vendor = (/webkit/i).test(navigator.appVersion) ? 'webkit' :
	(/firefox/i).test(navigator.userAgent) ? 'Moz' :
	(/trident/i).test(navigator.userAgent) ? 'ms' :
	'opera' in window ? 'O' : '',
	transform = vendor + 'Transform',
	has3d = css3.has3d(),
	hasTransform = css3.hasTransform(),
	Rotate = function(){
		return {
			init : function(obj){
				if(!obj){return;}
				var style1 = {},
				style2 = {},
				li = $(obj);
				if(li.length == 0){return;}
				var p = li.find('div'),
				p1 = $(p[0]),
				p2 = $(p[1]),
				height = p1.height(),
				prefixa = '-'+vendor+'-transform',
				temps = {},
				func,
				i = 1;
				if(has3d){	
					style1[prefixa] = 'rotate3d(0,1,0,0deg)';
					style2[prefixa] = 'rotate3d(0,1,0,180deg)';
					temps['-'+vendor+'-backface-visibility'] = 'hidden';
					temps['-'+vendor+'-transition'] = '-'+vendor+'-transform 0.5s ease';
					temps['-'+prefixa+'-style'] = 'preserve-3d';
					p1.css(style1);
					p2.css(style2);
					p.css(temps);
					func = function(){
						if(i%2 == 0){
							p1.css(style1);
							p2.css(style2);
							li.removeClass('rotatev');
						}
						else{
							p1.css(style2);
							p2.css(style1);
							li.addClass('rotatev');
						}
						i++;
					}
				}
				else if(hasTransform){
					var a = li.find('.no3d');
					p2.css('top',height);
					style1[prefixa] = 'translate(0,0)';
					style2[prefixa] = 'translate(0,-'+height+'px)';
					console.log(height,style2);
					temps['-'+vendor+'-backface-visibility'] = 'hidden';
					temps['-'+vendor+'-transition'] = '-'+vendor+'-transform 0.5s ease';
					a.css(temps);
					a.css(style1);
					func = function(){
						if(i%2 == 0){
							a.css(style1);
							li.removeClass('rotatev');
						}
						else{
							a.css(style2);
							li.addClass('rotatev');
						}
						i++;
					}
				}
				window.setInterval(func,5000);
			}
		};
	};
	return Rotate;
});