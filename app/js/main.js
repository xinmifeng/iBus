var appModule = angular.module('app',['ngRoute']);
function appRouteConfig($routeProvider){
	$routeProvider.when("/",{
		controller:indexControll,
		templateUrl:'views/index.html'
	}).
	when("/video/:id",{
		controller:videoControll,
		templateUrl:'views/video.html'
	}).
	when("/videoDetail/:id",{
		controller:videoDetailControll,
		templateUrl:'views/videoDetail.html'
	}).
	when("/activity",{
		controller:activityControll,
		templateUrl:'views/activity.html'
	}).
	when("/apks",{
		controller:apkControll,
		templateUrl:'views/apks.html'
	}).
	when("/appDetail/:id",{
		controller:appDetailControll,
		templateUrl:'views/appDetail.html'
	}).
	when("/history/:type",{
		controller:historyControll,
		templateUrl:'views/history.html'
	}).
	when("/my",{
		controller:myControll,
		templateUrl:'views/my.html'
	}).
	otherwise({
		redirectTo:"/"
	});
}

appModule.config(appRouteConfig);

var BG={hasbg:false};
function setBg($scope,hasbg){
	BG.hasbg=hasbg?"bg":"";
	$scope.BG=BG;
}

function setCurrentIndex(index){
	var aEls=document.querySelectorAll(".navbar a")	
	for(var i=0,l=aEls.length;i<l;i++){
		var item=aEls[i];
		if(i===index){
			item.classList.add("current");
		}
		else{
			item.classList.remove("current");
		}
	}
}

appModule.controller('MainControll',function ($scope){
	$scope.setCurrent=function(element){
		if(element.tagName==="SPAN")
			element=element.parentNode;
		var aEls=element.parentNode.parentNode.children;
		for(var i=0,l=aEls.length;i<l;i++){
			var item=aEls[i];
			if(element===item.firstElementChild){
				element.classList.add("current");
			}
			else{
				item.firstElementChild.classList.remove("current");
			}
		}
	}
	setBg($scope,true);
});

var server_url="../server/";

var isroll=false;
function swiper(){
	var mySwiper = new Swiper('.swiper-container',{
		pagination: '.pagination',
		loop:true,
		grabCursor: true,
		paginationClickable: true,
		autoplay:3000,
		autoplayDisableOnInteraction: false,
		autoplayStopOnLast:false
	});
}

function swiperLike(count){
	var mySwiperlike = new Swiper('.swiper-container',{
		pagination: '.pagination',
		paginationClickable: true,
		slidesPerView: (count<3?count:3),
		loop: true,
		autoplay:3000,
		autoplayDisableOnInteraction: false,
		autoplayStopOnLast:false
	});
}

appModule.directive("orientable",function(){
	return function($scope,element,attrs){
		element[0].onload=function(){
			var ppEl=this.parentNode.parentNode;
			if(ppEl){
				var count = parseInt(this.parentNode.parentNode.getAttribute("imgCount"));
				var index = parseInt(this.getAttribute("index"));
				if(index+1===count){
					swiper();
				}
			}
		}
	}
});

appModule.directive("orientablelike",function(){
	return function($scope,element,attrs){
		element[0].onload=function(){
			var count = parseInt(this.parentNode.parentNode.getAttribute("imgcount"));
			var index = parseInt(this.getAttribute("index"));
			if(index+1===count){
				swiperLike(count);
			}
		}
		element[0].onerror=function(){
		}
	}
});

/*
appModule.directive("controls",function(){
	return function($scope,element,attrs){
		element[0].onclick=function(){
			alert(1);
			//alert(getComputedStyle[this]["width"]);
		}
	}
});
*/

function dealBanner(data){
	for(var i=0,len=data.length;i<len;i++){
		var item=data[i];
		if(item.src){
			item.clickUrl=item.src;
		}
		else{
			if(item.details_type==1){
				item.clickUrl="#appDetail/"+item.details_id;
			}
			else if(item.details_type==2){
				item.clickUrl="#videoDetail/"+item.details_id;
			}
		}
	}
}

