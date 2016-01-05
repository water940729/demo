$(function(){
	//点击单选按钮
	$(".service").find("li input").click(function(){
		$(".service").find("li input").each(function(){
			$(this)[0].checked=false;
		});
		$(this)[0].checked=true;
	});
	
	//点击评价订单
	$(".order_com span").click(function(){
		var $div=$(this).parents("div.goods_bot").next("div.return");
		if($div.is(":hidden")){
			$div.show();
		}else{
			$div.hide();
		}
		
	})
});
