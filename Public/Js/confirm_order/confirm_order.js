$(function(){
    var flag=true;
    var value;
    //单选按钮点击取消事件
    $("input[type='radio']").click(function(){
        if(flag){
            $(this).attr("checked",true);
            flag=false;
        }else{
            $(this).attr("checked",false);
            flag=true;
        }
    })

    //文本框聚焦事件
    $("input[type='text']").focus(function(){
        value=$(this).val();
        $(this).val("");

    })

    $("input[type='text']").blur(function(){
        if($(this).val()==""){
            $(this).val(value);
        }
    })

    //点击添加新地址事件
    $(".add_new_address").click(function(){
        if($(".add_information").is(":hidden")){
            $(".add_information").fadeIn('normal');
			$(".info_div input[type=text]").val("");
			$("#detail_add").text("");
        }else{
            $(".add_information").hide();
        }
        
    })

    //点击所在地址事件
    $(".choose_sel_add").children("div").text( $(".choose_sel_add").find("li:first").text());
    $(".choose_sel_add").click(function(){
        if($(this).children("ul").is(":hidden")){
            $(this).children("ul").show();
        }else{
            $(this).children("ul").hide();
        }

    })

    $(".choose_sel_add").find("li").click(function(){
        $(".choose_sel_add").children("div").text($(this).text());
        $("#detail_add").text($(this).text());
    })


    //判断文本框中的文字的个数
    $(".leave_message").val("");
    $(".leave_message").blur(function(){
        var length=$(this).val().length;
        if(length>90){
            //alert("亲，意见的字数要在90字以内");
            alert("Dear, the length of suggestion should be less than 90.");
            $(this).val($(this).val().substr(0,90));
        }
        $(this).siblings("span").find(".message_num").text($(this).val().length);
    })

	
	//计算价格
	var allPrice=0;
	$("span.money").each(function(){
		var num=$(this).parent().siblings("div.good_num").find("span").text();
		var price=$(this).parent().siblings("div.price").find("span").text();
		var aP="￥"+num*price;
		allPrice+=num*price;
		$(this).text(aP);
	});
	
	$(".last_price").text("￥"+allPrice);

    //选择位置的时间

    var str="";
	 
    $("#cho_inp").keydown(function(){
        //alert("ok")
       var text1=$("#Province").val();
		var text2=$("#Country").val();
		var text3=$("#Town").val();
        if(text1=="省名"||text2=="地市"||text3=="县市"){
            alert("Please finish address completely.");
        }else{
            str=text1+text2+text3;
            $("#detail_add").text(str);
        }

    })



})