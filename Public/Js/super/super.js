$(function(){
	//幻灯片广告
	var oneWidth=$("#middle_adv_ul li").eq(0).width();
	
	var length=$("#middle_adv_ul li").length;
	var page=0;
	
	var ul_html=$("#middle_adv_ul").html();
	
	$("#middle_adv_ul").html(ul_html+ul_html);
	
	var ul_li=$("#middle_adv_ul li");
	
	$("#middle_adv_ul").width(ul_li.width()*ul_li.length);
	
	function to_left(){
		if(!$("#middle_adv_ul").is(":animated")){
		if(page==length-1){
			$("#middle_adv_ul").animate({left:'-='+oneWidth},"normal").animate({left:"0px"},0);
			//alert("ok")
			page=0;
		}else{
			$("#middle_adv_ul").animate({left:'-='+oneWidth},"normal");
			page++;
		}
		
		$("#to_num div").eq(page).addClass("current").siblings().removeClass("current");
		}
		
	}
	
	var timer=setInterval(to_left,3000);
	
	$("#to_left").bind("click",to_left);
	
	$("#to_right").click(function(){
		
		if(!$("#middle_adv_ul").is(":animated")){
			
		if(page==0){
		$("#middle_adv_ul").animate({left:-length*oneWidth+'px'},0).animate({left:"+="+oneWidth},"normal");
		page=length-1;
		}
		else{
			$("#middle_adv_ul").animate({left:'+='+oneWidth},"normal");
			page--;
		}
		$("#to_num div").eq(page).addClass("current").siblings().removeClass("current");
		}
	})
	
	$("#middle_adv_ul").hover(function(){
		$("#to_right").show();
		$("#to_left").show();
		clearInterval(timer);
	},function(){
		$("#to_right").hide();
		$("#to_left").hide();
		timer=setInterval(to_left,3000);
	})
	
	$("#to_right").mouseover(function(){
		clearInterval(timer);
		$(this).show();
		$("#to_left").show();
	})
	
	$("#to_right").mouseout(function(){
		timer=setInterval(to_left,3000);
	})
	
	$("#to_left").mouseover(function(){
		clearInterval(timer);
		$(this).show();
		$("#to_right").show();
		
	})
	
	$("#to_left").mouseout(function(){
		timer=setInterval(to_left,3000);
	})
	
	for(var i=0;i<length;i++){
		var newDiv=document.createElement("div");
		newDiv.className="num_current";
		$("#to_num").append(newDiv);
	}

	$("#to_num div").click(function(){
		//alert($(this).index());
		var index=$(this).index();
		$("#middle_adv_ul").animate({left:-index*oneWidth+"px"},"normal");
		$(this).addClass("current").siblings().removeClass("current");
		page=index;
		
	})

	//首页的样式
	$("#select_list_ul li").eq(0).addClass("cur_li").siblings("li").removeClass("cur_li");
	$("#select_list_ul li").click(function(){
		$(this).addClass("cur_li").siblings("li").removeClass("cur_li");
	})
	//动态改变中间幻灯片的高度
	$(".middle_adv").height($("#div_list").height()-68);
	$(".right_adv").height($(".middle_adv").height());

	//幻灯片左边的选项卡事件
	$("#div_list>div").height(($("#list li").length-1)*$("#list li").height()-2);
		
		$("#list li:gt(0)").hover(function(){
		var index=$(this).index();
		
		var top=$(this).offset().top+$(this).height()/2;
		
		var left=$(this).offset().left+$(this).width();
		
		$("#div_list>div").eq(index-1).show();
		
		$(this).css("backgroundColor","orange");
		
		$("#div_list span").show().offset({left:left,top:top})
	},function(){
			var index=$(this).index();

			$("#div_list>div").hide();
			
			$("#div_list>span").hide();
			
			$(this).css("backgroundColor","#FFB400");
		
		
		
	});
	
	

	//热销商品的特殊的div样式
	$(".hot_goods .goods_dis:nth-child(6n+1)").css("borderLeft","0");
	$(".hot_goods .goods_dis:last-child").css("borderRight","solid 1px #353535");
	$(".hot_goods .goods_dis:nth-child(6n)").css("borderRight","0");
	
	//板块的特殊div样式
	$(".item_body .item_body_goods:nth-child(5n+1)").css("borderLeft","0");
	$(".item_body .item_body_goods:last-child").css("borderRight","solid 1px #353535");
	$(".item_body .item_body_goods:nth-child(5n)").css("borderRight","0");
	
	//下面是点击各个楼层的选项卡进行切换的js
	$(".item").each(function(){
		$(this).find("div.item_body").eq(0).show().siblings("div.item_body").hide();
	})
	//$(".item div.item_body:eq(0)").show();
	/*var oStyle=$(".item_title").find("li").eq(1).attr("style");
	$(".item_title").find("li:gt(1)").attr("style","");
	$(".item_title").find("li:gt(0)").click(function(){
	var index=$(this).index();
		$(this).attr("style",oStyle).siblings("li").attr("style","");
		
		$(".item").find(".item_body").eq(index-1).show().siblings("div.item_body").hide();
	})*/

	$(".item_title").each(function(){
		$(this)[0].colorStyle=$(this).find("li").eq(1).attr("style");
		$(this).find("li:gt(1)").attr("style","");
		$(this).find("li:gt(0)").click(function(){
			var oStyle=$(this).parents("div.item_title")[0].colorStyle;
			var index=$(this).index();
			$(this).attr("style",oStyle).siblings("li:gt(0)").attr("style","");
			$(this).parents(".item").find(".item_body").eq(index-1).show().siblings("div.item_body").hide();
		})
	})
	
	//购物车和收藏的鼠标移入事件
	$(".item_body_text_right div").hover(function(){
		$(this).addClass("car_col");
	},function(){
		$(this).removeClass("car_col");
	})
	
	//促销公告的高度
	$(".right_adv").height($(".middle_adv").height());
	$(".right_top").height($(".middle_adv").height()-2);
});

























