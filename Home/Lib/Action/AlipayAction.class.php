<?php
class AlipayAction extends CommonAction{
    public function index(){
        echo "";
    }
    
    //构建提交表单
    public function alipayTo(){
    	$this->recodePostData("Data/Alipay/alipayto/alipay_".date("Y-m-d").".txt");
        $alipayConfig = C("alipayConfig");
        include VENDOR_PATH.'alipayLib/alipay.config.php';
        include VENDOR_PATH.'alipayLib/lib/alipay_service.class.php';
        
        //请与贵网站订单系统中的唯一订单号匹配
        $out_trade_no = trim($_POST["order_id"]);
        $money=trim($_POST["money"]);
        $userid = trim($_POST["userid"]);
                
        
        /**************************请求参数**************************/
        
        //必填参数//
        
        
        //订单名称，显示在支付宝收银台里的“商品名称”里，显示在支付宝的交易管理的“商品名称”的列表里。
        //$subject      = $_POST['subject'];
        
        $subject      = "远景话费代充系统账号充值[".$money."元]";
        
        //订单描述、订单详细、订单备注，显示在支付宝收银台里的“商品描述”里
        //$body         = $_POST['body'];
        $body         = "远景话费代充系统账号充值[".$money."元]";
        //订单总金额，显示在支付宝收银台里的“应付总额”里
        //$total_fee    = $_POST['total_fee'];
        $total_fee    = $money;
        
        //扩展功能参数——默认支付方式//
        
        //默认支付方式，取值见“即时到帐接口”技术文档中的请求参数列表
        $paymethod    = '';
        //默认网银代号，代号列表见“即时到帐接口”技术文档“附录”→“银行列表”
        $defaultbank  = '';
        
        
        //扩展功能参数——防钓鱼//
        
        //防钓鱼时间戳
        $anti_phishing_key  = '';
        //获取客户端的IP地址，建议：编写获取客户端IP地址的程序
        $exter_invoke_ip = '';
        //注意：
        //1.请慎重选择是否开启防钓鱼功能
        //2.exter_invoke_ip、anti_phishing_key一旦被使用过，那么它们就会成为必填参数
        //3.开启防钓鱼功能后，服务器、本机电脑必须支持SSL，请配置好该环境。
        //示例：
        //$exter_invoke_ip = '202.1.1.1';
        //$ali_service_timestamp = new AlipayService($aliapy_config);
        //$anti_phishing_key = $ali_service_timestamp->query_timestamp();//获取防钓鱼时间戳函数
        
        
        //扩展功能参数——其他//
        
        //商品展示地址，要用 http://格式的完整路径，不允许加?id=123这类自定义参数
        $show_url			= '';
        
        //自定义参数，可存放任何内容（除=、&等特殊字符外），不会显示在页面上
        $extra_common_param = '';
        
        //扩展功能参数——分润(若要使用，请按照注释要求的格式赋值)
        $royalty_type		= "";			//提成类型，该值为固定值：10，不需要修改
        $royalty_parameters	= "";
        //注意：
        //提成信息集，与需要结合商户网站自身情况动态获取每笔交易的各分润收款账号、各分润金额、各分润说明。最多只能设置10条
        //各分润金额的总和须小于等于total_fee
        //提成信息集格式为：收款方Email_1^金额1^备注1|收款方Email_2^金额2^备注2
        //示例：
        //royalty_type 		= "10"
        //royalty_parameters= "111@126.com^0.01^分润备注一|222@126.com^0.01^分润备注二"
        
        /************************************************************/
        
        //构造要请求的参数数组
        $parameter = array(
        		"service"			=> "create_direct_pay_by_user",
        		"payment_type"		=> "1",
        
        		"partner"			=> trim($aliapy_config['partner']),
        		"_input_charset"	=> trim(strtolower($aliapy_config['input_charset'])),
                "seller_email"		=> trim($aliapy_config['seller_email']),
                "return_url"		=> trim($aliapy_config['return_url']),
                "notify_url"		=> trim($aliapy_config['notify_url']),
        
        		"out_trade_no"		=> $out_trade_no,
        		"subject"			=> $subject,
        		"body"				=> $body,
        		"total_fee"			=> $total_fee,
        
        		"paymethod"			=> $paymethod,
        		"defaultbank"		=> $defaultbank,
        
        		"anti_phishing_key"	=> $anti_phishing_key,
        		"exter_invoke_ip"	=> $exter_invoke_ip,
        
        		"show_url"			=> $show_url,
        		"extra_common_param"=> $extra_common_param,
        
        		"royalty_type"		=> $royalty_type,
        		"royalty_parameters"=> $royalty_parameters
        );
  
        //构造即时到帐接口
        $alipayService = new AlipayService($aliapy_config);
        $html_text = $alipayService->create_direct_pay_by_user($parameter);
        echo $html_text;
    }
    
