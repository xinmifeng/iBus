var server_url="../server/";
var passwordModule = angular.module('password',[]);
var user={};
		
var passwordCtrl=['$scope','$http',function($scope,$http){
	$scope.user=user;
	function check(){
		var reObj={isok:false,msg:''};
		if(!(user.orgpwd && /^[a-zA-Z0-9]{6,12}$/.test(user.orgpwd))){
			reObj.msg="请输入6~12位的原密码!";
			return reObj;
		}
		
		if(!(user.pwd && /^[a-zA-Z0-9]{6,12}$/.test(user.pwd))){
			reObj.msg="请输入6~12位的新密码!";
			return reObj;
		}
		
		if(!(user.repwd && /^[a-zA-Z0-9]{6,12}$/.test(user.repwd))){
			reObj.msg="请输入6~12位的确认密码!";
			return reObj;
		}
		if(!(user.pwd===user.repwd)){
			reObj.msg="新密码与确认密码不匹配!";
			return reObj;
		}
		reObj.isok=true;
		return reObj;
	}

	$scope.checkChange=function(){
		var btn = document.getElementById("checkbtn");
		var checkObj=check();
		if(checkObj.isok){
			btn.style.backgroundColor="#81b73f";
			btn.style.border="1px solid #81b73f";
		}
		else{
			btn.style.backgroundColor="#c9c9c9";
			btn.style.border="1px solid #c9c9c9";
		}
	}

	$scope.modify=function(){
		var checkObj=check();
		if(checkObj.isok){
			$http({
				method:"get",
				url:server_url+"register.action.php",
				params:{
					"action":"modifypwd",
					"orgpwd":user.orgpwd,
					"pwd":user.pwd,
					"repwd":user.repwd
				}
			}).success(function(data){
				if(data.status===1){
					alert(data.message);
					window.location.href="index.php";	
				}
				else{
					alert(data.message);
				}
			});
		}
		else{
			alert(checkObj.msg);
		}
	}

}];
