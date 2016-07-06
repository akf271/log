<?php
return array(
	'commonPageLimit' => 5, //通用的分页数
    
    //登陆后跳转地址配置
    "jumpUrlForLogined" => array(
                "rootShop" => "/saccount/thelist",
                "branchShop" => "/consume"
     ),
    
    //支付宝配置
    "alipayConfig" => array(
                "partner" => "2088901940756012",
                "key" => "50kji6md1kxzy7yxipw6rlr395t6741g",
                "seller_email" => "szhh@vip.qq.com",
                "return_url" => "http://".$_SERVER["HTTP_HOST"]."/alipay/returnurl", //页面跳转同步通知页面路径
                "notify_url" => "http://".$_SERVER["HTTP_HOST"]."/alipay/notifyurl"  //异步回调地址
     ),
     
    //银联支付配置
    "chinapayConfig" => array(
    			"version" => "20070129",
                "MerPrKFielpath" => "Data/ChinapayKey_OIEGKE692309#!utwLKDklw/MerPrK.key", //私钥所在文件路径
                "PgPubkFielpath" => "Data/ChinapayKey_OIEGKE692309#!utwLKDklw/PgPubk.key", //公钥所在文件路径
                "return_url" => "http://".$_SERVER["HTTP_HOST"]."/chinapay/returnurl", //页面跳转同步通知页面路径
                "notify_url" => "http://".$_SERVER["HTTP_HOST"]."/chinapay/notifyurl"  //异步回调地址
     ),
     
     //充话费配置
     "consumeConfig" => array(
     			"key" => "CONSUME_HOGEGW289SD098982*ASDO2#GT",  
     			"costRate" => 0.1,    //手续费比例
     			"phoneGetRate" => 3   //话费与钱的换算比例
     ),
    
);
