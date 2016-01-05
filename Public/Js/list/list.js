$(function(){
	$(".left_name").each(function(){
		var oHei=$(this).parent("div.brand").height();
		$(this).height(oHei);
	});
	//点击左上角的事件
	$(".left_top_con").find("h4").click(function(){
		if($(this).next("ul.son_ul").is(":hidden")){
			$(this).next("ul.son_ul").slideDown();
			$(this).children("span.add_des").text("-");
		}else{
			$(this).next("ul.son_ul").slideUp();
			$(this).children("span.add_des").text("+");
		}
		
	});

	//特殊的div的样式
	$("div.right_bot_body").find(".right_bot_con:nth-child(4n+1)").css("borderLeft","0");
	$("div.right_bot_body").find("div.right_bot_con:last-child").css("borderRight","solid 1px #ccc");
	$("div.right_bot_body").find("div.right_bot_con:nth-child(4n)").css("borderRight","0");
	//点击多选事件
	$(".choose").click(function(){
		if($(this).text()=="+多选"){
			$(this).siblings("ul.ul2").show().siblings("ul.ul1").hide();
			$(this).text("收起")
		}else{
			$(this).siblings("ul.ul1").show().siblings("ul.ul2").hide();
			$(this).text("+多选")
		}
		
	})
	
	$("#reset").click(function(){
		 window.location.reload();
		})

	//点击多选下面的取消按钮事件
	$(".sub").find("input[value='取消']").click(function(){
		var parent=$(this).parents("ul.ul2");
		parent.hide();
		parent.siblings("ul.ul1").show();
		parent.siblings("div.choose").text("+多选");
		parent.find("input[type='checkbox']").each(function(){
			$(this)[0].checked=false;
		})
	})
	
	//价格的确定事件
	$(".from_to").hover(function(){
		$(".confirm").show();
	},function(){
		$(".confirm").hide();
	});
	
	$(".from_to input[type='text']").focus(function(){
		$(this).val("");
	})
	
	//价格排列
	$("#cho_sta li.sort_price").hover(function(){
		$(this).children("div.up_down").show();
	},function(){
		$(this).children("div.up_down").hide();
	});
})





















