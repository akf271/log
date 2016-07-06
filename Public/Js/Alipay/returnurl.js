$(document).ready(function(){		   
	art.dialog({
	    lock: true,
	    opacity: 0.87,	// 透明度
	    content: '充值完成',
	    icon: 'succeed',
	    ok: function () {
	        window.location.href = "/pay";
	    },
	    close: function () {
	        window.location.href = "/pay";
	    }
	});
});

