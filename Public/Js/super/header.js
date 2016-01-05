$(function(){
	
	//$("#header_reg ul").css("display","none");
	//$("#header_reg div").css("display","none");
	var timer=null;
	$("#header_reg").children("li:lt(4)").hover(function(){
		var index=$("li").index($(this));
		var ulLeft=$(this).offset().left+"px";
		var ulTop=$(this).offset().top+$(this).height()+"px";
		
		$(this).children("ul").css({position:"absolute",left:ulLeft,top:ulTop}).slideDown("fast");
		
		$(this).css("background","white");
	},function(){
		
			
			$(this).children("ul").stop(true,true).slideUp("fast");
		
			$(this).css("background","#eee");
		
		
	});
	
	
	
	
})