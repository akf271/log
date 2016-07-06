<?php
/*
 * 用户登录、登出管理
 */
class UserAction extends NoauthAction {
	public function index() {

	}
	
	/*
	 * 在展示登录页面前检查登录状态
	 */
	private function checkLoginStatusBeforeLogin() {
		if ($this->isLogined == true) {
			$jumpUrl = $this->getJumpUrlForLogined($this->fid);
			header("Location: " . $jumpUrl);
			exit;
		}
	}
	
	/*
	 * 验证传过来的24时小时免费手机验证码选项
	 */
	private function checkOnedayLoginSetting($username) {
		if (trim($_POST["onedaylogin"]) == "1") {
			setcookie("onedayLoginActiveStatus_" . trim($username), 1, (time()+3600*24), "/",$_SERVER["HTTP_HOST"]);
		}
	}
	
	/*
	 * 进行登陆的手机验证码检测
	 */
	private function doLoginSmscodeCheck($username) {
		if ($_COOKIE["onedayLoginActiveStatus_" . trim($username)] != 1) {
			header('Content-Type:application/json; charset=utf-8');
			if (trim($_POST["smscode"]) == null){
				$arrReturn["result"] = 1; //失败
	       		$arrReturn["info"] = "手机验证码不能为空!"; //提示信息
	       		$returnStr = json_encode($arrReturn);
	       		echo $returnStr;
	       		exit;
			}
			if (trim($_POST["smscode"]) != $_SESSION["smsCode"]){
				$arrReturn["result"] = 1; //失败
	       		$arrReturn["info"] = "手机验证码不正确!"; //提示信息
	       		$returnStr = json_encode($arrReturn);
	       		echo $returnStr;
	       		exit;
			}
			if (($_SESSION["smsCodeTime"]-time())>300){
				$arrReturn["result"] = 1; //失败
	       		$arrReturn["info"] = "手机验证码已过期!"; //提示信息
	       		$returnStr = json_encode($arrReturn);
	       		echo $returnStr;
	       		exit;
			}
			if ($_SESSION["getSmscodePhone"] != trim($_POST["phone"])) {
				$arrReturn["result"] = 1; //失败
	       		$arrReturn["info"] = "手机验证码与手机不匹配!"; //提示信息
	       		$returnStr = json_encode($arrReturn);
	       		echo $returnStr;
	       		exit;
			}
			
			//再验证一下手机号码是否在指定账号允许使用的验证手机列表内
			$Member = M("Member");												 
			$memberInfo = $Member->where("username = \"" . trim($username) . "\" and phone like(\"%[" . trim($_POST["phone"]) . "@#*#@%]%\")")->limit(1)->select();
			if (count($memberInfo) == 0) {
				$arrReturn["result"] = 1; //失败
	       		$arrReturn["info"] = "该账号不能用这个手机号进行验证!"; //提示信息
	       		$returnStr = json_encode($arrReturn);
	       		echo $returnStr;
	       		exit;
			}
		}
	}
	/*
	 * 记录本次登录
	 */
	function doLoginRecord($userid, $phone) {
		//在登录记录表中加入新记录
		$LoginDetail = M("LoginDetail");
		$data = array();
		$data["userid"] = $userid;
		$data["phone"] = $phone;
		$data["login_ip"] = $this->getIp();
		$time = time();
		$data["login_time"] = $time;
		$LoginDetail->add($data);
		
		//更新Member表中账号的最后登录时间
		$data = array();
		$Member = M("Member");
		$data["last_login_time"] = $time;
		$Member->where("userid = " . $userid)->save($data);
	}
	
	public function login() {
		$this->checkLoginStatusBeforeLogin();
		$this->display();
	} 
	
	public function logout() {
		$this->destroyLoginStatus();
		header("Location: /user/login");
	}
	
	/*
	 * 设置登录状态，也就是设置Session/Cookie
	 */
	private function setLoginStatus($userInfo) {
	 	$_SESSION['username'] = $userInfo['username'];
        $_SESSION['pswmd5'] = $userInfo['pswmd5'];
	}
	
	/*
	 * 销毁登录状态
	 */
	private function destroyLoginStatus() {
		$_SESSION["username"] = "";
		$_SESSION["pswmd5"] = "";
	}
	
