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
$ture_days=1;
$unit='时';
$days=(time()-strtotime($out))/86400;
if($days>0 && $days<1){
	$ture_days=ceil($days*24);
	$unit='时';
}
else{
	$ture_days=ceil($days);
	$unit='天';
}
$user["ture_days"]=$ture_days;
$user["unit"]=$unit;
echo json_encode(Common::getResult(1,"ok",$user));
exit(0);
?>
