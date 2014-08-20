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
echo json_encode($indexs);
?>
