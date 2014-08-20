<?php
class SocketClient{

	var $_service_port = 9999;
	var $_address = '192.168.100.177';
	var $_socket = null;

	public function __construct(){
		
	}

	function socketInit($address){
		//´´½¨ TCP/IP socket
		$this->_address=$address;
		$this->_socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
		if ($this->_socket < 0) {
			//echo "socket exception:".socket_strerror($this->_socket)."\n";
			return false;

		} else {

			$result = socket_connect($this->_socket, $this->_address, $this->_service_port);
			if ($result < 0){
				//echo "socket exception:($result)".socket_strerror($result)."\n";
				return false;
			}else{
				if(@socket_read($this->_socket, 255)){
					;
				}
				return true;
			}
		}
	}

	function sendMsg($msg){
		socket_write($this->_socket, $msg, strlen($msg));
		socket_close($this->_socket);
	}

}
?>