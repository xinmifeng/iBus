

function checkLogin(){
	if($("#mobile").val().length!=11 
		|| !reg.test($("#security").val()) 
		|| isNaN($("#mobile").val())
		|| !reg.test($("#validate").val())
		|| $("#security").val()==""
		){
		alert("输入错误!");
		return false;
	}
	return true;
}



function login(){
	if(checkLogin()){
		$("#btn_login").attr("disabled","true");
		$.ajax({
			type: "POST",
			dataType: "text",
			url: 'doLogin.php',
			data: 'mobile=' + $("#mobile").val()+ "&security=" + $("#security").val()+"&validate="+$("#validate").val(),
			error: function (){
				alert("服务暂不可用，请稍后再试 0。");
			},
			success: function (msg) {
				if(parseInt(msg)==0){
					alert("登录成功!");
				}else{
					alert("登录失败!");
					$("#btn_login").removeAttr("disabled");
				}
			}
		});
	}
}
