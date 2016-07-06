<?php
/*
 * 设置
 */
class SettingAction extends AuthAction {

	public function index() {
		$Member = M("Member");
		$memberInfo = $Member->where("userid = " . $this->userid . " and status != 1")->limit(1)->select();
		if (count($memberInfo) != 1) {
			header("location: /saccount/thelist");
			exit;
		}
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
		$this->assign("phoneMark", $phoneArr[0]["phoneMark"]);
		$this->assign("phoneArr", $phoneArr);
		$this->assign("pagetype",109);
		$this->display();
	}
	
	/*
	 * 获取手机评论
	 */
	public function getPhoneMark() {
		$jsonArr["result"]="notfound"; //初始化
		$phone = trim($this->_get("phone"));
		$Member = M("Member");
		$memberInfo = $Member->where("userid = " . $this->userid . " and status != 1")->limit(1)->select();
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
		for ($i = 0; $i < count($phoneArr); $i++) {
			if ($phoneArr[$i]["phone"] == $phone){
				$phoneMark = $phoneArr[$i]["phoneMark"];
				$jsonArr["result"]="found";
				break;
			}
		}
		$jsonArr["phoneMark"] = $phoneMark;
		$jsonStr=json_encode($jsonArr);
		echo $jsonStr;
	}
	
	/*
	 * 修改密码
	 */
	public function doChangePsw() {
		header('Content-Type:application/json; charset=utf-8');
		$oldPsw = trim($_POST["oldPsw"]);
		$newPsw = trim($_POST["newPsw"]);
		$newPswConfirm = trim($_POST["newPswConfirm"]);
		if ($oldPsw == null) {
			$arrReturn["result"] = 1; //失败
            $arrReturn["info"] = "旧密码不能为空"; //提示信息
            $returnStr = json_encode($arrReturn);
			echo $returnStr;
			exit;
		}
		if ($newPsw == null) {
			$arrReturn["result"] = 1; //失败
            $arrReturn["info"] = "新密码不能为空"; //提示信息
            $returnStr = json_encode($arrReturn);
			echo $returnStr;
			exit;
		}
		if ($newPswConfirm == null) {
			$arrReturn["result"] = 1; //失败
            $arrReturn["info"] = "确认新密码不能为空"; //提示信息
            $returnStr = json_encode($arrReturn);
			echo $returnStr;
			exit;
		}
		if($this->userInfo["pswmd5"] != md5($oldPsw)) {
			$arrReturn["result"] = 1; //失败
            $arrReturn["info"] = "旧密码错误"; //提示信息
            $returnStr = json_encode($arrReturn);
			echo $returnStr;
			exit;
		} 
		if ($newPsw != $newPswConfirm) {
			$arrReturn["result"] = 1; //失败
            $arrReturn["info"] = "两次输入的新密码不一致"; //提示信息
            $returnStr = json_encode($arrReturn);
			echo $returnStr;
			exit;
		}
		if(strlen($newPsw) < 6) {
			$arrReturn["result"] = 1; //失败
            $arrReturn["info"] = "新密码长度不能小于6位"; //提示信息
            $returnStr = json_encode($arrReturn);
			echo $returnStr;
			exit;
		}
		$data = array();
		$data["pswmd5"] = md5($newPsw);
		$Member = M("Member");
		$result = $Member->where("userid = " .$this->userid)->save($data);
		if ($result == false) {
			$arrReturn["result"] = 1; //失败
            $arrReturn["info"] = "系统故障，修改密码失败，请稍后重试"; //提示信息
            $returnStr = json_encode($arrReturn);
			echo $returnStr;
			exit;
		} else {
			$arrReturn["result"] = 0; //失败
            $arrReturn["info"] = "修改密码成功，请重新登录!"; //提示信息
            $arrReturn["backUrl"] = "/index";
            $returnStr = json_encode($arrReturn);
			echo $returnStr;
			exit;
		}
	}
	
