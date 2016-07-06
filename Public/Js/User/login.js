
$(document).ready(function(){		   
	$("#doLogin").click(function(){
		document.getElementById("loginInfo").innerHTML = "";
		var url = "/user/dologin"
		$("#loginForm").ajaxSubmit({
			url:url,
			type:"POST",
			success:function(data, st) {
			   if (data.result!=0) {
                   //alert("错误:" + data.info);
				   document.getElementById("loginInfo").innerHTML = data.info;
               } else {
				   //alert("成功:" + data.info);  
				   window.location.href = data.backUrl;
			   }
			} 
	    });
	});
	
	$("#inputUsername").blur(function(){
		var username = $("#inputUsername").val();
		var checkUrlBase="/user/checkuseronedayloginstatus";
		$.get(checkUrlBase, { username: username},
		function(result){
			var obj = jQuery.parseJSON(result);
			var backResult=obj.result;
			if(backResult == 1){
				//该账号24小时内免手机验证码就可以进行登录
				document.getElementById("phone").disabled = true;
				document.getElementById("smsCode").disabled = true;
				document.getElementById("getSmscode").style.display="none";
				document.getElementById("loginInfo").innerHTML = "该账号不需要手机验证";
			}else {
				document.getElementById("phone").disabled = false;
				document.getElementById("smsCode").disabled = false;
				document.getElementById("getSmscode").style.display="inline";
				document.getElementById("loginInfo").innerHTML = "";
			}
		});
	});
	
	//获取短信验证码
	$("#getSmscode").click(function(){
		var username = $("#inputUsername").val();
		var password = $("#inputPassword").val();
		var phone = $("#phone").val();
		var getSmscodeUrlBase="/smscodeuserinfo/getsmscode/";
		$.get(getSmscodeUrlBase, { phone: phone, username: username, password: password},
		function(result){
			if(result=="1"){
				document.getElementById("loginInfo").innerHTML = "";
				art.dialog({
					lock: true,
					icon: 'succeed',
					opacity: 0.87,	// 透明度
					content: '短信验证码已经发送到你的手机，请查收，5分钟内有效!',
					ok: true
				});
			}else if(result=="2"){
				document.getElementById("loginInfo").innerHTML = "手机号码格式错误!";
			}else if(result=="3"){
				//alert("你还没有登录，请先登录再进行认证!");
				//window.location.href="/member";
			}else if(result=="4"){
				document.getElementById("loginInfo").innerHTML = "你上次获取验证码时间小于5分钟，请5分钟后再来获取!";
			}else if(result=="5"){
				//alert("你今天已经连续3次获取，不能继续获取，请明天再来获取!");
			}else if(result=="6"){
				//alert("该手机号码已被使用!");
			}else if(result=="7"){
				document.getElementById("loginInfo").innerHTML = "系统故障，获取短信验证码失败，请稍后重试!";
			}else if(result=="0"){
				document.getElementById("loginInfo").innerHTML = "系统故障，获取短信验证码失败，请稍后重试!";
			} else if(result=="101") {
				document.getElementById("loginInfo").innerHTML = "用户名或密码错误";
			} else if(result=="102") {
				document.getElementById("loginInfo").innerHTML = "该账号不能用这个手机号进行验证";
			} else if(result=="103") {
				document.getElementById("loginInfo").innerHTML = "用户名不能为空";
			} else if(result=="104") {
				document.getElementById("loginInfo").innerHTML = "密码不能为为空";
			} else if(result=="105") {
				document.getElementById("loginInfo").innerHTML = "密码长度不能小于6位";
			} else if(result=="106") {
				document.getElementById("loginInfo").innerHTML = "手机号不能为空";
			} else if(result=="107") {
				document.getElementById("loginInfo").innerHTML = "该账号已停用，如有疑问，请联系总店管理员";
			} else if(result=="108") {
				document.getElementById("loginInfo").innerHTML = "因总账号被停用，该账号也被停用";
			}
		});
	});
	

});


document.onkeydown = function(e){
	var ev = document.all ? window.event : e;
	if(((ev.ctrlKey)&&(ev.keyCode==67))||((ev.ctrlKey)&&(ev.keyCode==88))||((ev.ctrlKey)&&(ev.keyCode==86))||((ev.ctrlKey)&&(ev.keyCode==65) )) {
		var focusId = document.activeElement.id;
		if (focusId == 'password') {
			document.getElementById("password").value = "";	
		}
	}
}