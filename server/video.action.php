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
$reVideos=array();
for($i=0,$l=count($videos);$i<$l;$i++){
	$item=$videos[$i];
	$item["pic_url"]=$upload_dir.$item["pic_url"];
	array_push($reVideos,$item);
}
$types=$DB->get("video_type");
$reData=Common::getResult(1,"ok",$reVideos);
$reData["types"]=$types;
echo json_encode($reData);
?>
