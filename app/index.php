<?php
session_start();
if(!isset($_SESSION["user"])){
	header("Location:login.php");
	exit(0);
}
require_once("../server/sqlDb.php");
$DB->orderBy("order_id","asc");
$fv=$DB->getOne("video_type");
$vid=0;
if($DB->count===1){
	$vid=$fv["type_id"];	
}
?>
<!Doctype>
<html ng-app="app">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0" />
	<meta name="format-detection" content="telephone=no" />
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<title>BusFree</title>
	<link href="css/bootstrap.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/jtzi.css"/>
	<script src="bower_components/angular/angular.js"></script>
	<script src="bower_components/angular-route/angular-route.js"></script>
	<script src="js/main.js"></script>
	<script src="js/sea.js"></script>
</head>
<body>
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
      <div class="text-center col-xs-1"></div>
         <div class="text-center col-xs-2 menu"> 
            <a href="#/"><span class="home" style="margin-bottom:-12px;"></span>主页</a>
         </div>
         <div class="text-center col-xs-2 menu">
            <a href="#video/<?php echo $vid;?>"><span class="see_shi" style="margin-bottom:-12px;"></span>视频</a>
         </div>
         <div class="text-center col-xs-2 menu">
            <a href="#activity" ><span class="dazhe" style="margin-bottom:-12px;"></span>优惠</a>
         </div>
         <div class="text-center col-xs-2 menu">
            <a href="#apks" ><span class="yong" style="margin-bottom:-12px;"></span>应用</a>
         </div>
         <div class="text-center col-xs-2 menu">
            <a href="#my" ><span class="mine" style="margin-bottom:-12px;"></span>我的</a>
         </div>
         <div class="text-center col-xs-1"></div>
      </div>
   </div>
</div>
<!--底部结束-->
</body>
</html>
<script>
	seajs.use("main");
</script>
