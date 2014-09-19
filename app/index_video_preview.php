<?php
session_start();
require("../server/mysql/sqlDb.php");
$qqReg="/MQQBrowser/i";
$sogouReg="/Sogou/i";
$ucReg="/UCBrowser/i";
$ios="/iPhone|iPod|iPad/i";
$firefox="/Firefox/i";
$agent=$_SERVER["HTTP_USER_AGENT"];
$isThree=preg_match($qqReg,$agent) || 
		 preg_match($sogouReg,$agent) ||
		 preg_match($ucReg,$agent) ||
		 preg_match($ios,$agent);
if($isThree){
	header("Location:index_preview.php");
	exit(0);
}

$DB->orderBy('order_id','Desc');
$fv=$DB->getOne('video_type');
$vid=0;
if($fv) $vid=$fv["type_id"];

?>
<!DOCTYPE HTML>
<html ng-app="app">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0" />
	<meta name="format-detection" content="telephone=no" />
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<title>LeLe WiFi</title>
	<script>
		window.isPreview=true;
	</script>
	<link href="css/bootstrap.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/jtzi.css"/>
	<link rel="stylesheet" href="css/idangerous.swiper.css">
	<link rel="stylesheet" href="css/swiper.css">
	<script src="bower_components/angular/angular.min.js"></script>
	<script src="bower_components/angular-route/angular-route.min.js"></script>
	<script src="bower_components/swiper/src/idangerous.swiper.js"></script>
	<script src="bower_components/angular-sanitize/angular-sanitize.js"></script>
	<script src="bower_components/videogular/videogular.js"></script>
	<script src="bower_components/videogular-controls/controls.js"></script>
	<script src="js/main.js"></script>
</head>
<body ng-controller="MainControll" class="{{BG.hasbg}}">
<!--标题-->
<div class="container-fluid">
   <div class="row text-center logo">
        <div class="row col-xs-2"><img src="images/logo.png" width="109" height="31" /></div>
        <div class="row col-xs-4"></div>
        <div class="row col-xs-4"></div>
   </div>
</div>
<!--标题结束-->
<div ng-view=""></div>
<!--底部-->
<div class="navbar navbar-fixed-bottom beau_col" role="navigation" style="padding:0px;">
   <div class="container-fluid" style="margin-top:0px;">
      <div class="row" >
         <div class="text-center col-xs-2 men" style="width:20%;"> 
            <a ng-click="setCurrent($event)" class="current" href="#/"><span class="home" style="margin-bottom:-12px;"></span>主页</a>
         </div>
         <div class="text-center col-xs-2 men" style="width:20%;">
            <a ng-click="setCurrent($event)"  href="#video/<?php echo $vid;?>"><span class="see_shi" style="margin-bottom:-12px;"></span>视频</a>
         </div>
         <div class="text-center col-xs-2 men" style="width:20%;">
            <a ng-click="setCurrent($event)"  href="#activity" ><span class="dazhe" style="margin-bottom:-12px;"></span>优惠</a>
         </div>
         <div class="text-center col-xs-2 men" style="width:20%;">
            <a ng-click="setCurrent($event)"  href="#apks" ><span class="yong" style="margin-bottom:-12px;"></span>下载吧</a>
         </div>
         <div class="text-center col-xs-2 men" style="width:20%;">
            <a ng-click="setCurrent($event)"  href="#my" ><span class="mine" style="margin-bottom:-12px;"></span>我的</a>
         </div>
      </div>
   </div>
</div>
<!--底部结束-->
</body>
</html>
