$(function(){
	//普通会员对应的进度条
	(function(){
		var outWid=$(".outer_div").width();
		var rate=$("#level_num").text()/2000;
		var oWidth=outWid*rate;
		$(".inner_div").width(oWidth);
	})()

	//搜索框聚焦失焦事件
		$("input[type='text']").focus(function(){
			$(this).val("");
			$(this).css("color","black");
		})

		$(".form_div input[type='text']").blur(function(){
			if($(this).val()==""){
				$(this).val("关键词");
				$(this).css("color","#ccc");
			}
		})

		$("#tel_n").blur(function(){
			if($(this).val()==""){
				$(this).val("输入你的手机号码");
				$(this).css("color","#ccc");
			}
		})


	//第一个li元素显示的时间
	
		var newDate=new Date();
	var oYear=newDate.getFullYear();
	var oMonth=newDate.getMonth()+1;
	var oDate=newDate.getDate();
	var oDay=newDate.getDay();
	var oWeek;
	switch(oDay){

		case 0:
		oWeek="星期日";
		break;

		case 1:
		oWeek="星期一";
		break;

		case 2:
		oWeek="星期二";
		break;

		case 3:
		oWeek="星期三";
		break;

		case 4:
		oWeek="星期四";
		break;

		case 5:
		oWeek="星期五";
		break;

		case 6:
		oWeek="星期六";
		break;

	}

	$("#date_time").text(oYear+"年"+oMonth+"月"+oDate+"日"+oWeek);

	//点击面值ul显示
	$(document).click(function(){
		$("#price_ul").hide();
	})
	$("#price_div").text($("#price_ul li").eq(0).text());
	$("#price_div").click(function(ev){
		if($("#price_ul").is(":hidden")){
			$("#price_ul").show();
		}else{
			$("#price_ul").hide();
		}
		ev.stopPropagation();
	})

	$("#price_ul li").hover(function(){
		$(this).css("background","yellow");
	},function(){
		$(this).css("background","white")
	})

	$("#price_ul li").click(function(){
		var oTxt=$(this).text();
		$("#price_div").text(oTxt);
		switch(oTxt){

			case "100":
			$("#price_count").text("售价: 98.82-99.64");
			break;

			case "50":
			$("#price_count").text("售价: 48.82-49.64");
			break;

			case "30":
			$("#price_count").text("售价: 28.82-29.64");
			break;

			case "20":
			$("#price_count").text("售价: 18.82-19.64");
			break;

			case "10":
			$("#price_count").text("售价: 8.82-9.64");
			break;

		}
	})

	//点击最近浏览取消
	$(".delete_div").click(function(){
		var index=$(this).parent("div").index();
		$(this).parent().remove();

		$("#span_div").children().eq(index).remove();
	})
	var iNow=0;
	$("#change_one").click(function(){
		var length=$(".img_con").length;
		iNow++;
		iNow=iNow%length;

		$(".img_con").eq(iNow).fadeIn(200).siblings("div.img_con").fadeOut(200);

		return false;
	})

})