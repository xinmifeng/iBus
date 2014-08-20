<?php
session_start();
require_once('common.class.php');
$user_id=$_SESSION["user"]["id"];
if(!isset($_GET["pwd"])){
	echo json_encode(Common::getResult(0,"lose pwd!"));
	exit(0);
}
if(!isset($_GET["newpwd"])){
	echo json_encode(Common::getResult(0,"lose newpwd!"));
	exit(0);
}
if(!isset($_GET["renewpwd"])){
	echo json_encode(Common::getResult(0,"lose renewpwd!"));
	exit(0);
}
$pwd=$_GET["pwd"];
$newpwd=$_GET["newpwd"];
$renewpwd=$_GET["renewpwd"];

if($newpwd!==$renewpwd){
	echo json_encode(Common::getResult(0,"newpwd not equal renewpwd!"));
	exit(0);
}
require_once("sqlDb.php");
$DB->where("id",$user_id)
   ->where("password",md5($pwd));
$DB->getOne("user");
if($DB->count===1){
	$DB->where("id",$user_id);
	$udata=array(
		"password"=>md5($newpwd)
	);
	if($DB->update("user",$udata)){
		echo json_encode(Common::getResult(1,"update ok!"));
		exit(0);
	}
	else{
		echo json_encode(Common::getResult(0,"update fail:".$DB->getLastError()));
		exit(0);
	}
}
else{
	echo json_encode(Common::getResult(0,"pwd error!"));
	exit(0);
}
?>
