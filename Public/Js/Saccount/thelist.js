function delbshop(shopid) {
	var UrlBase="/saccount/getbshopnamedescribe/";
	$.get(UrlBase, { shopid: shopid},
	function(result){
		var obj = jQuery.parseJSON(result);
		var backResult=obj.result;
		var bshopNameDescribe = obj.bshopNameDescribe;
		if(backResult=="found"){
			//找到了该分店
			var confirmMessage = "你确定要停用分店：" + bshopNameDescribe;
			art.dialog.confirm(confirmMessage , function(){
		    	var delBshopUrlBase = "/saccount/dobshopdel";
		    	$.get(delBshopUrlBase, { shopid: shopid},
				function(delBshopUrlBaseResult){
					var delBshopObj = jQuery.parseJSON(delBshopUrlBaseResult);
					var delBshopObjBackResult=delBshopObj.result;
					if(delBshopObjBackResult=="found"){
						//找到了该分店
						var delBshopResult = delBshopObj.delResult;
						if (delBshopResult == "success") {
							//alert("删除成功");
							//window.location.href = document.URL;
							art.dialog({
							    lock: true,
							    opacity: 0.87,	// 透明度
							    content: '停用成功',
							    icon: 'succeed',
							    ok: function () {
							        //art.dialog({content: '再来一个锁屏', lock: true});
							        window.location.href = document.URL;
							        return false;
							    },
							    close: function () {
							        //art.dialog({content: '22222222222再来一个锁屏', lock: true});
							        window.location.href = document.URL;
							        return false;
							    }
							});
						} else {
							art.dialog({
							    lock: true,
							    opacity: 0.87,	// 透明度
							    content: '系统故障，停用失败,请稍后重试',
							    icon: 'error'
							});
						}

					}else{
						window.location.href="/saccount/thelist";
					}
					
				});
			}, function(){
			    
			});
		}else{
			window.location.href="/saccount/thelist";
		}
		
	});

}

$(document).ready(function(){		   
	$("#doLogin").click(function(){
		document.getElementById("loginInfo").innerHTML = "";
		var url = "/user/dologin"
		$("#loginForm").ajaxSubmit({
			url:url,
			type:"POST",
			success:function(data, st) {
			   if (data.result!=0) {
                   //alert("错误:" + data.info);
				   document.getElementById("loginInfo").innerHTML = data.info;
               } else {
				   //alert("成功:" + data.info);  
				   window.location.href = data.backUrl;
			   }
			} 
	    });
	});
	
	$('.operate_a').on('mouseover', function(){
		var shopid = this.attributes['shopid'].nodeValue;
		layer.tips("<a href='/saccount/editbshop/shopid/" + shopid + "' >编辑</a> | <a href='/saccount/changebshoppsw/shopid/" + shopid + "' >重置密码</a> | <a href='javascript:void(0);'  onclick='delbshop(" + shopid + ");'>停用</a>" , this, 0, 300, 1, ['background-color:#F26C4F; color:#fff;','#F26C4F']);
	});


	//$('.money_a').on('mouseover', function(){
	//	var shopid = this.attributes['shopid'].nodeValue;
	//	layer.tips("<a href='/saccount/distributemoney/shopid/" + shopid + "' >增加额度</a>" , this, 0, 100, 1, ['background-color:#F26C4F; color:#fff;','#F26C4F']);
	//});
		
	$("#startUseUser").click(function() {
		var shopid = this.attributes['shopid'].nodeValue;
		//alert(shopid);
		var UrlBase="/saccount/getbshopnamedescribe/";
		$.get(UrlBase, { shopid: shopid},
		function(result){
			var obj = jQuery.parseJSON(result);
			var backResult=obj.result;
			var bshopNameDescribe = obj.bshopNameDescribe;
			if(backResult=="found"){
				//找到了该分店
				var confirmMessage = "你确定启用分店：" + bshopNameDescribe;
				art.dialog.confirm(confirmMessage , function(){
			    	var delBshopUrlBase = "/saccount/dostartuser";
			    	$.get(delBshopUrlBase, { shopid: shopid},
					function(delBshopUrlBaseResult){
						var delBshopObj = jQuery.parseJSON(delBshopUrlBaseResult);
						var delBshopObjBackResult=delBshopObj.result;
						if(delBshopObjBackResult=="found"){
							//找到了该分店
							var delBshopResult = delBshopObj.delResult;
							if (delBshopResult == "success") {
								//alert("删除成功");
								//window.location.href = document.URL;
								art.dialog({
								    lock: true,
								    opacity: 0.87,	// 透明度
								    content: '启用成功',
								    icon: 'succeed',
								    ok: function () {
								        //art.dialog({content: '再来一个锁屏', lock: true});
								        window.location.href = document.URL;
								        return false;
								    },
								    close: function () {
								        //art.dialog({content: '22222222222再来一个锁屏', lock: true});
								        window.location.href = document.URL;
								        return false;
								    }
								});
							} else {
								art.dialog({
								    lock: true,
								    opacity: 0.87,	// 透明度
								    content: '系统故障，启用失败，请稍后重试',
								    icon: 'error'
								});
							}

						}else{
							window.location.href="/saccount/thelist";
						}
						
					});
				}, function(){
				    
				});
			}else{
				window.location.href="/saccount/thelist";
			}
		});
	});



});

