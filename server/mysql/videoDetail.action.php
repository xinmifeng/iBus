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

$DB->where('index_id','222');
$fv=$DB->getOne('index');

$gdsrc="images/denglu_pic.jpg";
if($fv) {
	$gdsrc=$upload_dir.$fv[0];
}
$data["gdsrc"]=$gdsrc;

echo json_encode($data);
?>
