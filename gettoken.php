<?php
session_start();
require_once("common/SMS.class.php");

function generateToken(){
	$token="";
	$charset = '123456789';
	$_len = strlen($charset)-1;
	for ($i=0;$i<6;$i++) {
		$token.= $charset[mt_rand(0,$_len)];
	}
	$_SESSION['token'] = $token;
	return $token;
}

if(!empty($_POST["mobile"])){

		$url = "http://ds.muhd.cn:7077/checkMobile";

		$post_data = array ("mobile" => $_POST["mobile"]);

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $url);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		curl_setopt($ch, CURLOPT_POST, 1);

		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);

		$output = curl_exec($ch);

		//curl_errno($ch);
		curl_close($ch);

	//if($_SESSION['validate_session']==$_POST["validate"]){
/*
if(ceil($output)==0){
		$isms=new SMS();

		$err = $isms->send($sms_uid,$sms_key,$_POST["mobile"],urlencode("公交无线网关注册验证码为：".generateToken()));

		echo $err;
}else{
	echo MOBILE_ALREADY_EXIST;
}
*/
echo "1";
	//}else{
	//	echo INVALID_VALIDATION_CODE;
	//}
//}else{
//	echo INVALID_VALIDATION_CODE;

}

?>