<?php
session_start();
require_once('common.class.php');
if(!isset($_SESSION["user"])){
	echo json_encode(Common::getResult(-1,"用户未登录"));
	exit(0);
}
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
	$DB->where("src_type",$type)->where("user_id",$user_id)->where("src_id",$src_id);
	$history=$DB->getOne("user_history");
	if($DB->count>0){
		if(intval($history["is_like"])===1){
			echo json_encode(Common::getResult(0,"已经喜欢了,不能取消赞"));
			exit(0);
		}
		else{
			$history["is_like"]=1;
			if($DB->where("his_id",$history["his_id"])->update('user_history',$history)){
				$DB->where("v_id",$src_id)->update("video",array("total_like"=>$DB->inc(1)));
				echo json_encode(Common::getResult(1,"已更新"));
				exit(0);
			}
			echo json_encode(Common::getResult(0,"点赞失败"));
			exit(0);
		}
	}
	$history_love=array(
		"user_id"=>$user_id,
		"src_id"=>$src_id,
		"count"=>0,
		"is_like"=>1,
		"src_type"=>$type,
		"create_date"=>$DB->now()
	);
	if($DB->insert("user_history",$history_love)){
		$DB->where("v_id",$src_id)->update("video",array("total_like"=>$DB->inc(1)));
		echo json_encode(Common::getResult(1,"添加成功"));
		exit(0);
	}
	else{
		echo json_encode(Common::getResult(0,"点赞失败"));
		exit(0);
	}
}

if($type==="2" && $action==="2"){
	$DB->where('user_id',$user_id)->where('src_id',$src_id)->where('src_type',$type);
	$history=$DB->getOne('user_history');
	if($DB->count>0){
		$DB->update('user_history',array(
			'count'=>$DB->inc(1),
			'create_date'=>$DB->now()
		));
		if($DB->count>0){
			$DB->where('v_id',$src_id)
			   ->update('video',array(
					'count'=>$DB->inc(1)
				));
			if($DB->count>0){
				echo json_encode(Common::getResult(1,"更新总播放次数成功成功"));
				exit(0);
			}
			else{
				echo json_encode(Common::getResult(0,"更新总播放次数成功失败"));
				exit(0);
			}
		}
		else{
			echo json_encode(Common::getResult(0,"更新用户播放次数失败!"));
			exit(0);
		}
	}
	else{
		$data=array(
			'user_id'=>$user_id,
			'src_id'=>$src_id,
			'count'=>1,
			'is_like'=>0,
			'create_date'=>$DB->now(),
			'src_type'=>$type
		);
		if($DB->insert('user_history',$data)){
			$DB->where('v_id',$src_id);
			$DB->update('video',array(
				'count'=>$DB->inc(1)
			));
			if($DB->count>0){
				echo json_encode(Common::getResult(1,"成功添加播放"));
				exit(0);
			}
			else{
				echo json_encode(Common::getResult(0,"更新播放次数失败"));
				exit(0);
			}
		}
		else{
			echo json_encode(Common::getResult(0,"添加播放记录失败"));
			exit(0);
		}
	}
}
if($type==="1" && $action==="3"){
	$basename=$_GET['file'];
	$filename = '../../../swfupload/file/'.$basename;
	if(!file_exists($filename)){
		echo json_encode(Common::getResult(0,"此图片不存在"));
		exit(0);
	}
	$DB->where('user_id',$user_id)->where('src_id',$src_id)->where('src_type',$type);
	$DB->update('user_history',array(
		'create_date'=>$DB->now()
	));
	if($DB->count>0){
		echo json_encode(Common::getResult(1,"成功更新下载"));
		exit(0);
	}
	else{
		$h=array(
			'user_id'=>$user_id,
			'src_id'=>$src_id,
			'count'=>0,
			'is_like'=>0,
			'create_date'=>$DB->now(),
			'src_type'=>$type
		);
		$DB->insert('user_history',$h);
		if($DB->count>0){
			echo json_encode(Common::getResult(1,"成功添加下载"));
			exit(0);
		}
		else{
			echo json_encode(Common::getResult(0,"添加下载失败"));
			exit(0);
		}
	}
}
?>
