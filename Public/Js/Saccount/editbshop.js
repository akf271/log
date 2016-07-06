
$(document).ready(function(){		   
	//更换验证码
	$("#changeVerify").click(function(){
		var verifyImg=document.getElementById("verifyImg");
		var url="/public/logicverify/?id="+Math.random()*5;		
		$("#verifyImg").attr("src", url);
		return false;
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

	$("#editBshopFormButton").click(function() {
		var url = "/saccount/doeditbshop"
		$("#editBshopForm").ajaxSubmit({
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
						ok: true,
						ok: function () {
							if (data.backUrl != "") {
								window.location.href = data.backUrl;
							}
						},
					
						close: function () {
							if (data.backUrl != "") {
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


	

});


