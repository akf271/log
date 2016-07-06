<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>编辑分店信息_远景代充话费系统</title>
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
<script type="text/javascript" src="/Public/Js/Saccount/editbshop.js"></script>
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
        <li><a href="/saccount/thelist"  >子账号管理</a> <span class="divider">/</span></li>
        <li><a style="font-weight:bold" href="javascript:void(0);">编辑分店信息</a></li>
        <!-- <li><a href="#">Library</a> <span class="divider">/</span></li>
        <li class="active">Data</li>-->
      </ul>
    </div>
    <div class="content">
    <div class="blank40"></div>
      <form id="editBshopForm" class="form-horizontal">
      <input type="hidden" name="shopid" value="<?php echo ($shopid); ?>" />
      <input id="phoneId" type="hidden" value="<?php echo ($totalPhoneNum); ?>" name="phoneId">
  <div class="control-group">
    <label class="control-label" for="inputEmail">用户名：</label>
    <div class="controls" style="line-height:30px;">
      <?php echo ($memberInfo["username"]); ?>
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="inputPassword">密码：</label>
    <div class="controls" style="line-height:30px;">
      ******
    </div>
  </div>
  
  <div class="control-group">
    <label class="control-label" for="shopName">分店名称：</label>
    <div class="controls">
      <input type="text" id="shopName" placeholder="分店名称" name="shopName" value="<?php echo ($memberInfo["shop_name"]); ?>"><span class="help-inline help-inline2 " id="shopNameTip"></span>
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="shopManager">负责人：</label>
    <div class="controls">
      <input type="text2" id="shopManager" placeholder="张三" name="shopManager" value="<?php echo ($memberInfo["shop_manager"]); ?>"><span class="help-inline help-inline2 " id="shopManagerTip"></span>
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="shopTelephone">电话：</label>
    <div class="controls">
      <input type="tel" id="shopTelephone" placeholder="0571-88651569" name="shopTelephone" value="<?php echo ($memberInfo["shop_telephone"]); ?>"><span class="help-inline help-inline2 " id="shopTelephoneTip"></span>
    </div>
  </div>
  <!--<div class="control-group">
          <label class="control-label" for="inputmoney">可代充额度：</label>
          <div class="controls">
            <input type="money" id="inputmoney" placeholder="500.00" disabled="disabled">
            <span class=" " style="margin-left:10px;"><a href="/pay">充值</a></span> </div>
        </div>-->
        
       <!-- <div class="control-group">
  	<div style="border-top:#CCC 1px dashed; width:500px; height:10px;"></div>
    <label for="phone1" class="control-label">手机号码：</label>
    <div class="controls"><input type="text" placeholder="手机号码" name="phone1" id="phone1"></div>
  </div>
  <div class="control-group">
    <label for="phone1Mark" class="control-label">备注：</label>
    <div class="controls">
      <input type="text2" placeholder="请填写号码所属人，如：张三" name="phone1Mark" id="phone1Mark">
    </div>
     <div></div>
  </div>-->
        
        
        
        

<?php if(is_array($phoneArr)): $i = 0; $__LIST__ = $phoneArr;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><div class="control-group">
    <div style="border-top:#CCC 1px dashed; width:500px; height:10px;"></div>
    <label for="phone<?php echo ($data["id"]); ?>" class="control-label">手机号码：</label>
    <div class="controls"><input type="text" placeholder="手机号码" name="phone<?php echo ($data["id"]); ?>" id="phone<?php echo ($data["id"]); ?>"  value="<?php echo ($data["phone"]); ?>" /></div>
    </div>
    <div class="control-group">
    <label for="phone<?php echo ($data["id"]); ?>Mark" class="control-label">备注：</label>
    <div class="controls">
      <input type="text" placeholder="请填写号码所属人，如：张三" name="phone<?php echo ($data["id"]); ?>Mark" id="phone<?php echo ($data["id"]); ?>Mark"  value="<?php echo ($data["phoneMark"]); ?>"/>
    </div>
     <div></div>
    </div><?php endforeach; endif; else: echo "" ;endif; ?>
        
        
        
        
  <div class="control-group">
    <div class="controls">
      <!--<label class="checkbox">
        <input type="checkbox">  我已阅读并同意相关服务条款
      </label>-->
      <button type="button" id="editBshopFormButton" class="btn">确定修改</button>
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