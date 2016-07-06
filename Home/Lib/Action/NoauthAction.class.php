<?php
class NoauthAction extends CommonAction {
	protected $isLogined; //登录状态
	protected $fid; //父ID
	protected $userid; //用户ID
	protected $username;
	protected $userInfo; //用户信息
	protected $isRootShopDisable; //总店是否停用

	/*
	 * 初始化
	 */
	public function _initialize(){
		$this->getUserInfo();
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
			$memberInfo = $Member->where("username=\"".$username."\" and pswmd5=\"".$pswmd5."\"  and status = 0")->order("id")->limit(1)->select();
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
	 * 处理网站暂停及充值暂停通知
	 */
	public function processMessages() {
		$Message = M("Message");
		$messageInfo = $Message->where("message_type = 1 and message_status = 1")->select();
		if ($messageInfo[0]["message_type"] == 1) {
			$stopWebsiteActiveStartTime = trim($messageInfo[0]["active_start_time"]);
			$stopWebsiteActiveEndTime = trim($messageInfo[0]["active_end_time"]);
			if (($stopWebsiteActiveStartTime == null) || ($stopWebsiteActiveStartTime == "0") || ($stopWebsiteActiveStartTime < time())) {
				if (($stopWebsiteActiveEndTime == null) || ($stopWebsiteActiveEndTime == "0") || ($stopWebsiteActiveEndTime > time())) {
					header("location: /message/stopwebsite");
					exit;
				} 
			}
		}
	}
}
