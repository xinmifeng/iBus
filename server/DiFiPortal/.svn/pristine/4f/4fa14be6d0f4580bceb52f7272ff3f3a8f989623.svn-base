<?php

$mobile=$_POST["mobile"];

$security=$_POST["security"];

$mac=$_POST["mac"];

$difi_id=$_POST["difi_id"];

$ip=$_POST["ip"];

$id=0;

$con=mysqli_connect("192.168.6.66","root","kevin115","difi");

if (mysqli_connect_errno($con)){
       echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$results=mysqli_query($con,"select count(id) from tb_mobile_clients where user='".$mobile."'");

$row=mysqli_fetch_row($results);

if($row[0]==0){

mysqli_query($con,"INSERT INTO tb_mobile_clients(difi_id,internal_ip,user,mac,security,register_date) values('".$difi_id."','".$ip."','".$mobile."','".$mac."','".$security."',now())");

$id=mysqli_insert_id($con);

}

mysqli_close($con);

echo $id;

?>
