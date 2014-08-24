var server_url="../server/";

var registerModule = angular.module('register',["ngRoute"]);
function appRouteConfig($routeProvider){
	$routeProvider.when("/",{
		controller:register_one,
		templateUrl:'views/register_getCode.html'
	})
	.when("/checkCode",{
		controller:checkCodeControll,
		templateUrl:'views/register_checkCode.html'
	})
	.when("/register",{
		controller:registerControll,
		templateUrl:'views/register_setPassword.html'
	}).
	otherwise({
		redirectTo:"/"
	});
}
registerModule.config(appRouteConfig);

var user={isok:false};
function register_one($scope,$http){
	$scope.user=user;
	$scope.telChange=function(){
		var btn = document.getElementById("checkbtn");
		if(/^1\d{10}$/.test(user.user_name)){
			btn.style.backgroundColor="#81b73f";
			btn.style.border="1px solid #81b73f";
			$scope.user.isok=true;
		}
		else{
			btn.style.backgroundColor="#c9c9c9";
			btn.style.border="1px solid #c9c9c9";
			$scope.user.isok=false;
		}
	}
	$scope.getCode=function(){
		if(user.isok){
			$http({
				method:"get",
				url:server_url+"register.action.php",
				params:{
					"action":"codeCreate",
					"tel":user.user_name
				}
			}).success(function(data){
				if(data.status===1){
					window.location.href="#checkCode";	
				}
				else{
					alert(data.message);
				}
			});
		}
		else{
			alert("请输入11位手机号码!");
		}
	}
}

user.isCodeOk=false;
function checkCodeControll($scope,$http){
	$scope.user=user;
	$scope.codeChange=function(){
		var btn = document.getElementById("checkbtn");
		if(/^\d{4}$/.test(user.code)){
			btn.style.backgroundColor="#81b73f";
			btn.style.border="1px solid #81b73f";
			$scope.user.isCodeOk=true;
		}
		else{
			btn.style.backgroundColor="#c9c9c9";
			btn.style.border="1px solid #c9c9c9";
			$scope.user.isCodeOk=false;
		}
	}
	$scope.verifyCode=function(){
		if(user.isCodeOk){
			$http({
				method:"get",
				url:server_url+"register.action.php",
				params:{
					"action":"codeVerify",
					"code":user.code
				}
			}).success(function(data){
				if(data.status===1){
					window.location.href="#register";	
				}
				else{
					alert(data.message);
				}
			});
		}
		else{
			alert("请输入手机短信中的验证码!");
		}
	}
}

user.isPwdOk=false;
function registerControll($scope,$http){
	$scope.user=user;
	function check(){
		var pwdOk=false;
		var repwdOk=false;
		var isOk=false;
		if(user.pwd && /^[a-zA-Z0-9]{6,12}$/.test(user.pwd)){
			pwdOk=true;
		}
		if(user.repwd && /^[a-zA-Z0-9]{6,12}$/.test(user.repwd)){
			repwdOk=true;
		}
		if(pwdOk && repwdOk && (user.pwd && user.repwd && user.pwd===user.repwd)){
			isOk=true;
		}
		return isOk;
	}
	$scope.checkChange=function(){
		var btn = document.getElementById("checkbtn");
		if(check()){
			btn.style.backgroundColor="#81b73f";
			btn.style.border="1px solid #81b73f";
			$scope.user.isPwdOk=true;
		}
		else{
			btn.style.backgroundColor="#c9c9c9";
			btn.style.border="1px solid #c9c9c9";
			$scope.user.isPwdOk=false;
		}
	}
	$scope.verifyCode=function(){
		if(user.isPwdOk){
			$http({
				method:"get",
				url:server_url+"register.action.php",
				params:{
					"action":"codeRegist",
					"pwd":user.pwd,
					"repwd":user.repwd
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
		else{
			alert("请输入6~12位的密码与确认密码，并保证一致!");
		}
	}
}
