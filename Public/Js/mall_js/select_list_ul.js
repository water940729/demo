$(function(){
	$("#select_list_ul li").click(function(ev){
		$(this).addClass("li_spec").siblings().removeClass("li_spec");
		ev.stopPropagation();
	})
	
	$(document).click(function(){
		$("#select_list_ul li:eq(0)").addClass("li_spec").siblings().removeClass("li_spec");
	});
	
	//各楼层之间的鼠标经过样式的变化
	
	$(".floor").each(function(){
		$(this).find("div.floor_body").eq(0).show().siblings("div.floor_body").hide();
	})
	//$(".floor div.floor_body:eq(0)").show().siblings("div.floor_body").hide();
	//alert($(".floor_top").length);
	$(".floor_top").each(function(){
		$(this)[0].colorStyle=$(this).find("li").eq(1).attr("style");
		$(this).find("li:gt(1)").attr("style","");
		$(this).find("li:gt(0)").click(function(){
			var oStyle=$(this).parents("div.floor_top")[0].colorStyle;
			var index=$(this).index();
			$(this).attr("style",oStyle).siblings("li:gt(0)").attr("style","");
			$(this).parents(".floor").find(".floor_body").eq(index-1).show().siblings("div.floor_body").hide();
		})
	});


$(".floor_body div:nth-child(5n)").css({"boredrRight":"0","width":"239px"});
$(".floor_body div:nth-child(6n)").css({"boredrLeft":"0","borderRight":"solid 1px #ccc"});
});