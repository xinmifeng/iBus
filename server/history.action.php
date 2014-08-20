<?php
session_start();
require_once('common.class.php');
//用户优惠券下载历史 1
//用户视频观看历史	 2
if(!isset($_GET["type"])){
	echo json_encode(Common::getResult(0,"lose type!"));
	exit(0);
}
require_once("sqlDb.php");
$type=$_GET["type"];
$ids = $DB->subQuery();
$ids->where('src_type',$type);
if($type===1){
	$ids->get("activity",null,"id");
}
else if($type===2){
	$ids->get("video",null,"v_id");
}
$DB->where("src_id",$ids,"in");
$historys=$DB->get("user_history");
echo json_encode($historys);
?>
