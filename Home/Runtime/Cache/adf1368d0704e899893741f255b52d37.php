<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>充值_远景代充话费系统</title>
<link rel="stylesheet" type="text/css" href="/Public/Css/bootstrap.css"/>
<link rel="stylesheet" type="text/css" href="/Public/Css/bootstrap-responsive.css"/>
<script type="text/javascript" src="/Public/Js/jquery-1.7.2.js"></script>
<script type="text/javascript" src="/Public/Js/bootstrap.js"></script>
<link rel="stylesheet" type="text/css" href="/Public/Css/bootstrap-ie6.css"/>
<link rel="stylesheet" type="text/css" href="/Public/Css/ie.css"/>
<link rel="stylesheet" type="text/css" href="/Public/Css/Fee.css"/>
<script type="text/javascript" src="/Public/Js/jquery.form.js"></script>
<script type="text/javascript" src="/Public/Js/common.js"></script>
<script type="text/javascript" src="/Public/Js/Pay/index.js"></script>
</head>

<body style="background:#c4c4c4;">
<?php if(($stopWebsiteMessage != '') OR ($stopConsumeMessage != '') ): ?><div style=" height:30px; line-height:30px; background:#FFF; text-align:center;">
<font color="#FF0000"><?php echo ($stopWebsiteMessage); ?>  <?php echo ($stopConsumeMessage); ?></font>
</marquee>
<?php else: endif; ?>
</div>
<script type="text/javascript">
function gotoFirstPage() {
	window.location.href="/index";	
}
</script>

<div class="divGlobal margin " style=" box-shadow: 0 0 5px 0 #5F5F5F;">
  <div class="header_top" >
   <ul class="header_top_txt">
      <li>欢迎您，<?php echo ($shopNameDescribe); ?></li>
      <li><a href="/user/logout">[注销]</a></li>
   </ul>
  </div>
  <div class="header_bg" style="padding:30px 0 0 30px"><img style="cursor:pointer;" src="/Public/Images/logo.png" onclick="gotoFirstPage();" /></div>
</div>
<!--
<marquee scrolldelay="150" onmouseover="this.stop()" onmouseout="this.start()">
<font color="#FF0000">话费充值系统将于2013-12-25 12:00:00 进行维护，请做好相关准备。###<?php echo ($stopWebsiteMessage); ?>### @@@<?php echo ($consumeEnableStatus); ?>@@@ ***<?php echo ($stopConsumeMessage); ?>***</font>
</marquee>-->


