<?php
/*
 * 充值
 */
class PayAction extends AuthAction {
	
	/*
	 * 充值来源转义
	 */
	private function getPayForm($payFrom) {
		$payFrom = trim($payFrom);
		switch ($payFrom) {
			case "1":
				$payFrom = "支付宝";
				break;
				
			case "2":
				$payFrom = "银联支付";
				break; 
				
			default:
				break;
		}
		return $payFrom;
	}
	
	/*
	 * 充值状态转义
	 */
	private function getPayStatus($payStatus) {
		$payStatus = trim($payStatus);
		switch ($payStatus) {
			case "1":
				$payStatus = "发起充值，钱未支付";
				break;
			
			case "2":
				$payStatus = "钱已支付";
				break;
				
			case "3":
				$payStatus = "充值完成";
				break;
				
			default:
				break;
		}
		return $payStatus;
	}
	
	public function index() {
		$this->assign("pagetype",103);
		if (isset($_POST['doSubmit'])) {
	        $moneyPost = trim($_POST['money']);
	        $orderId = date("YmdHis") . rand(1000,9999);
	        
	        $Pay = M("Pay"); 
		    $data = array();
		    $data["userid"] = $this->userid;
		    $data["fid"] = $this->fid;
		    $data["money"] = $moneyPost;
		    $data["order_id"] = $orderId;
		    $data["pay_start_time"] = time();
		    $data["pay_finish_time"] = 0;
		    $data["pay_from"] = 1; //1代表从支付宝来的充值
		    $data["pay_status"] = 1; //1代表发起充值状态
		    $payResult = $Pay->add($data);
			if ($payResult != false) {
				//记录数据库成功
			    $post_url = "http://".$_SERVER["HTTP_HOST"]."/alipay/alipayto";
	    		echo "<form action=\"".$post_url."\" method=\"post\" id=\"alipaysubmit\" name=\"alipaysubmit\">
	    		<input type=\"hidden\" name=\"order_id\" value=\"".$orderId."\" />
	    		<input type=\"hidden\" name=\"money\" value=\"".$moneyPost."\" />
	    		<input type=\"hidden\" name=\"userid\" value=\"".$this->userid."\">
	    		</form>
	    		<script>document.forms['alipaysubmit'].submit();</script>";
			}
	    }
		$this->display();
	}
	
	public function doChinapay() {
		if (isset($_POST['doSubmit'])) {
	        $moneyPost = trim($_POST['money']);
	        $orderId = date('YmdHis'). rand(10,99);
	        $Pay = M("Pay"); 
		    $data = array();
		    $data["userid"] = $this->userid;
		    $data["fid"] = $this->fid;
		    $data["money"] = $moneyPost;
		    $data["order_id"] = $orderId;
		    $data["pay_start_time"] = time();
		    $data["pay_finish_time"] = 0;
		    $data["pay_from"] = 2; //2代表从银联支付来的充值
		    $data["pay_status"] = 1; //1代表发起充值状态
		    $payResult = $Pay->add($data);
			if ($payResult != false) {
				//记录数据库成功
			    $post_url = "http://".$_SERVER["HTTP_HOST"]."/chinapay/chinapayto";
	    		echo "<form action=\"".$post_url."\" method=\"post\" id=\"alipaysubmit\" name=\"alipaysubmit\">
	    		<input type=\"hidden\" name=\"order_id\" value=\"".$orderId."\" />
	    		<input type=\"hidden\" name=\"money\" value=\"".$moneyPost."\" />
	    		<input type=\"hidden\" name=\"userid\" value=\"".$this->userid."\">
	    		</form>
	    		<script>document.forms['alipaysubmit'].submit();</script>";
			}
	    }
	}
	
	
	/*
	 * 充值记录
	 */
	public function record() {
		$this->assign("pagetype",104);
		import('ORG.Util.Page');
		import('COM.Util.PageSpecial');
		$erverPageLimit = C("commonPageLimit"); //每页显示记录数
		$Pay = M("Pay");
		$order = "id desc";
		if(trim($_GET["p"]==NULL)){
			$payInfo = $Pay->where("userid = " . $this->userid ." and (pay_status=2 or pay_status=3)")->order($order)->limit($erverPageLimit)->select();
		}else{
			$payInfo = $Pay->where("userid = " . $this->userid ." and (pay_status=2 or pay_status=3)")->order($order)->page($_GET['p'].','.$erverPageLimit)->select();
		}
		for ($i = 0; $i < count($payInfo); $i++) {
			$payInfo[$i]["pay_from"] = $this->getPayForm($payInfo[$i]["pay_from"]);
			$payInfo[$i]["pay_status"] = $this->getPayStatus($payInfo[$i]["pay_status"]);
			$payInfo[$i]["pay_start_time"] = date("Y-m-d H:i:s", $payInfo[$i]["pay_start_time"]);
		}
		
		//分页代码
		$count      = $Pay->where("userid = " . $this->userid ." and (pay_status=2 or pay_status=3)")->count();// 查询满足要求的总记录数
		$Page       = new PageSpecial($count,$erverPageLimit);// 实例化分页类 传入总记录数和每页显示的记录数
		$show       = $Page->show();// 分页显示输出
		
		//模板赋值
		$this->assign("page", $show);
		$this->assign("payInfo", $payInfo);
		$this->display();
	}
	
