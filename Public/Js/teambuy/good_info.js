$(function(){
    //后台代码记录浏览历史byning
    good_id = $("#number").text();
    $.post("../../../Widget/footprint", {"id":good_id},function(data){
        //alert(data.status);                 
        //alert(data.msg);
    }, 'json');
	$("#route div").click(function(ev){
		var oneSize=35+$(this).width();
		$(this).children("ul").css("position","absolute").show().width(oneSize);
		$(this).siblings("div").children("ul").hide();
		ev.stopPropagation();
	})
	
    //用于秒杀等商品页面不用显示分类可选
	$("#route_absolute div").click(function(ev){
		var oneSize=35+$(this).width();
		$(this).children("ul").css("position","absolute").show().width(oneSize);
		$(this).siblings("div").children("ul").hide();
		ev.stopPropagation();
	})

	$("#route div ul li").hover(function(){
		$(this).css("background","yellow");
	},function(){
		$(this).css("background","white");
	})
	
	$(document).click(function(){
		$("#route div").children("ul").hide();
	})
	
	//运动的小图片
	var oneLi=12+$("#ul_div ul li").eq(0).width();
	var oUl=$("#ul_div ul");
	oUl.html(oUl.html()+oUl.html());
	var aLi=$("#ul_div ul li");
	oUl.width(oneLi*aLi.length);
	var iNow=1;
	//向左运动
	$("#to_left").click(function(){
		oUl.stop(true,true).animate({left:"-="+oneLi},300,function(){
		iNow++;
		if(iNow==6){
		oUl.stop(true,true).animate({left:"0"},0);	
		iNow=1;
		}
		});
		
	})
	//向右运动
	$("#to_right").click(function(){
		if(iNow==1){
			var left=-aLi.length/2*oneLi;
			oUl.stop(true,true).animate({left:left+"px"},0,function(){
				oUl.stop(true,true).animate({left:"+="+oneLi},300);
				iNow=5;
			})
		}
		else{
				oUl.stop(true,true).animate({left:"+="+oneLi},300);
				iNow--;
			}
	
	})
	
	//点击小的图片的事件
	$("#ul_div ul li").click(function(){
		$("#big_image").html($(this).html());
		$(this).css("border","solid 1px red").siblings("li").css("border","solid 1px #ccc")
	})
	
	//送至后面的那个模拟的select
	$("#goto_ul_div").text($("#goto_ul_div ul li:eq(0)").text());
	$("#goto_ul_div").click(function(){
		var top=$(this).height();
		var oWidth=$(this).width();
		$(this).children("ul").show().css("position","absolute");
	})

	//定义两个全局变量

	
	$("#back_span").click(function(){
		$(".shopCar_mask,.shopCar_mask_div").fadeOut(200);
		$("body").css("overflow","visible");
	})
	
	//点击收藏事件,后台代码byning
	$("#collect").click(function(){
        good_id = $("#number").text();
        alert(good_id);
        $.post("../../../Widget/collect", {"type":"4", "id":good_id},function(data){
            alert(data.status); 
            alert(data.msg);
        }
        , 'json');
        /*
		var top=(height-$(".collect_mask_div").height())/2;
		var left=(width-$(".collect_mask_div").width())/2;
		
		$(".collect_mask,.collect_mask_div").fadeIn(200);
		
		$(".collect_mask_div").css({top:top+"px",left:left+"px"});
        */
	})
	
	$("#collect_back_span").click(function(){
		$(".collect_mask,.collect_mask_div").fadeOut(200);
	})


    $("#list li").hover(function(){
        var index=$(this).index();

        var top=$(this).offset().top+$(this).height()/2;

        var left=$(this).offset().left+$(this).width();

        $("#div_list div").eq(index).show();

        $(this).addClass("addClass_cur");

        $("#div_list span").show().offset({left:left,top:top})
    },function(){


        var index=$(this).index();

        $("#div_list div").hide();

        $("#div_list span").hide();

        $(this).removeClass("addClass_cur");
    });

    $("#li_list").hover(function(){
        $(this).find("div.list").stop(true).slideDown("400");

    },function(){
        $("#div_list").hide();
        $(this).find("div.list").stop(true).slideUp("400");

    })

});
