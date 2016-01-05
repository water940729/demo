$(function(){
/*
    $(document).on("click", "#trial_delete", function(){
        $order_num = $(this).parents(".order_inform_top").children("span").first().text();
        var r = confirm("确认取消该商品？");
        if(r ==true){
            $.post("../Widget/del_order",{"order_num":$order_num}, function(data){
                if(data.status){
                    alert("订单取消成功成功.");
                     location.reload();
                } else {
                    alert("发生了一些问题.");
                }
            }, "json");
        }
    })
*/
    //选择时间
    $("#time_select").change(function(){
        var checkvalue = $("#time_select").val(); 
        status = $("#status").text();
        $("#order_content_margin").load("../TabChange/trial #order_content", {"status":status, "time_flag":checkvalue})            
    });

    //选择订单交易状态
    $("#all").click(function(){
        $("#order_content_margin").load("../TabChange/trial #order_content", {"status":"40"})            
        $("#status").text("40");
        $("#time_select").val(5);
        $("#search_text").val("");
    });

    $("#wait_pay").click(function(){
        $("#order_content_margin").load("../TabChange/trial #order_content", {"status":"0"})            
        $("#status").text("0");
        $("#time_select").val(5);
        $("#search_text").val("");
    });
    
    $("#wait_send").click(function(){
        $("#order_content_margin").load("../TabChange/trial #order_content", {"status":"1"})            
        $("#status").text("1");
        $("#time_select").val(5);
        $("#search_text").val("");
    });
    

    $("#wait_take").click(function(){
        $("#order_content_margin").load("../TabChange/trial #order_content", {"status":"2"})            
        $("#status").text("2");
        $("#time_select").val(5);
        $("#search_text").val("");
    });

    $("#wait_comment").click(function(){
        $("#order_content_margin").load("../TabChange/trial #order_content", {"status":"3"}) 
        $("#status").text("3");
        $("#time_select").val(5);
        $("#search_text").val("");
    });
    
    //根据文本查询
    $("#search").click(function(){
        var search_text = $("#search_text").val();    
        $("#order_content_margin").load("../TabChange/trial #order_content", {"search_text":search_text}) 
    });

	function liHeight(){
		$(".order_li_spec").each(function(){
		$(this).siblings("li").height($(this).height());
	});
	}
	
	
	liHeight();
	

	$("#text_search").focus(function(){
		$(this).val("");
	});
	
	$("#text_search").blur(function () {
		if($(this).val()==""){
			$(this).val("商品名称/订单编号");
		}
	})
	
	$("#select_ul li").click(function(){
		var index=$(this).index("#select_ul li");
		$("div.order_content").eq(index).show().siblings("div.order_content").hide();
		$(this).addClass("right_li_spec").siblings("li").removeClass("right_li_spec");
		liHeight();
	});
	
	$(".status_li").hover(function(){
		$(this).find("ul").show().css({position:"absolute",zIndex:3,background:"white",float:"none",width:"100px"});
	},function(){
		$(this).find("ul").hide()
	})

})
