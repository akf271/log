$(document).ready(function(){		   
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
							window.location.href="/distributemoney";
						}
						
					});
				}, function(){
				    
				});
			}else{
				window.location.href="/distributemoney";
			}
		});
	});



});

