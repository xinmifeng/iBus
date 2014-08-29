<?php
require_once("GetAppMAC.php");
session_start();

if(!empty($_POST["mobile"]) && !empty($_POST["security"]) && !empty($_POST["security2"]) && !empty($_POST["token"]) && !empty($_POST["validate"])){
	$mobile=$_POST["mobile"];
	$security=$_POST["security"];
	$security2=$_POST["security2"];
	$token=$_POST["token"];
	$validate=$_POST["validate"];
	if($_POST["security"]!=$_POST["security2"]){
		echo INPUT_ERROR;
	}else if($_SESSION['token']!=$_POST["token"]){
		echo INVALID_TOKEN;
	}else if($_SESSION['validate_session'] !=$_POST["validate"]){
		echo INVALID_VALIDATION_CODE;
	}else{

		$url = "http://ds.muhd.cn:7077/register";
		$post_data = array ("mobile" => $mobile,"security" => md5($security),"mac" => $client_mac,"difi_id" => $difi_id,"ip"=>$_SERVER["REMOTE_ADDR"]);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		$output = curl_exec($ch);
		echo($output);
		//curl_errno($ch);
		curl_close($ch);
	}
	
}

?>