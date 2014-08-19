<?php
session_start();
function createValidate() {
	$charset = 'abcdefghkmnprstuvwxyzABCDEFGHKMNPRSTUVWXYZ23456789';
	$code="";
	$_len = strlen($charset)-1;
	for ($i=0;$i<4;$i++) {
		$code.= $charset[mt_rand(0,$_len)];
	}
	$_SESSION['validate_session'] = strtolower($code);
	return $code;
 }
 echo createValidate();
 ?>