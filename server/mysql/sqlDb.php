<?php
require ("MysqliDb.php");
//$DB = new Mysqlidb('192.168.1.106', 'root', 'Roberter@1234', 'iBus');
//$DB = new Mysqlidb('localhost', 'root', 'Roberter@1234', 'busfree');
$DB = new Mysqlidb('192.168.1.101', 'root', 'root', 'busfree');
if(!$DB) die("Database error");

$prefix = 'bee_';
$DB->setPrefix($prefix);

?>
