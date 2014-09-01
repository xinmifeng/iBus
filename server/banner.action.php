<?php
session_start();
require_once('common.class.php');
if(!isset($_SESSION["user"])){
	if(isset($_GET["type"])){
		if($_GET["type"]!=="1"){
			echo json_encode(Common::getResult(-1,"用户未登录"));
			exit(0);
		}
	}
}
if(isset($_GET["type"])){
	require_once("sqlDb.php");
	/*
		首页:1
		视频:2
		优惠:3
		应用:4
	*/
	$type = $_GET["type"];
	$whereArr=array('type'=>$type);
	if($type==='2'){
		$subType=$_GET['sub_type'];
		$whereArr['sub_type']=$subType;
	}
	$banners=Database::select('bee_banner','*',array(
		'where'=>$whereArr,
		'orderBy'=>'order_id desc'
	));
	$reData=array();
	for($i=0,$l=count($banners);$i<$l;$i++){
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
