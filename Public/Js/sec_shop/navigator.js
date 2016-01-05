$(function(){
	 $("#navigator_ul li:eq(0)").addClass("navigator_li");
	 $("#middle_adv a:eq(0)").show();
	 var iNow=0;
	 var timer=null;
	 var length=$("#middle_adv a").length;
	 function changeImg(){
		 
		 $("#middle_adv a").eq(iNow).fadeIn("3000").siblings("a").fadeOut("3000");
		 iNow=(++iNow)%length;
	 }
	 changeImg();
	 timer=setInterval(changeImg,3000);
	 
	 $("#middle_adv a").hover(function(){
		 clearInterval(timer);
	 },function(){
		 timer=setInterval(changeImg,3000);
	 });
	 
	 //动态改变div的border
	 $(".floor div.floor_body_div:last-child").css("borderRight","solid 1px #ccc");
	  $(".floor div.floor_body_div:nth-child(5n+1)").css("borderLeft","0");
	   $(".floor div.floor_body_div:nth-child(5n)").css({"borderRight":"0","width":"239px"});
	   $(".floor div.floor_body_div:nth-child(5n) div.floor_body_div_top").css("width","239px");
	   
	   $(".product_rec_list div.pro_con:last-child").css("borderRight","solid 1px #ccc");
	   $(".product_rec_list div.pro_con:nth-child(3n+1)").css("borderLeft","0");
	   $(".product_rec_list div.pro_con:nth-child(3n)").css({"borderRight":"0","width":"396px"});
	   
	   //最下面的板块导航条
	   $(".floor_nav li:first-child").addClass("cur_li").siblings("li").removeClass("cur_li");
	   $(".page_num span").click(function(){
	   	$(this).css({"borderColor":"white","color":"orange","fontWeight":"bold"}).siblings("span").css({"borderColor":"#353535","color":"#353535","fontWeight":"normal"})
	   })
	   
})