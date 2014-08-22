<?php
session_start();
require_once('common.class.php');
if(!isset($_GET["tel"])){
	echo json_encode(Common::getResult(0,"请输入手机号!"));
	exit(0);
}
if(!isset($_GET["pwd"])){
	echo json_encode(Common::getResult(0,"请输入密码!"));
	exit(0);
}
$tel = $_GET["tel"];
$pwd = $_GET["pwd"];
require_once("sqlDb.php");
if(isset($DB)){
	$DB->where("user_name",$tel)
	   ->where("password",md5($pwd));
	$user = $DB->getOne("user");
	if($DB->count===1){
		$_SESSION["user"] = $user;
		echo json_encode(Common::getResult(1,"success!",$user));
		exit(0);
	}
	else{
		echo json_encode(Common::getResult(0,"手机号或密码错误!"));
		exit(0);
	}
}
?>
