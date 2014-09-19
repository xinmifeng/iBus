function isThreeBrowser(){
	var agent=navigator.userAgent;
	var qqReg=/MQQBrowser/gi;
	var sogouReg=/Sogou/gi;
	var ucReg=/UCBrowser/gi;
	var ios=/iPhone|iPod|iPad/gi;
	var firefox=/Firefox/gi;
	return qqReg.test(agent) ||
			sogouReg.test(agent) ||
			ucReg.test(agent) ||
			ios.test(agent);
			//firefox.test(agent);
}

var isThree=isThreeBrowser();

function E(f, e, o) {
    if (!e) e = 'load';
    if (!o) o = window;
    if(o.attachEvent) {
        o.attachEvent('on' + e, f)
    } else {
        o.addEventListener(e, f, false)
    }
}

function launchFullscreen(element) {
	if(element.requestFullscreen) {
		element.requestFullscreen();
	}
	else if(element.mozRequestFullScreen) {
		element.mozRequestFullScreen();
	}
	else if(element.webkitRequestFullscreen) {
		element.webkitRequestFullscreen();
	}
	else if(element.msRequestFullscreen) {
		element.msRequestFullscreen();
	}
	alert('您的浏览器不支持视频全屏!');
}

function isIOS(){
    var isIOS = navigator.userAgent.match(/iPhone/i)
        || navigator.userAgent.match(/iPad/i)
        || navigator.userAgent.match(/iPod/i);
	return isIOS;
}

var appModule = isThree?angular.module('app',['ngRoute']):angular.module('app',[
	'ngRoute',
	'ngSanitize',
	'com.2fdevs.videogular',
	'com.2fdevs.videogular.plugins.controls'
]);

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
		templateUrl:isThree?'views/videoDetail.html':"views/videoDetailOrg.html"
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
		element=element.target;
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
var server_url="../server/mysql/";

