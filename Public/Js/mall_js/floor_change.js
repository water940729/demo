$(function(){

	var width=$("#floor_change div:eq(1)").width();
	var height=$("#floor_change div:eq(1)").height();
	$("#floor_change div").each(function(){
		var index=$(this).index();
		$(this).css("top",index*height+"px");
	})

	if($(window).scrollTop()>=500){
		$("#floor_change").show();
	}
	
	function twoWidth(){
		$(this).stop(true,true).animate({width:2*$(this).width()},200);
	}
	
	function oneWidth(){
		$(this).stop(true,true).animate({width:width},200);
		//alert("ok")
	}
	

	$(window).scroll(function(){
		if( document.body.clientWidth<=1400){
			$("#floor_change").hide();
		}else{
			if($(window).scrollTop()>=500){
			if($("#floor_change").is(":hidden")){
				$("#floor_change").slideDown("normal");
				
			}
		}else{
			if($("#floor_change").is(":visible")){
				$("#floor_change").slideUp("normal");
			}
		}
		}
		
	});
	
	$(window).resize(function(){
		if( document.body.clientWidth<=1400){
			$("#floor_change").hide();
		}
	})

	$("#floor_change div:not(div.flower)").hover(twoWidth,oneWidth);
	
	

	//各个楼层事件的控制
	
	$("#floor_change div:last-child").click(function(){
		$('html,body').animate({scrollTop: $("#footer").offset().top}, 300);
	});
	
	$("#floor_change div").eq(1).click(function(){
		$('html,body').animate({scrollTop: '0px'}, 300);
	});
	
	$("#floor_change div:gt(1):not(':last-child')").click(function(){
		var index=$(this).index()-2;
		var top=$(".floor").eq(index).offset().top;
		//alert();
		$('html,body').animate({scrollTop:top}, 300);
	})

})