//去除字符串两端空格
String.prototype.dotrim = function () {
return this .replace(/^\s\s*/, '' ).replace(/\s\s*$/, '' );
} 

//邮箱验证
function   checkemail(str){   
  var   sReg   =   /[_a-zA-Z\d\-\.]+@[_a-zA-Z\d\-]+(\.[_a-zA-Z\d\-]+)+$/;   
  if   (   !   sReg.test(str)   )   
  {   
  return   false; 
  }     
  return   true;   
}

//添加收藏夹
function addfavorite()
{
   if (document.all)
   {
      window.external.addFavorite(window.location.href,document.title);
   }
   else if (window.sidebar)
   {
      window.sidebar.addPanel(document.title, window.location.href, "");
   }
} 






