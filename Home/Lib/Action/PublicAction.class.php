<?php
class PublicAction extends Action {
	public function index(){
		
	}

	public function verify(){
	    import('ORG.Util.Image');
	    Image::buildImageVerify();
	}

	/*
	 * 显示为加法运算的验证码
	 */
	public function logicVerify() {
		import('COM.Util.Image');
		Image::buildAddLogicImageVerify();
	}
}