	/*
	 * 修改手机号码
	 */
	public function doChangePhone() {
		header('Content-Type:application/json; charset=utf-8');
		$oldPhone = trim($_POST["oldPhone"]);
		$phoneMark = trim($_POST["phoneMark"]);
		$smsCode = trim($_POST["smsCode"]);
		$newPhone = trim($_POST["newPhone"]);
		$newPhoneConfirm = trim($_POST["newPhoneConfirm"]);
		if ($oldPhone == null) {
			$arrReturn["result"] = 1; //失败
            $arrReturn["info"] = "当前手机号码不能为空"; //提示信息
            $returnStr = json_encode($arrReturn);
			echo $returnStr;
			exit;
		}
		if ($smsCode == null) {
			$arrReturn["result"] = 1; //失败
            $arrReturn["info"] = "短信验证码不能为空"; //提示信息
            $returnStr = json_encode($arrReturn);
			echo $returnStr;
			exit;
		}
		if ($newPhone == null) {
			$arrReturn["result"] = 1; //失败
            $arrReturn["info"] = "新手机号码不能为空"; //提示信息
            $returnStr = json_encode($arrReturn);
			echo $returnStr;
			exit;
		}
		if ($newPhoneConfirm == null) {
			$arrReturn["result"] = 1; //失败
            $arrReturn["info"] = "确认手机号码不能为空"; //提示信息
            $returnStr = json_encode($arrReturn);
			echo $returnStr;
			exit;
		}
		if ($newPhone != $newPhoneConfirm) {
			$arrReturn["result"] = 1; //失败
            $arrReturn["info"] = "新手机号码与确认手机号码不一致"; //提示信息
            $returnStr = json_encode($arrReturn);
			echo $returnStr;
			exit;
		}
		if($this->checkPhone($newPhone) == false) {
			$arrReturn["result"] = 1; //失败
            $arrReturn["info"] = "新手机号码格式错误，请检查"; //提示信息
            $returnStr = json_encode($arrReturn);
			echo $returnStr;
			exit;
		}
		if($this->checkPhone($oldPhone) == false) {
			$arrReturn["result"] = 1; //失败
            $arrReturn["info"] = "当前手机号码格式错误，请检查"; //提示信息
            $returnStr = json_encode($arrReturn);
			echo $returnStr;
			exit;
		}
		if (trim($_POST["smsCode"]) != $_SESSION["smsCode"]){
			$arrReturn["result"] = 1; //失败
       		$arrReturn["info"] = "短信验证码不正确!"; //提示信息
       		$returnStr = json_encode($arrReturn);
       		echo $returnStr;
       		exit;
		}
		if ((time()-$_SESSION["smsCodeTime"]) > 300) {
			$arrReturn["result"] = 1; //失败
       		$arrReturn["info"] = "短信验证码已过期，请重新获取!"; //提示信息
       		$returnStr = json_encode($arrReturn);
       		echo $returnStr;
       		exit;
		}
		if ($_SESSION["getSmscodePhone"] != trim($_POST["oldPhone"])) {
			$arrReturn["result"] = 1; //失败
       		$arrReturn["info"] = "你提交的当前手机号码与获取短信验证码的手机号码不一致!"; //提示信息
       		//$arrReturn["info"] = print_r($_SESSION);
       		$returnStr = json_encode($arrReturn);
       		echo $returnStr;
       		exit;
		}
		//验证这个手机号码是否已经在用户的可用于验证的手机号码列表中
		if($this->userInfo["phone"] == str_replace("[" . $oldPhone . "@#*#@", "", $this->userInfo["phone"])) {
			$arrReturn["result"] = 1; //失败
            $arrReturn["info"] = "你填写的当前手机号码不在允许进行验证的手机列表中，不能进行修改"; //提示信息
            $returnStr = json_encode($arrReturn);
			echo $returnStr;
			exit;
		}
		
		$Member = M("Member");
		$memberInfo = $Member->where("userid = " . $this->userid . " and status != 1")->limit(1)->select();
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
		$phoneStr = ""; //初始化
		for ($i = 0; $i < count($phoneArr); $i++) {
			if ($oldPhone == $phoneArr[$i]["phone"]) {
				$phoneStr .=",[" . $newPhone . "@#*#@" . $phoneMark . "]";
			} else {
				$phoneStr .=",[" . $phoneArr[$i]["phone"] . "@#*#@" . $phoneArr[$i]["phoneMark"] . "]";
			}
		}
		$phoneStr = substr($phoneStr, 1, (strlen($phoneStr) - 1));
		$data = array();
		//$data["phone"] = str_replace("[" . $oldPhone . "]", "[" . $newPhone . "]", $this->userInfo["phone"]);
		$data["phone"] = $phoneStr;
		$result = $Member->where("userid = " .$this->userid)->save($data);
		if ($result == false) {
			$arrReturn["result"] = 1; //失败
            $arrReturn["info"] = "系统故障，修改密码失败，请稍后重试"; //提示信息
            $returnStr = json_encode($arrReturn);
			echo $returnStr;
			exit;
		} else {
			$arrReturn["result"] = 0; //失败
            $arrReturn["info"] = "修改手机号成功!"; //提示信息
            $returnStr = json_encode($arrReturn);
			echo $returnStr;
			exit;
		}
	}
	
