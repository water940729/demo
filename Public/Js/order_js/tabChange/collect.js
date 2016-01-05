$(function(){

   $("#all").click(function(){
        $("#collect_content_margin").load("../TabChange/collect #collect_content", {"type":"40"})
   });

   $(".seckill").click(function(){
        $("#collect_content_margin").load("../TabChange/collect #collect_content", {"type":"3"})
   });

   $(".common").click(function(){
        $("#collect_content_margin").load("../TabChange/collect #collect_content", {"type":"1"})
   });


   $(".teambuy").click(function(){
        $("#collect_content_margin").load("../TabChange/collect #collect_content", {"type":"4"})
   });

   $(".trial").click(function(){
        $("#collect_content_margin").load("../TabChange/collect #collect_content", {"type":"5"})
   });

   $(".book").click(function(){
        $("#collect_content_margin").load("../TabChange/collect #collect_content", {"type":"6"})
   });

    
});
