<?php
require_once("SocketClient.class.php");
$mobile=$_POST["mobile"];
$client_mac=trim($_POST["mac"]);
$security=$_POST["security"];
$difi_id=$_POST["difi-id"];
$client_ip=$_POST["ip"];
$zone=substr($difi_id,0,5);


	$fp = fopen("connect/authorization_".date("Y-m-d",time()).".txt", "a");
	fwrite($fp,"[".date("Y-m-d H:i:s")."] ".$mobile."@".$client_mac."@".$client_ip."@".$difi_id." request connect/report \r\n");

//if authorization completed
if(CheckMobile($mobile,$security)>0){
	//send socket to difi-server
	$cmd="<msg from='server' to='".$difi_id."'><cmd>setallow</cmd><user>".$mobile."</user><ip>".$client_ip."</ip><mac>".$client_mac."</mac><rate>-1</rate><data>2048000</data><time>4096000</time><DF><DIP>10.147.6.0/24,192.168.100.40</DIP><rate>200,100</rate><data>100M</data></DF></msg>\r\n";
fwrite($fp,$cmd);
	$bytes=array(2);
	$bytes[0]=2;
	$bytes[1]=0x10;
	//var_dump($bytes);
	$str = "";
	foreach($bytes as $ch) {
		$str .= chr($ch);
	}
	$str = $str.$cmd;
	//echo substr($str,2,strlen($str)-2);
	$_remote = new SocketClient();
	//$_remote->socketInit();
	$_remote->socketInit(GetHostIp($difi_id));
	$_remote->sendMsg($str);
	fwrite($fp,"[".date("Y-m-d H:i:s")."] ".$mobile."@".$client_mac."@".$client_ip." DUMMY bytes,DUMMY seconds @".$difi_id." send request to difi server.\r\n");

	echo 0;	
}else{
	fwrite($fp,"[".date("Y-m-d H:i:s")."] ".$mobile."@".$client_mac."@".$client_ip."@".$difi_id." authorization error.\r\n");
	echo -1;
}

function GetHostIp($_difi_id){
	$host="";
	$con=mysqli_connect("192.168.6.66","root","kevin115","difi");
	if (mysqli_connect_errno($con)){
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	$results = mysqli_query($con,"select server_ip from tb_difi where difi_id='".$_difi_id."'");
	$row=mysqli_fetch_row($results);
	mysqli_close($con);
	return $row[0];
}

function CheckMobile($_mobile,$_security){
        $con=mysqli_connect("192.168.6.66","root","kevin115","difi");
        if (mysqli_connect_errno($con)){
                echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
        $results = mysqli_query($con,"select count(id) from tb_mobile_clients where user='".$_mobile."' and security='".$_security."'");
        $row=mysqli_fetch_row($results);
        mysqli_close($con);
        return $row[0];
}
fclose($fp);

?>
