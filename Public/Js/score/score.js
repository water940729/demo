/**
 * Created by SaiSai on 2015/6/28.
 */
$(function(){

    var arr=["很差", "差", "良好", "好", "很好"];
  $(".order_che").click(function(){
        var $score=$(this).parents("div.goods_bot").next("div.score");
        if($score.is(":hidden")){
            $score.show();
        }else{
            $score.hide();
        }
    })

  //评分效果的实现
  $(".star").each(function(){
        var flag=true;
        var aLi=$(this).find("li");
        var iNow=0;
        aLi.hover(function(){
            var index=$(this).index();
            /*for(var i=iNow;i<aLi.length;i++){
                 aLi.eq(i).removeClass("score_cur");
            }*/
            for(var i=0;i<=index;i++){
                aLi.eq(i).addClass("score_cur");
            }
            $(this).parents("div.score").find("span.score_span").text(arr[index]);

        },function(){
            $(this).parents("div.score").find("span.score_span").text(arr[iNow]);
            for(var i=iNow+1;i<aLi.length;i++){
                 aLi.eq(i).removeClass("score_cur");
            }
            if(iNow==0&&flag){
              for(var i=iNow;i<aLi.length;i++){
                 aLi.eq(i).removeClass("score_cur");
            } 
            $(this).parents("div.score").find("span.score_span").text("");
            }
        });

       aLi.click(function(){
            iNow=$(this).index();
            for(var i=iNow+1;i<aLi.length;i++){
                 aLi.eq(i).removeClass("score_cur");
            }
            flag=false;
       }) 
  })


//回车键发送
$(".txt").each(function(){
    var that=$(this);
    $(this).keydown(function(ev){
       var keycode=ev.keyCode;
       if(keycode==13){
        var oVal=$(this).val();
        var newLi=that.parent("ul.label").append("<li><input type='checkbox' checked ><span>"+oVal+"</span></li>");
        $(this).val("");
       }
    })
})

/*
   //点击评价事件
   $(".btn").click(function(){
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
                    alert("出现了一些问题。");
               } else {
                    alert("成功评价");
               }
            },
            fail:function(){
                alert("not ok");
            }
        });
        //var value=$(this).parents("div.score").find("div textarea.text").val();
   }) //end btn click
*/
}) //end all
   
