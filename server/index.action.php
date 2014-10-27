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
$where=array();
if($type>0){
	$where['index_type']=$type;
}
$rindexs=Database::select('bee_index','*',array(
	'where'=>$where,
	'orderBy'=>'position asc'
));

$indexs=array();
for($i=0,$l=count($rindexs);$i<$l;$i++){
	$item=$rindexs[$i];
	if($item["index_id"]=="111" || $item["index_id"]=="222") continue;
	array_push($indexs,$item);
}

$reData=array();
$widthObj=array(8,4,6,6,8,4,4,8,8,4,4,8);
if($type==="2"){
	$widthObj=array(8,4,4,8,8,4,4,8);
}
$fv=Database::select('bee_video_type','type_id',array(
	'orderBy'=>'order_id desc',
	'single'=>true
));
$vid=0;
if($fv) $vid=$fv;

function getUrl($item,$vid){
	if((strpos($item["src"],'#')===0)){
		return $itme["src"].$vid;
	}
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
			$s.="apks";
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
