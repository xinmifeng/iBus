var appModule = angular.module('app',['ngRoute']);
function appRouteConfig($routeProvider){
	$routeProvider.when("/",{
		controller:indexControll,
		templateUrl:'views/index.html'
	}).
	when("/video/:id",{
		controller:videoControll,
		templateUrl:'views/TV_hot.html'
	}).
	when("/videoDetail/:id",{
		controller:videoDetailControll,
		templateUrl:'views/tv_time.html'
	}).
	when("/activity",{
		controller:activityControll,
		templateUrl:'views/money_list.html'
	}).
	when("/apks",{
		controller:apkControll,
		templateUrl:'views/yingyong.html'
	}).
	when("/appDetail/:id",{
		controller:appDetailControll,
		templateUrl:'views/download_youhui.html'
	}).
	when("/history/:type",{
		controller:historyControll,
		templateUrl:'views/history_mine.html'
	}).
	when("/my",{
		controller:myControll,
		templateUrl:'views/main_mine.html'
	}).
	otherwise({
		redirectTo:"/"
	});
}

appModule.config(appRouteConfig);

var server_url="../server/";

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
}

function videoControll($scope,$http,$routeParams){
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
}

function videoDetailControll($scope,$http,$routeParams,$sce){
	$http({
		method:"get",
		url:server_url+"videoDetail.action.php",
		params:{"id":$routeParams.id}
	}).success(function(data){
		$scope.item=data.data;
		$scope.item.address=$sce.trustAsResourceUrl("."+$scope.item.address);
	});
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
}
