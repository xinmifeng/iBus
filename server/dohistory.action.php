<?php
session_start();
require_once('common.class.php');
//type 1:活动 2:视频
if(!isset($_GET["type"])){
	echo json_encode(Common::getResult(0,"type参数!"));
	exit(0);
}
//action 1:love 2:播放
if(!isset($_GET["action"])){
	echo json_encode(Common::getResult(0,"action参数!"));
	exit(0);
}
//src_id 活动或视频id
if(!isset($_GET["id"])){
	echo json_encode(Common::getResult(0,"id参数!"));
	exit(0);
}
$user_id=$_SESSION["user"]["id"];
$type=$_GET["type"];
$action=$_GET["action"];
$src_id=$_GET["id"];

require_once("sqlDb.php");
if($type==="2" && $action==="1"){
	$history=Database::select("bee_user_history",'*',array(
		'where'=>array('user_id'=>$user_id,'src_id'=>$src_id),
		'singleRow'=>true
	));
	if($history){
		if(intval($history["is_like"])===1){
			echo json_encode(Common::getResult(0,"已经喜欢了,不能取消赞"));
			exit(0);
		}
		else{
			$history["is_like"]=1;
			if(Database::update('bee_user_history',$history,array('his_id'))){
				$v=Database::select('bee_video','*',array(
					'where'=>array('v_id'=>$src_id),
					'singleRow' => true
				));
				if($v){
					$v["total_like"]=intval($v["total_like"])+1;
					if(Database::update('bee_video',$v,array('v_id'))){
						echo json_encode(Common::getResult(1,"已更新"));
						exit(0);
					}
				}
			}
			echo json_encode(Common::getResult(0,"点赞失败"));
			exit(0);
		}
	}
	$sql="insert into bee_user_history('user_id','src_id','count','is_like','create_date','src_type') values('";
	$sql=$sql.$user_id."','".$src_id."',0,1,datetime('now'),'".$type."')";
	$pdost=Database::sql($sql);
	if($pdost){
		$v=Database::select('bee_video','*',array(
			'where'=>array('v_id'=>$src_id),
			'singleRow' => true
		));
		if($v){
			$v["total_like"]=intval($v["total_like"])+1;
			if(Database::update('bee_video',$v,array('v_id'))){
				echo json_encode(Common::getResult(1,"添加成功"));
				exit(0);
			}
		}
	}
	else{
		echo json_encode(Common::getResult(0,"点赞失败"));
		exit(0);
	}
}
if($type==="2" && $action==="2"){
	$history=Database::select("bee_user_history",'*',array(
		'where'=>array('user_id'=>$user_id,'src_id'=>$src_id),
		'singleRow'=>true
	));
	if($history){
		$history["count"]=intval($history["count"])+1;
		if(Database::update('bee_user_history',$history,array('his_id'))){
			echo json_encode(Common::getResult(1,"成功更新播放"));
			exit(0);
		}
	}
	else{
		$sql="insert into bee_user_history('user_id','src_id','count','is_like','create_date','src_type') values('";
		$sql=$sql.$user_id."','".$src_id."',1,0,datetime('now'),'".$type."')";
		$pdost=Database::sql($sql);
		if($pdost){
			echo json_encode(Common::getResult(1,"成功添加播放"));
			exit(0);
		}
	}
}
?>
