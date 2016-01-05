$(function(){
	/*秒杀商品*/
	var timer1=null;
	function oTime(){
		var oDate=new Date();
		var oSec=Math.round(oDate.getTime()/1000);
		$(".prev_div").prev("div.top_th").find(".endTime").each(function(){
			var num=$(this).siblings("span.goods_num").text();
			$(this).siblings("span.goods_num").text(num);
			var startTime=$(this).text();
			var time=startTime-oSec;
			var hour=(time-time%3600)/3600;
			//alert(hour);
			var minute=((time-hour*3600)-(time-hour*3600)%60)/60;
			//alert(minute);
			var second=time-hour*3600-minute*60;
			//alert(second);
			if(hour<10){
				hour="0"+hour;
			}
			if(minute<10){
				minute="0"+minute;
			}
			if(second<10){
				second="0"+second;
			}
			if((hour=="00"&&minute=="00"&&second=="00")||(num<=0)){
				$(this).parents("div.top_img_div").find("div.go_sec").css("backgroundColor","#ccc");
				$(this).parents("div.top_img_div").find("div.go_sec").find("a").text("秒杀结束").attr("href","javascript:void(0)");
				$(this).parent().remove();
				
			}
			$(this).siblings("span.time_now").text(hour+":"+minute+":"+second);
		})
	}
	
	oTime();
	timer1=setInterval(oTime,1000);
	
	/*底下是把秒杀预告的商品添加到秒杀商品中去*/
	var timer2=null;
	var iNow=0;
	function add(){
		
		var oDate=new Date();
		var oSec=Math.round(oDate.getTime()/1000);
			$(".prev_div").next("div.bot_th").find(".startTime").each(function(){
			var num=$(this).siblings("span.goods_num").text();
			$(this).siblings("span.goods_num").text(--num);
			var startTime=$(this).text();
			var time=startTime-oSec;
			var hour=(time-time%3600)/3600;
			//alert(hour);
			var minute=((time-hour*3600)-(time-hour*3600)%60)/60;
			//alert(minute);
			var second=time-hour*3600-minute*60;
			//alert(second);
			if(hour<10){
				hour="0"+hour;
			}
			if(minute<10){
				minute="0"+minute;
			}
			if(second<10){
				second="0"+second;
			}
			if(hour=="00"&&minute=="00"&&second=="00"){
				iNow++;
				$(this).parents("div.top_img_div").find("div.go_sec").show();
				$(this).parents("div.top_img_div").find("span.start").text("距结束:");
				if(iNow==1){
					$(this).text($(this).siblings("span.endTime").text());
				}
				alert(iNow)
				if(iNow==2){
				$(this).parents("div.top_img_div").find("div.go_sec").css("backgroundColor","#ccc");
				$(this).parents("div.top_img_div").find("div.go_sec").find("a").text("秒杀结束").attr("href","javascript:void(0)");
				$(this).parent().remove();
				}
				
				//$(this).siblings("span.endTime").text($(this).text());
				timer2=setInterval(add,1000);
			}
			if(num<=0){
				$(this).parents("div.top_img_div").find("div.go_sec").css("backgroundColor","#ccc");
				$(this).parents("div.top_img_div").find("div.go_sec").find("a").text("秒杀结束").attr("href","javascript:void(0)");
				$(this).parent().remove();
			}
			$(this).siblings("span.time_now").text(hour+":"+minute+":"+second);
		})
	}
	add();
	timer2=setInterval(add,1000);
	/*判断商品的数量*/
	function desNum(){
		//这个that 你在写Ajax的时候在Ajax的作用域内定义一下 var that=$(this) 不然就访问不到。
		var num=that.parents("div.top_img_div").find("span.goods_num").text();
		if(num>0){
		num--;
		$(this).parents("div.top_img_div").find("span.goods_num").text(num);
		}
		if(num<=0){
			clearInterval(timer1);
			that.parents("div.top_img_div").remove();
			timer1=setInterval(oTime,1000);
		}
	}
		
	
})





















