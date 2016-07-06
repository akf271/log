$(document).ready(function(){
	var payNowSelect = "alipay";

	$("#paySubmit").click(function(){		
		$("#payForm").submit();
		
	});

	$("#chinapayLogo").click(function(){
		payNowSelect = "chinapay";
		$("#payForm").attr("action", "/pay/dochinapay");
		$("#chinapayLogo").attr("src", "/Public/Images/Chinapay_logo_active.png");
		$("#alipayLogo").attr("src", "/Public/Images/logo-alipay.png");

	});

	$("#chinapayLogo").mouseover(function(){
		$("#chinapayLogo").attr("src", "/Public/Images/Chinapay_logo_hover.png");
		$("#alipayLogo").attr("src", "/Public/Images/logo-alipay.png");
	});

	$("#chinapayLogo").mouseout(function(){
		if (payNowSelect == "alipay") {
			$("#alipayLogo").attr("src", "/Public/Images/logo-alipay_active.png");
			$("#chinapayLogo").attr("src", "/Public/Images/Chinapay_logo.png");
		} else {
			$("#alipayLogo").attr("src", "/Public/Images/logo-alipay.png");
			$("#chinapayLogo").attr("src", "/Public/Images/Chinapay_logo_active.png");
		}
	});


	$("#alipayLogo").click(function(){
		payNowSelect = "alipay";
		$("#payForm").attr("action", "");
		$("#alipayLogo").attr("src", "/Public/Images/logo-alipay_active.png");
		$("#chinapayLogo").attr("src", "/Public/Images/Chinapay_logo.png");

	});

	$("#alipayLogo").mouseover(function(){
		$("#alipayLogo").attr("src", "/Public/Images/logo-alipay_hover.png");
		$("#chinapayLogo").attr("src", "/Public/Images/Chinapay_logo.png");
	});

	$("#alipayLogo").mouseout(function(){
		if (payNowSelect == "alipay") {
			$("#alipayLogo").attr("src", "/Public/Images/logo-alipay_active.png");
			$("#chinapayLogo").attr("src", "/Public/Images/Chinapay_logo.png");
		} else {
			$("#alipayLogo").attr("src", "/Public/Images/logo-alipay.png");
			$("#chinapayLogo").attr("src", "/Public/Images/Chinapay_logo_active.png");
		}
	});
});

