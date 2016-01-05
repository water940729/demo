$(function(){
	//选择颜色 选择容量
	$(".choose_color ul li,#content_div span").click(function(){
		$(this).css("border","solid 1px red").siblings().css("border","solid #ccc 1px");
	})
	//选择数量
	$("#decrease").click(function(){
		var oTxt=$("#num").val();
		if(oTxt<=1){
			$("#num").val("1");
		}else{
			$("#num").val(--oTxt);
		}
		
	})
	
	$("#add").click(function(){
		var oTxt=$("#num").val();
		$("#num").val(++oTxt);
	})
	
//	//热销排行榜的切换
//	$("#first_goods").mouseover(function(){
//		$(this).addClass("current").removeClass("past").siblings().removeClass("current");
//		$("#second_goods").addClass("past");
//		$("#bottom_first").show();
//		$("#bottom_second").hide();
//	})
//	$("#second_goods").mouseover(function(){
//		$(this).addClass("current").removeClass("past").siblings().removeClass("current");
//		$("#first_goods").addClass("past");
//		$("#bottom_second").show();
//		$("#bottom_first").hide();
//	})
//
    $(".details_dispaly").hide();
    $(".details_dispaly").eq(0).show();
    $(".right_bot_ul li").click(function(){
   	$(this).addClass("ul_li_current").siblings("li").removeClass("ul_li_current");
        var index=$(this).index();
        $(this).parents("div.right_bot_details").find("div.details_dispaly").eq(index).show().siblings(".details_dispaly").hide();
	})
	
	
	var str1="";
	var str2="";
	var str3="";
	$("#six1").find("li").click(function(){
		str1=$(this).text();
		$("#already_choose").text(str1+" "+str2+" "+str3);
	})
	
	$("#six2").find("li").click(function(){
		str2=$(this).text();
		$("#already_choose").text(str1+" "+str2+" "+str3);
	})
	
	$("#six3").find("li").click(function(){
		str3=$(this).text();
		$("#already_choose").text(str1+" "+str2+" "+str3);
	})
	
	$(".details_navigator").height($(".details_image").height()+20);
	
});
