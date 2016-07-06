<?php
/*
 * 代充话费
 */
class ConsumeAction extends AuthAction {
	
	/*
	 * 进行钱与实际手机号的话费收到的钱的换算
	 */
	private function getTelephoneFare($phoneMoney) {
		$consumeConfig = C("consumeConfig");
		$consumeConfigPhoneGetRate = $consumeConfig["phoneGetRate"];
		$telephoneFare = $consumeConfigPhoneGetRate * $phoneMoney;
		return $telephoneFare;
	}
	
	/*
	 * 获得手续费等提示信息，用于提示
	 */
	public function consumeTipsInfo() {
		$phoneMoney = trim($this->_get("phoneMoney"));
		if(($this->checkIfIsAInt($phoneMoney) == false) || ($phoneMoney == 0)) {
			$jsonArr["result"]= "0";
		} else {
			$jsonArr["result"]= "1";
			$jsonArr["costRate"] = $this->getPoundage($phoneMoney);
			$jsonArr["phoneGetRate"] = $this->getTelephoneFare($phoneMoney);
		}
		$jsonStr=json_encode($jsonArr);
		echo $jsonStr; 
	}
	
	/*
	 * 计算手续费
	 */
	private function getPoundage($phoneMoney) {
		$consumeConfig = C("consumeConfig");
		$consumeConfigCostRate = $consumeConfig["costRate"];
		$poundage = $consumeConfigCostRate * $phoneMoney;
		return $poundage;
	}

	private function changeConsumeStatus($status) {
		$status = trim($status);
		switch ($status) {
			case 1:
				$status = "订单已提交";
				break;
				
			case 10:
				$status = "订单正在处理中";
				break;
				
			case 20:
				$status = "充话费成功";
				break;
			
			case 30:
				$status = "充话费失败";
				break;
				
			default:
				$status = "undefined";
				break;
		}
		return $status;
	}

	public function index() {
		$this->assign("pagetype",106);
		if ($this->consumeEnableStatus == 1) {
			$this->assign("messageContent", $this->stopConsumeMessage);
			$this->display("stopConsume");
		} else {
			$this->display();
		}
	}
	
	/*
	 * 代充记录
	 */
	public function record() {
		$this->assign("pagetype",107);
		import('ORG.Util.Page');
		import('COM.Util.PageSpecial');
		$erverPageLimit = C("commonPageLimit"); //每页显示记录数
		$order = "id desc";
		
		$MoneyConsumeDetail = M("MoneyConsumeDetail");
		if(trim($_GET["p"]==NULL)){
			$moneyConsumeDetailInfo = $MoneyConsumeDetail->where("userid = " . $this->userid)->order($order)->limit($erverPageLimit)->select();
		}else{
			$moneyConsumeDetailInfo = $MoneyConsumeDetail->where("userid = " . $this->userid)->order($order)->page($_GET['p'].','.$erverPageLimit)->select();
		}
		for ($i = 0; $i < count($moneyConsumeDetailInfo); $i++) {
			$moneyConsumeDetailInfo[$i]["start_time"] = date("Y-m-d H:i:s", $moneyConsumeDetailInfo[$i]["start_time"]);
			$moneyConsumeDetailInfo[$i]["status"] = $this->changeConsumeStatus($moneyConsumeDetailInfo[$i]["status"]);
		}
		
		//分页代码
		$count      = $MoneyConsumeDetail->where("userid = " . $this->userid)->count();// 查询满足要求的总记录数
		$Page       = new PageSpecial($count,$erverPageLimit);// 实例化分页类 传入总记录数和每页显示的记录数
		$show       = $Page->show();// 分页显示输出
		
		$this->assign("moneyConsumeDetailInfo", $moneyConsumeDetailInfo);
		$this->assign("page", $show);
		$this->display();
	}
	
