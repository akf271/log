<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>代充金额分配_远景代充话费系统</title>
<link rel="stylesheet" type="text/css" href="/Public/Css/bootstrap.css"/>
<link rel="stylesheet" type="text/css" href="/Public/Css/bootstrap-responsive.css"/>
<script type="text/javascript" src="/Public/Js/jquery-1.7.2.js"></script>
<script type="text/javascript" src="/Public/Js/bootstrap.js"></script>
<link rel="stylesheet" type="text/css" href="/Public/Css/bootstrap-ie6.css"/>
<link rel="stylesheet" type="text/css" href="/Public/Css/ie.css"/>
<link rel="stylesheet" type="text/css" href="/Public/Css/Fee.css"/>
<script type="text/javascript" src="/Public/Js/artDialog/artDialog.js?skin=blue"></script>
<script src="/Public/Js/artDialog/plugins/iframeTools.js"></script>
<script type="text/javascript" src="/Public/Js/common.js"></script>
<script type="text/javascript" src="/Public/Js/Distributemoney/index.js"></script>
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
        <li><a href="/distributemoney"  style="font-weight:bold">代充金额分配</a> <!--<span class="divider">/</span>--></li>
        <!-- <li><a href="#">Library</a> <span class="divider">/</span></li>
        <li class="active">Data</li>-->
      </ul>
    </div>
    <div class="content">
    <div class="alert alert-info"> <br />
      <h2>账户可用余额：<?php echo ($userInfo["money"]); ?>元</h2><br />
      </div>
      <table class="table table-hover">
        <thead>
          <tr>
            <th class="h20">分店名称</th>
            <th class="h20">用户名</th>
            <th class="h20">负责人</th>
            <th class="h20">电话</th>
            <th class="h20">可用代充额度</th>
            <th class="h20">操作</th>
          </tr>
        </thead>
        <tbody>
          <tr>
                 <?php if(is_array($memberInfo)): $i = 0; $__LIST__ = $memberInfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><tr>
            <td><?php echo ($rootShopName); ?>-<?php echo ($data["shop_name"]); ?></td>
            <td><?php echo ($data["username"]); ?></td>
            <td><?php echo ($data["shop_manager"]); ?></td>
            <td><?php echo ($data["shop_telephone"]); ?></td>
            <td><?php echo ($data["money"]); ?></a> </td>
            <?php if(($data["status"] == 0)): ?><td><a href="/distributemoney/distributemoney/shopid/<?php echo ($data["userid"]); ?>" >增加额度</a>&nbsp;|&nbsp;<a href="/distributemoney/reducebshopmoney/shopid/<?php echo ($data["userid"]); ?>" >减少额度</a> </td><?php else: ?><td>冻结 | <a href="javascript:void(0);" id="startUseUser" shopid="<?php echo ($data["userid"]); ?>">启用</a></td><?php endif; ?>
            
             </td>
          </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        </tbody>
      </table>
     <div class="blank40"></div>
<div class="pagination pagination-centered ">
  <ul>
    <?php echo ($page); ?>
  </ul>
</div>
    </div>
    <div class="blank10"></div>
  </div>
</div>
</body>
</html>