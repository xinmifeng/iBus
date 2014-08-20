<?php
session_start();
require_once('common.class.php');
if(isset($_GET["type"])){
	require_once("sqlDb.php");
	/*
		首页:1
		视频:2
		优惠:3
		应用:4
	*/
	$type = $_GET["type"];
	$DB->where("type",$type);
	$DB->orderBy("order_id","desc");
	$banners=$DB->get("banner");
	echo json_encode(Common::getResult(1,"ok",$banners));
	exit(0);
}
else{
	echo json_encode(Common::getResult(0,"缺少type参数!"));
	exit(0);
}
?>
