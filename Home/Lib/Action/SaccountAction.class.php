<?php
/*
 * 子账号管理
 */
class SaccountAction extends AuthAction {

	public function index() {
		$msg = "充值完成 ！";
        $jumpUrl = "/pay";
        $this->showSuccessDialog($jumpUrl, $msg);
		$this->checkIfIsBshop();
	}
	
	/*
	 * 子账号列表
	 */
	public function thelist() {
		$this->assign("pagetype",101);
		import('ORG.Util.Page');
		import('COM.Util.PageSpecial');
		$erverPageLimit = C("commonPageLimit"); //每页显示记录数
		$LoginDetail = M("LoginDetail");
		$order = "id desc";
		$this->checkIfIsBshop();
		
		$Member = M("Member");
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
	 * 添加子账号
	 */
	public function add() {
		$this->assign("pagetype",101);
		$this->checkIfIsBshop();
		$this->display();
	}
	
	/*
	 *给分店分配钱
	 */
	public function distributeMoney() {
//		exit;
//		$this->assign("pagetype",101);
//		$this->checkIfIsBshop();
//		$shopid = trim($this->_get("shopid"));	
//		$Member = M("Member");
//		$count = $Member->where("userid = " . $shopid . " and fid = " . $this->userid  . " and status != 1")->count();
//		if ($count != 1) {
//			header("location: /saccount/thelist");
//			exit;
//		}
//		$memberInfo = $Member->where("userid = " . $shopid . " and fid = " . $this->userid  . " and status != 1")->limit(1)->select();
//		$this->assign("memberInfo", $memberInfo[0]);
//		$this->assign("shopid", $shopid);
//		$this->display("distributeMoney");
	}
	
	/*
	 * 编辑分店信息
	 */
	public function editBshop() {
		$this->assign("pagetype",101);
		$this->checkIfIsBshop();
		
		$shopid = trim($this->_get("shopid"));	
		$Member = M("Member");
		$count = $Member->where("userid = " . $shopid . " and fid = " . $this->userid . " and status != 1")->count();
		if ($count != 1) {
			header("location: /saccount/thelist");
			exit;
		}
		$memberInfo = $Member->where("userid = " . $shopid . " and fid = " . $this->userid . " and status != 1")->limit(1)->select();
		$phoneArrTemp = explode("]", $memberInfo[0]["phone"]);
		$phoneArr = array();
		for ($i = 0; $i < (count($phoneArrTemp) - 1); $i++) {
			$phoneStr = trim(str_replace("[", "", $phoneArrTemp[$i]));
			$phoneStr = trim(str_replace(",", "", $phoneStr));
			$phoneArrExplodeTemp = explode("@#*#@", $phoneStr);
			$phoneArr[$i]["id"] = $i+1;
			$phoneArr[$i]["phone"] = trim($phoneArrExplodeTemp[0]);
			$phoneArr[$i]["phoneMark"] = trim($phoneArrExplodeTemp[1]);
		}
		$totalPhoneNum = count($phoneArr);
		
		//模板赋值
		$this->assign("totalPhoneNum", $totalPhoneNum);
		$this->assign("memberInfo", $memberInfo[0]);
		$this->assign("phoneArr", $phoneArr);
		$this->assign("shopid", $shopid);
		$this->display("editBshop");
	}
	
	/*
	 * 修改分店密码
	 */
	public function changeBshopPsw() {
		$this->assign("pagetype",101);
		$this->checkIfIsBshop();
		
		$shopid = trim($this->_get("shopid"));	
		$Member = M("Member");
		$count = $Member->where("userid = " . $shopid . " and fid = " . $this->userid  . " and status != 1")->count();
		if ($count != 1) {
			header("location: /saccount/thelist");
			exit;
		}
		$memberInfo = $Member->where("userid = " . $shopid . " and fid = " . $this->userid  . " and status != 1")->limit(1)->select();
		$this->assign("memberInfo", $memberInfo[0]);
		$this->assign("shopid", $shopid);
		$this->display("changeBshopPsw");
	}
	
	/*
	 * 删除分店
	 */
	public function delBshop() {
		$this->assign("pagetype",101);
		$this->checkIfIsBshop();

	}
	
	/*
	 * 进行实际 的给分店分配钱的操作
	 */
	public function doDistributeMoney() {
		exit;
		header('Content-Type:application/json; charset=utf-8');
		$this->recodePostData("Data/Saccount/doDistributeMoney/doDistributeMoney_".date("Y-m-d").".txt");
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
	        $arrReturn["info"] = "相关用户不存在或已停用"; //提示信息
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
		//更新分店的钱
		$bshopInfo = $Member->where("userid = " . $shopid . " and fid = " . $this->userid)->limit(1)->select();
		$bshopMoneyNew = $bshopInfo[0]["money"] + $money;
		$data = array();
		$data["money"] = $bshopMoneyNew;
		$bshopMoneyUpdateResult = $Member->where("userid = " . $shopid . " and fid = " . $this->userid)->save($data);
		//更新总店自己的钱
		$rootShopMoneyNew = $this->userInfo["money"] - $money;
		$data = array();
		$data["money"] = $rootShopMoneyNew;
		$rootShopMoneyUpdateResult = $Member->where("userid = $this->userid")->save($data);
		//更新金额分配表
		$MoneyDistributeDetail = M("MoneyDistributeDetail");
		$data = array();
		$data["time"] = $time;
		$data["money"] = $money;
		$data["userid"] = $this->userid;
		$data["branch_userid"] = $shopid;
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
	 * 进行实际的分店添加操作
	 */
	public function doAdd() {
		header('Content-Type:application/json; charset=utf-8');
		$this->recodePostData("Data/Saccount/doAdd/doAdd_".date("Y-m-d").".txt");
		$this->checkIfIsBshop();
		$username = trim($_POST["username"]);
		$password = trim($_POST["password"]);
		$passwordConfirm = trim($_POST["passwordConfirm"]);
		$shopName = trim($_POST["shopName"]);	
		$shopTelephone = trim($_POST["shopTelephone"]);
		$shopManager = trim($_POST["shopManager"]);
		$money = trim($_POST["money"]);
		$phoneId = trim($_POST["phoneId"]);
		
		$arrReturn["backUrl"] = ""; //初始化
		
		if ($username == null) {
			$arrReturn["result"] = 1; //失败
            $arrReturn["info"] = "用户名不能为空"; //提示信息
            $returnStr = json_encode($arrReturn);
			echo $returnStr;
			exit;
		}
		if ($password == null) {
			$arrReturn["result"] = 1; //失败
            $arrReturn["info"] = "密码不能为空"; //提示信息
            $returnStr = json_encode($arrReturn);
			echo $returnStr;
			exit;
		}
		if ($passwordConfirm == null) {
			$arrReturn["result"] = 1; //失败
            $arrReturn["info"] = "确认密码不能为空"; //提示信息
            $returnStr = json_encode($arrReturn);
			echo $returnStr;
			exit;
		}
		if ($shopName == null) {
			$arrReturn["result"] = 1; //失败
            $arrReturn["info"] = "分店名称不能为空"; //提示信息
            $returnStr = json_encode($arrReturn);
			echo $returnStr;
			exit;
		}
		if ($shopTelephone == null) {
			$arrReturn["result"] = 1; //失败
            $arrReturn["info"] = "电话不能为空"; //提示信息
            $returnStr = json_encode($arrReturn);
			echo $returnStr;
			exit;
		}
		if ($shopManager == null) {
			$arrReturn["result"] = 1; //失败
            $arrReturn["info"] = "负责人不能为空"; //提示信息
            $returnStr = json_encode($arrReturn);
			echo $returnStr;
			exit;
		}
		if ($money == null) {
			$arrReturn["result"] = 1; //失败
            $arrReturn["info"] = "代充额度不能为空"; //提示信息
            $returnStr = json_encode($arrReturn);
			echo $returnStr;
			exit;
		}
		if (strlen($password) < 6) {
			$arrReturn["result"] = 1; //失败
            $arrReturn["info"] = "密码长度不能小于6位"; //提示信息
            $returnStr = json_encode($arrReturn);
			echo $returnStr;
			exit;
		}
		if ($password != $passwordConfirm) {
			$arrReturn["result"] = 1; //失败
            $arrReturn["info"] = "密码与确认密码不一致"; //提示信息
            $returnStr = json_encode($arrReturn);
			echo $returnStr;
			exit;
		}
		if ($this->checkFloatBitLessThanThree($money) == false) {
			$arrReturn["result"] = 1; //失败
            $arrReturn["info"] = "代充额度格式错误，必须是整数或最大两位小数"; //提示信息
            $returnStr = json_encode($arrReturn);
			echo $returnStr;
			exit;
		}
		$Member = M("Member");
		$count = $Member->where("username = \"" . $username . "\"")->count();
		if ($count != 0) {
			$arrReturn["result"] = 1; //失败
            $arrReturn["info"] = "用户名已存在，请换一个用户名"; //提示信息
            $returnStr = json_encode($arrReturn);
			echo $returnStr;
			exit;
		}
		$count = $Member->where("shop_name = \"" . $shopName . "\"")->count();
		if ($count != 0) {
			$arrReturn["result"] = 1; //失败
            $arrReturn["info"] = "分店名 [" . $shopName . "] 已存在，请换一个"; //提示信息
            $returnStr = json_encode($arrReturn);
			echo $returnStr;
			exit;
		}
		$count = $Member->where("shop_telephone = \"" . $shopTelephone . "\"")->count();
		if ($count != 0) {
			$arrReturn["result"] = 1; //失败
            $arrReturn["info"] = "电话  [" . $shopTelephone . "] 已存在，请换一个"; //提示信息
            $returnStr = json_encode($arrReturn);
			echo $returnStr;
			exit;
		}
		if ($money > $this->userInfo["money"]) {
			$arrReturn["result"] = 1; //失败
            $arrReturn["info"] = "分配的代充额度大于总账号的的余额，分配失败，请修改成一个较小的值，或者先进行账号<a href='/pay'>充值</a>"; //提示信息
            $returnStr = json_encode($arrReturn);
			echo $returnStr;
			exit;
		}
		if (($phoneId == null) || (!is_numeric($phoneId))) {
			$arrReturn["result"] = 1; //失败
			$arrReturn["backUrl"] = "/saccount/thelist";
            $arrReturn["info"] = "提交的参数异常，请重试"; //提示信息
            $returnStr = json_encode($arrReturn);
			echo $returnStr;
			exit;
		}
		$phoneId = intval($phoneId);
		for ($i = 1; $i <= $phoneId; $i++) {
			if (trim($_POST["phone" . $i]) != null) {
				$postPhone = trim($_POST["phone" . $i]);
				$postPhoneMark = trim($_POST["phone" . $i . "Mark"]);
				if ($this->checkPhone($postPhone) == false) {
					$arrReturn["result"] = 1; //失败
		            $arrReturn["info"] = "手机号码 " . $postPhone . $i. " 格式错误，请输入正确手机号"; //提示信息
		            $returnStr = json_encode($arrReturn);
					echo $returnStr;
					exit;
				}
				$postPhone = str_replace("[", "", $postPhone);
				$postPhone = str_replace("]", "", $postPhone);
				$postPhone = str_replace("@", "", $postPhone);
				$postPhone = str_replace("#", "", $postPhone);
				$postPhone = str_replace("*", "", $postPhone);
				$postPhoneMark = str_replace("[", "", $postPhoneMark);
				$postPhoneMark = str_replace("]", "", $postPhoneMark);
				$postPhoneMark = str_replace("@", "", $postPhoneMark);
				$postPhoneMark = str_replace("#", "", $postPhoneMark);
				$postPhoneMark = str_replace("*", "", $postPhoneMark);
				$postPhone = trim($postPhone);
				$postPhoneMark = trim($postPhoneMark);
				$phoneStr .= ",[" . $postPhone . "@#*#@" . $postPhoneMark . "]";
			}
		}
		$phoneStr = trim($phoneStr);
		if ($phoneStr == null) {
			$arrReturn["result"] = 1; //失败
            $arrReturn["info"] = "您必须至少填写一个手机号码"; //提示信息
            $returnStr = json_encode($arrReturn);
			echo $returnStr;
			exit;
		}
		
		$Member = M("Member");
		$bshopid = $useridInfo["0"]["userid"] + 1;
		//更新总店自己的钱
		$rootShopMoneyUpdateResult = $Member->where("userid = $this->userid")->setDec("money", $money);
		
		//插入新分店记录
		$data = array();
		$Member->startTrans();
		$useridInfo = $Member->where(1)->order("userid desc")->limit(1)->select();
		$data["fid"] = $this->userid;
		$data["userid"] = $useridInfo["0"]["userid"] + 1;
		$data["username"] = $username;
		$pswmd5 = md5($password);
		$data["pswmd5"] = $pswmd5;
		$data["phone"] = $phoneStr;
		$data["last_login_time"] = 0;
		$data["shop_name"] = $shopName;
		$data["shop_manager"] = $shopManager;
		$data["shop_telephone"] = $shopTelephone;
		$data["money"] = $money;
		$data["status"] = 0;
		$memberAddresult = $Member->add($data);
		
		$time = time();
		//更新金额分配表
		$MoneyDistributeDetail = M("MoneyDistributeDetail");
		$data = array();
		$data["time"] = $time;
		$data["money"] = $money;
		$data["userid"] = $this->userid;
		$data["branch_userid"] = $bshopid;
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
		$data["userid"] = $bshopid;
		$data["money"] = $money;
		$data["change_type"] = 1;
		$data["change_reason"] = 3;
		$data["time"] = $time;
		$data["phone"] = "";
		$moneyChangeDetailBshopSaveResult = $MoneyChangeDetail->add($data);//分店增加金额
		
		if(($memberAddresult != false) && ($moneyDistributeDetailSaveResult != false) && ($moneyChangeDetailRootShopSaveResult != false) && ($moneyChangeDetailBshopSaveResult != false)) {
			// 提交事务
    		$Member->commit(); 
			$arrReturn["result"] = 0; //成功
			$arrReturn["backUrl"] = "/saccount/thelist";
            $arrReturn["info"] = "添加成功"; //提示信息
            $returnStr = json_encode($arrReturn);
			echo $returnStr;
			exit;
		} else {
			//事务回滚
			$Member->rollback();
			$arrReturn["result"] = 1; //失败
			$arrReturn["backUrl"] = "/saccount/thelist";
            $arrReturn["info"] = "系统异常，操作操作失败，请稍后重试!"; //提示信息
            $returnStr = json_encode($arrReturn);
			echo $returnStr;
			exit;
		}
	}
	
	/*
	 * 进行实际的修改密码操作
	 */
	public function doChangeBshopPsw() {
		header('Content-Type:application/json; charset=utf-8');
		$this->checkIfIsBshop();
		$shopid = trim($_POST["shopid"]);
		$password = trim($_POST["password"]);
		$passwordConfirm = trim($_POST["passwordConfirm"]);
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
		
		if ($password == null) {
			$arrReturn["result"] = 1; //失败
            $arrReturn["info"] = "密码不能为空"; //提示信息
            $returnStr = json_encode($arrReturn);
			echo $returnStr;
			exit;
		}
		if ($passwordConfirm == null) {
			$arrReturn["result"] = 1; //失败
            $arrReturn["info"] = "确认密码不能为空"; //提示信息
            $returnStr = json_encode($arrReturn);
			echo $returnStr;
			exit;
		}
		if (strlen($password) < 6) {
			$arrReturn["result"] = 1; //失败
            $arrReturn["info"] = "密码长度不能小于6位"; //提示信息
            $returnStr = json_encode($arrReturn);
			echo $returnStr;
			exit;
		}
		if ($password != $passwordConfirm) {
			$arrReturn["result"] = 1; //失败
            $arrReturn["info"] = "密码与确认密码不一致"; //提示信息
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
		
		$data = array();
		$data["pswmd5"] = md5($password);
		$result = $Member->where("userid = " . $shopid . " and fid = " . $this->userid)->save($data);
		if ($result != false) {
			$arrReturn["result"] = 0; //失败
            $arrReturn["info"] = "修改密码成功"; //提示信息
            $returnStr = json_encode($arrReturn);
			echo $returnStr;
			exit;
		} else {
			$arrReturn["result"] = 1; //失败
            $arrReturn["info"] = "系统故障，操作失败，请稍后重试"; //提示信息
            $returnStr = json_encode($arrReturn);
			echo $returnStr;
			exit;
		}
	}
	
	/*
	 * 进行实际的分店信息修改操作
	 */
	public function doEditBshop() {
		header('Content-Type:application/json; charset=utf-8');
		$this->checkIfIsBshop();
		$arrReturn["backUrl"] = ""; //初始化
		$shopid = trim($_POST["shopid"]);
		$phoneId  = trim($_POST["phoneId"]);
		$shopName = trim($_POST["shopName"]);
		$shopManager = trim($_POST["shopManager"]);
		$shopTelephone = trim($_POST["shopTelephone"]);
		
		
		if(($this->checkIfIsAInt($phoneId) == false) || (checkIfIsAInt == null)) {
			$arrReturn["result"] = 1; //失败
			$arrReturn["errorCode"] = 1; //相关用户不存在
			$arrReturn["backUrl"] = "/saccount/thelist";
	        $arrReturn["info"] = "提交的参数异常"; //提示信息
	        $returnStr = json_encode($arrReturn);
			echo $returnStr;
			exit;
		}
		
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
		if ($shopName == null) {
			$arrReturn["result"] = 1; //失败
            $arrReturn["info"] = "分店名称不能为空"; //提示信息
            $returnStr = json_encode($arrReturn);
			echo $returnStr;
			exit;
		}
		if ($shopManager == null) {
			$arrReturn["result"] = 1; //失败
            $arrReturn["info"] = "负责人不能为空"; //提示信息
            $returnStr = json_encode($arrReturn);
			echo $returnStr;
			exit;
		}
		if ($shopTelephone == null) {
			$arrReturn["result"] = 1; //失败
            $arrReturn["info"] = "电话不能为空"; //提示信息
            $returnStr = json_encode($arrReturn);
			echo $returnStr;
			exit;
		}
		
		$phoneId = intval($phoneId);
		for ($i = 1; $i <= $phoneId; $i++) {
			if (trim($_POST["phone" . $i]) != null) {
				$postPhone = trim($_POST["phone" . $i]);
				$postPhoneMark = trim($_POST["phone" . $i . "Mark"]);
				if ($this->checkPhone($postPhone) == false) {
					$arrReturn["result"] = 1; //失败
		            $arrReturn["info"] = "手机号码 " . $postPhone . $i. " 格式错误，请输入正确手机号"; //提示信息
		            $returnStr = json_encode($arrReturn);
					echo $returnStr;
					exit;
				}
				$postPhone = str_replace("[", "", $postPhone);
				$postPhone = str_replace("]", "", $postPhone);
				$postPhone = str_replace("@", "", $postPhone);
				$postPhone = str_replace("#", "", $postPhone);
				$postPhone = str_replace("*", "", $postPhone);
				$postPhoneMark = str_replace("[", "", $postPhoneMark);
				$postPhoneMark = str_replace("]", "", $postPhoneMark);
				$postPhoneMark = str_replace("@", "", $postPhoneMark);
				$postPhoneMark = str_replace("#", "", $postPhoneMark);
				$postPhoneMark = str_replace("*", "", $postPhoneMark);
				$postPhone = trim($postPhone);
				$postPhoneMark = trim($postPhoneMark);
				$phoneStr .= ",[" . $postPhone . "@#*#@" . $postPhoneMark . "]";
			}
		}
		$phoneStr = trim($phoneStr);
		$phoneStr = substr($phoneStr, 1, (strlen($phoneStr) - 1));  
		if ($phoneStr == null) {
			$arrReturn["result"] = 1; //失败
            $arrReturn["info"] = "您必须至少填写一个手机号码"; //提示信息
            $returnStr = json_encode($arrReturn);
			echo $returnStr;
			exit;
		}
		
		$data = array();
		$data["shop_name"] = $shopName;
		$data["shop_manager"] = $shopManager;
		$data["shop_telephone"] = $shopTelephone;
		$data["phone"] = $phoneStr;
		$result = $Member->where("userid = " . $shopid . " and fid = " . $this->userid)->save($data);
		if ($result != false) {
			$arrReturn["result"] = 0; //失败
            $arrReturn["info"] = "修改成功"; //提示信息
            $returnStr = json_encode($arrReturn);
			echo $returnStr;
			exit;
		} else {
			$arrReturn["result"] = 1; //失败
            $arrReturn["info"] = "系统故障，操作失败，请稍后重试"; //提示信息
            $returnStr = json_encode($arrReturn);
			echo $returnStr;
			exit;
		}		
	}
	
	/*
	 * 进行操作删除,所谓的删除其实是停用
	 */
	public function doBshopDel() {
		$shopid = trim($this->_get("shopid"));
		$Member = M("Member");
		$count = $Member->where("userid = " . $shopid . " and fid = " . $this->userid . " and status != 1")->count();
		if ($count != 1) {
			$jsonArr["result"]="notfound";
			$jsonStr=json_encode($jsonArr);
			echo $jsonStr;
		} else {
			$jsonArr["result"]="found";
		}
		$data = array();
		$data["status"] = 1;
		$result = $Member->where("userid = " . $shopid . " and fid = " . $this->userid . " and status != 1")->save($data);
		if ($result != false) {
			$jsonArr["delResult"]="success";
		} else {
			$jsonArr["delResult"]="fail";
		}
		$jsonStr=json_encode($jsonArr);
		echo $jsonStr;
	}
	
	/*
	 * 进行实际的用户启用操作
	 */
	public function doStartUser() {
		$shopid = trim($this->_get("shopid"));
		$Member = M("Member");
		$count = $Member->where("userid = " . $shopid . " and fid = " . $this->userid . " and status != 0")->count();
		if ($count != 1) {
			$jsonArr["result"]="notfound";
			$jsonStr=json_encode($jsonArr);
			echo $jsonStr;
		} else {
			$jsonArr["result"]="found";
		}
		$data = array();
		$data["status"] = 0;
		$result = $Member->where("userid = " . $shopid . " and fid = " . $this->userid . " and status != 0")->save($data);
		if ($result != false) {
			$jsonArr["delResult"]="success";
		} else {
			$jsonArr["delResult"]="fail";
		}
		$jsonStr=json_encode($jsonArr);
		echo $jsonStr;
	}
	
	/*
	 * 获取分店名称描述
	 */
	public function getBshopNameDescribe() {
		$shopid = trim($this->_get("shopid"));
		$Member = M("Member");
		$count = $Member->where("userid = " . $shopid . " and fid = " . $this->userid)->count();
		if ($count != 1) {
			$jsonArr["result"]="notfound";
			$jsonStr=json_encode($jsonArr);
			echo $jsonStr;
			exit;
		}
		
		$memberInfo = $Member->where("userid = " . $shopid . " and fid = " . $this->userid)->limit(0)->select();
		$shopNameDescribe = $this->shopNameDescribe . "-" . $memberInfo[0]["shop_name"];
		$jsonArr["result"]="found";
		$jsonArr["bshopNameDescribe"] = $shopNameDescribe;
		$jsonStr=json_encode($jsonArr);
		echo $jsonStr;
		
	}
	
}

