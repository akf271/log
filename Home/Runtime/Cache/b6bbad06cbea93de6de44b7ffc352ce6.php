<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>安全设置_远景代充话费系统</title>
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
<script type="text/javascript" src="/Public/Js/Setting/index.js"></script>
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
        <li><a href="/setting"  style="font-weight:bold">安全设置</a> <!--<span class="divider">/</span>--></li>
        <!-- <li><a href="#">Library</a> <span class="divider">/</span></li>
        <li class="active">Data</li>-->
      </ul>
    </div>
    <div class="content">
      <div class="blank40"></div>
      <div class="tabbable"> <!-- Only required for left/right tabs -->
        <ul class="nav nav-tabs">
          <li class="active"><a href="#tab1" data-toggle="tab">修改密码</a></li>
          <li><a href="#tab2" data-toggle="tab">修改手机号码</a></li>
          <li><a href="#tab3" data-toggle="tab">添加手机号码</a></li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="tab1">
            <div class="blank20"></div>
            <p>
            <form id="changePswForm" class="form-horizontal">
              <div class="control-group">
                <label class="control-label" for="changePswFormOldPsw">旧密码：</label>
                <div class="controls">
                  <input type="password" id="changePswFormOldPsw" name="oldPsw" placeholder="旧密码">
                  <span id="changePswFormOldPswTip" class="help-inline help-inline2 "></span> </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="changePswFormNewPsw">新密码：</label>
                <div class="controls">
                  <input type="password" id="changePswFormNewPsw" name="newPsw" placeholder="新密码">
                  <span id="changePswFormNewPswTip" class="help-inline help-inline2 "></span> </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="changePswFormNewPswConfirm">确认新密码：</label>
                <div class="controls">
                  <input type="password" name="newPswConfirm" id="changePswFormNewPswConfirm" placeholder="确认新密码">
                  <span id="changePswFormNewPswConfirmTip" class="help-inline help-inline2 "></span> </div>
              </div>
             <!-- <div class="control-group">
                <label class="control-label" for="inputEmail">验证码： </label>
                <div class="controls"> <img src="/Public/Images/verification.png" />
                  <input style=" width:35px; margin-right:5px;" type="money" id="inputmoney" placeholder="">
                  <a href="">看不清换一张</a></div>
              </div>-->
              <div class="control-group">
                <div class="controls">
                  <button id="changePswFormButton" type="button" class="btn">提交</button>
                </div>
              </div>
            </form>
            </p>
          </div>
          <div class="tab-pane" id="tab2">
            <div class="blank20"></div>
            <p>
            <form id="changePhoneForm" class="form-horizontal">
              <div class="control-group">
                <label class="control-label" for="changePhoneFormOldPhone">当前手机号码：</label>
                <div class="controls">
                  <!--<input type="text" id="changePhoneFormOldPhone" name="oldPhone" placeholder="18000000000">-->
                  <select id="changePhoneFormOldPhone" name="oldPhone">
   <?php if(is_array($phoneArr)): $i = 0; $__LIST__ = $phoneArr;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><option value="<?php echo ($data["phone"]); ?>"><?php echo ($data["phone"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
</select>
                  <ul style="overflow:scroll; height:200px;" aria-labelledby="dLabel" role="menu" class="dropdown-menu">               
                    <li><a href="/consume/bshoprecord/id/44">DDDLLL</a></li><li><a href="/consume/bshoprecord/id/37">abcdefg</a></li><li><a href="/consume/bshoprecord/id/36">43262436</a></li><li><a href="/consume/bshoprecord/id/35">43262436</a></li><li><a href="/consume/bshoprecord/id/33">asdgasd</a></li><li><a href="/consume/bshoprecord/id/32">123523</a></li><li><a href="/consume/bshoprecord/id/30">河东路店</a></li><li><a href="/consume/bshoprecord/id/29">江干店_29</a></li></ul>
                  <!--<span id="changePhoneFormOldPhoneTip" class="help-inline help-inline2 ">--><a id="getSmscode" href="javascript:void(0);">获取短信验证码</a><!--</span>--> </div>
              </div>
              
               <div class="control-group">
                <label class="control-label" for="phoneMark">备注：</label>
                <div class="controls">
                  <input type="text" id="phoneMark" name="phoneMark" placeholder="请填写号码所属人，如张三" value="<?php echo ($phoneMark); ?>">
                  <span id="phoneMarkTip" class="help-inline help-inline2 "></span> </div>
              </div>
              
               <div class="control-group">
                <label class="control-label" for="changePhoneFormSmsCode">短信验证码：</label>
                <div class="controls">
                  <input type="text" id="changePhoneFormSmsCode" name="smsCode" placeholder="短信验证码">
                  <span id="changePhoneFormSmsCodeTip" class="help-inline help-inline2 "></span> </div>
              </div>
               <div class="control-group">
                <label class="control-label" for="changePhoneFormNewPhone">新手机号码：</label>
                <div class="controls">
                  <input type="text" id="changePhoneFormNewPhone" name="newPhone" placeholder="新手机号码">
                  <span id="changePhoneFormNewPhoneTip" class="help-inline help-inline2 "></span> </div>
              </div>
               <div class="control-group"> 
                <label class="control-label" for="changePhoneFormNewPhoneConfirm">确认新手机号码：</label>
                <div class="controls">
                  <input type="text" id="changePhoneFormNewPhoneConfirm" name="newPhoneConfirm" placeholder="确认新手机号码">
                  <span id="changePhoneFormNewPhoneConfirmTip" class="help-inline help-inline2 "></span> </div>
              </div>
              <div class="control-group">
                <div class="controls">
                  <button id="changePhoneFormButton" type="button" class="btn">提交</button>
                </div>
              </div>
            </form>
            </p>
          </div>
          <div class="tab-pane" id="tab3">
          <div class="blank20"></div>
            <p>
            <form id="addPhoneForm" class="form-horizontal">
               <div class="control-group">
                <label class="control-label"  for="addPhoneFormPhone">新手机号码：</label>
                <div class="controls">
                  <input type="text" id="addPhoneFormPhone" name="phone" placeholder="新手机号码">
                  <span id="addPhoneFormPhoneTip" class="help-inline help-inline2 "></span> </div>
              </div>
               <div class="control-group">
                <label class="control-label" for="addPhoneFormPhoneConfirm">确认新手机号码：</label>
                <div class="controls">
                  <input type="text" id="addPhoneFormPhoneConfirm" name="phoneConfirm" placeholder="确认新手机号码">
                  <span id="addPhoneFormPhoneConfirmTip" class="help-inline help-inline2 "></span> </div>
              </div>
                <div class="control-group">
                <label class="control-label" for="phoneMark">备注：</label>
                <div class="controls">
                  <input type="text" id="phoneMark" name="phoneMark" placeholder="请填写号码所属人，如张三">
                  <span id="phoneMarkTip" class="help-inline help-inline2 "></span> </div>
              </div>
              <!--<div class="control-group">
                <label class="control-label" for="inputtext2">备注：</label>
                <div class="controls">
                  <input type="text2" id="inputtext2" placeholder="备注">
                  <span class="help-inline help-inline2 "></span> </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="inputEmail">验证码： </label>
                <div class="controls"> <img src="/Public/Images/verification.png" />
                  <input style=" width:35px; margin-right:5px;" type="money" id="inputmoney" placeholder="">
                  <a href="">看不清换一张</a></div>
              </div>-->
              <div class="control-group">
                <div class="controls">
                  <button id="addPhoneFormButton" type="button" class="btn">提交</button>
                </div>
              </div>
            </form>
            </p>
          </div>
        </div>
      </div>
      <div class="blank40"></div>
    </div>
    <div class="blank10"></div>
  </div>
</div>
</body>
</html>