<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>增加额度_远景代充话费系统</title>
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
<script type="text/javascript" src="/Public/Js/Saccount/distributemoney.js"></script>
</head>

<body style="background:#c4c4c4;">
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
          <li <?php if(($pagetype == 106)): ?>class="active" <?php else: ?>class=""<?php endif; ?>><a href="/consume" style="text-shadow:none">代充话费</a></li>
          <li <?php if(($pagetype == 107)): ?>class="active" <?php else: ?>class=""<?php endif; ?>><a href="/consume/record" style="text-shadow:none">代充话费记录</a></li>
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
        <li><a href="/saccount/thelist"  >子账号管理</a> <span class="divider">/</span></li>
        <li><a style="font-weight:bold" href="javascript:void(0);">增加额度</a></li> <!--<span class="divider">/</span></li>
        <li class="active">Data</li>-->
      </ul>
    </div>
    <div class="content">
      <div class="blank40"></div>
      <div class="alert alert-info"> <br />增加额度账号：<?php echo ($memberInfo["username"]); ?><br />
        <h2>账号余额：<?php echo ($memberInfo["money"]); ?></h2></div>
      <form class="form-horizontal" id="distributeMoneyForm">
      <input type="hidden" name="shopid" value="<?php echo ($shopid); ?>" />
           <div class="control-group">
          <label class="control-label" for="inputmoney">可用分配额度：</label>
          <div class="controls" style="margin-top:5px;">
            <span style="margin-left:10px; color:#D9400B; font-size:14px;"><?php echo ($userInfo["money"]); ?>元</span>
           </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="inputmoney">分配可代充额度：</label>
          <div class="controls">
            <input type="text"  name="money" id="inputmoney" placeholder="分配可代充额度" onkeyup="javascript: var myreg=/^[+]?(([1-9]\d*[.]?)|(0.))(\d{0,2})?$/;if(!myreg.test(this.value)){this.value=''; }; "> 元
            <span class="help-inline help-inline2 " id="moneyTip"></span> </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="inputEmail">验证码： </label>
          <div class="controls"> <img id="verifyImg" onclick="this.src='/public/logicverify/?id='+Math.random()*5;" src="/public/logicverify/" style="cursor:pointer;"><input style=" width:35px; margin-right:5px;" type="text" name="verify" id="inputmoney" placeholder=""><a id="changeVerify" href="javascript:void(0);">看不清换一张</a></div>
        </div>
        <div class="control-group">
          <div class="controls">
            <!--<label class="checkbox">
              <input type="checkbox">
              我已阅读并同意相关服务条款 </label>-->
            <button type="button" id="distributeMoneyFormButton" class="btn">确定增加</button>
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