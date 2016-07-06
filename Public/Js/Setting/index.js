
$(document).ready(function(){	
	
	//修改密码	   
	$("#changePswFormButton").click(function(){
		//alert("修改密码");
		var url = "/setting/dochangepsw"
		$("#changePswForm").ajaxSubmit({
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
							window.location.href = data.backUrl;
						},
					
						close: function () {
							window.location.href = data.backUrl;
						},
					});
			   }
			} 
	    });
	});

	//修改手机号
	$("#changePhoneFormButton").click(function(){
		$('#inputtel').after('content'); 
		var url = "/setting/dochangephone"
		$("#changePhoneForm").ajaxSubmit({
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
						},
						close: function () {
							window.location.href = "/saccount/thelist";
						},
					});
			   }
			} 
	    });
	});

	//增加手机号
	$("#addPhoneFormButton").click(function(){
		var url = "/setting/doaddphone"
		$("#addPhoneForm").ajaxSubmit({
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
						},
						close: function () {
							window.location.href = "/saccount/thelist";
						},
					});
			   }
			} 
	    });
	});
	
	
	$("#changePswFormOldPsw").blur(function(){
		var oldPswValue = $("#changePswFormOldPsw").val().dotrim();
		if (oldPswValue.length < 6) {
			document.getElementById("changePswFormOldPswTip").innerHTML = "密码长度不能小于6位";
			//document.getElementById("changePswFormOldPsw").focus();
		} else {
			document.getElementById("changePswFormOldPswTip").innerHTML = "";
		}
		
	});

	$("#changePswFormNewPsw").blur(function(){
		var newPsw = document.getElementById("changePswFormNewPsw");
		var newPswConfirm = document.getElementById("changePswFormNewPswConfirm");
		var newPswValue = newPsw.value.dotrim();
		var newPswConfirmValue = newPswConfirm.value.dotrim();
		if (newPswValue.length < 6) {
			document.getElementById("changePswFormNewPswTip").innerHTML = "密码长度不能小于6位";
			//newPsw.focus();
		} else {
			document.getElementById("changePswFormNewPswTip").innerHTML = "";
		}
		if (newPswValue == newPswConfirmValue) {
			document.getElementById("changePswFormNewPswConfirmTip").innerHTML = "";
		}
	});

	$("#changePswFormNewPswConfirm").blur(function(){
		var newPsw = document.getElementById("changePswFormNewPsw");
		var newPswConfirm = document.getElementById("changePswFormNewPswConfirm");
		var newPswValue = newPsw.value.dotrim();
		var newPswConfirmValue = newPswConfirm.value.dotrim();
		if (newPswValue == newPswConfirmValue) {
			document.getElementById("changePswFormNewPswConfirmTip").innerHTML = "";
		} else {
			document.getElementById("changePswFormNewPswConfirmTip").innerHTML = "两次输入密码不一致";
		}		
	});

	$("#changePhoneFormSmsCode").blur(function(){
		if ($("#changePhoneFormSmsCode").val().dotrim().length == 0) {
			document.getElementById("changePhoneFormSmsCodeTip").innerHTML = "请输入手机验证码";
		} else {
			document.getElementById("changePhoneFormSmsCodeTip").innerHTML = "";
		}
	});

	$("#changePhoneFormNewPhone").blur(function(){
		var newPhone = document.getElementById("changePhoneFormNewPhone");
		var newPhoneConfirm = document.getElementById("changePhoneFormNewPhoneConfirm");
		var newPhoneValue = newPhone.value.dotrim();
		var newPhoneConfirmValue = newPhoneConfirm.value.dotrim();
		if (newPhoneValue.length == 0) {
			document.getElementById("changePhoneFormNewPhoneTip").innerHTML = "手机号码不能为空";
			//newPhone.focus();
		} else {
			document.getElementById("changePhoneFormNewPhoneTip").innerHTML = "";
		}
		if (newPhoneValue == newPhoneConfirmValue) {
			document.getElementById("changePhoneFormNewPhoneConfirmTip").innerHTML = "";
		}
	});

	$("#changePhoneFormNewPhoneConfirm").blur(function(){
		var newPhone = document.getElementById("changePhoneFormNewPhone");
		var newPhoneConfirm = document.getElementById("changePhoneFormNewPhoneConfirm");
		var newPhoneValue = newPhone.value.dotrim();
		var newPhoneConfirmValue = newPhoneConfirm.value.dotrim();
		if (newPhoneValue == newPhoneConfirmValue) {
			document.getElementById("changePhoneFormNewPhoneConfirmTip").innerHTML = "";
		} else {
			document.getElementById("changePhoneFormNewPhoneConfirmTip").innerHTML = "两次输入手机号码不一致";
		}	
	});

	$("#addPhoneFormPhone").blur(function(){
		var phone = document.getElementById("addPhoneFormPhone");
		var phoneConfirm = document.getElementById("addPhoneFormPhoneConfirm");
		var phoneValue = phone.value.dotrim();
		var phoneConfirmValue = phoneConfirm.value.dotrim();
		if (phoneValue.length == 0) {
			document.getElementById("addPhoneFormPhoneTip").innerHTML = "手机号码不能为空";
			//phone.focus();
		} else {
			document.getElementById("addPhoneFormPhoneTip").innerHTML = "";
		}
		if (phoneValue == phoneConfirmValue) {
			document.getElementById("addPhoneFormPhoneConfirmTip").innerHTML = "";
		} 
	});

	$("#addPhoneFormPhoneConfirm").blur(function(){
		var phone = document.getElementById("addPhoneFormPhone");
		var phoneConfirm = document.getElementById("addPhoneFormPhoneConfirm");
		var phoneValue = phone.value.dotrim();
		var phoneConfirmValue = phoneConfirm.value.dotrim();
		if (phoneValue == phoneConfirmValue) {
			document.getElementById("addPhoneFormPhoneConfirmTip").innerHTML = "";
		} else {
			document.getElementById("addPhoneFormPhoneConfirmTip").innerHTML = "两次输入手机号码不一致";
		}	
	});


	//获取短信验证码
	$("#getSmscode").click(function(){;
		var phone=document.getElementById("changePhoneFormOldPhone");
			if(!(/^1[3|4|5|8][0-9]\d{8}$/.test(phone.value))){
			art.dialog({
						lock: true,
						icon: 'succeed',
						opacity: 0.87,	// 透明度
						content: '手机号码不正确',
						ok: true
					});
			return false;
		} 
		
		var getSmscodeUrlBase="/smscode/getsmscode/";
		$.get(getSmscodeUrlBase, { phone: phone.value},
		function(result){
			if(result=="1"){
				//alert("短信验证码已经发送到你的手机，请查收，5分钟内有效!");
				art.dialog({
					lock: true,
					icon: 'succeed',
					opacity: 0.87,	// 透明度
					content: '短信验证码已经发送到你的手机，请查收，5分钟内有效!',
					ok: true
				});	
			}else if(result=="2"){
				//alert("手机号码格式错误!");
				art.dialog({
					lock: true,
					icon: 'error',
					opacity: 0.87,	// 透明度
					content: '手机号码格式错误!',
					ok: true
				});	
			}else if(result=="3"){
				//alert("你还没有登录，请先登录再进行认证!");
				//window.location.href="/member";
			}else if(result=="4"){
				//alert("你上次获取验证码时间小于5分钟，请5分钟后再来获取!");
				art.dialog({
					lock: true,
					icon: 'error',
					opacity: 0.87,	// 透明度
					content: '你上次获取验证码时间小于5分钟，请5分钟后再来获取!',
					ok: true
				});	
			}else if(result=="5"){
				//alert("你今天已经连续3次获取，不能继续获取，请明天再来获取!");
			}else if(result=="6"){
				//alert("该手机号码已被使用!");
			}else if(result=="7"){
				//alert("系统故障，获取短信验证码失败，请稍后重试!");
				art.dialog({
					lock: true,
					icon: 'error',
					opacity: 0.87,	// 透明度
					content: '系统故障，获取短信验证码失败，请稍后重试!',
					ok: true
				});	
			}else if(result=="0"){
				//alert("系统故障，获取短信验证码失败，请稍后重试!");
				art.dialog({
					lock: true,
					icon: 'error',
					opacity: 0.87,	// 透明度
					content: '系统故障，获取短信验证码失败，请稍后重试!',
					ok: true
				});	
			}
		});
	});

	$("#changePhoneFormOldPhone").change(function() {
		var phoneValue = $("#changePhoneFormOldPhone").val();
		var UrlBase="/setting/getphonemark/";
		$.get(UrlBase, { phone: phoneValue},
		function(result){
			var obj = jQuery.parseJSON(result);
			var backResult=obj.result;
			var phoneMark = obj.phoneMark;
			if(backResult=="found"){
				//找到了该分店
				document.getElementById("phoneMark").value = phoneMark;
			}else{
				art.dialog({
					lock: true,
					icon: 'error',
					opacity: 0.87,	// 透明度
					content: "该手机号码记录不存在，不能进行修改",
					ok: true,
					ok: function () {
						window.location.href = "/setting";
					},
					close: function () {
						window.location.href = "/setting";
					},
				});
			}
		});
	});

});


