var server_url="../server/";
if(window.isPreview){
	server_url="../server/mysql/";
}

var loginModule = angular.module('login',[]);
var user={};
var loginControll=['$scope','$http',function($scope,$http){
	if(localStorage["tel"]){
		user.tel=localStorage["tel"];
	}
	$scope.user=user;	
	$scope.login=function(){
		var btn = document.getElementById('loginsub');
		btn.style.backgroundColor="#c9c9c9";
		btn.disabled=true;
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
				var href=window.isPreview?"index_preview.php":"index.php";
				window.location.href=href;	
			}
			else{
				btn.style.backgroundColor="#81b73f";
				btn.disabled=false;
			}
		});
	}
}];
