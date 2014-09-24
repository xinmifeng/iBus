<?php
session_start();
require_once("common.class.php");
function generateToken(){
	$token="";
	$charset = '123456789';
	$_len = strlen($charset)-1;
	for ($i=0;$i<4;$i++) {
		$token.= $charset[mt_rand(0,$_len)];
	}
	$_SESSION['token'] = $token;
	return $token;
}

if(!isset($_GET["action"])){
	echo json_encode(Common::getResult(0,"lose action!"));
	exit(0);
}

$action=$_GET["action"];
if($action==="codeCreate"){
	if(!isset($_GET["tel"])){
		echo json_encode(Common::getResult(0,"lose tel!"));
		exit(0);
	}
	$tel=$_GET["tel"];
	if(false){
		echo json_encode(Common::getResult(0,"此手机号已被注册!"));
		exit(0);
	}
	else{
		require_once("SMS.class.php");
		$token = generateToken();
		$isms=new SMS();
		$re=$isms->send($sms_uid,$sms_key,$tel,urlencode("公交无线网关验证码：".$token));
		if($re!=="1"){
			echo json_encode(Common::getResult(0,"errorcode:".$re));
			exit(0);
		}
		else{
			$_SESSION["tel"] = $tel;
			echo json_encode(Common::getResult(1,"ok"));
			exit(0);
		}
	}
}
else if($action==="codeVerify"){
	if(!$_SESSION["tel"]){
		echo json_encode(Common::getResult(0,"请先完成上步操作"));
		exit(0);
	}
	if(!isset($_GET["code"])){
		echo json_encode(Common::getResult(0,"lose code!"));
		exit(0);
	}
	$code=$_GET["code"];
	if(isset($_SESSION["token"])){
		$token = $_SESSION["token"];
		if($token===$code){
			$_SESSION["verifyOk"]=true;
			echo json_encode(Common::getResult(1,"ok"));
			exit(0);
		}
	}
	echo json_encode(Common::getResult(0,"验证码错误或已失效,请重新获取"));
	exit(0);
}
else if($action==="codeRegist"){
	if(!$_SESSION["verifyOk"]){
		echo json_encode(Common::getResult(0,"请先完成上步操作"));
		exit(0);
	}
	if(!isset($_GET["pwd"])){
		echo json_encode(Common::getResult(0,"请输入密码"));
		exit(0);
	}
	if(!isset($_GET["repwd"])){
		echo json_encode(Common::getResult(0,"请输入确认密码"));
		exit(0);
	}
	if(!isset($_SESSION["tel"])){
		echo json_encode(Common::getResult(0,"验证码错误或已失效,请重要获取"));
		exit(0);
	}
	$pwd=$_GET["pwd"];
	$repwd=$_GET["repwd"];
	$tel=$_SESSION["tel"];
	if($pwd!==$repwd){
		echo json_encode(Common::getResult(0,"密码与确认密码不一致"));
		exit(0);
	}
	else{
		require_once("GetAppMAC.php");
		if(true){
			$user=array(
				"mobile"=>$tel,
				"security"=>md5($pwd),
				"mac"=>$client_mac,
				"difi_id"=>$difi_id,
				"ip"=>$_SERVER["REMOTE_ADDR"]
			);
			$out=Common::httpRequest('register',$user);
			$out=intval($out);
			if($out>0){
				$_SESSION["user"]=array(
					"id"=>$out,
					"user_name"=>$tel,
				);
				echo json_encode(Common::getResult(1,"ok"));
				exit(0);
			}
			else{
				echo json_encode(Common::getResult(0,"注册失败!"));
				exit(0);
			}
		}
		else{
			echo json_encode(Common::getResult(0,"已经存在此用户"));
			exit(0);

		}
	}
}
else if($action==="modifypwd"){
	if(!isset($_GET["orgpwd"])){
		echo json_encode(Common::getResult(0,"请输入原密码"));
		exit(0);
	}
	if(!isset($_GET["pwd"])){
		echo json_encode(Common::getResult(0,"请输入新密码"));
		exit(0);
	}
	if(!isset($_GET["repwd"])){
		echo json_encode(Common::getResult(0,"请输入确认密码"));
		exit(0);
	}
	if($_GET["pwd"]!=$_GET["repwd"]){
		echo json_encode(Common::getResult(0,"新密码与确认密码不匹配"));
		exit(0);
	}
	if($_GET["orgpwd"]==$_GET["pwd"]){
		echo json_encode(Common::getResult(0,"新密码不能与原密码相同"));
		exit(0);
	}
	$orgpwd=$_GET["orgpwd"];
	$pwd=$_GET["pwd"];
	$repwd=$_GET["repwd"];
	$user_id=$_SESSION["user"]["id"];
	$tel=$_SESSION["user"]["user_name"];
	require_once("GetAppMAC.php");
	$param=array(
		"mobile"=>$tel,
		"security"=>md5($orgpwd),
		"mac"=>$client_mac,
		"difi_id"=>$difi_id,
		"ip"=>$_SERVER["REMOTE_ADDR"]
	);
	$out=Common::httpRequest('authorization',$param);
	$out=intval($out);
	if($out>0){
		$cuser=array(
			"mobile"=>$tel,
			"security"=>md5($pwd),
			"oldsecurity"=>md5($orgpwd),
			"mac"=>$client_mac,
			"difi_id"=>$difi_id,
			"ip"=>$_SERVER["REMOTE_ADDR"]
		);
		$out2=Common::httpRequest('resetSecurity',$cuser);
		$out2=intval($out2);
		if($out2>0){
			echo json_encode(Common::getResult(1,"密码修改成功!"));
			exit(0);
		}
		else{
			echo json_encode(Common::getResult(0,"密码修改失败!"));
			exit(0);
		}
	}
	else{
		echo json_encode(Common::getResult(0,"原密码输入错误"));
		exit(0);
	}
}
else{
	echo json_encode(Common::getResult(0,"action 错误"));
	exit(0);
}
?>
