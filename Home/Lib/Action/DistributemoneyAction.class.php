<?php
/*
 * 给子账号分配钱
 */
class DistributemoneyAction extends AuthAction {
	
	private function changeDistributeType($distributeType) {
		$distributeType = trim($distributeType);
		switch ($distributeType) {
			case "1":
				$distributeType = "分配额度";
				break;
			case "2":
				$distributeType = "减少额度";
				break;
			default:
				$distributeType = "Undefined";
				break;
		}
		return $distributeType;
	}

	public function index() {
		$this->assign("pagetype",102);
		import('ORG.Util.Page');
		import('COM.Util.PageSpecial');
		$erverPageLimit = C("commonPageLimit"); //每页显示记录数
		$LoginDetail = M("LoginDetail");
		$order = "id desc";
		$this->checkIfIsBshop();
		
		$Member = M("Member");
		$memberInfo = $Member->where("fid = " . $this->userid)->select();
		if(trim($_GET["p"]==NULL)){
			$memberInfo = $Member->where("fid = " . $this->userid)->order($order)->limit($erverPageLimit)->select();
		}else{
			$memberInfo = $Member->where("fid = " . $this->userid)->order($order)->page($_GET['p'].','.$erverPageLimit)->select();
		}
		//分页代码
		$count      = $Member->where("fid = " . $this->userid)->count();// 查询满足要求的总记录数
		$Page       = new PageSpecial($count,$erverPageLimit);// 实例化分页类 传入总记录数和每页显示的记录数
		$show       = $Page->show();// 分页显示输出

		$this->assign("rootShopName", $this->shopNameDescribe);
		$this->assign("memberInfo", $memberInfo);
		$this->assign("page", $show);
		$this->display();
	}
	
	/*
	 *给分店分配钱
	 */
	public function distributeMoney() {
		$shopid = trim($this->_get("shopid"));
		$this->assign("pagetype",102);
		$this->checkIfIsBshop();
		
		$Member = M("Member");
		$count = $Member->where("userid = " . $shopid . " and fid = " . $this->userid  . " and status != 1")->count();
		if ($count != 1) {
			header("location: /distributemoney");
			exit;
		}
		$memberInfo = $Member->where("userid = " . $shopid . " and fid = " . $this->userid)->limit(1)->select();
		$this->assign("memberInfo", $memberInfo[0]);
		$this->assign("shopid", $shopid);
		$this->display("distributeMoney");
	}
	
