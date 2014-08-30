<?php
class SMS{

	public function __construct(){
	
	}

	function send($_sms_uid,$_sms_key,$_smsmob,$_smstext){
		$url = "http://utf8.sms.webchinese.cn/?Uid=".$_sms_uid."&KeyMD5=".$_sms_key."&smsMob=".$_smsmob."&smsText=".$_smstext;
		//$url="http://gbk.sms.webchinese.cn/?Uid=".$_sms_uid."&KeyMD5=".$_sms_key."&smsMob=".$_smsmob."&smsText=".$_smstext;
		$fp = fopen("smsLog/smss_".date("Y-m-d",time()).".txt", "a");
		fwrite($fp,"[".date("Y-m-d H:i:s")."] ".$url."\r\n");
		fclose($fp);
		if(function_exists('file_get_contents') && 0){
			$output = file_get_contents($url);
		}
		else{
			$ch = curl_init();
			$timeout = 5;
			curl_setopt ($ch, CURLOPT_URL, $url);
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
			$output = curl_exec($ch);
			curl_close($ch);
			return $output;
		}
	}
}
?>
