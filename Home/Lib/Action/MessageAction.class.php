<?php
/*
 * 通知
 */
class MessageAction extends Action {
	public function index() {
	
	}
	
	public function stopWebsite() {
		$Message = M("Message");
		$messageInfo = $Message->where("message_type = 1 and message_status = 1")->select();
		if ($messageInfo[0]["message_type"] == 1) {
			$stopWebsiteActiveStartTime = trim($messageInfo[0]["active_start_time"]);
			$stopWebsiteActiveEndTime = trim($messageInfo[0]["active_end_time"]);
			if (($stopWebsiteActiveStartTime == null) || ($stopWebsiteActiveStartTime == "0") || ($stopWebsiteActiveStartTime < time())) {
				if (($stopWebsiteActiveEndTime == null) || ($stopWebsiteActiveEndTime == "0") || ($stopWebsiteActiveEndTime > time())) {
					$_SESSION["username"] = "";
					$_SESSION["pswmd5"] = "";
					$messageContent = $messageInfo[0]["message_content"];
					$this->assign("messageContent", $messageContent);
					$stopWebsiteActiveStatus = 1;
				} 
			}
		}
		if ($stopWebsiteActiveStatus == 1) {
			$this->display("stopWebsite");
		} else {
			header("location: /user/login");
		}
	}
	
	
}