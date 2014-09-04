<?php
session_start();
if(!isset($_SESSION["user"])){
	header("Location:login.php");
	exit(0);
}
?>
<!Doctype>
<html ng-app="password">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title>BusFree</title>
	<link href="css/bootstrap.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/jtzi.css"/>
	<script src="bower_components/angular/angular.min.js"></script>
	<script src="js/password.js"></script>
</head>

<body style="background:#ededed;" ng-controller="passwordCtrl">
<!--标题-->
<div class="container-fluid" style="margin-bottom:0;">
   <div class="row text-center logo">
        <div class="row col-xs-2"><img src="images/logo.png" width="109" height="31" /></div>
        <div class="row col-xs-4"></div>
        <div class="row col-xs-7 text-right zhuce"><a href="javascript:history.back(0);">返回</a></div>
   </div>
</div>

<!--输入框-->
<div class="container-fluid">
<div class="row pd30">
<form role="form">
  <div class="form-group">
    <label for="exampleInputEmail1"></label>
    <input ng-model="user.orgpwd" ng-change="checkChange()" type="password" class="form-control" id="exampleInputEmail1" placeholder="请输入原密码">
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1"></label>
    <input ng-model="user.pwd" ng-change="checkChange()" type="password" class="form-control" id="exampleInputEmail1" placeholder="请输入新密码">
  </div>
  <div class="form-group" style="margin-top:-15px;">
    <label for="exampleInputEmail1"></label>
    <input ng-model="user.repwd" ng-change="checkChange()" type="password" class="form-control" id="exampleInputEmail1" placeholder="再次输入密码">
  </div>
 </form>
</div>

<div class="row pd30">
	<button id="checkbtn" ng-click="modify()" type="button" class="btn btn-primary btn-lg btn-block" 
	style="background:#c9c9c9; border:1px solid #c9c9c9; outline:none;height:38px; line-height:18px; margin-top:-30px; color:#fefefe; font-size:16px;">修改密码
	</button>
</div>

<div>
	<img src="images/denglu_pic.jpg" width="640" height="404" class="img-responsive pic_car guding"/></div>
	<div class="row text-center footer">杭州微元科技有限公司&nbsp;&nbsp;&nbsp;&nbsp;版权所有</div>
</div>
</body>
</html>
