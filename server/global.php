<?php
/*
global $difi_id;
global $difi_sn;
global $difi_mac;
global $difi_server;
global $difi_pssword;
*/
global $sms_id;
global $sms_key;

/*
define("ERROR_OK",0);
define("INVALID_VALIDATION_CODE",-1);
define("INVALID_TOKEN",-2);
define("UNKNOWN_USER_OR_SECURITY",-3);
define("INPUT_ERROR",-4);
define("MOBILE_ALREADY_EXIST",-5);
*/

$arr = parse_ini_file("iBus.ini");
/*
$difi_id=$arr["difi_id"];
$difi_sn = $arr["difi_sn"];
$difi_mac = $arr["difi_mac"];
$difi_server = $arr["difi_server"];
*/
$sms_uid = $arr["sms_uid"];
$sms_key = strtoupper(md5($arr["sms_key"]));
?>
