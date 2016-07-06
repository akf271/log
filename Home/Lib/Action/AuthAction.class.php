<?php
class AuthAction extends CommonAction {
	protected $isLogined; //登录状态
	protected $fid; //父ID
	protected $userid; //用户ID
	protected $username;
	protected $userInfo; //用户信息
	protected $shopNameDescribe; //店名描述
	protected $messageDescribe;  //网站暂停、充值暂停通知
	protected $consumeEnableStatus; //可充值状态:1:可以正常充值，0：不能
	protected $stopWebsiteMessage;  //暂停网站通知
	protected $stopConsumeMessage;  //暂停充值话费的通知内容
	protected $isRootShopDisable; //总店是否停用
	

	/*
	 * 初始化
	 */
	public function _initialize(){
		$this->getUserInfo();
		$this->checkLogin();
		$this->shopNameDescribe = $this->getShopNameDescribe();
		$this->processMessages();
		
	}
	
	/*
	 * 验证登陆状态
	 */
	private function getUserInfo(){
		$this->isLogined = false; //初始化 
		$username = trim($_SESSION["username"]);
		$pswmd5 = trim($_SESSION["pswmd5"]);
		if(($username != NULL)&&($pswmd5 != NULL)){
			$Member = M("Member");
			$memberInfo = $Member->where("username=\"".$username."\" and pswmd5=\"".$pswmd5."\" and status = 0")->order("id")->limit(1)->select();
			if($memberInfo != false){
				if(($memberInfo[0]["username"] == $username) && ($memberInfo[0]["pswmd5"] == $pswmd5)){
					if ($memberInfo[0]["fid"] == 0) {
						$this->isLogined = true;
						$this->fid = $memberInfo[0]["fid"];
						$this->userid = $memberInfo[0]["userid"];
						$this->username = $memberInfo[0]["username"];
						$this->userInfo = $memberInfo[0];
					} else {
						//如果是分店，还要查看总店是否停用，如果总店停用，那么分店也不能用
						$rootShopInfo = $Member->where("userid = " . $memberInfo[0]["fid"])->select();
						$rootShopStatus = $rootShopInfo[0]["status"];
						if ($rootShopStatus == 0) {
							$this->isLogined = true;
							$this->fid = $memberInfo[0]["fid"];
							$this->userid = $memberInfo[0]["userid"];
							$this->username = $memberInfo[0]["username"];
							$this->userInfo = $memberInfo[0];
							$this->isRootShopDisable = false;
						} else {
							$this->isRootShopDisable = true;
						}
					}
					
				}
			}
		}
		$this->assign("isLogined",$this->isLogined);
		$this->assign("fid",$this->fid);
		$this->assign("userid",$this->userid);
		$this->assign("username",$this->username);
		$this->assign("userInfo",$this->userInfo);
	}

	/*
	 * 验证是否已经登陆
	 */
	private function checkLogin(){
		if(($this->isLogined)!= true){
			header("location: /user/login");
			exit;
		}
	}
	
	/*
	 * 验证是否是否是分店，如果是分店，有些菜单不能访问
	 */
	public function checkIfIsBshop() {
		if ($this->fid != 0) {
			//说明是分店
			$jumpUrlForLogined =C("jumpUrlForLogined");
			$defaultHomePage = $jumpUrlForLogined["branchShop"];
			header("Location: " . $defaultHomePage);
			exit;
		}
	}
	
	/*
	 * 验证是否是否是总店，如果是总店，有些菜单不能访问
	 */
	public function checkIfIsRootshop() {
		if ($this->fid == 0) {
			//说明是分店
			$jumpUrlForLogined =C("jumpUrlForLogined");
			$defaultHomePage = $jumpUrlForLogined["rootShop"];
			header("Location: " . $defaultHomePage);
			exit;
		}
	}
	
	/*
	 * 获取店名描述
	 */
	public function getShopNameDescribe() {
		if ($this->fid == 0) {
			$shopNameDescribe = $this->userInfo["shop_name"];
		} else {
			$Member = M("Member");
			$memberInfo = $Member->where("userid = " . $this->fid)->select();
			$shopNameDescribe = $memberInfo[0]["shop_name"] . "_" . $this->userInfo["shop_name"];
		}
		$this->assign("shopNameDescribe", $shopNameDescribe);
		return $shopNameDescribe;
	}
	
	/*
	 * 处理网站暂停及充值暂停通知
	 */
	public function processMessages() {
		$Message = M("Message");
		$messageInfo = $Message->where("message_type = 1 and message_status = 1")->select();
		if ($messageInfo[0]["message_type"] == 1) {
			$stopWebsitePromptStartTime = trim($messageInfo[0]["prompt_start_time"]);
			$stopWebsiteActiveStartTime = trim($messageInfo[0]["active_start_time"]);
			$stopWebsiteActiveEndTime = trim($messageInfo[0]["active_end_time"]);
			if (($stopWebsiteActiveStartTime == null) || ($stopWebsiteActiveStartTime == "0") || ($stopWebsiteActiveStartTime < time())) {
				if (($stopWebsiteActiveEndTime == null) || ($stopWebsiteActiveEndTime == "0") || ($stopWebsiteActiveEndTime > time())) {
					header("location: /message/stopwebsite");
					exit;
				} 
			}
			if ($stopWebsitePromptStartTime <= time()) {
				$this->stopWebsiteMessage = trim($messageInfo[0]["message_content"]);
				
			}
			$this->assign("stopWebsiteMessage", $this->stopWebsiteMessage);
		}
		
		$messageInfo = array();//重新初始化
		$messageInfo = $Message->where("message_type = 2  and message_status = 1")->select();
		if ($messageInfo[0]["message_type"] == 2) {
			$stopConsumePromptStartTime = trim($messageInfo[0]["prompt_start_time"]);
			$stopConsumeActiveStartTime = trim($messageInfo[0]["active_start_time"]);
			$stopConsumeActiveEndTime = trim($messageInfo[0]["active_end_time"]);
			if (($stopConsumeActiveStartTime == null) || ($stopConsumeActiveStartTime == "0") || ($stopConsumeActiveStartTime < time())) {
				if (($stopConsumeActiveEndTime == null) || ($stopConsumeActiveEndTime == "0") || ($stopConsumeActiveEndTime > time())) {
					$this->consumeEnableStatus = 1;
					$this->stopConsumeMessage = trim($messageInfo[0]["message_content"]);
				} 
			}
			if ($stopConsumePromptStartTime <= time()) {
				$this->stopConsumeMessage = trim($messageInfo[0]["message_content"]);
			}
			$this->assign("consumeEnableStatus", $this->consumeEnableStatus);
			$this->assign("stopConsumeMessage", $this->stopConsumeMessage);
		}
		
	}
}
