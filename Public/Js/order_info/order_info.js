$(function(){
	var oTxt1 = $("#checktime").text();
	var oTxt2 = $("#ordtime").text();
	//alert(oTxt1);
	//alert(oTxt2);
	var newTime1 = new Date(oTxt1);
	var newTime2 = new Date(oTxt2);
	//alert(newTime1);
	//alert(newTime2);
	$("#checktime").text(newTime1.toLocaleString());
	$("#ordtime").text(newTime2.toLocaleString());
	//var oDate=new Date();
	//alert(oDate.getTime());
	
	$("#delete_order").click(function(){
		if(confirm("确定要删除吗？")){
			$(this).parents("div.bot_title").remove();
		}
		
	})
})