function indexControll($scope,$http){
	$http({
		method:"get",
		url:server_url+"banner.action.php",
		params:{"type":1}
	}).success(function(data){
		var data=data.data;
		dealBanner(data);
		$scope.data=data;
		$scope.dataCount=data.length;
	});
	$http({
		method:"get",
		url:server_url+"index.action.php",
		params:{"type":0}
	}).success(function(data){
		var items=data.data;
		var mdata=[];
		var tdata=[];
		for(var i=0,l=items.length;i<l;i++){
			tdata.push(items[i]);
			if(items.length===(i+1) || tdata.length===2){
				mdata.push(JSON.parse(JSON.stringify(tdata)));
				tdata=[];
			}
		}
		$scope.indexData=mdata;
	});
	setBg($scope,true);
}

function videoControll($scope,$http,$routeParams){
	$scope.swiper=function(){
		swiper();
	}
	var type=parseInt($routeParams.id);

	$http({
		method:"get",
		url:server_url+"banner.action.php",
		params:{"type":2,"sub_type":type}
	}).success(function(data){
		var data=data.data;
		dealBanner(data);
		$scope.data=data;
		$scope.dataCount=data.length;
	});

	$http({
		method:"get",
		url:server_url+"video.action.php",
		params:{"type":type,"start":0,"count":10}
	}).success(function(data){
		var items=data.data;
		var mdata=[];
		var tdata=[];
		for(var i=0,l=items.length;i<l;i++){
			tdata.push(items[i]);
			if(items.length===(i+1) || tdata.length===2){
				mdata.push(JSON.parse(JSON.stringify(tdata)));
				tdata=[];
			}
		}
		$scope.groups=mdata;
		for(var i=0,l=data.types.length;i<l;i++){
			var itype=data.types[i];
			itype.cssvalue=i%2===0?2:3;
			itype.current=(i===0)?"current":"";
			itype.current=parseInt(itype["type_id"])===type?"current":"";
		}
		$scope.types=data.types;
		$scope.typeCss=(100/l)+"%";
	});
	setBg($scope,true);
	setCurrentIndex(1);
}

function videoDetailControll($scope,$http,$routeParams,$sce){
	var id=$routeParams.id;
	$http({
		method:"get",
		url:server_url+"videoDetail.action.php",
		params:{"id":id}
	}).success(function(data){
		$scope.item=data.data;
		$scope.item.likeClass=parseInt($scope.item.is_like)?"love":"";
		$scope.item.address=$sce.trustAsResourceUrl($scope.item.address);
		$scope.item.likeData=data.likeData;
		$scope.item.likeDataCount=data.likeData.length;
	});
	$scope.loveMovie=function(){
		$http({
			method:"get",
			url:server_url+"dohistory.action.php",
			params:{
				"type":2,
				"action":1,
				"id":id
			}
		}).success(function(data){
			if(data.status){
				$scope.item.likeClass="love";		
				$scope.item.total_like=parseInt($scope.item.total_like)+1;
			}
			else{
				alert(data.message);
			}
		});
	}
	$scope.play=function(el){
		if(el.paused){
			el.play();
			$http({
				method:"get",
				url:server_url+"dohistory.action.php",
				params:{
					"type":2,
					"action":2,
					"id":id
				}
			}).success(function(data){
				if(!data.status){
					console.log(data.message);
				}
			});
		}
		else{
			el.pause();
		}
	}

	setBg($scope,false);
	setCurrentIndex(1);
}

function activityControll($scope,$http){
	$http({
		method:"get",
		url:server_url+"banner.action.php",
		params:{"type":3}
	}).success(function(data){
		var data=data.data;
		dealBanner(data);
		$scope.data=data;
		$scope.dataCount=data.length;
	});
	$http({
		method:"get",
		url:server_url+"index.action.php",
		params:{"type":2}
	}).success(function(data){
		var items=data.data;
		var mdata=[];
		var tdata=[];
		for(var i=0,l=items.length;i<l;i++){
			tdata.push(items[i]);
			if(items.length===(i+1) || tdata.length===2){
				mdata.push(JSON.parse(JSON.stringify(tdata)));
				tdata=[];
			}
		}
		$scope.indexData=mdata;
	});
	setBg($scope,true);
	setCurrentIndex(2);
}

