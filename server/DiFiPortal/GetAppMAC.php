<?php
class GetMacAddr{
	var $retarray = array();
	var $mac_addr;
	function __construct($os_type,$ip){
		switch (strtolower($os_type)){
			case "linux":
				$this->forLinux($ip);
				break;
			case "solaris":
				break;
			case "unix":
				break;
			case "winnt":
				$this->forWindows($ip);
				break;
			default:
				$this->forWindows($ip);
				break;
		}
	}

	function forWindows($ip){
	  	@exec("arp -n",$this->retarray); //执行arp -a命令，结果放到数组$array中
	  	//print_r($array); //打印获取的数组
	  	foreach($this->retarray as $value)
	  	{
	  		if(strpos($value,$ip))
	  		{
	  			$value = explode($ip,$value)[1];
	  			$value = explode("动态",$value)[0];
	  			$this->mac_addr = $value;
	  		}
	  	}

	  }
	  
	function forLinux($ip){
		@exec("arp -n",$this->retarray); //执行arp -a命令，结果放到数组$array中
		//print_r($array); //打印获取的数组
		foreach($this->retarray as $value)
		{
			if(strpos($value,$ip))
			{
				$value = explode("at",$value)[1];
				$value = substr($value, 0,18);
				$this->mac_addr = $value;
			}
		}
	}
}

$mac = new GetMacAddr(PHP_OS,$_SERVER["REMOTE_ADDR"]);
$client_mac = trim($mac->mac_addr);

  
?>