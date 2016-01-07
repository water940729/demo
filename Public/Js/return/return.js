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
		
		order_num = $(this).parents(".goods_bot").find(".ordid").text();
        good_id = $(this).parents(".goods_bot").find(".good_id").text();
        $.post("../Widget/confirm_return", {"order_num":order_num, "good_id":good_id, "type":"1"}, function(data){
           if(data.status){
                //alert("退货成功！");
				$('#right').load('../TabChange/return_good.html');
           } else {
                alert("something wrong");
           }
        }, "json")
		/*var $div=$(this).parents("div.goods_bot").next("div.return");
		if($div.is(":hidden")){
			$div.show();
		}else{
			$div.hide();
		}*/
		
	})
});
