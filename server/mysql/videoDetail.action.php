<?php
session_start();
require_once('common.class.php');
header("Content-type: application/json");
if(!isset($_GET["id"])){
	echo json_encode(Common::getResult(0,"lose id!"));
	exit(0);
}
require_once("sqlDb.php");
$id=$_GET["id"];
$DB->where("v_id",$id);
$video=$DB->getOne("video");
$user_id=$_SESSION["user"]["id"];
$DB->where("user_id",$user_id)->where("src_id",$id)->where("src_type",2);
$history=$DB->getOne("user_history");
$is_like=0;
if(!is_null($history)){
	$is_like=$history["is_like"];
}
$video["is_like"]=$is_like;
$video["address"]=$upload_dir.$video["address"];

//猜你喜欢
$videoType=$video["type_id"];
$DB->where("type_id",$videoType);
$DB->orderBy("count","desc");
$DB->orderBy("total_like","desc");
$likeVideos=$DB->get("video",5,array("v_id","pic_url","count","title"));
$reLikeVideos=array();
for($i=0,$l=count($likeVideos);$i<$l;$i++){
	$item=$likeVideos[$i];
	$item["pic_url"]=$upload_dir.$item["pic_url"];
	array_push($reLikeVideos,$item);
}
$data=Common::getResult(1,"ok",$video);
$data["likeData"]=$reLikeVideos;
echo json_encode($data);
?>
