function checkRegister(){
	if($("#mobile").val().length!=11 
	|| !reg.test($("#security").val()) 
		|| isNaN($("#mobile").val()) 
		|| !reg.test($("#validate").val())
		|| ($("#security").val()!= $("#security2").val())
		|| $("#token").val().length!=4 
		|| !reg.test($("#token").val())
	){
		alert("输入错误!");
		return false;
	}
	return true;
}


function register() {
	if(checkRegister()){
		$("#btn_register").attr("disabled",true);

		$.ajax({
			type: "POST",
			dataType: "text",
			url: 'doRegister.php', //访问路径
			data: 'mobile=' + $("#mobile").val()+ "&security=" + $("#security").val() + "&security2=" + $("#security2").val()+"&token="+$("#token").val()+"&validate="+$("#validate").val(), //需要验证的参数
			error: function () {//访问失败时调用的函数
				alert("服务不可用，请稍后再试。");
				$("#btn_register").removeAttr("disabled");
			},
			success: function (msg) {
				if (parseInt(msg)>0) {
					alert("注册成功，请登录。");
					document.location.href = "login.php";
				} else {
					alert("注册失败，请稍候再试。["+msg+"]");
					$("#btn_register").removeAttr("disabled");
				}
			}
		});

	}
}