	/*
	 * 新增手机号码
	 */
	public function doAddPhone() {
		header('Content-Type:application/json; charset=utf-8');
		$phone = trim($_POST["phone"]);
		$phoneConfirm = trim($_POST["phoneConfirm"]);
		$phoneMark = trim($_POST["phoneMark"]);
		if ($phone == null) {
			$arrReturn["result"] = 1; //失败
            $arrReturn["info"] = "新手机号码不能为空"; //提示信息
            $returnStr = json_encode($arrReturn);
			echo $returnStr;
			exit;
		}
		if ($phoneConfirm == null) {
			$arrReturn["result"] = 1; //失败
            $arrReturn["info"] = "确认新手机号码不能为空"; //提示信息
            $returnStr = json_encode($arrReturn);
			echo $returnStr;
			exit;
		}
		if ($phone != $phoneConfirm) {
			$arrReturn["result"] = 1; //失败
            $arrReturn["info"] = "两次输入的手机号码不一致"; //提示信息
            $returnStr = json_encode($arrReturn);
			echo $returnStr;
			exit;
		}
		if($this->checkPhone($phone) == false) {
			$arrReturn["result"] = 1; //失败
            $arrReturn["info"] = "手机号码格式错误，请检查"; //提示信息
            $returnStr = json_encode($arrReturn);
			echo $returnStr;
			exit;
		}
		//验证这个手机号码是否已经在用户的可用于验证的手机号码列表中
		if($this->userInfo["phone"] != str_replace("[" . $phone . "]", "", $this->userInfo["phone"])) {
			$arrReturn["result"] = 1; //失败
            $arrReturn["info"] = "该手机号已经添加过了，请不要重复添加"; //提示信息
            $returnStr = json_encode($arrReturn);
			echo $returnStr;
			exit;
		}
		$phoneMark = str_replace("[", "", $phoneMark);
		$phoneMark = str_replace("]", "", $phoneMark);
		$phoneMark = str_replace("@", "", $phoneMark);
		$phoneMark = str_replace("#", "", $phoneMark);
		$phoneMark = str_replace("*", "", $phoneMark);
		$phoneMark = trim($phoneMark);
		$data = array();
		$data["phone"] = $this->userInfo["phone"] . ",[" . $phone . "@#*#@" . $phoneMark . "]";
		$Member = M("Member");
		$result = $Member->where("userid = " .$this->userid)->save($data);
		if ($result == false) {
			$arrReturn["result"] = 1; //失败
            $arrReturn["info"] = "系统故障，修改密码失败，请稍后重试"; //提示信息
            $returnStr = json_encode($arrReturn);
			echo $returnStr;
			exit;
		} else {
			$arrReturn["result"] = 0; //失败
            $arrReturn["info"] = "添加新手机号成功!"; //提示信息
            $returnStr = json_encode($arrReturn);
			echo $returnStr;
			exit;
		}
	}
}

