var server_url="../server/";

var loginModule = angular.module('login',[]);
var user={};
function loginControll($scope,$http){
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
				"tel":user.user_name,
				"pwd":user.password
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
}
