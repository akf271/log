<?php
class SmscodeAction extends NoauthAction {
	public function index (){
		
	}
	
	/*
	 * 检查sms验证码的获取情况，如果一个用户上次获取在5分钟之内，
	 * 则不能续费获取，如果今天已经获取获取次数超过3次，也
	 * 不能续费获取
	 */
	private function checkSmscodeState($phone){
		$phone=trim($phone);
		$SmscodeDetail=M("SmscodeDetail");
		$SmscodeDetailInfo = $SmscodeDetail->where("phone=\"" . $phone . "\"")->order("time desc")->limit(1)->select();
		if($SmscodeDetailInfo!=false){
			$timeLastSmscode = $SmscodeDetailInfo[0]["time"];
			if((time()-$timeLastSmscode) < 300){
				echo "4"; //你上次获取验证码时间小于5分钟
				exit;
			}
		}
		
		$today = date("Y-m-d");
		$timeStart=strtotime($today);
		$timeEnd=$timeStart+24*3600;
		$SmscodeDetail=M("SmscodeDetail");
		$SmscodeDetailInfo = $SmscodeDetail->where("phone=\"" . $phone . "\" and time>=\"".$timeStart."\" and time<=\"".$timeEnd."\"")->field("count(*)")->order("time desc")->limit(1)->select();
		if($SmscodeDetailInfo[0]["count(*)"]>=3){
			//echo "5";  //你今天已经连续3次获取，不能继续获取，请明天再来获取
			//exit;
		}
		
		//如果是用手机号码注册，需要这部分代码
//		$User = M("User");
//		$userInfo = $User->where("phone=\"".$phone."\"")->field("count(*)")->select();
//		if($userInfo[0]["count(*)"]!=0){ 
//			echo "6";  //手机号码已经被使用
//			exit;
//		}
	}
	
	//把一条sms验证码发送记录保存在数据库中
	private function recodeSmsCodeInDb($smscode,$phone){
		$smscode=trim($smscode);
		$phone=trim($phone);
		$SmscodeDetail=M("SmscodeDetail");
		(trim($this->userid) == null)?($data["userid"] = 0):($data["userid"] = $this->userid);
		$data["phone"]=$phone;
		$data["smscode"]=$smscode;
		$data["time"]=time();
		$result=$SmscodeDetail->add($data);
		if(($result==false)||($result==NULL)||($result==0)){
			echo "7"; //系统故障，获取短信验证码失败，请稍后重试
			exit;
		}
	}
	
	//Ajax方式获取短信验证码
	public function getSmscode($phone){
		Vendor('SmsCode.Client');
		$gwUrl = 'http://sdkhttp.eucp.b2m.cn/sdk/SDKService?wsdl';
		$serialNumber = '3SDK-EMY-0130-OGZTL';
		$password = '930573';
		$sessionKey="zkyj123";
		$connectTimeOut = 2;
		$readTimeOut = 10;
		$proxyhost = false;
		$proxyport = false;
		$proxyusername = false;
		$proxypassword = false; 
		$client = new Client($gwUrl,$serialNumber,$password,$sessionKey,$proxyhost,$proxyport,$proxyusername,$proxypassword,$connectTimeOut,$readTimeOut);
		
		$phone=trim($phone);
		$checkPhoneResult=$this->checkPhone($phone);
		if($checkPhoneResult==false){
			echo "2"; //手机号码格式错误
			exit;
		}
		
//		if($this->isLogined==false){
//			echo "3"; //没有登录
//			exit;
//		}
		$this->checkSmscodeState($phone);
		
		//短信接口要进行登陆验证
		$client->setOutgoingEncoding("UTF-8");
		$statusCode = $client->login();	
		if (!($statusCode!=null && $statusCode=="0"))
		{
			echo "0";	//传回0做失败处理，系统故障，获取失败！
			exit;	
		}
		
		$code=rand(100000,999999);
		$_SESSION["smsCode"]=$code;
		$_SESSION["smsCodeTime"]=time();
		$_SESSION["getSmscodePhone"] = $phone;
		
		$this->recodeSmsCodeInDb($code,$phone);
		
		$codestr="您好，您的手机验证码是".$code."，5分钟有效。【中科远景】";
		$statusCode = $client->sendSMS(array($phone),$codestr);
		if ($statusCode!=null && $statusCode=="0")
		{
			echo "1"; //发送成功 
			exit;
		}
		else
		{
			echo "0"; //发送失败
			exit;
		}
	}
	
}