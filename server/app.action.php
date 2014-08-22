<?php
session_start();
require_once('common.class.php');
/*
if(!isset($_GET["apptype"])){
	echo json_encode(Common=>=>getResult(0,"lose apptype!"));
	exit(0);
}
*/
require_once("sqlDb.php");
$DB->where("type","应用");
$DB->orderBy("app_type","asc");
$DB->orderBy("create_date","desc");
$activitys = $DB->get("activity");

$a0=array(
	"gr"=>"10px",
	"gpic"=>"images/anzuo.jpg",
	"data"=>array()
);
$a1=array(
	"gr"=>"70px",
	"gpic"=>"images/game.jpg",
	"data"=>array()
);

for($i=0,$len=$DB->count;$i<$len;$i++){
	$item=$activitys[$i];
	$obj=array(
		"id"=>$item["id"],
		"picture_url"=>$item["picture_url"],
		"title"=>$item["title"]
	);
	if($item["app_type"]==="1"){
		array_push($a0["data"],$obj);
	}
	else{
		array_push($a1["data"],$obj);
	}
}

$reData=array($a0,$a1);

echo json_encode(Common::getResult(1,"ok",$reData));
exit(0);
?>
