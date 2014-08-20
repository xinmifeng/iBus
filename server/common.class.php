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
}
?>
