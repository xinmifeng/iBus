<?php
	/*
	$con = mysql_connect('localhost:3306','root','Roberter@1234');
	if($con){
		mysql_select_db('iBus',$con);	
		$result = mysql_query('select * from user');
		while($row=mysql_fetch_row($result)){
			echo '<p>'
			.$row[0]
			.'_'.$row[1]
			.'_'.$row[2]
			.'_'.$row[3]
			.'</p>';
		}
	}
	else{
		die('connect mysql fail!'.mysql_error());
	}
	*/
	require('common/db.php');
	$db=new DB();
	$result=$db->query('select * from user');
	$arr = mysql_fetch_array($result,1);
	echo json_encode($arr);
	$db->close();
?>
<!Doctype>
<html>
<head>
<title><title>
</head>
<body>
</body>
</html>

