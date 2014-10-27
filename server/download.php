<?php
if(empty($_GET['name'])) {
	header("HTTP/1.0 404 Not Found");
	return;
}

if(empty($_GET['type'])) {
	header("HTTP/1.0 404 Not Found");
	return;
}

$type=$_GET["type"];
$basename=$_GET['name'];
#$filename = '../../swfupload/file/'.$basename;
#$filename = 'http://m.lelewifi.com/swfupload/file/'.$basename;

function getAbsolutePath($name=''){
	$picPath='/mnt/data/dificache/';
	$basePath='http://m.lelewifi.com/swfupload/file/';
	if(!$name) return false;
	$md5=md5($basePath.$name);
	$pstr=substr($md5,-3);
	return $picPath.$pstr[2].'/'.$pstr[1].'/'.$pstr[0].'/'.$md5;
}

$filename = getAbsolutePath($basename);

$min="";

$loseImagestr="<b>此图片不存在</b>+++";
$loseApkstr="<b>此应用不存在</b>";

$size = filesize($filename);
$fp  =  @fopen($filename, "rb");

if(!(file_exists($filename) && $size && $fp)){
	switch($type){		
		case "image":
			echo $loseImagestr;
		break;
		case "apk":
			echo $loseApkstr;
		break;
	}
	exit(0);
}

switch($type){
	case "image":
		$min = ($mime = getimagesize($filename)) ? $mime['mime'] : $mime;
	break;
	case "apk":
		$min= "application/vnd.android.package-archive";
	break;
}

@header("Cache-Control: ");
@header("Pragma: ");
@header("Content-Type: " . $min);
@header("Content-Length: " . $size);
@header("Content-Disposition: attachment; filename=\"" . $basename . "\"");
@header('Content-Transfer-Encoding: binary');
ob_end_clean();
@fpassthru($fp);
?>