	/*
	 * 获取登陆后的跳转地址
	 */
	private function getJumpUrlForLogined($fid) {
		$jumpUrlForLogined =C("jumpUrlForLogined");
		if ($fid == 0) {
			$jumpUrlForLogined = $jumpUrlForLogined["rootShop"];
		} else {
			$jumpUrlForLogined = $jumpUrlForLogined["branchShop"];
		}
		return $jumpUrlForLogined;
	}
	
	/*
	 * 进行实际的登录操作
	 */
	public function doLogin() {
		$this->doLoginSmscodeCheck($_POST["username"]);
		header('Content-Type:application/json; charset=utf-8');
        $Member = M("Member");
        $username = trim($_POST["username"]);
        $pswmd5 = md5(trim($_POST["password"]));
        $result = $Member->where("username = \"" . $username . "\" and pswmd5=\"" . $pswmd5 . "\"")->limit(1)->select();
        if($result != false){
        	if ($result[0]["status"] != 0) {
        		//账号禁用状态
        		$arrReturn["result"] = 1; //失败
	            $arrReturn["info"] = "该账号已经停用，如有疑问，请联系总店管理员!"; //提示信息
	            $returnStr = json_encode($arrReturn);
        	} else {
        		//如果是子店，查看总店是否禁用
        		if ($result[0]["fid"] != 0) {
	        		$rootShopInfo = $Member->where("userid = " . $result[0]["fid"])->select();
					$rootShopStatus = $rootShopInfo[0]["status"];
					if ($rootShopStatus != 0) {
						$arrReturn["result"] = 1; //失败
		            	$arrReturn["info"] = "因总账号被停用，该账号也被停用!"; //提示信息
		            	$returnStr = json_encode($arrReturn);
					} else {
						$this->setLoginStatus($result[0]); //设置登陆状态
			        	$this->checkOnedayLoginSetting($_POST["username"]);  //检查是否24小时内登陆免验证码
			        	//进行登录记录
			        	$userid = $result[0]["userid"];
			        	if ($_COOKIE["onedayLoginActiveStatus"] != 1) {
			        		$phone = trim($_POST["phone"]);
			        	} else {
			        		$phone = 0;
			        	}
			        	$this->doLoginRecord($userid, $phone);
			        	
			            $arrReturn["result"] = 0; //成功
			            $arrReturn["info"] = "恭喜，登录成功!"; //提示信息
			            $arrReturn["backUrl"] = $this->getJumpUrlForLogined($result[0]["fid"]);
					}
        		} else {
        			$this->setLoginStatus($result[0]); //设置登陆状态
		        	$this->checkOnedayLoginSetting($_POST["username"]);  //检查是否24小时内登陆免验证码
		        	//进行登录记录
		        	$userid = $result[0]["userid"];
		        	if ($_COOKIE["onedayLoginActiveStatus"] != 1) {
		        		$phone = trim($_POST["phone"]);
		        	} else {
		        		$phone = 0;
		        	}
		        	$this->doLoginRecord($userid, $phone);
		        	
		            $arrReturn["result"] = 0; //成功
		            $arrReturn["info"] = "恭喜，登录成功!"; //提示信息
		            $arrReturn["backUrl"] = $this->getJumpUrlForLogined($result[0]["fid"]);
        		}
        	}
        } else {
            $arrReturn["result"] = 1; //失败
            $arrReturn["info"] = "用户名或密码不正确!"; //提示信息
            $returnStr = json_encode($arrReturn);
        }
        $returnStr = json_encode($arrReturn);
        echo $returnStr;
	}
	
	public function checkUserOnedayLoginStatus() {
		$jsonArr = array(); //初始化
		$username = trim($this->_get("username"));
		if ($username != null) {
			if ($_COOKIE["onedayLoginActiveStatus_" . trim($username)] != 1) {
				$jsonArr["result"] = 0; //未发现该账号24小时内免手机验证的设置
			} else {
				$jsonArr["result"] = 1;  //该账号24小时内免手机验证
			}
		} else {
				$jsonArr["result"] = 0;  
		}
		echo json_encode($jsonArr);
	}
	
	/*
	 * 验证登录信息，同时获取手机验证码
	 */
	public function getSmscodeandchecklogininfo() {
	
	}
	
}


