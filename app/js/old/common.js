var reg=/^[A-Za-z0-9]*$/; var str="";

function getValidate() {
	$.ajax({
		type: "POST",
		dataType: "text",
		url: 'validate.php',
		data: 'rand='+Math.random(),
		error: function () {
			alert("服务暂不可用，请稍后再试 0。");
		},
		success: function (msg) {
			$("#code").html(msg);
		}
	});
}