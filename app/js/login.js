var server_url="../server/mysql/";

var loginModule = angular.module('login',[]);
var user={};
var loginControll=['$scope','$http',function($scope,$http){
	if(localStorage["tel"]){
		user.tel=localStorage["tel"];
	}
	$scope.user=user;	
	$scope.login=function(){
		localStorage["tel"]=user.user_name;
		$http({
			method:"get",
			url:server_url+"login.action.php",
			params:{
				"tel":user.user_name || document.getElementById("tb_tel").value || undefined,
				"pwd":user.password || document.getElementById("tb_pwd").value || undefined
			}
		}).success(function(data){
			if(data.status===1){
				window.location.href="index.php";	
			}
			else{
				alert(data.message);
			}
		});
	}
}];
