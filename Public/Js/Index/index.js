$(document).ready(function(){
	//大类选择
	$("#clsid_change").click(function(){
		//alert("产品大类选择!");
	});
	
	//小类选择
	$("#avg_change").click(function(){
		//alert("产品小类选择!");
	});
	
	//地区选择
	$("#zone_change").click(function(){
		//alert("地区选择");
	});

});
﻿
function clsid_change(i) {
	var url = window.location.href;
	var patt = new RegExp("\/zid\/","g");
	var urlArr=url.split(patt);
	if(urlArr.length != 1) {
	   //有clsid参数字段
	   var zid = urlArr[1];
	   patt = new RegExp("\/", "g");
	   var clsIdArr = zid.split(patt);
	   zid = clsIdArr[0];
	   if (zid != "") {
			//zid值存在
			var jumpUrl = "/index/index/clsid/"+i+"/zid/" + zid;
	   } else {
			//zid值不存在
			var jumpUrl = "/index/index/clsid/" + i;
	   }
	} else {
		var jumpUrl = "/index/index/clsid/" + i;
	}
	window.location.href = jumpUrl;
}

function clsid_change_to_all() {
	var jumpUrl = "/";
	window.location.href = jumpUrl;
}

function zone_change(i) {
	var url = window.location.href;
	var patt = new RegExp("\/clsid\/","g");
	var urlArr=url.split(patt);
	if(urlArr.length != 1) {
	   //有clsid参数字段
	   var clsId = urlArr[1];
	   patt = new RegExp("\/", "g");
	   var clsIdArr = clsId.split(patt);
	   clsId = clsIdArr[0];
	   if (clsId != "") {
			//clsId值存在
			var jumpUrl = "/index/index/clsid/"+clsId+"/zid/" + i;
	   } else {
			//clsId值不存在
			var jumpUrl = "/index/index/zid/" + i;
	   }
	} else {
		var jumpUrl = "/index/index/zid/" + i;
	}
	window.location.href = jumpUrl;
}

function change_to_zone_top(){
	var url = window.location.href;
	var patt = new RegExp("\/clsid\/","g");
	var urlArr=url.split(patt);
	if(urlArr.length != 1) {
	   //有clsid参数字段
	   var clsId = urlArr[1];
	   patt = new RegExp("\/", "g");
	   var clsIdArr = clsId.split(patt);
	   clsId = clsIdArr[0];
	   if (clsId != "") {
			//clsId值存在
			var jumpUrl = "/index/index/clsid/"+clsId;
	   } else {
			//clsId值不存在
			var jumpUrl = "/index/index";
	   }
	} else {
		var jumpUrl = "/index/index";
	}
	window.location.href = jumpUrl;
}