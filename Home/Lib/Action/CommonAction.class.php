<?php
class CommonAction extends Action {
    
	/*
	 * 初始化
	 */
	public function _initialize(){

	}
	
	/*
     * 判断记录是否存在，如果不存在，就直接跳转到一个页面
     * 如果存在，就返回这一条查询到的结果
     */
    protected function checkRecordExist($dbName, $where, $jumpUrl) {
        $DbLink = M($dbName);
        $result = $DbLink->where($where)->select();
        if ($result == false) {
            header("location:" . $jumpUrl);
            exit;
        } else {
            return $result[0];
        }
    }
    
	/*
	 * 验证电话号码格式验证，规则比较宽，
	 * 只验证只有+和-和数字这些字符
	 */
	protected function checkPhoneFormat($phoneStr){
		$phoneStr=trim($phoneStr);
		$phoneStr=str_replace("+", "", $phoneStr);
		$phoneStr=str_replace("-", "", $phoneStr);
		$phoneStr=trim($phoneStr);
		$mode="/^(\d)+$/i";
		if(preg_match($mode,$phoneStr)){
			return true;
		}else{
			return false;
		}
	}
    
	//校验短信验证码
	private function checkSmsCode($smsCode,$phone){
		$result = true;
		$phone = trim($phone);
		$smsCode = trim($smsCode);
		if ($smsCode != $_SESSION["smsCode"]){
			$result = false;
		}
		if (($_SESSION["smsCodeTime"]-time())>300){
			$result = false;
		}
		if ($_SESSION["getSmscodePhone"] != $phone) {
			$result = false;
		}
		return $result;
	}
	
    protected  function checkPhoneSession($phone){
		//验证提交的手机号与获取短信码的相同
		$phone=trim($phone);
		if($phone!=$_SESSION["getSmscodePhone"]){
			$result=false;
		}else{
			return true;
		}
	}
	
	
	/*
	 * 对手机号码格式进行正则验证
	 */
	protected function checkPhone($phone){
		//验证手机格式
		import('ORG.Util.TelPhone');
		$telPhone=new TelPhone($phone);
		$result=$telPhone->checkTelPhoneNum();
		return $result;
	}
    
	/*
	 * 对post数据进行记录
	 */
	protected function recodePostData($savePath) {
	    if (is_array($_POST)) {
	        $strToWrite = date("Y-m-d H:i:s") . "\r\n";
	        foreach ($_POST as $key => $value) {
	            $strToWrite .= $key . "#" . $value . "\r\n";
	        }
	        $strToWrite .= "-------------------------------------------------------\r\n";
	    }
	    $fp = fopen($savePath, "a+");
	    flock($fp, LOCK_EX);
	    fwrite($fp,$strToWrite);
	    fclose($fp);
	}
	
	/*
	 * 对Request数据进行记录
	 */
	protected function recodeRequestData($savePath) {
	    if (is_array($_REQUEST)) {
	        $strToWrite = date("Y-m-d H:i:s") . "\r\n";
	        foreach ($_REQUEST as $key => $value) {
	            $strToWrite .= $key . "#" . $value . "\r\n";
	        }
	        $strToWrite .= "-------------------------------------------------------\r\n";
	    }
	    $fp = fopen($savePath, "a+");
	    flock($fp, LOCK_EX);
	    fwrite($fp,$strToWrite);
	    fclose($fp);
	}
	
	/*
     * 输出ajax返回信息，并退出程序执行
     */
    protected function echoAjaxBackInfoAndExit($result, $info) {
        header('Content-Type:application/json; charset=utf-8'); 
        $arrReturn["result"] = $result; 
        $arrReturn["info"] = $info;
        $returnStr = json_encode($arrReturn);
        echo $returnStr;
        exit;
    }
    
    /*
     * 邮箱正则表达式
     */
	protected function checkEmail($str){
		return (preg_match('/^[_.0-9a-z-a-z-]+@([0-9a-z][0-9a-z-]+.)+[a-z]{2,4}$/',$str))?true:false;
	}
	
	/*
	 * 获取客户端IP地址
	 */
	public function getIp(){
		if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
		$ip = getenv("HTTP_CLIENT_IP");
		else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
		$ip = getenv("HTTP_X_FORWARDED_FOR");
		else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
		$ip = getenv("REMOTE_ADDR");
		else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
		$ip = $_SERVER['REMOTE_ADDR'];
		else
		$ip = "unknown";
		return($ip);
	} 
	
	/*
	 * 获取分店列表
	 */
	public function getBshopList($userid) {
		$Member = M("Member");
		$memberInfo = $Member->where("fid = " . $userid)->order("userid desc")->select();
		return $memberInfo;
	}
    
	/*
	 * 根据店ID获取店名称
	 */
	public function getShopNameByShopId($shopId) {
		$shopId = trim($shopId);
		$Member = M("Member");
		$memberInfo = $Member->where("userid = " . $shopId)->limit(1)->select();
		$shopName = $memberInfo[0]["shop_name"];
		return $shopName;
	}

	//验证是否是一个整数类型，不带小数点
	 protected function checkIfIsAInt($str){
	 	$str=trim($str);
		$mode="/^\d+$/i";
		if(preg_match($mode,$str)){
			return true;
		}else{
			return false;
		}
	 }
	 
	/*
	 * 验证是否是整数或2位以内小数
	 */
	public function checkFloatBitLessThanThree($str) {
		$str = trim($str);
		$aryExplode = explode(".", $str);
		if (count($aryExplode) > 2) {
			return false;
		}
		$intStr = trim($aryExplode[0]);
		$floatStr = trim($aryExplode[1]);
		if (($this->checkIfIsAInt($intStr) == false) || ($intStr == null)) {
			return false;
		}
		if (($floatStr != null) && ($this->checkIfIsAInt($floatStr) == false)) {
			return false;
		}
		if (strlen($floatStr) > 2) {
			return false;
		}
		return true;
	}
	
	/*
	 * 根据店的ID获取店的信息
	 */
	public function getShopInfoByShopId($shopid) {
		$shopid = trim($shopid);
		$Member = M("Member");
		$memberInfo = $Member->where("userid = " . $shopid)->limit(1)->select();
		return $memberInfo[0];
	}
	
	//显示成功信息
	public function showSuccessDialog($jumpUrl,$msg){
		$this->assign("jumpUrl",$jumpUrl);
		$this->assign("msg",$msg);
		$this->display("Common:successMsg");
		exit;
	}
	
}
