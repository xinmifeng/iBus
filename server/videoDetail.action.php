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
echo json_encode(Common::getResult(1,"ok",$video));
?>
