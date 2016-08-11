// JavaScript Document
 $(document).ready(function()
{
	var h1=$(window).height();
	var h2=$(document.body).outerHeight(true);	
	//alert(h2-h1); 
	if (h1>h2)
	{//屏幕高度比文档高度高
	 var h3=h1-h2;
	 $("#tempheight").css('height',h3);
	}	
//alert($(window).height()); //浏览器时下窗口可视区域高度
//alert($(document).height()); //浏览器时下窗口文档的高度
//alert($(document.body).height());//浏览器时下窗口文档body的高度
//alert($(document.body).outerHeight(true));//浏览器时下窗口文档body的总高度 包括border padding margin
//alert($(window).width()); //浏览器时下窗口可视区域宽度
//alert($(document).width());//浏览器时下窗口文档对于象宽度
//alert($(document.body).width());//浏览器时下窗口文档body的高度
//alert($(document.body).outerWidth(true));//浏览器时下窗口文档body的总宽度 包括border padding margin
})   