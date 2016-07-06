<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>成功</title>
<link href="/Public/Css/base.css" rel="stylesheet" type="text/css" />
<link href="/Public/Css/login.css" rel="stylesheet" type="text/css" />

</head>
<body>
<span id="jumpUrl" style="display:none"><?php echo ($jumpUrl); ?></span>
<div style="border: 10px solid #b1c3cf; width:500px; height:240px; padding:10px; margin:220px auto 0 auto;">
  <div class="login_reg" style="background:#FFF; width:500px; height:240px;">
    <div class="blank40"></div>
    <div class="blank40"></div>
    <dl class="success" style="width:430px;">
      <dt style="height:100px;"><img src="/Public/Images/success_bg.png" /></dt>
      <dd style="width:270px;color:#64a23d;"><?php echo ($msg); ?>
        <div  class="blank10"></div>
        <span style="color:#999; margin-right:10px;"><span id="secondLeft">5</span>秒自动跳转</span> <a href="<?php echo ($jumpUrl); ?>" title="点击跳转">[点击跳转]</a> </dd>
    </dl>
  </div>
</div>
<script type="text/javascript">
    var timeLeft=5;
	function doJump(){
		window.location=document.getElementById("jumpUrl").innerHTML;
	}
	
	function changeSecondLeft(){
		if(timeLeft>=1){
			timeLeft=timeLeft-1;
		}
		if(timeLeft>=0){
			var secondLeft=document.getElementById("secondLeft");
			secondLeft.innerHTML=timeLeft;
		}
	}
	
	window.setTimeout(function(){ //延迟加载  
		doJump();  
	},5000);
	
	window.setInterval(function(){ //延迟加载  
		changeSecondLeft();  
	},1000);    
</script>
</body>
</html>