var isroll=false;
function swiper(){
	new Swiper('.swiper-container',{
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
	new Swiper('.swiper-container',{
		pagination: '.pagination',
		paginationClickable: true,
		slidesPerView: (count<3?count:3),
		loop: count>3,
		autoplay:3000,
		autoplayDisableOnInteraction: false,
		autoplayStopOnLast:false
	});
}

appModule.directive("orientable",function(){
	return function($scope,element){
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

function dealLike(el){
	if(!el || !el.parentNode || !el.parentNode.parentNode) return;
	var count = parseInt(el.parentNode.parentNode.getAttribute("imgcount"));
	var index = parseInt(el.getAttribute("index"));
	var relCount=count<3?3:count;
	if(index+1===count){
		swiperLike(relCount);
	}
}

appModule.directive("orientablelike",function(){
	return function($scope,element){
		element[0].onload=function(){
			dealLike(this);	
		}
		element[0].onerror=function(){
			dealLike(this);	
		}
	}
});

var indexArray=[];
function dealImage(isorient){
	indexArray=isorient?window.arr:indexArray;
	indexArray.sort(function(a,b){
		return a.index>b.index?1:-1;
	});
	for(var i=0,l=indexArray.length;i<l;i++){
		var elObj=indexArray[i];		
		if(elObj.islast){
			if(!indexArray[i-1]) continue;
			var lastEl=indexArray[i-1].el;
			var el=elObj.el;
			var	pw=lastEl.width;
			var ph=lastEl.height;
			var nw=el.width;
			var nh=el.height;
			if(ph && nh){
				el.style.height=ph+"px";
			}
		}
	}
	var change="onorientationchange" in window ? "orientationchange" : "resize"
	var copy=(function(ar){
		var ars=[];
		for(var i=0,l=ar.length;i<l;i++){
			var item=ar[i];
			ars.push({
				el:item.el,
				index:item.index,
				islast:item.islast
			});
		}
		return ars;
	})(indexArray);
	window.arr=copy;
	function orientationChange(e){
		setTimeout('dealImage(true)',400);
	}
	E(orientationChange,change);
	indexArray=[];
}

function insetIndexArray(el){
	var index=parseInt(el.getAttribute("orientindex"));
	var islast=el.getAttribute("last")==="true";
	var pel=el.parentNode.parentNode.parentNode;
	var pindex=parseInt(pel.getAttribute("index"));
	var count=parseInt(el.getAttribute("count"));
	indexArray.push({'el':el,'index':pindex*2+index,'islast':islast});
	if(indexArray.length===count){
		dealImage();
	}
}

appModule.directive("orientindex",function(){
	return function($scope,element){
		element[0].onload=function(){
			insetIndexArray(this);
		}
		element[0].onerror=function(){
			insetIndexArray(this);
		}
	}
});

appModule.directive("orientvideo",function(){
	return function($scope,element,attrs){
		E(function(){
			var video=this;
			var containner=video.parentNode;
			var w=parseInt(getComputedStyle(video)["width"]);
			var h=parseInt(getComputedStyle(video)["height"]);
			var imgDiv=video.nextElementSibling;
			var iw=parseInt(imgDiv.style.width);
			var ih=parseInt(imgDiv.style.height);
			imgDiv.style.left=(w-iw)/2+"px";
			imgDiv.style.top=(h-130)/2+"px";
		},'loadstart',element[0]);
	}
});

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

function redirectToLogin(data){
	if(parseInt(data.status)==-1){
		window.location.href="login.php";
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
		redirectToLogin(data);
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
		redirectToLogin(data);
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

function subStr(str,length){
	var restr="";
	var len=0;
	for(var i=0,l=str.length;i<l;i++){
		var c=str[i];
		var charCode=str.charCodeAt(i);
		if(charCode>=0 && charCode<=128){
			len++;
			restr+=c;
			if(len>=length) return restr;
		}
		else{
			if(len+2>length) {return restr};
			len+=2;
			restr+=c;
			if(len==length) return restr;
		}
	}
	return restr;
}
function videoDetailControll($scope,$http,$routeParams,$sce){
	var id=$routeParams.id;
	$http({
		method:"get",
		url:server_url+"videoDetail.action.php",
		params:{"id":id}
	}).success(function(data){
		redirectToLogin(data);
		var likeData=data.likeData;
		var relikeData=[];
		for(var i=0,l=likeData.length;i<l;i++){
			var ld=likeData[i];
			ld.clickUrl="#videoDetail/"+ld.v_id;
			ld.title=subStr(ld.title,13);
			if(ld.v_id!=id){
				relikeData.push(ld);
			}
		}
		var orgCount=relikeData.length;
		function create(){
			var o_obj=JSON.parse(JSON.stringify(likeData[0]));
			for(var key in o_obj){
				o_obj[key]="";
			}
			o_obj["hidepic"]=true;
			o_obj["pic_url"]="images/hospital.jpg";
			return o_obj;
		}
		var tempData=[];
		if(relikeData.length>0 && relikeData.length<3){
			for(var i=0,l=3-relikeData.length;i<l;i++){
				tempData.push(create());
			}
		}
		relikeData=relikeData.concat(tempData);
		$scope.item=data.data;
		$scope.item.likeClass=parseInt($scope.item.is_like)?"love":"";
		$scope.item.address=$sce.trustAsResourceUrl($scope.item.address);
		$scope.item.likeData=relikeData;
		$scope.item.likeDataCount=orgCount;
		$scope.item.showtool=false;
		$scope.item.gdsrc=data.gdsrc;

		$scope.currentTime = 0;
		$scope.totalTime = 0;
		$scope.state = null;
		$scope.volume = 1;
		$scope.isCompleted = false;
		$scope.API = {
			currentTime:$scope.item.length,
			timeLeft:$scope.item.length
		};

		$scope.config = {
			autoHide: false,
			autoHideTime: 3000,
			autoPlay: false,
			transclude: true,
			sources: [
				{src: $scope.item.address, type: "video/mp4"}
			],
			theme:{
				url:"css/themes/default/videogular.css"
			}
		};

		$scope.onPlayerReady = function(API) {
			$scope.API = API; 
			$scope.canUse=true;
		}
		if(window.scrollTo){
			window.scrollTo(0,0);
		}
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
			redirectToLogin(data);
			if(data.status){
				$scope.item.likeClass="love";		
				$scope.item.total_like=parseInt($scope.item.total_like)+1;
			}
			else{
				alert(data.message);
			}
		});
	}
	var isplay=false;
	function playAjax($http){
		$http({
			method:"get",
			url:server_url+"dohistory.action.php",
			params:{
				"type":2,
				"action":2,
				"id":id
			}
		}).success(function(data){
			redirectToLogin(data);
			if(!data.status){
				console.log(data.message);
			}
		});
	}
	$scope.mplay=function(play,pause,t){
		var el=document.querySelector("video");
		if(isThree || play){
			if(el.paused){
				el.play();
				setVideoStatus(el);
				if(isplay) return;
				$scope.item.count=parseInt($scope.item.count)+1;
				isplay=true;
				playAjax($http);	
			}
			else{
				if(!isThree && play){
					el.pause();
				}
			}
		}
		else{
			if(!$scope.canUse){
				el.addEventListener("canplay",function(){
					var length=el.duration;
					if(length){
						var m=Math.floor(length/60);
						var s=Math.floor(length-m*60);
						$scope.API.timeLeft=(m>9?m:"0"+m)+":"+(s<10?"0"+s:s);
					}
				},false);
			}
			if(!el.paused){
				if(isplay) return;
				$scope.item.count=parseInt($scope.item.count)+1;
				isplay=true;
				playAjax($http);	
			}
		}
		if(pause){
			setVideoStatus(el);
		}
	}

	function setVideoStatus(el){
		var btn=document.querySelector('vg-play-pause-button div');
		if(!el.paused){
			btn.classList.remove('play');
			btn.classList.add('pause');
		}
		else{
			btn.classList.remove('pause');
			btn.classList.add('play');
		}
	}

	$scope.mmplay=function(){
		var myVideo = document.getElementsByTagName('video')[0];
		$scope.mplay(true,true);
	}
	$scope.fullscreen=function(){
		var el=document.querySelector("video");
		if(el){
			launchFullscreen(el);
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
		redirectToLogin(data);
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
		redirectToLogin(data);
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
		redirectToLogin(data);
		var data=data.data;
		dealBanner(data);
		$scope.data=data;
		$scope.dataCount=data.length;
	});
	$http({
		method:"get",
		url:server_url+"app.action.php"
	}).success(function(data){
		redirectToLogin(data);
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
		redirectToLogin(data);
		if(data.status){
			$scope.item=data.data;
			switch(parseInt($scope.item["app_type"])){
				case 0:
				$scope.item.text="下载优惠券";
				setCurrentIndex(2);
				break;
				case 1:
				$scope.item.text="下载游戏";
				setCurrentIndex(3);
				break;
				case 2:
				$scope.item.text="下载应用";
				setCurrentIndex(3);
				break;
			}
			$scope.item.show=!($scope.item["type"]=="限时活动");
		}
	});
	$scope.mdownload=function(){
		var ios=isIOS();
		if(ios){
			var isOk = window.confirm("IOS系统无法直接下载,请长按图片保存!是否添加下载记录?");
			if(!isOk) return;
		}
		var isapk=parseInt($scope.item["app_type"])>0;
		var url=isapk?$scope.item.download_url:$scope.item.src;
		var filename=url.substr(url.lastIndexOf("/")+1);
		var imgReg=/^[a-z0-9]{32}\.(jpg|png|gif|bmp|ico)$/;
		var apkReg=/^[a-z0-9]{32}\.apk$/;
		var reg=isapk?apkReg:imgReg;
		var str=isapk?"此应用或游戏不存在":"此图片不存在";
		if(filename && reg.test(filename)){
			$http({
				method:"get",
				url:server_url+"dohistory.action.php",
				params:{
					type:1,
					action:3,
					id:$routeParams.id,
					file:filename
				}
			}).success(function(data){
				redirectToLogin(data);
				if(data.status && !ios){
					window.location.href='../server/mysql/download.php?type=image&&name='+filename;
					alert('下载成功');
				}
				else{
					alert(data.message);
				}
			});
		}
		else{
			alert(str);
		}
	}
	setBg($scope,false);
}

function myControll($scope,$http){
	$http({
		method:"get",
		url:server_url+"getSession.php"
	}).success(function(data){
		redirectToLogin(data);
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
			redirectToLogin(data);
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
	history.type=type=="1"?"我的优惠劵":"最近观看";
	history.showcount=type=="2";
	history.href=type=="2"?"videoDetail":"appDetail";
	$scope.history=history;
	$http({
		method:"get",
		url:server_url+"history.action.php",
		params:{
			type:$routeParams.type
		}
	}).success(function(data){
		redirectToLogin(data);
		if(data.status){
			$scope.group=data.data;
		}
	});
	setBg($scope,false);
}
