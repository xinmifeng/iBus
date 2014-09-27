<?php
session_start();
require_once('common.class.php');
header("Content-type: application/json");
if(!isset($_SESSION["user"])){
	echo json_encode(Common::getResult(-1,"用户未登录"));
	exit(0);
}
if(!isset($_GET["id"])){
	echo json_encode(Common::getResult(0,"lose id!"));
	exit(0);
}
require_once("sqlDb.php");
$id=$_GET["id"];
$activity=Database::select('bee_activity','*',array(
	'where'=>array('id'=>$id),
	'singleRow'=>true
));
$pic_url=$activity["picture_url"];
$src=$activity["src"];
$activity["src"]=$upload_dir.$src;
$activity["picture_url"]=$upload_dir.$pic_url;
echo json_encode(Common::getResult(1,"ok",$activity));
?>
