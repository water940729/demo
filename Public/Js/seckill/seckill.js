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
	
	//隐藏秒杀预告的  我要秒杀的div
	$(".prev_div").next("div.bot_th").find("div.go_sec").hide();
	$(".top_th").find("div.top_con").eq(0).show().siblings("div.top_con").hide();
	$(".bot_th").find("div.top_con").eq(0).show().siblings("div.top_con").hide();
	
	//秒杀预告的li点击
	$(".prev_div").find("li").eq(0).css("color","orange").siblings("li").css("color","white");
	$(".prev_div").find("li").hover(function(){
		$(".bot_th").children("div.top_con").eq($(this).index()).show().siblings("div.top_con").hide();
		$(this).css("color","orange").siblings("li").css("color","white");
	})
	
	//导航条切换
	$(".navigator ul li:eq(1)").addClass("li_move").siblings("li").removeClass("li_move");
	$(".navigator ul li:gt(0)").mouseover(function(){
		$(".top_th").find("div.top_con").eq($(this).index()-1).show().siblings("div.top_con").hide();
		var oLeft=$(this)[0].offsetLeft+$(this).width()/2;
		$(this).addClass("li_move").siblings("li").removeClass("li_move");
		$("#san_span").offset(function(){
			$("#san_span").stop(true,true).animate({left:oLeft},300);
		});
		
		//alert("ok")
	})

});
