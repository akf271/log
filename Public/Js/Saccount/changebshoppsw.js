
$(document).ready(function(){		   
	//更换验证码
	$("#changeVerify").click(function(){
		var verifyImg=document.getElementById("verifyImg");
		var url="/public/logicverify/?id="+Math.random()*5;		
		$("#verifyImg").attr("src", url);
		return false;
    });
	
	$("#inputPassword").blur(function(){
		var password = document.getElementById("inputPassword");
		var passwordConfirm = document.getElementById("inputPasswordConfirm");
		var passwordValue = password.value.dotrim();
		var passwordConfirmValue = passwordConfirm.value.dotrim();
		if (passwordValue.length < 6) {
			document.getElementById("passwordTip").innerHTML = "密码长度不能小于6位";
		} else {
			document.getElementById("passwordTip").innerHTML = "";
		}
		if (passwordValue == passwordConfirmValue) {
			document.getElementById("passwordConfirmTip").innerHTML = "";
		} else {
			document.getElementById("passwordConfirmTip").innerHTML = "两次输入的密码不一致";
		}	
	});

	$("#inputPasswordConfirm").blur(function(){
		var password = document.getElementById("inputPassword");
		var passwordConfirm = document.getElementById("inputPasswordConfirm");
		var passwordValue = password.value.dotrim();
		var passwordConfirmValue = passwordConfirm.value.dotrim();
		if (passwordValue == passwordConfirmValue) {
			document.getElementById("passwordConfirmTip").innerHTML = "";
		} else {
			document.getElementById("passwordConfirmTip").innerHTML = "两次输入的密码不一致";
		}	
	});
	
	$("#changeBshopPswFormButton").click(function() {
		var url = "/saccount/dochangebshoppsw"
		$("#changeBshopPswForm").ajaxSubmit({
			url:url,
			type:"POST",
			success:function(data, st) {
			   if (data.result!=0) {
                   //错误
				    art.dialog({
						lock: true,
						icon: 'error',
						opacity: 0.87,	// 透明度
						content: data.info,
						ok: true
					});
               } else {
				   //成功

				    art.dialog({
						lock: true,
						icon: 'succeed',
						opacity: 0.87,	// 透明度
						content: data.info,
						ok: true,
						ok: function () {
							window.location.href = "/saccount/thelist";
							return false;
						},
					
						close: function () {
							window.location.href = "/saccount/thelist";
							return false;
						},
					});
				   
			   }
			} 
	    });
	});

});


