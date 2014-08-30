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

$videos=Database::select('bee_video','*',array(
	'where'=>array('type_id'=>$type),
	'orderBy'=>'order_id desc',
	'limit'=>$start.','.$count
));

$reVideos=array();
for($i=0,$l=count($videos);$i<$l;$i++){
	$item=$videos[$i];
	$item["pic_url"]=$upload_dir.$item["pic_url"];
	array_push($reVideos,$item);
}

$types=Database::select('bee_video_type','*',array(
	'orderBy'=>'order_id desc'
));

$reData=Common::getResult(1,"ok",$reVideos);
$reData["types"]=$types;
echo json_encode($reData);
?>
