<?php
session_start();
require_once('common.class.php');
if(!isset($_SESSION["user"])){
	echo json_encode(Common::getResult(-1,"用户未登录"));
	exit(0);
}
$user=$_SESSION["user"];

$data=array(
	"mobile"=>$user["user_name"]
);
$out=Common::httpRequest('getRegistDate',$data);
$ture_days=ceil((time()-strtotime($out))/86400);
$user["ture_days"]=$ture_days;
echo json_encode(Common::getResult(1,"ok",$user));
exit(0);
?>
