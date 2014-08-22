<?php
session_start();
require_once('common.class.php');
if(!isset($_SESSION["user"])){
	echo json_encode(Common::getResult(0,"fail"));
	exit(0);
}
$user=$_SESSION["user"];
echo json_encode(Common::getResult(1,"ok",$user));
exit(0);
?>
