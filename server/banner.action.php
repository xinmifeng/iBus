<?php
session_start();
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
	$banners = $DB->get("banner");
    header("Content-type: application/json");
	echo json_encode($banners);
}
?>
