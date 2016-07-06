
$(document).ready(function(){		   
	//更换验证码
	$("#changeVerify").click(function(){
		var verifyImg=document.getElementById("verifyImg");
		var url="/public/logicverify/?id="+Math.random()*5;		
		$("#verifyImg").attr("src", url);
		return false;
    });

    $("#phoneMoney").keyup(function(){
    	var phoneMoneyValue = $("#phoneMoney").val();
    	var url = "/consume/consumetipsinfo"
		$.get(url, {phoneMoney: phoneMoneyValue},
		function(result){
			var obj = jQuery.parseJSON(result);
			var backResult=obj.result;
			if(backResult=="1"){
				var costRate=obj.costRate;
				var phoneGetRate=obj.phoneGetRate;
				document.getElementById("phoneGetRate").innerHTML = "实际到账金额:" + phoneGetRate;
				document.getElementById("costRate").innerHTML = costRate + "元";
			} else {
				
			}
		});
    });

	$("#phone").blur(function(){
		var phone = document.getElementById("phone");
		var phoneConfirm = document.getElementById("phoneConfirm");
		var phoneValue = phone.value.dotrim();
		var phoneConfirmValue = phoneConfirm.value.dotrim();
		if (phoneValue.length == 0) {
			document.getElementById("phoneTip").innerHTML = "手机号码不能为空";
		} else {
			document.getElementById("phoneTip").innerHTML = "";
		}
		if (phoneValue == phoneConfirmValue) {
			document.getElementById("phoneConfirmTip").innerHTML = "";
		} else {
			if (phoneConfirmValue.length != 0) {
				document.getElementById("phoneConfirmTip").innerHTML = "两次输入手机号不一致";
			}
		}	
	});

	$("#phoneConfirm").blur(function(){
		var phone = document.getElementById("phone");
		var phoneConfirm = document.getElementById("phoneConfirm");
		var phoneValue = phone.value.dotrim();
		var phoneConfirmValue = phoneConfirm.value.dotrim();
		if (phoneValue == phoneConfirmValue) {
			document.getElementById("phoneConfirmTip").innerHTML = "";
		} else {
			if (phoneConfirmValue.length != 0) {
				document.getElementById("phoneConfirmTip").innerHTML = "两次输入手机号不一致";
			}
		}	
	});

    $("#doConsumeFormButton").click(function(){
    	$("#doConsumeFormButton").attr("disabled","disabled");
    	var url = "/consume/doconsume";
		$("#doConsumeForm").ajaxSubmit({
			url:url,
			type:"POST",
			success:function(data, st) {
				$("#doConsumeFormButton").removeAttr("disabled");
			   if (data.result!=0) {
                   //错误
				    art.dialog({
						lock: true,
						icon: 'error',
						opacity: 0.87,	// 透明度
						content: data.info,
						ok: true,
						ok: function () {
							if (data.jumpUrl != "") {
								//window.location.href = data.jumpUrl;
								return false;
							}
						},
						close: function () {
							if (data.jumpUrl != "") {
								//window.location.href = data.jumpUrl;
								return false;
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
							//window.location.href = "/consume/record";
							return false;
						},
					
						close: function () {
							//window.location.href = "/consume/record";
							return false;
						},
					});
				   
			   }
			} 
	    });
    });
	
	

});


