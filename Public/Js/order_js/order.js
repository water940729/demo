$(function(){
	function liHeight(){
		$(".order_li_spec").each(function(){
		$(this).siblings("li").height($(this).height());
	});
	}
	
	
	liHeight();
	
	$("#left_content ul li").hover(function(){
		$(this).addClass("addClass");
		$(this).find("a").css("color","white");
	},function(){
		$(this).removeClass("addClass");
		$(this).find("a").css("color","#666");
		$(this).find("a:contains('我的优惠券')").css("color","#E3007F");
	});
	
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

    //删除一个订单的事件绑定都放到最外面来做，避免多次重复绑定
    $(document).on("click", ".seckill_delete", function(){
        $order_num = $(this).parents(".order_inform_top").children("span").first().text();
        var r = confirm("确认取消该商品？");
        if(r ==true){
            $.post("../Widget/del_seckillorder",{"order_num":$order_num}, function(data){
                if(data.status){
                    alert("订单取消成功成功.");
                    $('#right').load('../TabChange/seckill.html');
                } else {
                    alert("发生了一些问题.");
                }
            }, "json");
        }
    })

    $(document).on("click", ".trial_delete", function(){
        $order_num = $(this).parents(".order_inform_top").children("span").first().text();
        var r = confirm("确认取消该商品？");
        if(r ==true){
            $.post("../Widget/del_trialorder",{"order_num":$order_num}, function(data){
                if(data.status){
                    alert("订单取消成功成功.");
                    $('#right').load('../TabChange/trial.html');
                } else {
                    alert("发生了一些问题.");
                }
            }, "json");
        }
    })

    $(document).on("click", ".teambuy_delete", function(){
        $order_num = $(this).parents(".order_inform_top").children("span").first().text();
        var r = confirm("确认取消该商品？");
        if(r ==true){
            $.post("../Widget/del_teambuyorder",{"order_num":$order_num}, function(data){
                if(data.status){
                    alert("订单取消成功成功.");
                    $('#right').load('../TabChange/teambuy.html');
                } else {
                    alert("发生了一些问题.");
                }
            }, "json");
        }
    })

    $(document).on("click", ".book_delete", function(){
        var order_num = $(this).parents(".order_inform_top").children("span").first().text();
        var r = confirm("确认取消该商品？");
        if(r ==true){

            $.post("../Widget/del_bookorder",{"order_num":order_num}, function(data){
                if(data.status){
                    alert("订单取消成功成功.");
                    $('#right').load('../TabChange/book.html');
                } else {
                    alert("发生了一些问题.");
                }
            }, "json");

        }
    })

   //下面处理的是收藏页面加入购物车以及删除
   $(document).on("click", ".del_shopcar_add", function(){
        var r = confirm("确认取消该商品？");
        if(r == true){
        type_id = $(this).parent(".del_shopcar").children("span").first().text();     
        good_id = $(this).parent(".del_shopcar").children("span").last().text();     
        $.post("../Widget/del_collect_good", {"type_id":type_id, "good_id":good_id}, function(data){
            if(data.status){
                alert("取消收藏成功");
                $('#right').load('../TabChange/collect.html');
            } else {
                alert("发生了一些问题");
            }
        }, "json");

        }
   });

   //加入购物车
   /*
   $(document).on("click", ".del_shopcar_add", function(){
        var r = confirm("确认加入购物车?");
        if(r == true){
            good_id = $("#collect_good_id").text();
            type_id = $(this).parent(".del_shopcar").children("span").first().text();     
            $.post("../Widget/add_to_cart", {"type_id":type_id, "good_id":good_id}, function(data){
                if(data.status){
                    alert("成功加入购物车");
                    $('#right').load('../TabChange/collect.html');
                }else {
                    alert("发生了一些问题"); 
                }
            }, "json");
        }
   });

*/

   //下面处理的是店铺收藏页面加入购物车以及删除
   $(document).on("click", ".del_shop_add", function(){
        var r = confirm("确认取消该店铺的收藏？");
        if(r == true){
        shop_id = $(this).parent(".del_shopcar").children("span").first().text();     
        $.post("../Widget/del_collect_shop", { "shop_id":shop_id}, function(data){
            if(data.status){
                alert("取消收藏成功");
                $('#right').load('../TabChange/shop_collect.html');
            } else {
                alert("发生了一些问题");
            }
        }, "json");

        }
   });

   //点击评价事件
   $(document).on("click",".score_btn", function(){
        //得到tag列表
        var tag_array = new Array();
        $(this).parents("div.score").find("ul.label").find(":checkbox").each(function(){
            if($(this).is(":checked")){
                tag_array.push($(this).next("span").text());
            }
        })

        var score = $(this).parents("div.score").find("span.score_span").text();    
        var content = $(this).parents("div.score").find("textarea.text").val();

        var img_url = new Array();
        $(this).parents("div.score").find("div.feedback").find("img").each(
        function(){
            img_url.push($(this).attr("src"));    
        })
        
        var good_type_id = $(this).parents("div.goods_con").find("span.good_type_id").text();      
        var good_id = $(this).parents("div.goods_con").find("span.good_id").text();      
        var order_time = $(this).parents("div.goods_con").find("span.order_time").text();      
        //试用stringify来json序列化，传递给后台
        var dataInfo = {
            tags:tag_array,
            good_id:good_id,
            good_type_id:good_type_id,

            order_time:order_time,
            img_url:img_url,
            score:score,
            content:content
        }
        $.ajax({
            url:"../Widget/add_score",
            type:"post",
            dataType:"json",
            data:JSON.stringify(dataInfo),
            contentType:"application/json",
            success:function(data){
               if(data.status == "0"){
                    alert("Something wrong");
               } else {
                    alert("Comment success");
                    $('#right').load('../TabChange/score.html');
               }
            },
            fail:function(){
                alert("not ok");
            }
        });
        //var value=$(this).parents("div.score").find("div textarea.text").val();
   }) //end score_btn click

    //点击退换货事件
    $(document).on("click", ".return_btn", function(){
        var good_id;
        var good_type_id;
        var order_time;
        var content;
        var zhifubao;
        var service_type;
        var if_invoice = 0;
        var img_url = new Array();
        $(this).parents("div.return").find("div.feedback").find("img").each(
        function(){
            img_url.push($(this).attr("src"));    
        })
        good_id = $(this).parents("div.goods_con").find("span.good_id").text();
        order_time = $(this).parents("div.goods_con").find("span.order_time").text();
        ordid = $(this).parents("div.goods_con").find("span.ordid").text();
        good_type_id = $(this).parents("div.goods_con").find("span.good_type_id").text();
        content = $(this).parents("div.return").find("textarea.text").val();
        service_type = $(this).parents("div.return").find("ul.service").find('input:radio:checked').val();
        zhifubao = $(".zhifubao").val();
        $(this).parents("div.return").find("div.invoice").find(":checkbox").each(function(){
            if($(this).is(":checked")){
                if_invoice = 1;
            }
        });
        var dataInfo = {
            good_id:good_id,
            good_type_id:good_type_id,
            content:content,
            img_url:img_url,
            if_invoice:if_invoice,
            service_type:service_type,
            ordid:ordid,
            order_time:order_time,
            zhifubao:zhifubao
        }
        $.ajax({
            url:"../Widget/add_return",
            type:"post",
            dataType:"json",
            data:JSON.stringify(dataInfo),
            contentType:"application/json",
            success:function(data){
                if(data.status == 1){
                    alert("信息提交成功");
                } else {
                    alert("提交出现了一些问题");
                }
                $("#right").load("../TabChange/return_good.html");
            },
            fail:function(){
                alert("not ok");
            }
        });  //end ajax
    });

    $(document).on("click", ".confirm_rev", function(){
        order_num = $(this).parents(".order_inform").find(".ordid").text();
        good_id = $(this).parents(".order_inform_bottom").find(".productid").text();
        $.post("../Widget/confirm_rev", {"order_num":order_num, "good_id":good_id, "type":"1"}, function(data){
           if(data.status){
                //alert("confirm success");
           } else {
                alert("something wrong");
           }
           
           $('#right').load('../TabChange/order.html');
        }, "json")
    });
    $(document).on("click", ".seckill_confirm_rev", function(){
        order_num = $(this).parents(".order_inform").find(".ordid").text();
        good_id = $(this).parents(".order_inform_bottom").find(".productid").text();
        $.post("../Widget/confirm_rev", {"order_num":order_num, "good_id":good_id, "type":"2"}, function(data){
            if(data.status){
                //alert("已确认收货");
            } else {
                alert("something wrong");
            }
           $('#right').load('../TabChange/order.html');
        }, "json")
    });

    $(document).on("click", ".teambuy_confirm_rev", function(){
        order_num = $(this).parents(".order_inform").find(".ordid").text();
        good_id = $(this).parents(".order_inform_bottom").find(".productid").text();
        $.post("../Widget/confirm_rev", {"order_num":order_num, "good_id":good_id, "type":"3"}, function(data){
           if(data.status){
                alert("已确认收货");
           } else {
                alert("发生了一些问题");
           }
           $('#right').load('../TabChange/order.html');
        }, "json")
    });

    $(document).on("click", ".trial_confirm_rev", function(){
        order_num = $(this).parents(".order_inform").find(".ordid").text();
        good_id = $(this).parents(".order_inform_bottom").find(".productid").text();
        $.post("../Widget/confirm_rev", {"order_num":order_num, "good_id":good_id, "type":"4"}, function(data){
           if(data.status){
                alert("已确认收货");
           } else {
                alert("发生了一些问题");
           }
           $('#right').load('../TabChange/order.html');
        }, "json")
    });
    $(document).on("click", ".book_confirm_rev", function(){
        order_num = $(this).parents(".order_inform").find(".ordid").text();
        good_id = $(this).parents(".order_inform_bottom").find(".productid").text();
        $.post("../Widget/confirm_rev", {"order_num":order_num, "good_id":good_id, "type":"5"}, function(data){
           if(data.status){
                alert("已确认收货");
           } else {
                alert("发生了一些问题");
           }
           $('#right').load('../TabChange/order.html');
        }, "json")
    });

    //去付款
    $(document).on("click", ".to_pay", function(){
        var order_num = $(this).parents(".order_inform_top").children("span").first().text();
        document.write('<form name="myForm"><input type=hidden name=ordid></form>');
        var myForm = document.forms['myForm'];
        myForm.action='/order/to_pay';
        myForm.method='post';
        myForm.ordid.value=order_num;
        myForm.submit();
    });
    
    //点击去评价
    $(document).on("click",".order_comment",function(){
        $('#right').load('../TabChange/score.html');
    });

    
    //处理退换货点击
    $(document).on("click", ".order_return", function(){
        good_id = $(this).parents(".order_inform_bottom").find(".productid").text();
        order_num = $(this).parents(".order_inform").find(".ordid").text();
        $.post("../Widget/oper_return", {"order_num":order_num, "good_id":good_id,"type":1}, function(data){
            if(data.status){
                //alert("已记录该退换货，请在退换货页面填写详细信息");
                $("#right").load("../TabChange/return_good.html");
            } else {
                alert("发生了一些问题");
            }
        }, "json");
    });

    $(document).on("click", ".seckill_return", function(){
        good_id = $(this).parents(".order_inform_bottom").find(".productid").text();
        order_num = $(this).parents(".order_inform").find(".ordid").text();
        $.post("../Widget/oper_return", {"order_num":order_num, "good_id":good_id,"type":2}, function(data){
            if(data.status){
                alert("已记录该退换货，请在退换货页面填写详细信息");
                $("#right").load("../TabChange/return_good.html");
            } else {
                alert("发生了一些问题");
            }
        }, "json");
    });
    $(document).on("click", ".teambuy_return", function(){
        good_id = $(this).parents(".order_inform_bottom").find(".productid").text();
        order_num = $(this).parents(".order_inform").find(".ordid").text();
        $.post("../Widget/oper_return", {"order_num":order_num, "good_id":good_id,"type":3}, function(data){
            if(data.status){
                alert("已记录该退换货，请在退换货页面填写详细信息");
                $("#right").load("../TabChange/return_good.html");
            } else {
                alert("发生了一些问题");
            }
        }, "json");
    });
    $(document).on("click", ".trial_return", function(){
        good_id = $(this).parents(".order_inform_bottom").find(".productid").text();
        order_num = $(this).parents(".order_inform").find(".ordid").text();
        $.post("../Widget/oper_return", {"order_num":order_num, "good_id":good_id,"type":4}, function(data){
            if(data.status){
                alert("已记录该退换货，请在退换货页面填写详细信息");
                $("#right").load("../TabChange/return_good.html");
            } else {
                alert("发生了一些问题");
            }
        }, "json");
    });
    $(document).on("click", ".book_return", function(){
        good_id = $(this).parents(".order_inform_bottom").find(".productid").text();
        order_num = $(this).parents(".order_inform").find(".ordid").text();
        $.post("../Widget/oper_return", {"order_num":order_num, "good_id":good_id,"type":5}, function(data){
            if(data.status){
                alert("已记录该退换货，请在退换货页面填写详细信息");
                $("#right").load("../TabChange/return_good.html");
            } else {
                alert("发生了一些问题");
            }
        }, "json");
    });

})
