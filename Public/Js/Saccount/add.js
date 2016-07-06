
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
		var passwordConfirm = document.getElementById("inputpasswordConfirm");
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

	$("#inputpasswordConfirm").blur(function(){
		var password = document.getElementById("inputPassword");
		var passwordConfirm = document.getElementById("inputpasswordConfirm");
		var passwordValue = password.value.dotrim();
		var passwordConfirmValue = passwordConfirm.value.dotrim();
		if (passwordValue == passwordConfirmValue) {
			document.getElementById("passwordConfirmTip").innerHTML = "";
		} else {
			document.getElementById("passwordConfirmTip").innerHTML = "两次输入的密码不一致";
		}	
	});

	$("#inputUserName").blur(function(){
		var username = document.getElementById("inputUserName");
		var usernameValue = username.value.dotrim();
		if (usernameValue.length == 0) {
			document.getElementById("usernameTip").innerHTML = "用户名不能为空";
		}  else {
			document.getElementById("usernameTip").innerHTML = "";
		}
	});

    $("#shopName").blur(function(){
		var shopName = document.getElementById("shopName");
		var shopNameValue = shopName.value.dotrim();
		if (shopNameValue.length == 0) {
			document.getElementById("shopNameTip").innerHTML = "分店名称不能为空";
		}  else {
			document.getElementById("shopNameTip").innerHTML = "";
		}
	});

	$("#shopManager").blur(function(){
		var shopManager = document.getElementById("shopManager");
		var shopManagerValue = shopManager.value.dotrim();
		if (shopManagerValue.length == 0) {
			document.getElementById("shopManagerTip").innerHTML = "负责人不能为空";
		}  else {
			document.getElementById("shopManagerTip").innerHTML = "";
		}
	});

	$("#shopTelephone").blur(function(){
		var shopTelephone = document.getElementById("shopTelephone");
		var shopTelephoneValue = shopTelephone.value.dotrim();
		if (shopTelephoneValue.length == 0) {
			document.getElementById("shopTelephoneTip").innerHTML = "电话不能为空";
		}  else {
			document.getElementById("shopTelephoneTip").innerHTML = "";
		}
	});

	$("#phone").blur(function(){
		var phone = document.getElementById("phone");
		var phoneValue = phone.value.dotrim();
		if (phoneValue.length == 0) {
			document.getElementById("phoneTip").innerHTML = "手机号码不能为空";
		}  else {
			document.getElementById("phoneTip").innerHTML = "";
		}
	});

	$("#money").blur(function(){
		var money = document.getElementById("money");
		var moneyValue = money.value.dotrim();
		if (moneyValue.length == 0) {
			document.getElementById("moneyTip").innerHTML = "金额不能为空";
		}  else {
			document.getElementById("moneyTip").innerHTML = "";
		}
	});

	$("#addFormButton").click(function() {
		$("#addFormButton").attr("disabled","disabled");
		var url = "/saccount/doadd";
		$("#addForm").ajaxSubmit({
			url:url,
			type:"POST",
			success:function(data, st) {
				$("#addFormButton").removeAttr("disabled");
			   if (data.result!=0) {
                   //错误
				    art.dialog({
						lock: true,
						icon: 'error',
						opacity: 0.87,	// 透明度
						content: data.info,
						ok: true,
						ok: function () {
							if((data.backUrl != null) && (data.backUrl != "")) {
								window.location.href = data.backUrl;
							}
							
						},

						close: function () {
							if((data.backUrl != null) && (data.backUrl != "")) {
								window.location.href = data.backUrl;
							}
							
						},
					
						
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
							if((data.backUrl != null) && (data.backUrl != "")) {
								window.location.href = data.backUrl;
							}
							
						},
					
						close: function () {
							if((data.backUrl != null) && (data.backUrl != "")) {
								window.location.href = data.backUrl;
							}
							
						},
					});
				   
			   }
			} 
	    });
	});

	$("#addPhone").click(function() {
		var phoneId = document.getElementById("phoneId");
		var phoneValueInt = phoneId.value = parseInt(phoneId.value) + 1;
		$("#addPhoneDiv").before("<div class=\"control-group\" id=\"phone" + phoneValueInt + "Div\"><div style=\"border-top:#CCC 1px dashed; width:500px; height:10px;\"></div><label for=\"phone" + phoneValueInt + "\" class=\"control-label\">手机号码：</label><div class=\"controls\"><input type=\"text\" placeholder=\"手机号码\" id=\"phone" + phoneValueInt + "\" name=\"phone" + phoneValueInt + "\"></div></div><div class=\"control-group\" id=\"phone" + phoneValueInt + "MarkDiv\"><label for=\"phone" + phoneValueInt + "Mark\" class=\"control-label\">备注：</label><div class=\"controls\"><input type=\"text\" placeholder=\"请填写号码所属人，如：张三\" id=\"phone" + phoneValueInt + "Mark\" name=\"phone" + phoneValueInt + "Mark\"><span class=\"remind\" style=\"margin-left:20px; color:#D9400B\"><a href=\"javascript:void(0);\" onclick=\"delPhone(" + phoneValueInt + ");\">[删除]</a></span> </div><div></div></div>");
	});


	

});

function delPhone(delPhoneId) {
	//alert("delPhoneId:" + delPhoneId);
	//alert("phone" + delPhoneId + "Div");
	document.getElementById("phone" + delPhoneId + "Div").style.display = "none";
	document.getElementById("phone" + delPhoneId + "MarkDiv").style.display = "none";
	document.getElementById("phone" + delPhoneId).value = "";
	document.getElementById("phone" + delPhoneId + "Mark").value = "";

}


