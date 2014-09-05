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

$filename = '../../SWFUpload/file/'.$basename;
$min="";

$loseImagestr="<b>此图片不存在</b>";
$loseApkstr="<b>此应用不存在</b>";

$size = filesize($filename);
$fp   = fopen($filename, "rb");

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
		$mim = ($mime = getimagesize($filename)) ? $mime['mime'] : $mime;
	break;
	case "apk":
		$min= "application/vnd.android.package-archive";
	break;
}

header("Content-type: " . $mime);
header("Content-Length: " . $size);
header("Content-Disposition: attachment; filename=" . $basename);
header('Content-Transfer-Encoding: binary');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
fpassthru($fp);

?>
