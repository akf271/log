<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>后台登录</title>
<link rel="stylesheet" type="text/css" href="/Public/Css/bootstrap.css"/>
<link rel="stylesheet" type="text/css" href="/Public/Css/bootstrap-responsive.css"/>
<script type="text/javascript" src="/Public/Js/jquery-1.7.2.js"></script>
<script type="text/javascript" src="/Public/Js/bootstrap.js"></script>
<link rel="stylesheet" type="text/css" href="/Public/Css/bootstrap-ie6.css"/>
<link rel="stylesheet" type="text/css" href="/Public/Css/ie.css"/>
<link rel="stylesheet" type="text/css" href="/Public/Css/Fee.css"/>
<script type="text/javascript" src="/Public/Js/artDialog/artDialog.js?skin=blue"></script>
<script type="text/javascript" src="/Public/Js/jquery.form.js"></script>
<script type="text/javascript" src="/Public/Js/common.js"></script>
<script type="text/javascript" src="/Public/Js/User/login.js"></script>
</head>
<body style="background: url(/Public/Images/login_bg.jpg) top center no-repeat #004259;">
<?php echo ($onedayLoginActiveStatus); ?>
<div style="width:900px; margin:190px auto">
	<form  id="loginForm" class="form-horizontal" style="background:#f6fafb; width:485px; margin-left:315px;
  box-shadow: 0px 0px 10px 0px rgb( 5, 38, 52 );
  z-index: 16;">
    <div style="background:url(/Public/Images/login_title.jpg); height:50px; text-align:center; line-height:50px; color:#fff;font-size:20px;">管理后台登录</div>
    <div class="blank10"></div>
 <div class="control-group" style="margin-bottom:10px;">
    <label class="control-label" for="inputEmail"></label>
    <div id="loginInfo" class="controls"  style="color:#ee5238">
     <!--提示-->
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="inputUsername">用户名：</label>
    <div class="controls">
      <input type="text" name="username" id="inputUsername" placeholder="用户名">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="inputPassword">密码：</label>
    <div class="controls">
      <input type="password" name="password" id="inputPassword" placeholder="密码">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="phone">手机号码：</label>
    <div class="controls">
      <input type="text" name="phone" id="phone" placeholder="手机号码"  ><a id="getSmscode" href="javascript:void(0);" style="margin-left:10px;">获取验证码</a>
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="smsCode">手机验证码：</label>
    <div class="controls">
      <input name="smscode" type="text" id="smsCode" placeholder="手机验证码"  >
    </div>
  </div>
  <div class="control-group">
    <div class="controls">
      <label class="checkbox">
        <input type="checkbox" name="onedaylogin" id="onedaylogin" value="1"> 
        24小时内免输入手机验证码
      </label>
      <button type="button" id="doLogin" class="btn">登 &nbsp;&nbsp;录</button>
    </div>
    <div class="blank20"></div>
  </div>
</form>

</div>
</body>
</html>