function apkControll($scope,$http){
	$http({
		method:"get",
		url:server_url+"banner.action.php",
		params:{"type":4}
	}).success(function(data){
		var data=data.data;
		dealBanner(data);
		$scope.data=data;
		$scope.dataCount=data.length;
	});
	$http({
		method:"get",
		url:server_url+"app.action.php"
	}).success(function(data){
		function arrayGroup(arr){
			var mdata=[];
			var tdata=[];
			for(var i=0,l=arr.length;i<l;i++){
				tdata.push(arr[i]);
				if(arr.length===(i+1) || tdata.length===2){
					mdata.push(JSON.parse(JSON.stringify(tdata)));
					tdata=[];
				}
			}
			return mdata;
		}
		var odata=data.data;
		var groups=[];
		for(var i=0,l=odata.length;i<l;i++){
			sdata={};
			for(var key in odata[i]){
				sdata[key]=odata[i][key];
			}
			sdata.data=arrayGroup(sdata.data);
			groups.push(sdata);
		}
		$scope.groups=groups;
	});
	setBg($scope,true);
	setCurrentIndex(3);
}

function appDetailControll($scope,$http,$routeParams){
	$http({
		method:"get",
		url:server_url+"activityDetail.action.php",
		params:{"id":$routeParams.id}
	}).success(function(data){
		if(data.status){
			$scope.item=data.data;
			setCurrentIndex($scope.item["app_type"]==0?2:3);
		}
	});
	$scope.download=function(){
		function download(filename){
			var img=document.getElementById("img");
			var lnk = document.createElement('a'), e;
			lnk.download = filename;
			lnk.href=img.src;
			if (document.createEvent) {
				e = document.createEvent("MouseEvents");
				e.initMouseEvent("click", true, true, window,0, 0, 0, 0, 0, false, false, false,false, 0, null);
				lnk.dispatchEvent(e);
			}else if (lnk.fireEvent) {
				lnk.fireEvent("onclick");
			}

			/*
			var img=document.getElementById("img");
			if(img){
				if(document.createEvent){
					var e=document.createEvent("TouchEvent");
					e.initUIEvent("touchstart", true, true); 
					img.dispatchEvent(e);
					setTimeout(function(){
						var e2=document.createEvent("TouchEvent");
						e2.initUIEvent("touchend", true, true); 
						img.dispatchEvent(e2);
					},2000);
				}
				else if(img.fireEvent){
					img.fireEvent("touchstart");
					setTimeout(function(){
						img.fireEvent("touchend");
					},1000);
				}
			}
			*/
		}
		download("yhq.jpg");
	}
	setBg($scope,false);
}

function myControll($scope,$http){
	$http({
		method:"get",
		url:server_url+"getSession.php"
	}).success(function(data){
		if(data.status){
			$scope.item=data.data;
			var tel=$scope.item.user_name;
			if(tel && tel.length===11){
				$scope.item.user_name=tel.replace(/(\d{3})(\d{4})(\d{4})/g,"$1****$3");
			}
		}
	});
	$scope.exitLogin=function(){
		$http({
			method:"get",
			url:server_url+"exit.action.php"
		}).success(function(data){
			if(data.status){
				window.location.href="login.php";
			}
		});
	}
	setBg($scope,false);
	setCurrentIndex(4);
}

function historyControll($scope,$http,$routeParams){
	var type=$routeParams.type;
	var history={};
	history.type=type=="1"?"我的优惠劵":"我的观看历史";
	$scope.history=history;
	$http({
		method:"get",
		url:server_url+"history.action.php",
		params:{
			type:$routeParams.type
		}
	}).success(function(data){
		if(data.status){
			$scope.group=data.data;
		}
	});
	setBg($scope,false);
}
