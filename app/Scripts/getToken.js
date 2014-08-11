var t=60;
var _t;
var _onTimer=false;
function doTimer(){
	if(t>0){
		$("#timer").html("("+(t-1)+"秒)后可重新发送");
		t=t-1;
	}else{
		clearInterval(_t);
		$("#timer").html("<span onClick=\"javascript:getToken();\" onMouseOver=\"this.style.cursor='hand';\">点此获取</span>");
		t=60;
		_onTimer=false;
	}
}

function getToken() {
	if(!_onTimer){
		if($("#mobile").val().length!=11 || isNaN($("#mobile").val())){
			alert("请输入手机号码!");
			return false;
		}
		$.ajax({
			type: "POST",
			dataType: "text",
			url: 'gettoken.php',
			data: 'mobile='+$("#mobile").val(),//+"&validate="+$("#validate").val(),
//			async:false,
			error: function () {
				alert("服务暂不可用，请稍后再试 00。");
			},
			success: function (msg) {
				//$("#url").html(msg);
				if (parseInt(msg)>0) {
					_onTimer=true;
					$("#btn_register").attr("disabled",false);
					_t = self.setInterval("doTimer()", 1000);
				} else{
					alert("用户已存在。["+msg+"]");
				}
			}
		});
	}
}