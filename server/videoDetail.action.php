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

$video=Database::select('bee_video','*',array(
	'where'=>array('v_id'=>$id),
	'singleRow'=>true
));

$user_id=$_SESSION["user"]["id"];

$history=Database::select('bee_user_history','*',array(
	'where'=>array('user_id'=>$user_id,'src_id'=>$id,'src_type'=>2),
	'orderBy'=>'create_date desc',
	'singleRow'=>true
));

$is_like=0;
if(!is_null($history)){
	$is_like=$history["is_like"];
}

$video["is_like"]=$is_like;
$video["address"]=$upload_dir.$video["address"];

//猜你喜欢
$videoType=$video["type_id"];

$likeVideos=Database::select('bee_video','v_id,pic_url,count,title',array(
	'where'=>array('type_id'=>$videoType),
	'orderBy'=>'count desc,total_like desc',
	'limit'=>'0,9'
));

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
