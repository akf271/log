<?php
class IndexAction extends AuthAction {
	
    public function index(){
    	$jumpUrl = "http://" . $_SERVER["HTTP_HOST"] . "/saccount/thelist";
		header("location: " . $jumpUrl);
    }
    
}