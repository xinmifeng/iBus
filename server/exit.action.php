<?php
session_start();
require_once('common.class.php');
if(isset($_SESSION["user"])){
	$_SESSION["user"]=null;
	echo json_encode(Common::getResult(1,"exit success!"));
	exit(0);
}
echo json_encode(Common::getResult(0,"not login yet!"));
?>
