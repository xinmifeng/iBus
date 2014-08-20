<?php
session_start();
require_once('common.class.php');
/*
if(!isset($_GET["apptype"])){
	echo json_encode(Common::getResult(0,"lose apptype!"));
	exit(0);
}
*/
require_once("sqlDb.php");
$DB->where("type",1);
$activitys = $DB->get("activity");
echo json_encode(Common::getResult(1,"ok",$activitys));
exit(0);
?>
