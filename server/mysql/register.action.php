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
		echo json_encode(Common::getResult(0,"手机号丢失,请重新注册!"));
		exit(0);
	}
	require_once("sqlDb.php");
	$tel=$_GET["tel"];
	$DB->where("user_name",$tel);
	$DB->getOne("user");
	if($DB->count===1){
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
	if(!isset($_GET["code"])){
		echo json_encode(Common::getResult(0,"lose code!"));
		exit(0);
	}
	$code=$_GET["code"];
	if(isset($_SESSION["token"])){
		$token = $_SESSION["token"];
		if($token===$code){
			echo json_encode(Common::getResult(1,"ok"));
			exit(0);
		}
	}
	echo json_encode(Common::getResult(0,"验证码错误或已失效,请重新获取"));
	exit(0);
}
else if($action==="codeRegist"){
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
		require_once("sqlDb.php");
		$DB->where("user_name",$tel);
		$DB->getOne("user");
		if($DB->count===0){
			$user=array(
				"user_name"=>$tel,
				"password"=>md5($pwd),
				"status"=>1,
				"create_date"=>$DB->now()
			);
			$id=$DB->insert("user",$user);
			if($id){
				$DB->where('id',$id);	
				$user=$DB->getOne('user');
				unset($user["password"]);
				$_SESSION["user"]=$user;
				echo json_encode(Common::getResult(1,"ok"));
				exit(0);
			}
			else{
				echo json_encode(Common::getResult(0,"insert user error:".$DB->getLastError()));
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
	$orgpwd=$_GET["orgpwd"];
	$pwd=$_GET["pwd"];
	$repwd=$_GET["repwd"];
	$user_id=$_SESSION["user"]["id"];
	require_once("sqlDb.php");

	$DB->where('id',$user_id)->where('password',md5($orgpwd));
	$cuser=$DB->getOne('user');
	if($cuser){
		$cuser["password"]=md5($pwd);
		$DB->update('user',array(
			'password'=>md5($pwd)
		));
		if($DB->count>0){
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
