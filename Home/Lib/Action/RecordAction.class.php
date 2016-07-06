<?php
/*
 * 各种日志记录
 */
class RecordAction extends AuthAction {

	public function index() {
		$this->display();
	}
	
	/*
	 * 对登陆号码中的手机号码表述进行转义
	 */
	private function changeLoginRecordPhone($phone) {
		$phone = trim($phone);
		if (($phone == "0") || ($phone == null)) {
			$phone = "免手机验证";
		}
		return $phone;
	}
	
	/*
	 * 登录记录
	 */
	public function login() {
		$this->assign("pagetype",110);
		import('ORG.Util.Page');
		import('COM.Util.PageSpecial');
		$erverPageLimit = C("commonPageLimit"); //每页显示记录数
		$LoginDetail = M("LoginDetail");
		$order = "id desc";
		if(trim($_GET["p"]==NULL)){
			$loginDetailInfo = $LoginDetail->where("userid = " . $this->userid)->order($order)->limit($erverPageLimit)->select();
		}else{
			$loginDetailInfo = $LoginDetail->where("userid = " . $this->userid)->order($order)->page($_GET['p'].','.$erverPageLimit)->select();
		}
		for ($i = 0; $i < count($loginDetailInfo); $i++) {
			$loginDetailInfo[$i]["phone"] = $this->changeLoginRecordPhone($loginDetailInfo[$i]["phone"]);
			$loginDetailInfo[$i]["login_time"] = date("Y-m-d H:i:s", $loginDetailInfo[$i]["login_time"]);
		}
		
		//分页代码
		$count      = $LoginDetail->where("userid = " . $this->userid)->count();// 查询满足要求的总记录数
		$Page       = new PageSpecial($count,$erverPageLimit);// 实例化分页类 传入总记录数和每页显示的记录数
		$show       = $Page->show();// 分页显示输出
		
		//模板赋值
		$this->assign("page", $show);
		$this->assign("loginDetailInfo", $loginDetailInfo);
		$this->display();
	}

}


