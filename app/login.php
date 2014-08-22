<?php
session_start();
if(isset($_SESSION["user"])){
	header("Location:index.php");
	exit(0);
}
?>
<!Doctype>
<html ng-app="login">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title>BusFree</title>
	<link href="css/bootstrap.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/jtzi.css"/>
	<script src="bower_components/angular/angular.js"></script>
	<script src="js/login.js"></script>
</head>
<body ng-controller="loginControll" style="background:#ededed;">

<!--logo大背景-->
<div class="container-fluid">
   <div class="row text-center pic_bg" >
		<img src="images/denglv_bg.png" width="166" 
		height="46" style="margin-top:20px;"/>
	</div>
</div>

<!--输入框-->
<form ng-submit="login()" role="form">
<div class="container-fluid">
	<div class="row pd30">
		<div class="form-group" style="margin-top:-15px;">
			<label for="exampleInputEmail1"></label>
			<input ng-model="user.user_name" type="text" class="form-control" 
			id="exampleInputEmail1" placeholder="请输入手机号">
		</div>
		<div class="form-group" style="margin-top:-15px;">
			<label for="exampleInputPassword1"></label>
			<input ng-model="user.password" type="password" class="form-control" 
				id="exampleInputPassword1" placeholder="请输入密码">
		</div>
</div>

<div class="row pd30 kkk">
	<input type="submit" class="btn btn-primary btn-lg btn-block" style="background:#81b73f; border:1px solid #81b73f; outline:none; 
height:35px; line-height:2px; margin-top:-40px; font-size:16px;" value="登&nbsp;&nbsp;录"></input></div>

<div class="row pd30 kkk"><a href="register.php"><button type="button" class="btn btn-primary btn-lg btn-block" style="background:#fff; border:1px solid #fff; outline:none; 
height:38px; line-height:20px; margin-top:-30px; color:#999; font-size:16px;">注&nbsp;&nbsp;册</button></a></div>

</form>

<div class="row"><img src="images/denglu_pic.jpg" width="640" height="404" class="img-responsive pic_car guding"/></div>
<div class="row text-center footer">杭州微元科技有限公司&nbsp;&nbsp;&nbsp;&nbsp;版权所有</div>
</div>
</body>
</html>
