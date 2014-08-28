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
	if($type==="2"){
		$subType=$_GET["sub_type"];
		$DB->where("sub_type",$subType);
	}
	$DB->orderBy("order_id","desc");
	$banners=$DB->get("banner");
	$reData=array();
	for($i=0,$l=$DB->count;$i<$l;$i++){
		$item=$banners[$i];
		$item["picture_url"]=$upload_dir.$item["picture_url"];
		array_push($reData,$item);
	}
	echo json_encode(Common::getResult(1,"ok",$reData));
	exit(0);
}
else{
	echo json_encode(Common::getResult(0,"缺少type参数!"));
	exit(0);
}
?>
