<?php
require_once('prepend.php');
class Common{
	public function __construct(){
	}
	
	public static function getResult($status=0,$message="",$data=array()){
		return array(
			"status"=>$status,
			"message"=>$message,
			"data"=>$data
		);
	}

	public static function httpRequest($url,$post_data){
		$url="http://ds.muhd.cn:7077/".$url;
		$ch = curl_init();
		$timeout = 5;
		curl_setopt ($ch, CURLOPT_URL, $url);
		curl_setopt ($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		$output = curl_exec($ch);
		curl_close($ch);
		return $output;
	}
}
?>
