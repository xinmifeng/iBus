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
$id=$_SESSION["user"]["id"];
$type=$_GET["type"];

$params=array($id,$type);
$sql="select v.v_id id,v.pic_url picture,v.title title,h.create_date from bee_video v,bee_user_history h where h.src_id=v.v_id and h.user_id=? and h.src_type=?";
if($type==="1"){
$sql="select a.id,a.picture_url picture,a.title title,h.create_date from bee_activity a,bee_user_history h where a.id=h.src_id and user_id=? and h.src_type=?";
}
$historys=$DB->rawQuery($sql,$params);
echo json_encode(Common::getResult(1,"success!",$historys));
exit(0);
?>