	/*
	 * 分店代充记录
	 */
	public function bshopRecord() {
		$this->assign("pagetype",108);
		$this->checkIfIsBshop();
		import('ORG.Util.Page');
		import('COM.Util.PageSpecial');
		$erverPageLimit = C("commonPageLimit"); //每页显示记录数
		$bshopArr = $this->getBshopList($this->userid);
		$lastBshopId = $bshopArr[0]["userid"];
		$id = trim($this->_get("id"));
		if (count($bshopArr) == 0) {
			$moneyConsumeDetailInfo = array();
		} else {
			$MoneyConsumeDetail = M("MoneyConsumeDetail");
			$order = "id desc";
			if ($id == null) {
				if(trim($_GET["p"]==NULL)){
					$moneyConsumeDetailInfo = $MoneyConsumeDetail->where("fid = " . $this->userid)->order($order)->limit($erverPageLimit)->select();
				}else{
					$moneyConsumeDetailInfo = $MoneyConsumeDetail->where("fid = " . $this->userid)->order($order)->page($_GET['p'].','.$erverPageLimit)->select();
				}
				$count      = $MoneyConsumeDetail->where("fid = " . $this->userid)->count();// 查询满足要求的总记录数
			} else {
				if(trim($_GET["p"]==NULL)){
					$moneyConsumeDetailInfo = $MoneyConsumeDetail->where("fid = " . $this->userid . " and userid = " . $id)->order($order)->limit($erverPageLimit)->select();
				}else{
					$moneyConsumeDetailInfo = $MoneyConsumeDetail->where("fid = " . $this->userid . " and userid = " . $id)->order($order)->page($_GET['p'].','.$erverPageLimit)->select();
				}
				$count      = $MoneyConsumeDetail->where("fid = " . $this->userid . " and userid = " . $id)->count();// 查询满足要求的总记录数
			}
			for ($i = 0; $i < count($moneyConsumeDetailInfo); $i++) {
				$moneyConsumeDetailInfo[$i]["start_time"] = date("Y-m-d H:i:s", $moneyConsumeDetailInfo[$i]["start_time"]);
				$moneyConsumeDetailInfo[$i]["status"] = $this->changeConsumeStatus($moneyConsumeDetailInfo[$i]["status"]);
				$moneyConsumeDetailInfo[$i]["bshopName"] = $this->getShopNameByShopId($moneyConsumeDetailInfo[$i]["userid"]);
			}
			//分页代码
			
			$Page       = new PageSpecial($count,$erverPageLimit);// 实例化分页类 传入总记录数和每页显示的记录数
			$show       = $Page->show();// 分页显示输出
			//获取分店名称
			//$bshopName = $this->getShopNameByShopId($id);
		}
		
		
		$this->assign("bshopArr", $bshopArr);
		$this->assign("moneyConsumeDetailInfo", $moneyConsumeDetailInfo);
		$this->assign("page", $show);
		$this->assign("bshopName", $bshopName);
		$this->display("bshopRecord");
	}
	
