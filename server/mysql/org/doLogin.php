<?php
session_start();
session_destroy();
require_once("GetAppMAC.php");

if(!empty($_POST["mobile"]) && !empty($_POST["security"]) && !empty($_POST["validate"])){
	$mobile=$_POST["mobile"];
	$security=$_POST["security"];
	$validate=$_POST["validate"];
	if($validate!=$_SESSION["validate_session"]){
		echo INVALID_VALIDATION_CODE;
	}else{
		echo login($mobile,md5($security),$client_mac,$difi_id);
	}

}else{
	echo INPUT_ERROR;
}

function login($_mobile,$_security,$_difi_mac,$_difi_id){

	$url = "http://ds.muhd.cn:7077/authorization";
	$post_data = array ("mobile" => $_mobile,"security" => $_security,"mac" => $_difi_mac,"difi-id" => $_difi_id,"ip"=>$_SERVER["REMOTE_ADDR"]);
	$timeout = 10;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
	$output = curl_exec($ch);
	
	//curl_errno($ch);
	curl_close($ch);
	return $output;//var_dump($post_data);

}
?>

