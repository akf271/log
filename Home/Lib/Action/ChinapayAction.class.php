<?php
class ChinapayAction extends CommonAction {
    public function index(){
    	
    }
    
    public function chinapayTo() {
    	$this->recodePostData("Data/Chinapay/chinapayto/chinapay_".date("Y-m-d").".txt");
    	header("Content-type:text/html;charset=utf-8");
    	$money = trim($_POST["money"]);
    	if (($this->checkFloatBitLessThanThree($money) == false) || ($money == 0)) {
    		header("location: /");
    		exit;
    	} 
    	$chinapayConfig = C("chinapayConfig");
    	$money = $money * 100;
		load("@.netpayclient");
		$merid = buildKey($chinapayConfig["MerPrKFielpath"]); 
        if(!$merid) { 
        	echo "导入私钥文件失败！"; 
            exit; 
        } 
		$ordid = trim($_POST["order_id"]); 
		$transamt = padstr($money,12); 
		$curyid = "156"; 
		$transdate = date('Ymd'); 
		$transtype = "0001"; 
		$version = $chinapayConfig["version"]; 
		$priv1 = "Memo";
		$pagereturl = $chinapayConfig["return_url"]; 
		$bgreturl = $chinapayConfig["notify_url"]; 
		$plain = $merid . $ordid . $transamt . $curyid . $transdate . $transtype . $priv1; 
		//对订单的签名 
		$chkvalue = sign($merid, $ordid, $transamt, $curyid, $transdate, $transtype, $priv1); 
		//对一段字符串的签名 
		$chkvalue = sign($plain); 
		if (!$chkvalue) { 
		      echo "签名失败！"; 
		      exit; 
		} 
		//echo $chkvalue;
		echo "<form   action=\"https://payment.ChinaPay.com/pay/TransGet\"   METHOD=\"POST\" id=\"alipaysubmit\" name=\"alipaysubmit\">
			<input  type=hidden   name=\"MerId\"   value=\"" . $merid  . "\"/>
			<input  type=hidden   name=\"OrdId\"   value=\"" . $ordid  . "\"/>
			<input  type=hidden   name=\"TransAmt\"  value=\"" . $transamt  . "\"/>
			<input  type=hidden   name=\"CuryId\"   value=\"156\"/>
			<input  type=hidden   name=\"TransDate\"   value=\"" . $transdate  . "\"/>
			<input  type=hidden   name=\"TransType\"   value=\"" . $transtype  . "\"/>
			<input  type=hidden   name=\"Version\"   value=\"" . $version  . "\"/> 
			<input  type=hidden  name=\"BgRetUrl\"   value=\"" . $bgreturl  . "\"/>
			<input  type=hidden   name=\"PageRetUrl\"  value=\"" . $pagereturl  . "\"/>
			<input  type=hidden   name=\"GateId\"   value=\"\">
			<input  type=hidden   name=\"Priv1\"   value=\"" . $priv1  . "\">
			<input  type=hidden   name=\"ChkValue\" value=\"" . $chkvalue  . "\">
			</form> <script>document.forms['alipaysubmit'].submit();</script>";
    }
    
    //异步回调
    public function notifyUrl() {
    	 $this->recodeRequestData("Data/Chinapay/origin/chinapay_".date("Y-m-d").".txt");
         header("Content-type:text/html;charset=utf-8");
		 load("@.netpayclient");
		 $chinapayConfig = C("chinapayConfig");
         $flag = buildKey($chinapayConfig["PgPubkFielpath"]); 
         if(!$flag) { 
	         echo "导入公钥文件失败！"; 
	         exit; 
         } 
         $merid = $_REQUEST["merid"]; 
         $orderno = $_REQUEST["orderno"]; 
         $transdate = $_REQUEST["transdate"]; 
         $amount = $_REQUEST["amount"]; 
         $currencycode = $_REQUEST["currencycode"]; 
         $transtype = $_REQUEST["transtype"]; 
         $status = $_REQUEST["status"]; 
         $checkvalue = $_REQUEST["checkvalue"]; 
         $gateId = $_REQUEST["GateId"]; 
         $priv1 = $_REQUEST["Priv1"]; 
         $plain = $merid . $orderno . $amount . $currencycode . $transdate . $transtype . $status . $priv1 . $checkvalue; 
         //对订单验证签名 
         $flag  =  verifyTransResponse($merid,  $orderno,  $amount,  $currencycode,  $transdate,  $transtype, $status, $checkvalue); 
         $time = time();
         if(!$flag) {
         	$this->recodeRequestData("Data/Chinapay/error/chinapay_".date("Y-m-d").".txt");
            echo "<h2>验证签名失败！</h2>"; 
            exit; 
         } else {
         	$this->recodeRequestData("Data/Chinapay/success/chinapay_".date("Y-m-d").".txt");
         	//echo "验证签名成功！";
         	$PayDbLink = M("Pay");
        	$PayInfo = $PayDbLink->where("order_id=\"".$orderno."\" and pay_status=1")->limit(1)->select();
        	$userId = trim($PayInfo[0]["userid"]);
        	if(($userId!=NULL)){
            	$data = array();//初始化
            	$data["pay_status"] = 2;
            	$total_fee = $PayInfo[0]["money"];
            	$PayUpdateResult = $PayDbLink->where("order_id=\"".$orderno."\"  and pay_status=1")->save($data);
            	if(($PayUpdateResult!=false)&&($PayUpdateResult!=0)){
            	    //给用户账号加钱
            	    $Member = M("Member");
            	    $userUpdateResult = $Member->where("userid=".$userId)->setInc("money", $total_fee);
            	    if(($userUpdateResult!=false)&&($userUpdateResult!=0)){
            	        //给用户加钱成功，修改充值状态
            	        $data = array();
            	        $data["pay_status"] = 3;
            	        $data["pay_finish_time"] = $time;
            	        $PayDbLink->where("order_id=\"".$orderno."\" and pay_status=2")->save($data);
            	        
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
         }
    }
    
    //同步回调
    public function returnUrl() {
    	$this->display("returnUrl");
    }
}