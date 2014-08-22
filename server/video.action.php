<?php
session_start();
require_once('common.class.php');
header("Content-type: application/json");
if(!isset($_GET["type"])){
	echo json_encode(Common::getResult(0,"lose type!"));
	exit(0);
}
if(!isset($_GET["start"])){
	echo json_encode(Common::getResult(0,"lose start!"));
	exit(0);
}
if(!isset($_GET["count"])){
	echo json_encode(Common::getResult(0,"lose count!"));
	exit(0);
}
require_once("sqlDb.php");
$type=$_GET["type"];
$start=$_GET["start"];
$count=$_GET["count"];
$params = array($type,$start,$count);
$videos=$DB->rawQuery("select * from bee_video where type_id = ? order by order_id desc limit ?,?",$params);

$DB->orderBy("order_id");
$types=$DB->get("video_type");
$reData=Common::getResult(1,"ok",$videos);
$reData["types"]=$types;
echo json_encode($reData);
?>
