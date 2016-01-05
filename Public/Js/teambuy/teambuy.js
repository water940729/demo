$(function(){
		//商品幻灯片广告

	var iNow=0;
	var timer=null;
	var len=$("#img_ul li").length;
	
	for (var i=0;i<len;i++){
		var newA=document.createElement("a");
		newA.href="javascript:void(0)";
		$(".img_eq").append(newA);
	}
	
	function moveAd(){
		if(!$("#img_ul li").is(":animated")){
			$("#img_ul li").eq(iNow).fadeIn(1000).siblings("li").fadeOut(1000);
			$(".img_eq a").eq(iNow).addClass("a_cur").siblings("a").removeClass("a_cur");
			iNow++
			iNow=iNow%len;
		}
		
	}
	$("#to_left,#to_right,#img_ul").hover(function(){
		clearInterval(timer);
	},function(){
		timer=setInterval(moveAd,3000);
	})

	$("#to_right").click(function(){
		moveAd();
	})

	$("#to_left").click(function(){
		var len=$("#img_ul li").length;
		if(iNow==0){
			iNow=len-1;
		}
		if(!$("#img_ul li").is(":animated")){
			$("#img_ul li").eq(iNow).fadeIn(1000).siblings("li").fadeOut(1000);
			$(".img_eq a").eq(iNow).addClass("a_cur").siblings("a").removeClass("a_cur");
			iNow--
			iNow=iNow%len;
		}
	});

	$(".img_eq a").click(function(){
		var index=$(this).index();
		$("#img_ul li").eq(index).fadeIn(1000).siblings("li").fadeOut(1000);
		iNow=index;
		$(this).addClass("a_cur").siblings("a").removeClass("a_cur");
	})
	moveAd();
	timer=setInterval(moveAd,3000);
	
	//首页切换
	$(".navi_div").children("ul").children("li:first-child").addClass("cur");
	$(".navi_div").children("ul").children("li").mouseover(function(){
		$(this).addClass("cur").siblings("li").removeClass("cur");
	})
	
	
	//特殊div样式
	$(".top_con").each(function(){
		$(this).find("div.top_img_div").each(function(){
			if(($(this).index())%4==0){
				$(this).css("marginLeft","0");
			}
		})
	})
	
	//移到商品上样式的变化
	$("div.top_img_div").hover(function(){
		$(this).css("borderColor","#FF7EAC").siblings().css("borderColor","#353535");
	},function(){
		$(this).css("borderColor","#353535");
	});
	
	//点击标题上的分类切换div
	$(".title_ul").parents("div.container").find("div.top_con").eq(0).show().siblings("div.top_con").hide();
	$(".title_ul").addClass()
	$(".title_ul li:gt(0):not(li:last-child)").each(function(){
		var num=$(this).parents("div.container").find("div.top_con").eq($(this).index()-1).find("div.top_img_div").length;
		$(this).find("span").text(num)
	})
	$(".title_ul li:gt(0)").mouseover(function(){
		$(this).parents("div.container").find("div.top_con").eq($(this).index()-1).show().siblings("div.top_con").hide();
	})

})
