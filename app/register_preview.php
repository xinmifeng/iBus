<?php
session_start();
if(isset($_SESSION["user"])){
	header("Location:index_preview.php");
	exit(0);
}

require("../server/mysql/sqlDb.php");
$DB->where('index_id','111');
$fv=$DB->getOne('index');
$gdsrc="images/denglu_pic.jpg";
if($fv) {
	$arr = parse_ini_file("../server/mysql/iBus.ini");
	$upload_dir = $arr["upload_dir"];
	$gdsrc=$upload_dir.$fv[0];
}
?>

<!Doctype>
<html ng-app="register">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title>LeLe WiFi</title>
	<script>
		window.isPreview=true;
	</script>
	<link href="css/bootstrap.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/jtzi.css"/>
	<script src="bower_components/angular/angular.min.js"></script>
	<script src="bower_components/angular-route/angular-route.min.js"></script>
	<script src="js/register.js"></script>
</head>
<body style="background:#ededed;">
	<!--标题-->
	<div class="container-fluid" style="margin-bottom:0;">
	   <div class="row text-center logo">
			<div class="row col-xs-2"><img src="images/logo.png" width="109" height="31" /></div>
			<div class="row col-xs-4"></div>
			<div class="row col-xs-7 text-right zhuce"><a href="login_preview.php">登录</a></div>
	   </div>
	</div>
	<div ng-view></div>
	<div><img src="<?php echo $gdsrc ?>" width="640" height="404" class="img-responsive pic_car guding"/></div>
	<div class="row text-center footer">杭州微元科技有限公司&nbsp;&nbsp;&nbsp;&nbsp;版权所有</div>
	</div>
</body>
</html>