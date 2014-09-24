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
require_once("GetAppMAC.php");

$user=array(
	"mobile"=>$tel,
	"security"=>md5($pwd),
	"mac"=>$client_mac,
	"difi_id"=>$difi_id,
	"ip"=>$_SERVER["REMOTE_ADDR"]
);

$out=Common::httpRequest('authorization',$user);
$out=intval($out);
if($out>0){
	$data=array(
		"id"=>$out,
		"user_name"=>$tel,
	);
	$_SESSION["user"]=$data;
	echo json_encode(Common::getResult(1,"success!",$data));
	exit(0);
}
else{
	echo json_encode(Common::getResult(0,"手机号或密码错误!"));
	exit(0);
}

?>
