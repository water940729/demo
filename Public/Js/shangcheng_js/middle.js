$(function(){
	
	var oneWidth=$("#middle_adv_ul li").eq(0).width();
	
	var length=$("#middle_adv_ul li").length;
	//alert(length)
	
	var page=0;
	
	var ul_html=$("#middle_adv_ul").html();
	
	
	//alert(ul_li.length);
	
	$("#middle_adv_ul").html(ul_html+ul_html);
	
	var ul_li=$("#middle_adv_ul li");
	
	
	//alert(ul_li.length);
	
	$("#middle_adv_ul").width(ul_li.width()*ul_li.length);
	
	function to_left(){
		
		//alert(typeof oneWidth);
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
	
	
});

