    //充值同步跳转
    public function returnUrl(){
        $this->display("returnUrl");
    }
    
    //异步回调
    public function notifyUrl(){
        $alipayConfig = C("alipayConfig");
        include VENDOR_PATH.'alipayLib/alipay.config.php';
        include VENDOR_PATH.'alipayLib/lib/alipay_notify.class.php';
        
        //计算得出通知验证结果
        $alipayNotify = new AlipayNotify($aliapy_config);
        $verify_result = $alipayNotify->verifyNotify();
        
        //测试记录
        $out_trade_no	= $_POST['out_trade_no'];	    //获取订单号
        $trade_no		= $_POST['trade_no'];	    	//获取支付宝交易号
        $total_fee		= $_POST['total_fee'];			//获取总价格
    	$orderid=trim($out_trade_no);
    	
    	$strToWrite="\r\n\r\n\r\n时间: ".date("Y-m-d H:i:s")."\r\n订单号: ".$out_trade_no."\r\n支付宝交易号: ".$trade_no."\r\n支付金额: ".$total_fee;
    	$dateFilePath = "Data/Alipay/origin/alipay_".date("Y-m-d").".txt";
    	$fp = fopen($dateFilePath,"a+");
    	flock($fp, LOCK_EX);
    	fwrite($fp, $strToWrite);
    	fclose($fp);

    	if($verify_result) {//验证成功
        	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        	//请在这里加上商户的业务逻辑程序代
        
        	//——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
            //获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表
            $out_trade_no	= $_POST['out_trade_no'];	    //获取订单号
            $trade_no		= $_POST['trade_no'];	    	//获取支付宝交易号
            $total_fee		= $_POST['total_fee'];			//获取总价格
        	$orderid=trim($out_trade_no);
        	
        	$strToWrite="\r\n\r\n\r\n时间: ".date("Y-m-d H:i:s")."\r\n订单号: ".$out_trade_no."\r\n支付宝交易号: ".$trade_no."\r\n支付金额: ".$total_fee;
        	$dateFilePath = "Data/Alipay/success/alipay_".date("Y-m-d").".txt";
    	    $fp = fopen($dateFilePath,"a+");
        	flock($fp, LOCK_EX);
        	fwrite($fp, $strToWrite);
        	fclose($fp);
			
        	$time = time();
            if($_POST['trade_status'] == 'TRADE_FINISHED') {
        		$PayDbLink = M("Pay");
        		$PayInfo = $PayDbLink->where("order_id=\"".$orderid."\" and pay_status=1")->limit(1)->select();
        		$userId = trim($PayInfo[0]["userid"]);
        		if(($userId!=NULL)){
            		$data = array();//初始化
            		$data["pay_status"] = 2;
            		$PayUpdateResult = $PayDbLink->where("order_id=\"".$orderid."\"  and pay_status=1")->save($data);
            		if(($PayUpdateResult!=false)&&($PayUpdateResult!=0)){
            		    //给用户账号加钱
            		    $Member = M("Member");
            		    $userUpdateResult = $Member->where("userid=".$userId)->setInc("money", $total_fee);
            		    if(($userUpdateResult!=false)&&($userUpdateResult!=0)){
            		        //给用户加钱成功，修改充值状态
            		        $data = array();
            		        $data["pay_status"] = 3;
            		        $data["pay_finish_time"] = $time;
            		        $PayDbLink->where("order_id=\"".$orderid."\" and pay_status=2")->save($data);
            		        
            		        //给金额变化表加记录
            		        $MoneyChangeDetail = M("MoneyChangeDetail");
            		        $data = array();
            		        $data["userid"] = $userId;
            		        $data["money"] = $total_fee;
            		        $data["change_type"] = 1;
            		        $data["change_reason"] = 1;
            		        $data["phone"] = "";
            		        $data["time"] = $time;
            		        $MoneyChangeDetail->add($data);
            		    }
            		}
        		}
        		
        		//判断该笔订单是否在商户网站中已经做过处理
        			//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
        			//如果有做过处理，不执行商户的业务程序
        
        		//注意：
        		//该种交易状态只在两种情况下出现
        		//1、开通了普通即时到账，买家付款成功后。
        		//2、开通了高级即时到账，从该笔交易成功时间算起，过了签约时的可退款时限（如：三个月以内可退款、一年以内可退款等）后。
        
                //调试用，写文本函数记录程序运行情况是否正常
                //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
                echo "success";		//请不要修改或删除
            } else if ($_POST['trade_status'] == 'TRADE_SUCCESS') {
            	$PayDbLink = M("Pay");
        		$PayInfo = $PayDbLink->where("order_id=\"".$orderid."\" and pay_status=1")->limit(1)->select();
        		$userId = trim($PayInfo[0]["userid"]);
        		if(($userId!=NULL)){
            		$data = array();//初始化
            		$data["pay_status"] = 2;
            		$PayUpdateResult = $PayDbLink->where("order_id=\"".$orderid."\"  and pay_status=1")->save($data);
            		if(($PayUpdateResult!=false)&&($PayUpdateResult!=0)){
            		    //给用户账号加钱
            		    $Member = M("Member");
						$userUpdateResult = $Member->where("userid=".$userId)->setInc("money", $total_fee);
            		    if(($userUpdateResult!=false)&&($userUpdateResult!=0)){
            		        //给用户加钱成功，修改充值状态
            		        $data = array();
            		        $data["pay_status"] = 3;
            		        $data["pay_finish_time"] = $time;
            		        $PayDbLink->where("order_id=\"".$orderid."\" and pay_status=2")->save($data);
            		        
            		        //给金额变化表加记录
            		        $MoneyChangeDetail = M("MoneyChangeDetail");
            		        $data = array();
            		        $data["userid"] = $userId;
            		        $data["money"] = $total_fee;
            		        $data["change_type"] = 1;
            		        $data["change_reason"] = 1;
            		        $data["phone"] = "";
            		        $data["time"] = $time;
            		        $MoneyChangeDetail->add($data);
            		    }
            		}
        		}
                echo "success";		//请不要修改或删除
                //GivePay($orderid,$money);
        		//判断该笔订单是否在商户网站中已经做过处理
        			//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
        			//如果有做过处理，不执行商户的业务程序
        
        		//注意：
        		//该种交易状态只在一种情况下出现——开通了高级即时到账，买家付款成功后。
        
                //调试用，写文本函数记录程序运行情况是否正常
                //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
            }
        
        	//——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
        }
        else {
        	$strToWrite="\r\n\r\n\r\n时间: ".date("Y-m-d H:i:s")."\r\n订单号: ".$out_trade_no."\r\n支付宝交易号: ".$trade_no."\r\n支付金额: ".$total_fee;
        	$dateFilePath = "Data/Alipay/error/alipay_".date("Y-m-d").".txt";
    	    $fp = fopen($dateFilePath,"a+");
        	flock($fp, LOCK_EX);
        	fwrite($fp, $strToWrite);
        	fclose($fp);
            //验证失败
            echo "fail";
            //调试用，写文本函数记录程序运行情况是否正常
            //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
        }
    }
}