	/*
	 * 进行实际 的给分店分配钱的操作
	 */
	public function doDistributeMoney() {
		header('Content-Type:application/json; charset=utf-8');
		$this->recodePostData("Data/Distributemoney/doDistributeMoney/doDistributeMoney_".date("Y-m-d").".txt");
		$this->checkIfIsBshop();
		$arrReturn["errorCode"] = 0; //初始化
		$shopid = trim($_POST["shopid"]);
		$money = trim($_POST["money"]);
		$verify = trim($_POST["verify"]);
		$Member = M("Member");

		$count = $Member->where("userid = " . $shopid . " and fid = " . $this->userid)->count();

		if (($count != 1)) {
			$arrReturn["result"] = 1; //失败
			$arrReturn["errorCode"] = 1; //相关用户不存在
	        $arrReturn["info"] = "相关用户不存在"; //提示信息
	        $returnStr = json_encode($arrReturn);
			echo $returnStr;
			exit;
		}
		$memberInfo = $Member->where("userid = " . $shopid . " and fid = " . $this->userid)->limit(1)->select();
		if($memberInfo[0]["status"] == 1) {
			$arrReturn["result"] = 1; //失败
			$arrReturn["errorCode"] = 1; //相关用户不存在
	        $arrReturn["info"] = "该账号已停用，不能进行操作，如要操作，请先启用账号"; //提示信息
	        $returnStr = json_encode($arrReturn);
			echo $returnStr;
			exit;
		}
		if ($money == null) {
			$arrReturn["result"] = 1; //失败
            $arrReturn["info"] = "分配代充额度不能为空"; //提示信息
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
		
		
		if ($_SESSION["logicResultVerify"] != md5($verify)) {
			$arrReturn["result"] = 1; //失败
            $arrReturn["info"] = "验证码错误"; //提示信息
            $returnStr = json_encode($arrReturn);
			echo $returnStr;
			exit;
		}
		
		if ($this->checkFloatBitLessThanThree($money) == false) {
			$arrReturn["result"] = 1; //失败
            $arrReturn["info"] = "分配可代充额度格式错误"; //提示信息
            $returnStr = json_encode($arrReturn);
			echo $returnStr;
			exit;
		}
		if ($this->userInfo["money"] < $money) {
			$arrReturn["result"] = 1; //失败
            $arrReturn["info"] = "分配的金额过大，超过了你的账号余额，请充值"; //提示信息
            $returnStr = json_encode($arrReturn);
			echo $returnStr;
			exit;
		}
		
		$Member->startTrans();
		$time = time();
		//更新总店自己的钱
		$rootShopMoneyUpdateResult = $Member->where("userid = $this->userid")->setDec("money", $money);
		//更新分店的钱
		$bshopMoneyUpdateResult = $Member->where("userid = " . $shopid . " and fid = " . $this->userid)->setInc("money", $money);
		//更新金额分配表
		$MoneyDistributeDetail = M("MoneyDistributeDetail");
		$data = array();
		$data["time"] = $time;
		$data["money"] = $money;
		$data["userid"] = $this->userid;
		$data["branch_userid"] = $shopid;
		$data["distribute_type"] = 1;
		$data["order_id"] = date("YmdHis") . rand(1000,9999);
		$moneyDistributeDetailSaveResult = $MoneyDistributeDetail->add($data);
		//更新金额变化表
		$MoneyChangeDetail = M("MoneyChangeDetail");
		$data = array();
		$data["userid"] = $this->userid;
		$data["money"] = $money;
		$data["change_type"] = 2;
		$data["change_reason"] = 2;
		$data["time"] = $time;
		$data["phone"] = "";
		$moneyChangeDetailRootShopSaveResult = $MoneyChangeDetail->add($data);//总店减少金额
		
		$data = array();
		$data["userid"] = $shopid;
		$data["money"] = $money;
		$data["change_type"] = 1;
		$data["change_reason"] = 3;
		$data["time"] = $time;
		$data["phone"] = "";
		$moneyChangeDetailBshopSaveResult = $MoneyChangeDetail->add($data);//分店增加金额
		if(($bshopMoneyUpdateResult != false) && ($rootShopMoneyUpdateResult != false) && ($moneyDistributeDetailSaveResult != false) && ($moneyChangeDetailRootShopSaveResult != false) && ($moneyChangeDetailBshopSaveResult != false)) {
			// 提交事务
    		$Member->commit(); 
    		$arrReturn["result"] = 0; //成功
            $arrReturn["info"] = "增加成功"; //提示信息
            $returnStr = json_encode($arrReturn);
			echo $returnStr;
			exit;
		} else {
			//事务回滚
			$Member->rollback();
			$arrReturn["result"] = 1; //失败
            $arrReturn["info"] = "系统故障，操作失败，请稍后重试"; //提示信息
            $returnStr = json_encode($arrReturn);
			echo $returnStr;
			exit;
		}
	}
	
	/*
	 * 分配记录详情
	 */
	public function detail() {
		$this->assign("pagetype",111);
		$this->checkIfIsBshop();
		import('ORG.Util.Page');
		import('COM.Util.PageSpecial');
		$erverPageLimit = C("commonPageLimit"); //每页显示记录数
		$MoneyDistributeDetail = M("MoneyDistributeDetail");
		$order = "dc_money_distribute_detail.id desc";
		if(trim($_GET["p"]==NULL)){
			$moneyDistributeDetailInfo = $MoneyDistributeDetail->join("dc_member on dc_money_distribute_detail.userid = dc_member.userid and dc_money_distribute_detail.userid")->where("dc_money_distribute_detail.userid = " . $this->userid)->limit($erverPageLimit)->order($order)->field("dc_money_distribute_detail.distribute_type,dc_money_distribute_detail.id, dc_money_distribute_detail.userid,dc_money_distribute_detail.money, dc_money_distribute_detail.time, dc_money_distribute_detail.branch_userid")->select();
		}else{
			$moneyDistributeDetailInfo = $MoneyDistributeDetail->join("dc_member on dc_money_distribute_detail.userid = dc_member.userid and dc_money_distribute_detail.userid")->where("dc_money_distribute_detail.userid = " . $this->userid)->order($order)->page($_GET['p'].','.$erverPageLimit)->field("dc_money_distribute_detail.distribute_type,dc_money_distribute_detail.id, dc_money_distribute_detail.userid,dc_money_distribute_detail.money, dc_money_distribute_detail.time, dc_money_distribute_detail.branch_userid")->select();
		}
		
		
		for ($i = 0; $i < count($moneyDistributeDetailInfo); $i++) {
			$moneyDistributeDetailInfo[$i]["time"] = date("Y-m-d H:i:s", $moneyDistributeDetailInfo[$i]["time"]);
			$bshopId = $moneyDistributeDetailInfo[$i]["branch_userid"];
			$bshopInfo = $this->getShopInfoByShopId($bshopId);
			$moneyDistributeDetailInfo[$i]["username"] = $bshopInfo["username"];
			$moneyDistributeDetailInfo[$i]["shop_name"] = $bshopInfo["shop_name"];
			$moneyDistributeDetailInfo[$i]["shop_manager"] = $bshopInfo["shop_manager"];
			$moneyDistributeDetailInfo[$i]["shop_telephone"] = $bshopInfo["shop_telephone"];
			$moneyDistributeDetailInfo[$i]["distributeType"] = $this->changeDistributeType($moneyDistributeDetailInfo[$i]["distribute_type"]);
		
		}
		//分页代码
		$count      = $MoneyDistributeDetail->where("userid = " . $this->userid)->count();// 查询满足要求的总记录数
		$Page       = new PageSpecial($count,$erverPageLimit);// 实例化分页类 传入总记录数和每页显示的记录数
		$show       = $Page->show();// 分页显示输出
		//模板赋值
		$this->assign("page", $show);
		$this->assign("moneyDistributeDetailInfo", $moneyDistributeDetailInfo);
		$this->display();
	}
	
	/*
	 * 分店收到的总店的拨款记录，也包括被总店收回钱的记录
	 */
	public function bshopRecord() {
		$this->assign("pagetype",112);
		$this->checkIfIsRootshop();
		import('ORG.Util.Page');
		import('COM.Util.PageSpecial');
		$erverPageLimit = C("commonPageLimit"); //每页显示记录数
		$MoneyDistributeDetail = M("MoneyDistributeDetail");
		$order = "id desc";
		if(trim($_GET["p"]==NULL)){
			$moneyDistributeDetailInfo = $MoneyDistributeDetail->where("branch_userid = " . $this->userid)->order($order)->limit($erverPageLimit)->select();
		}else{
			$moneyDistributeDetailInfo = $MoneyDistributeDetail->where("branch_userid = " . $this->userid)->order($order)->page($_GET['p'].','.$erverPageLimit)->select();
		}
		
		for ($i = 0; $i < count($moneyDistributeDetailInfo); $i++) {
			$moneyDistributeDetailInfo[$i]["time"] = date("Y-m-d H:i:s", $moneyDistributeDetailInfo[$i]["time"]);
			$moneyDistributeDetailInfo[$i]["distributeType"] = $this->changeDistributeType($moneyDistributeDetailInfo[$i]["distribute_type"]);
		}
		
		//分页代码
		$count      = $MoneyDistributeDetail->where("branch_userid = " . $this->userid)->count();// 查询满足要求的总记录数
		$Page       = new PageSpecial($count,$erverPageLimit);// 实例化分页类 传入总记录数和每页显示的记录数
		$show       = $Page->show();// 分页显示输出
		
		//模板赋值
		$this->assign("page", $show);
		$this->assign("moneyDistributeDetailInfo", $moneyDistributeDetailInfo);
		$this->display("bshopRecord");
	}
	
	/*
	 * 总店回收分店一部分的余额
	 */
	public function reduceBshopMoney() {
		$shopid = trim($this->_get("shopid"));
		$this->assign("pagetype",102);
		$this->checkIfIsBshop();
		
		$Member = M("Member");
		$count = $Member->where("userid = " . $shopid . " and fid = " . $this->userid  . " and status != 1")->count();
		if ($count != 1) {
			header("location: /distributemoney");
			exit;
		}
		$memberInfo = $Member->where("userid = " . $shopid . " and fid = " . $this->userid)->limit(1)->select();
		$this->assign("memberInfo", $memberInfo[0]);
		$this->assign("shopid", $shopid);
		$this->display("reduceBshopMoney");
	}
	
	/*
	 * 进行实际 的回收分店一部分余额的操作
	 */
	public function doReduceBshopMoney() {
		header('Content-Type:application/json; charset=utf-8');
		$this->recodePostData("Data/Distributemoney/doReduceBshopMoney/doReduceBshopMoney".date("Y-m-d").".txt");
		$this->checkIfIsBshop();
		$arrReturn["errorCode"] = 0; //初始化
		$shopid = trim($_POST["shopid"]);
		$money = trim($_POST["money"]);
		$verify = trim($_POST["verify"]);
		$Member = M("Member");

		$count = $Member->where("userid = " . $shopid . " and fid = " . $this->userid)->count();

		if (($count != 1)) {
			$arrReturn["result"] = 1; //失败
			$arrReturn["errorCode"] = 1; //相关用户不存在
	        $arrReturn["info"] = "相关用户不存在"; //提示信息
	        $returnStr = json_encode($arrReturn);
			echo $returnStr;
			exit;
		}
		$memberInfo = $Member->where("userid = " . $shopid . " and fid = " . $this->userid)->limit(1)->select();
		if($memberInfo[0]["status"] == 1) {
			$arrReturn["result"] = 1; //失败
			$arrReturn["errorCode"] = 1; //相关用户不存在
	        $arrReturn["info"] = "该账号已停用，不能进行操作，如要操作，请先启用账号"; //提示信息
	        $returnStr = json_encode($arrReturn);
			echo $returnStr;
			exit;
		}
		if ($money == null) {
			$arrReturn["result"] = 1; //失败
            $arrReturn["info"] = "减少额度值不能为空"; //提示信息
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
		
		
		if ($_SESSION["logicResultVerify"] != md5($verify)) {
			$arrReturn["result"] = 1; //失败
            $arrReturn["info"] = "验证码错误"; //提示信息
            $returnStr = json_encode($arrReturn);
			echo $returnStr;
			exit;
		}
		
		if ($this->checkFloatBitLessThanThree($money) == false) {
			$arrReturn["result"] = 1; //失败
            $arrReturn["info"] = "分配可代充额度格式错误"; //提示信息
            $returnStr = json_encode($arrReturn);
			echo $returnStr;
			exit;
		}

		if ($memberInfo[0]["money"] < $money) {
			$arrReturn["result"] = 1; //失败
            $arrReturn["info"] = "要减少的额度值超过了分店账号余额，请换成一个额度值"; //提示信息
            $returnStr = json_encode($arrReturn);
			echo $returnStr;
			exit;
		}
		
		$Member->startTrans();
		$time = time();
		//更新分店的钱
		$bshopMoneyUpdateResult = $Member->where("userid = " . $shopid . " and fid = " . $this->userid)->setDec("money", $money);
		//更新总店自己的钱
		$rootShopMoneyUpdateResult = $Member->where("userid = $this->userid")->setInc("money", $money);
		//更新金额分配表
		$MoneyDistributeDetail = M("MoneyDistributeDetail");
		$data = array();
		$data["time"] = $time;
		$data["money"] = $money;
		$data["userid"] = $this->userid;
		$data["branch_userid"] = $shopid;
		$data["distribute_type"] = 2;
		$data["order_id"] = date("YmdHis") . rand(1000,9999);
		$moneyDistributeDetailSaveResult = $MoneyDistributeDetail->add($data);
		//更新金额变化表
		$MoneyChangeDetail = M("MoneyChangeDetail");
		$data = array();
		$data["userid"] = $this->userid;
		$data["money"] = $money;
		$data["change_type"] = 1;
		$data["change_reason"] = 5;
		$data["time"] = $time;
		$data["phone"] = "";
		$moneyChangeDetailRootShopSaveResult = $MoneyChangeDetail->add($data);//总店减少金额
		
		$data = array();
		$data["userid"] = $shopid;
		$data["money"] = $money;
		$data["change_type"] = 2;
		$data["change_reason"] = 6;
		$data["time"] = $time;
		$data["phone"] = "";
		$moneyChangeDetailBshopSaveResult = $MoneyChangeDetail->add($data);//分店增加金额
		if(($bshopMoneyUpdateResult != false) && ($rootShopMoneyUpdateResult != false) && ($moneyDistributeDetailSaveResult != false) && ($moneyChangeDetailRootShopSaveResult != false) && ($moneyChangeDetailBshopSaveResult != false)) {
			// 提交事务
    		$Member->commit(); 
    		$arrReturn["result"] = 0; //成功
            $arrReturn["info"] = "减少额度成功"; //提示信息
            $returnStr = json_encode($arrReturn);
			echo $returnStr;
			exit;
		} else {
			//事务回滚
			$Member->rollback();
			$arrReturn["result"] = 1; //失败
            $arrReturn["info"] = "系统故障，操作失败，请稍后重试"; //提示信息
            $returnStr = json_encode($arrReturn);
			echo $returnStr;
			exit;
		}
	}
}

