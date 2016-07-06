
$(document).ready(function(){		   
	//更换验证码
	$("#changeVerify").click(function(){
		var verifyImg=document.getElementById("verifyImg");
		var url="/public/logicverify/?id="+Math.random()*5;		
		$("#verifyImg").attr("src", url);
		return false;
    });

    $("#inputmoney").blur(function(){
		var money = document.getElementById("inputmoney");
		var moneyValue = money.value.dotrim();
		if (moneyValue.length == 0) {
			document.getElementById("moneyTip").innerHTML = "金额不能为空";
		}  else {
			document.getElementById("moneyTip").innerHTML = "";
		}
	});
	

	$("#distributeMoneyFormButton").click(function() {
		var url = "/saccount/dodistributemoney"
		$("#distributeMoneyForm").ajaxSubmit({
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
							window.location.href = document.URL;
							return false;
						},
					
						close: function () {
							window.location.href = document.URL;
							return false;
						},
					});
				   
			   }
			} 
	    });
	});

});

