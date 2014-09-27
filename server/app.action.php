<?php
session_start();
require_once('common.class.php');
if(!isset($_SESSION["user"])){
	echo json_encode(Common::getResult(-1,"用户未登录"));
	exit(0);
}
/*
if(!isset($_GET["apptype"])){
	echo json_encode(Common=>=>getResult(0,"lose apptype!"));
	exit(0);
}
*/
require_once("sqlDb.php");
$pdost=Database::sql('select * from bee_activity where app_type>0 order by app_type asc,create_date desc');
$activitys=array();
foreach($pdost as $row){
	array_push($activitys,$row);
}

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

for($i=0,$len=count($activitys);$i<$len;$i++){
	$item=$activitys[$i];
	$obj=array(
		"id"=>$item["id"],
		"picture_url"=>$upload_dir.$item["picture_url"],
		"title"=>$item["title"]
	);
	if($item["app_type"]==="2"){
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