	/*
	 * 分店充值记录
	 */
	public function bshopRecord() {
		$this->assign("pagetype",105);
		$this->checkIfIsBshop();
		import('ORG.Util.Page');
		import('COM.Util.PageSpecial');
		$erverPageLimit = C("commonPageLimit"); //每页显示记录数
		$bshopArr = $this->getBshopList($this->userid);
		$lastBshopId = $bshopArr[0]["userid"];
		$id = trim($this->_get("id"));
		if (count($bshopArr) == 0) {
			$payInfo = array();
		} else {
			$Pay = M("Pay");
			$order = "id desc";
			if ($id == null) {
				if(trim($_GET["p"]==NULL)){
					$payInfo = $Pay->where("fid = " . $this->userid . "  and (pay_status=2 or pay_status=3)")->order($order)->limit($erverPageLimit)->select();
				}else{
					$payInfo = $Pay->where("fid = " . $this->userid . "  and (pay_status=2 or pay_status=3)")->order($order)->page($_GET['p'].','.$erverPageLimit)->select();
				}
				$count = $Pay->where("fid = " . $this->userid . "  and (pay_status=2 or pay_status=3)")->count();// 查询满足要求的总记录数
			} else {
				if(trim($_GET["p"]==NULL)){
					$payInfo = $Pay->where("fid = " . $this->userid ." and userid = " . $id . "  and (pay_status=2 or pay_status=3)")->order($order)->limit($erverPageLimit)->select();
				}else{
					$payInfo = $Pay->where("fid = " . $this->userid ." and userid = " . $id . "  and (pay_status=2 or pay_status=3)")->order($order)->page($_GET['p'].','.$erverPageLimit)->select();
				}
				$count = $Pay->where("fid = " . $this->userid ." and userid = " . $id . "  and (pay_status=2 or pay_status=3)")->count();// 查询满足要求的总记录数
			}
			for ($i = 0; $i < count($payInfo); $i++) {
				$payInfo[$i]["pay_from"] = $this->getPayForm($payInfo[$i]["pay_from"]);
				$payInfo[$i]["pay_status"] = $this->getPayStatus($payInfo[$i]["pay_status"]);
				$payInfo[$i]["pay_start_time"] = date("Y-m-d H:i:s", $payInfo[$i]["pay_start_time"]);
				$payInfo[$i]["bshopName"] = $this->getShopNameByShopId($payInfo[$i]["userid"]);
			}
			//分页代码
			$Page       = new PageSpecial($count,$erverPageLimit);// 实例化分页类 传入总记录数和每页显示的记录数
			$show       = $Page->show();// 分页显示输出
		}
		$this->assign("bshopArr", $bshopArr);
		$this->assign("payInfo", $payInfo);
		$this->assign("page", $show);
		$this->display("bshopRecord");
	}
	
	
	
}

