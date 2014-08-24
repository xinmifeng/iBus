<?php
session_start();
require_once('common.class.php');
if(!isset($_SESSION["user"])){
	echo json_encode(Common::getResult(0,"fail"));
	exit(0);
}
$user=$_SESSION["user"];
$ture_days=ceil( (time() - strtotime($user["create_date"])) / 86400);
$user["ture_days"]=$ture_days;
echo json_encode(Common::getResult(1,"ok",$user));
exit(0);
?>
