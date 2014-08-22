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
$DB->where("id",$id);
$activity=$DB->getOne("activity");
echo json_encode(Common::getResult(1,"ok",$activity));
?>