<div class="divGlobal margin">
  <div class="DivMainLeft">
    <div class="DivFiexWidth">
      <div id="menu">
        <ul class="m_t_20">
          <li class="float_l m_l_20 m_r_20 "><img src="/Public/Images/Picture.png" /></li>
          <li class=" ">
            <h3 style="margin-bottom:-10px;"><?php if(($userInfo["fid"] == 0)): ?>总账号 <?php else: ?>分账号<?php endif; ?></h3>
          </li>
          <li class=""><?php echo ($shopNameDescribe); ?></li>
        </ul>
        <div class="blank10"></div>
        <ul class="nav nav-list" >
         <?php if(($fid == 0)): ?><li <?php if(($pagetype == 101)): ?>class="active" <?php else: ?>class=""<?php endif; ?>><a href="/saccount/thelist">子账号管理</a></li><?php else: endif; ?>

          <?php if(($fid == 0)): ?><li <?php if(($pagetype == 102)): ?>class="active" <?php else: ?>class=""<?php endif; ?>><a href="/distributemoney" style="text-shadow:none">代充金额分配</a></li><?php else: endif; ?>
          <?php if(($fid == 0)): ?><li <?php if(($pagetype == 111)): ?>class="active" <?php else: ?>class=""<?php endif; ?>><a href="/distributemoney/detail" style="text-shadow:none">代充金额分配记录</a></li><?php else: endif; ?>
          <li <?php if(($pagetype == 103)): ?>class="active" <?php else: ?>class=""<?php endif; ?>><a href="/pay" style="text-shadow:none">充值</a></li>
          <li <?php if(($pagetype == 104)): ?>class="active" <?php else: ?>class=""<?php endif; ?>><a href="/pay/record" style="text-shadow:none">充值记录</a></li>
          <?php if(($fid == 0)): ?><li <?php if(($pagetype == 105)): ?>class="active" <?php else: ?>class=""<?php endif; ?>><a href="/pay/bshoprecord" style="text-shadow:none">分店充值记录</a></li><?php else: endif; ?>
          <?php if(($fid != 0)): ?><li <?php if(($pagetype == 112)): ?>class="active" <?php else: ?>class=""<?php endif; ?>><a href="/distributemoney/bshoprecord" style="text-shadow:none">总店拨款记录</a></li><?php else: endif; ?>
          <li <?php if(($pagetype == 106)): ?>class="active" <?php else: ?>class=""<?php endif; ?>><a href="/consume" style="text-shadow:none">充话费</a></li>
          <li <?php if(($pagetype == 107)): ?>class="active" <?php else: ?>class=""<?php endif; ?>><a href="/consume/record" style="text-shadow:none">充话费记录</a></li>
          <?php if(($fid == 0)): ?><li <?php if(($pagetype == 108)): ?>class="active" <?php else: ?>class=""<?php endif; ?>><a href="/consume/bshoprecord" style="text-shadow:none">分店代充话费记录</a></li><?php else: endif; ?>
          <li <?php if(($pagetype == 109)): ?>class="active" <?php else: ?>class=""<?php endif; ?>><a href="/setting" style="text-shadow:none">安全设置</a></li>
           <li <?php if(($pagetype == 110)): ?>class="active" <?php else: ?>class=""<?php endif; ?>><a href="/record/login" style="text-shadow:none">登录日志</a></li>
        </ul>
        <div class="blank10"></div>
      </div>
    </div>
    <div class="DivFiexWidth"  style="background: url(/Public/Images/nav_bg.png) top right no-repeat #c4c4c4; height:10px;"> </div>
  </div>
  <div class="DivMainRight">
    <div class="h80">
      <ul class="breadcrumb ">
        <li class="blank40"></li>
        <li><a style="font-weight:bold" href="/pay">充值</a> </li>

      </ul>
    </div>
    <div class="content">
      <div class="blank40"></div>
      <div class="alert alert-info"> <br />
        充值账号：<?php echo ($userInfo["username"]); ?><br />
        <h2>账号余额：<?php echo ($userInfo["money"]); ?></h2>
      </div>
      <form class="form-horizontal"  method="post" action = "" id="payForm" target=" ">
        <div class="control-group">
          <label class="control-label" for="inputmoney">充值金额：</label>
          <div class="controls">
            <input type="text" name="money" id="inputmoney" placeholder="充值金额" onkeyup="javascript: var myreg=/^[+]?(([1-9]\d*[.]?)|(0.))(\d{0,2})?$/;if(!myreg.test(this.value)){this.value=''; }; " >&nbsp;&nbsp;元
            <!--<span class="help-inline help-inline2 ">出错提示</span>--> </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="inputmoney">充值渠道：</label>
          <div class="controls">
           <label class="checkbox inline">
  <!--<input type="checkbox" id="inlineCheckbox1" value="option1" checked="checked">--><img id="alipayLogo" src="/Public/Images/logo-alipay_active.png" width="125" height="41" />
</label>
 <label class="checkbox inline">
  <!--<input type="checkbox" id="inlineCheckbox1" value="option1" checked="checked">--><img id="chinapayLogo" src="/Public/Images/Chinapay_logo.png" width="125" height="41" />
</label>
          </div>
        </div>
        <div class="control-group">
    <label class="control-label" for="inputEmail"> </label>
    <!--
    <div class="controls">
      <a  href="#" >+添加银行卡</a>
      
    </div>-->
  </div>
 
        <div class="control-group">
          <div class="controls">
          <!--
            <label class="checkbox">
              <input type="checkbox">
              我已阅读并同意相关服务条款 </label>-->
              <input type="hidden" name="doSubmit" value="doSubmit" />
            <button type="button" id="paySubmit" class="btn">充&nbsp;&nbsp;值</button>
          </div>
        </div>
      </form>
      
      <div class="blank40"></div>
    </div>
    <div class="blank10"></div>
  </div>
</div>
</body>
</html>