<?php
class TestAction extends Action {
	public function index() {
		set_time_limit(0);
		$Model = M();
		$sql = "set autocommit=0;";
		$Model->query($sql);
		$sql = "SELECT * FROM `dc_member` WHERE username = \"akf_271\" for update;";
		$Model->query($sql);
		
//		$Member = M("Member");
//		$data = array();
//		$data["money"] = "11111";
//		$result = $Member->where("username = \"akf_271\"")->save($data);
//		if ($result != false) {
//			echo "success";
//		} else {
//			echo "fail";
//		}
//		for ($i = 0; $i <= 1000; $i++){
//			$str = file_get_contents("http://www.baidu.com");
//		}
		$Test = M("Test");
		for ($i = 1; $i <= 100000; $i++) {
			$data = array();
			$data["nub"] = $i;
			$Test->add($data);
		}
	}
	
	public function abc() {
		//set_time_limit(0);
		$Model = M();
		$sql = "set autocommit=0;";
		$Model->query($sql);
		$sql = "SELECT * FROM `dc_member` WHERE username = \"dakf_271\" for update;";
		$Model->query($sql);

		$Member = M("Member");
		$data = array();
		$data["money"] = "6666";
		$result = $Member->where("username = \"akf_271\"")->save($data);
		if ($result != false) {
			echo "success";
		} else {
			echo "fail";
		}
//		$sql = "commit";
//		$Model->query($sql);
		for ($i = 0; $i <= 1000; $i++){
			$str = file_get_contents("http://www.baidu.com");
		}
	}
	
	
	public function def() {
		$Model = M();
		$sql = "set autocommit=0;";
		$Model->query($sql);
		$sql = "SELECT * FROM `dc_member` WHERE username = \"akf_271\" for update;";
		$Model->query($sql);
		
		$Member = M("Member");
		$data = array();
		$data["money"] = "555555";
		$result = $Member->where("username = \"akf_271\"")->save($data);
		if ($result != false) {
			echo "success";
		} else {
			echo "fail";
		}
		$sql = "commit;";
		$Model->query($sql);
		
//		for ($i = 0; $i <= 1000; $i++){
//			$str = file_get_contents("http://www.baidu.com");
//		}
	}
	
	public function gh() {
//		$Model = M();
//		$sql = "set autocommit=0;";
//		$Model->query($sql);
//		$sql = "SELECT * FROM `dc_member` WHERE username = \"akf_271\" for update;";
//		$Model->query($sql);
		
		$Member = M("Member");
		$data = array();
		$data["money"] = "33333";
		$result = $Member->where("username = \"akf_271\"")->save($data);
		if ($result != false) {
			echo "success";
		} else {
			echo "fail";
		}
//		for ($i = 0; $i <= 1000; $i++){
//			$str = file_get_contents("http://www.baidu.com");
//		}
	}
	
	public function a1() {
		$Model = M();
		$sql = "START TRANSACTION;";
		$Model->query($sql);
		$Model->save($options);
		$sql = "set autocommit=0;";
		$Model->query($sql);
		
		$sql = "SELECT * FROM `dc_member` WHERE username = \"akf_271\" for update;";
		$Model->query($sql);
		
		$sql = "UPDATE `yjdc`.`dc_member` SET `money` = '66' WHERE `dc_member`.`username` ='akf_271';";
		$Model->query($sql);
		
//		$sql = "commit;";
//		$Model->query($sql);
	}
	
	public function a2() {
//		header("Content-type:text/html;charset=utf-8");
//		$site_url = "http://" . $_SERVER["HTTP_HOST"];
//		load("@.netpayclient");
//		$merid = buildKey("MerPrk.key"); 
//        if(!$merid) { 
//        	echo "导入私钥文件失败！"; 
//            exit; 
//        } 
//        
//
//       
//		$ordid = "00" . date('YmdHis'); 
//		$transamt = padstr('1598',12); 
//		$curyid = "156"; 
//		$transdate = date('Ymd'); 
//		$transtype = "0001"; 
//		$version = "20070129"; 
//		$priv1 = "Memo";
//		$pagereturl = $site_url . "/netpayclient_order_feedback.php"; 
//		$bgreturl = $site_url . "/netpayclient_order_feedback.php"; 
//		$plain = $merid . $ordid . $transamt . $curyid . $transdate . $transtype . $priv1; 
//		//对订单的签名 
//		$chkvalue = sign($merid, $ordid, $transamt, $curyid, $transdate, $transtype, $priv1); 
//		//对一段字符串的签名 
//		$chkvalue = sign($plain); 
//		if (!$chkvalue) { 
//		      echo "签名失败！"; 
//		      exit; 
//		} 
//		//echo $chkvalue;
//		echo "<form   action=\"https://payment.ChinaPay.com/pay/TransGet\"   METHOD=\"POST\" id=\"alipaysubmit\" name=\"alipaysubmit\">
//			<input  type=hidden   name=\"MerId\"   value=\"" . $merid  . "\"/>
//			<input  type=hidden   name=\"OrdId\"   value=\"" . $ordid  . "\"/>
//			<input  type=hidden   name=\"TransAmt\"  value=\"" . $transamt  . "\"/>
//			<input  type=hidden   name=\"CuryId\"   value=\"156\"/>
//			<input  type=hidden   name=\"TransDate\"   value=\"" . $transdate  . "\"/>
//			<input  type=hidden   name=\"TransType\"   value=\"" . $transtype  . "\"/>
//			<input  type=hidden   name=\"Version\"   value=\"" . $version  . "\"/> 
//			<input  type=hidden  name=\"BgRetUrl\"   value=\"" . $bgreturl  . "\"/>
//			<input  type=hidden   name=\"PageRetUrl\"  value=\"" . $pagereturl  . "\"/>
//			<input  type=hidden   name=\"GateId\"   value=\"\">
//			<input  type=hidden   name=\"Priv1\"   value=\"" . $priv1  . "\">
//			<input  type=hidden   name=\"ChkValue\" value=\"" . $chkvalue  . "\">
//			</form> <script>document.forms['alipaysubmit'].submit();</script>";
       
       
	}
	

	
	
	
	

	

}