	/*
	 * 进行实际的代充操作
	 */
	public function doConsume() {
		$this->assign("pagetype",108);
		header('Content-Type:application/json; charset=utf-8');
		$arrReturn["jumpUrl"] = "";
		$this->recodePostData("Data/Consume/doConsume/doConsume".date("Y-m-d").".txt");
		$phoneMoney = trim($_POST["phoneMoney"]); //本次代充的金额
		$phone = trim($_POST["phone"]);
		$phoneConfirm = trim($_POST["phoneConfirm"]);
		$verify = trim($_POST["verify"]);
		if ($this->consumeEnableStatus == 1) {
			$arrReturn["result"] = 1; //失败
            $arrReturn["info"] = $this->stopConsumeMessage; //提示信息
            $arrReturn["jumpUrl"] = "/consume";
            $returnStr = json_encode($arrReturn);
			echo $returnStr;
			exit;
		}
		if ($phoneMoney == null) {
			$arrReturn["result"] = 1; //失败
            $arrReturn["info"] = "话费金额不能为空"; //提示信息
            $returnStr = json_encode($arrReturn);
			echo $returnStr;
			exit;
		}
		if ($phone == null) {
			$arrReturn["result"] = 1; //失败
            $arrReturn["info"] = "充值手机号码不能为空"; //提示信息
            $returnStr = json_encode($arrReturn);
			echo $returnStr;
			exit;
		}
		if ($phoneConfirm == null) {
			$arrReturn["result"] = 1; //失败
            $arrReturn["info"] = "确认充值手机号码不能为空"; //提示信息
            $returnStr = json_encode($arrReturn);
			echo $returnStr;
			exit;
		}
		if ($verify == null) {
			$arrReturn["result"] = 1; //失败
            $arrReturn["info"] = "验证码不能为空"; //提示信息
            $returnStr = json_encode($arrReturn);
			echo $returnStr;
			exit;
		}
		if ($this->checkPhone($phone) == false) {
			$arrReturn["result"] = 1; //失败
            $arrReturn["info"] = "充值手机号码不正确，请输入正确的手机号码"; //提示信息
            $returnStr = json_encode($arrReturn);
			echo $returnStr;
			exit;
		}
		if ($phone != $phoneConfirm) {
			$arrReturn["result"] = 1; //失败
            $arrReturn["info"] = "充值手机号码与确认充值手机号码不一致"; //提示信息
            $returnStr = json_encode($arrReturn);
			echo $returnStr;
			exit;
		} 
		
		if ($_SESSION["logicResultVerify"] != md5($verify)) {
			$arrReturn["result"] = 1; //失败
            $arrReturn["info"] = "验证码错误"; //提示信息
            $returnStr = json_encode($arrReturn);
			echo $returnStr;
			exit;
		}
		if ($this->checkIfIsAInt($phoneMoney) == false) {
			$arrReturn["result"] = 1; //失败
            $arrReturn["info"] = "话费格式错误，只能是整数值"; //提示信息
            $returnStr = json_encode($arrReturn);
			echo $returnStr;
			exit;
		}
		
		$Model = M();
		$sql = "SELECT * FROM `dc_member` WHERE username = \"" . $this->userInfo["username"] ."\"";
		$memberInfo = $Model->query($sql);
		$money = $memberInfo[0]["money"];
		if ($money - $phoneMoney < 0) {
			$arrReturn["result"] = 1; //失败
            $arrReturn["info"] = "要充值的话费金额超过了你的账户余额，请调整话费金额或进行 <a href = '/pay'>充值</a>"; //提示信息
            $returnStr = json_encode($arrReturn);
			echo $returnStr;
			exit;
		}
		$MoneyConsumeDetail = M("MoneyConsumeDetail");
		$moneyConsumeDetailInfo = $MoneyConsumeDetail->where("userid = " . $this->userid . " and status = 1")->field("sum(money)")->select();
		$moneyWaitToProcess = trim($MoneyConsumeDetail[0]["sum(money)"]);
		if ($moneyWaitToProcess == null) {
			$moneyWaitToProcess = 0;
		}
		if (($moneyWaitToProcess + $phoneMoney) > $memberInfo[0]["money"]) {
			$arrReturn["result"] = 1; //失败
            $arrReturn["info"] = "要充值的话费额加上待处理的充话费订单的额度超过了您的账号的总余额，余额不足，请  <a href = '/pay'>充值</a>"; //提示信息
            $returnStr = json_encode($arrReturn);
			echo $returnStr;
			exit;
		}
	
		$orderId = date("YmdHis") . rand(1000,9999);
		$telephoneFare = $this->getTelephoneFare($phoneMoney); //充值用掉的钱
		$poundage = $this->getPoundage($phoneMoney); //手续费
		
		//记录本次充话费记录
		$consumeConfig = C("consumeConfig");
		$consumeConfigKey = $consumeConfig["key"];
		$data = array();
		$data["userid"] = $this->userid;
		$data["fid"] = $this->fid;
		$data["order_id"] = $orderId;
		$data["phone"] = $phone;
		$data["money"] = $phoneMoney;
		$data["telephone_fare"] = $telephoneFare;
		$data["poundage"] = $poundage;
		$time = time();
		$data["start_time"] = $time;
		$data["finish_time"] = $time;
		$data["check"] = md5(md5($orderId.$phone.$phoneMoney.$consumeConfigKey));
		$data["status"] = 1;	
		$result = $MoneyConsumeDetail->add($data);
	
		if ($result == true) {
			$arrReturn["result"] = 0; //失败
            $arrReturn["info"] = "订单已提交，请耐心等待处理"; //提示信息
            $returnStr = json_encode($arrReturn);
			echo $returnStr;
			exit;
		} else {   
			$arrReturn["result"] = 1; //失败
            $arrReturn["info"] = "系统异常，充值话费失败，请稍后重试"; //提示信息
            $returnStr = json_encode($arrReturn);
			echo $returnStr;
			exit;
		}
	}
	
	
}

