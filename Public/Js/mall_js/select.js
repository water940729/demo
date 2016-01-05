$(function(){
	
	$("#list li:gt(0)").hover(function(){
		var index=$(this).index();
		
		var top=$(this).offset().top+$(this).height()/2;
		
		var left=$(this).offset().left+$(this).width();
		
		$("#div_list div").eq(index-1).show();
		
		$("#div_list span").show().offset({left:left,top:top})
		$(this).css("backgroundColor","#E2007E");
	},function(){
			
			var index=$(this).index();
			
			$("#div_list div").hide();
			
			$("#div_list span").hide();
			$(this).css("backgroundColor","#F480C1");
	});
	
	//动态改变高度
  	//alert($(".middle_adv")[0].offsetParent.id)
  	var topHei=$(".middle_adv")[0].offsetTop;
  	var hei=topHei+12;
  	var oHei=($(".list_adv").height()-hei)/2;
  	$(".middle_adv").height($(".list_adv").height()-topHei);

  	$(".right_top").height(oHei);
  	$(".right_bottom").height(oHei);
  	var toHei=$(".middle_adv").height()-50;
  	$("#to_left,#to_right").css("top",toHei/2)
	
})