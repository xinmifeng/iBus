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
$DB->where("index_id","111","<>");
$DB->where("index_id","222","<>");
$DB->orderBy("position","asc");
$indexs=$DB->get("index");
$reData=array();
$widthObj=array(8,4,6,6,8,4,4,8,8,4,4,8);
if($type==="2"){
	$widthObj=array(8,4,4,8,8,4,4,8);
}
$DB->orderBy("order_id","desc");
$fv=$DB->getOne("video_type");
$vid=0;
if($DB->count===1){
	$vid=$fv["type_id"];	
}
function getUrl($item,$vid){
	$type=$item["index_type"];
	$id=$item["details_id"];
	if(is_null($id)){
		return "#video/".$vid;
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
		case 3:
			$s.="#apks";
	}
	return $s;
}
for($i=0,$len=count($indexs);$i<$len;$i++){
	$pr=$i%2===0?"5px":"0";
	$item=$indexs[$i];
	$cssvalue=$widthObj[$i];
	$index_type=$item["index_type"];
	$redirect_src=getUrl($item,$vid);
	array_push($reData,array(
		"pic_url"=>$upload_dir.$item["pic_url"],
		"details_id"=>$item["details_id"],
		"position"=>$item["position"],
		"reurl"=>$redirect_src,
		"cssvalue"=>$cssvalue,
		"pr"=>$pr
	));
}
echo json_encode(Common::getResult(1,"ok",$reData));
?>
