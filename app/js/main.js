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

appModule.controller('MainControll',function ($scope){
	setBg($scope,true);
});

var server_url="../server/";

function swiper(){
	var mySwiper = new Swiper('.swiper-container',{
		  pagination: '.pagination',
		  loop:true,
		  grabCursor: true,
		  paginationClickable: true
	});
}

function commonDeal(action){
}

function indexControll($scope,$http){
	$http({
		method:"get",
		url:server_url+"banner.action.php",
		params:{"type":1}
	}).success(function(data){
		$scope.data=data;
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
	$scope.swiper=function(){
		swiper();
	}
	setBg($scope,true);
}

function videoControll($scope,$http,$routeParams){
	$scope.swiper=function(){
		swiper();
	}
	var type=$routeParams.id;
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
			var type=data.types[i];
			type.cssvalue=i%2===0?2:3;
		}
		$scope.types=data.types;
	});
	setBg($scope,true);
}

function videoDetailControll($scope,$http,$routeParams,$sce){
	$http({
		method:"get",
		url:server_url+"videoDetail.action.php",
		params:{"id":$routeParams.id}
	}).success(function(data){
		$scope.item=data.data;
		$scope.item.likeClass=$scope.item.is_like?"love":"";
		$scope.item.address=$sce.trustAsResourceUrl("."+$scope.item.address);
	});
	$scope.loveMovie=function(){
		$http({
			method:"get",
			url:server_url+"dohistory.action.php",
			params:{
				"type":2,
				"action":1,
				"id":$routeParams.id
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
	setBg($scope,false);
}

function activityControll($scope,$http){
	$http({
		method:"get",
		url:server_url+"banner.action.php",
		params:{"type":3}
	}).success(function(data){
		$scope.data=data;
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
	$scope.swiper=function(){
		swiper();
	}
	setBg($scope,true);
}

function apkControll($scope,$http){
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
	$scope.swiper=function(){
		swiper();
	}
	setBg($scope,true);
}

function appDetailControll($scope,$http,$routeParams){
	$http({
		method:"get",
		url:server_url+"activityDetail.action.php",
		params:{"id":$routeParams.id}
	}).success(function(data){
		if(data.status){
			$scope.item=data.data;
		}
	});
	$scope.download=function(){
		function download(url,filename){
			var lnk = document.createElement('a'), e;
			lnk.download = filename;
			lnk.href=url;
			if (document.createEvent) {
				e = document.createEvent("MouseEvents");
				e.initMouseEvent("click", true, true, window,0, 0, 0, 0, 0, false, false, false,false, 0, null);
				lnk.dispatchEvent(e);
			}else if (lnk.fireEvent) {
				lnk.fireEvent("onclick");
			}
		}
		//download("images/xizai_point.jpg","point.jpg");
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
