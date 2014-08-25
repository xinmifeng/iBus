<?php
session_start();
require_once('common.class.php');
header("Content-type: application/json");
if(!isset($_GET["type"])){
	echo json_encode(Common::getResult(0,"lose type!"));
	exit(0);
}
require_once("sqlDb.php");
$type=$_GET["type"];
if($type>0){
	$DB->where("index_type",$type);
}
$DB->orderBy("position","asc");
$indexs=$DB->get("index");
$reData=array();
$widthObj=array(8,4,6,6,8,4,4,8,8,4,4,8);
if($type==="2"){
	$widthObj=array(8,4,4,8,8,4,4,8);
}
function getUrl($item){
	$type=$item["index_type"];
	$id=$item["details_id"];
	if(is_null($id)){
		return "#video/1";
	}
	$s="#";
	switch($type){
		case 0:
			$s.="video";
			break;
		case 1:
			$s.="videoDetail/".$id;
			break;
		case 2:
			$s.="appDetail/".$id;
			break;
	}
	return $s;
}
for($i=0,$len=$DB->count;$i<$len;$i++){
	$pr=$i%2===0?"5px":"0";
	$item=$indexs[$i];
	$cssvalue=$widthObj[$i];
	$index_type=$item["index_type"];
	$redirect_src=getUrl($item);
	array_push($reData,array(
		"pic_url"=>$item["pic_url"],
		"details_id"=>$item["details_id"],
		"position"=>$item["position"],
		"reurl"=>$redirect_src,
		"cssvalue"=>$cssvalue,
		"pr"=>$pr
	));
}
echo json_encode(Common::getResult(1,"ok",$reData));
?>
