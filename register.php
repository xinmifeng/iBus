<?php
	ini_set('display_errors','On');
	ini_set('display_errors', true);
	ini_set('html_errors', false);
	error_reporting(E_ALL);

	$a=array(1,2,array('a','b','c'));
	var_dump($a);
	echo('</br>');
	$ar=array(
		"a"=>1,
		"b"=>2
	);
	var_dump($ar);
	echo('</br>');
	echo($ar["b"]);
	unset($ar["a"]);
	echo('</br>');
	var_dump($ar);
	echo('</br>');
	print_r($a);	
	echo('</br></hr>');
	foreach($ar as $i => $value){
		echo($i.'=>'.$value);	
		echo('</br>');
	}
	class A{
		private $a;
		public $b;
	}

	$pa= new A();
	echo('</br>');
	var_dump(array_diff(array(1,2,3,array(1)),array(2,3,4,array(1))));
	echo('</br>');
	$colors=array('red','green','blue','yellow');
	foreach($colors as $color){
		echo "Do yo like $color?\n";
	}
	echo('</br>');

	class profiler{
		function profiler(){
			$this->starttime=microtime();
		}
		static function p(){
			echo '</br>abc';
		}
	}

	$pro = new profiler();
	echo $pro->starttime;
	call_user_func(array('profiler','p'));
	echo '</br>';
	$tpss = function($n){
		return	$n*$n*$n; 
	};
	print_r(array_map($tpss,range(1,5)));
?>
<head>
<meta name="viewport" content="target-densitydpi=device-dpi, width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>+公交无线网关欢迎您(Microunit Co.,Ltd.)+</title>
<script type="text/javascript" src="Scripts/jquery-1.4.1.min.js"></script>
<script type="text/javascript" src="Scripts/common.js"></script>
<script type="text/javascript" src="Scripts/getToken.js"></script>
<script type="text/javascript" src="Scripts/register.js"></script>

</head>

<body onLoad="javascript:getValidate();">

<p>&nbsp;</p>
<table width="100%" border="0" cellspacing="2" cellpadding="0">
  <tr>
    <td align="center" style=" border-bottom-style:dotted; border-color:#036; border-bottom-width:1">
    <table width="80%" border="0" cellspacing="2" cellpadding="0">
      <tr>
        <td><img src="images/Portal_0.png" width="209" height="68"></td>
      </tr>
      <tr>
        <td align="right"><a href="javascript:history.back(-1);">返回</a></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center"><table width="80%" border="0" cellpadding="0" cellspacing="2">
      <tr>
        <td>+手机号码:</td>
        <td><input type="text" name="mobile" id="mobile"></td>
      </tr>
      <tr>
        <td>+登录密码:</td>
        <td><input type="password" name="security" id="security"></td>
      </tr>
      <tr>
        <td>+确认密码:</td>
        <td><input type="password" name="security2" id="security2"></td>
      </tr>
      <tr>
        <td>+短信验证:</td>
        <td><input type="text" name="token" id="token" value="" size="10">
          <div id="timer" style="text-align:center;display: inline;"><span onClick="javascript:getToken();" onMouseOver="this.style.cursor='hand';">点此获取</span></div></td>
      </tr>
	  <!--验证码，防止意外恶意访问-->
      <!--tr>
			<td>+验&nbsp;&nbsp;证&nbsp;&nbsp;码:</td>
          <td><input type="text" name="validate" id="validate" value="" size="10" />
			<font size="5" style=" font-weight:bold; color:#009">
			<div id="code" onClick="javascript:getValidate();" style="cursor:'hand';width:80px;text-align:center;display: inline; border-bottom-style:dotted; border-color:#036; border-bottom-width:1; border-top-style:dotted; border-color:#036; border-top-width:1;border-left-style:dotted; border-color:#036; border-left-width:1;border-right-style:dotted; border-color:#036; border-right-width:1"></div></font>不区分大小写</td>
      </tr-->
      <tr>
        <td colspan="2" align="center"><input id="btn_register" name="btn_register" type="button" disabled value="注册" onClick="javascript:register();"> 
          免责协议</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center"><table width="80%" border="0" cellspacing="2" cellpadding="0">
      <tr>
        <td align="center">Microunit Co.,Ltd.HangZhou·China</td>
      </tr>
    </table></td>
  </tr>
</table>
<?php for($i=0;$i<5;$i++): ?>
	<p>hello,hear!<?php echo $i ?></p>
<?php endfor; ?>
<!--p>&nbsp;</p>
<div id="url"></div-->
</body>
</html>
<script>
	var arr=<?php echo json_encode(array(1,2,3,4,5)); ?>;
</script>
