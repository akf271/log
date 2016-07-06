<?php
/*
 * 手机号码类，通过这个类，
 * 可以进行手机号码,合法性验证
 */
class TelPhone {
		private $telPhoneNum;

		function __construct($telPhoneNum){
			$telPhoneNum=trim($telPhoneNum);
			$this->telPhoneNum=$telPhoneNum;
		}
		
		public function checkTelPhoneNum(){
			if(preg_match("/^13[0-9]{1}[0-9]{8}$|14[57]{1}[0-9]{8}$|15[012356789]{1}[0-9]{8}$|18[123456789]{1}[0-9]{8}$/",$this->telPhoneNum)){    
			    //验证通过    
			    return true;
			        
			}else{    
			    //验证没有通过
			    return false;      
			} 
		}
		
		
		
	
}
