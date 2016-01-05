<?php

	 include ("../../conn/conn.php");
	 
	 if($_SESSION['role'] == 1){
		$shopPage = isset($_GET['shopPage'])?$_GET['shopPage']:0;
	}else if($_SESSION['role'] == 2){
		$shopPage = $_SESSION['mall_id'];	
	}
	
   if(isset($_GET['cat'])){
	$cat = $_GET['cat'];
   }else{
	$cat = 0;
    }
    $tableNameArr = array('商城','团购','秒杀','试用','预售','超市');
	$tableArr = array('orderlist','teambuy_orderlist','seckill_orderlist','trial_orderlist','book_orderlist',' super_orderlist');
	
	$result=mysql_query("select id,name from mall") or die("数据库异常");
	    $shopLocation[0]='葵花商城';
	 while($array=mysql_fetch_array($result)){
		  $shopLocation[$array['id']]=$array['name'];
	 }
	 
	mysql_free_result($result);
	$result=mysql_query("select * from adLocation where pageLocation =$shopPage") or die("数据库异常");
		while($array=mysql_fetch_array($result)){
		  $adLocation[]=$array;
	 }
	$mallId = isset($_GET['id'])?$_GET['id']:0;
    $type = isset($_GET['type'])?$_GET['type']:-1;
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="author" content="liuxiao@WiiPu -- http://www.wiipu.com" />
		<link rel="stylesheet" href="../css/style2.css" type="text/css" />
		<script src="../js/jquery-1.6.min.js" type="text/javascript"></script>
		<script type="text/javascript">
		
		 var cat = <?php  echo $cat; ?>;			 
		 var type = <?php  echo $type; ?>;
		 var order = 'DESC';
		 var orderBy = 'id';
		 var page = 1;
		 var currentType;
		 var currentOrder;
		 var mallId= <?php  echo $mallId; ?>;
		 
		 function changeMall(){
			mallId = $("#direction").val();
			order = 'DESC';
			orderBy = 'id';
			page = 1;
			currentType='';
			currentOrder='';
			$('#titleMall').text($("#direction option:selected").text());
			searchGoods();
		 }
		function searchGoods(){
			 
			 $.ajax({
				   type: "POST",
				   url: "orderManageController.php",
				   data: "action=search&cat="+cat+"&type="+type+"&order="+order+"&orderBy="+orderBy+"&page="+page+'&mallId='+mallId,
				   success: function(msg){
					 var dataObj=eval("("+msg+")");//转换为json对象
					 if(dataObj['status'] == 1){
						 $('#pageConDiv').empty();
						 $("#pageConDiv").append(dataObj['constr']);
						 
						 $("#orderTable").empty();
						// var headStr ='<tr><td colspan=11 >'+dataObj['headStr']+'</td></tr>';
						 //$("#orderTable").append(headStr);
						 var str ='<tr><td colspan=15 >'+dataObj['headStr']+'</td></tr>'+
						    ' <tr class="t1" id="adTableLine">'+
							'<td >order number</td>'+
							'<td >order user</td>'+
							'<td >commodities_mall</td>'+
							'<td >store</td>'+								
							'<td >product name</td>'+					
							'<td >price</td>'+
							'<td >received</td>'+
							'<td >rec_addr</td>'+
							'<td >order date</td>'+
							'<td>payment amount</td>'+
							'<td>Delivery name</td>'+
							'<td>Delivery order no</td>'+
							'<td >order state</td>'+
							'<td >delete</td>'+
							'<td >operation</td>'+
						    '</tr>';
						  $("#orderTable").append(str);
						   for(var i=0;i<dataObj['data'].length;i++){
							  str ="<tr tag='' style='background-color:' name='"+dataObj['data'][i]['id']+"'>"+
							        "<td>"+dataObj['data'][i]['ordid']+"</td>"+
									"<td>"+dataObj['data'][i]['username']+"</td>"+
									"<td>"+dataObj['data'][i]['mall']+"</td>"+
									"<td>"+dataObj['data'][i]['shop']+"</td>"+
									"<td>"+dataObj['data'][i]['productname']+"</td>"+
									"<td>"+dataObj['data'][i]['ordprice']+"</td>"+
									"<td>"+dataObj['data'][i]['recname']+"</td>"+
									"<td>"+dataObj['data'][i]['recaddress']+"</td>"+
									"<td>"+dataObj['data'][i]['ordtime']+"</td>"+
									"<td>"+dataObj['data'][i]['ordfee']+"</td>"+
									"<td>"+dataObj['data'][i]['expressName']+"</td>"+
									"<td>"+dataObj['data'][i]['expressNum']+"</td>"+
									"<td>"+dataObj['data'][i]['stausStr']+"</td>";
									
								if(dataObj['data'][i]['right'] == 1){
								   str += "<td onclick='deleteOrder(this)' style='cursor:pointer'>del</td>";
								 if(dataObj['data'][i]['ordstatus'] == 1){
								     str = str + '<td tag=0 onclick="sendGoods(this)" style="cursor:pointer" >Shipping Setting</td></tr>';
							     }
								 else if(dataObj['data'][i]['ordstatus'] == 4){
									  str = str + '<td onclick="sendGoods(this)" style="cursor:pointer" >replacement setting</td></tr>';
								 }else if(dataObj['data'][i]['ordstatus'] == 6){
									  str = str + '<td onclick="changeStatus(this)" style="cursor:pointer" >return setting</td></tr>';
								 }
								 else{
								     str = str+'<td onclick="" style="cursor:pointer" ></td></tr>';
							       }
							  }
						      $("#orderTable").append(str);						
					    }}
					 }
				});
		}
		window.onload = function(){
			currentOrder = $("#orginOrder");
			currentType = $("#orginType");
			searchGoods();
		}
		function chooseStatus(ele){
			if(currentType){
				currentType.css('background-color','#ffc0cb');
			}
			currentType = $(ele);
			currentType.css('background-color','#87ceeb');
			type = $(ele).attr('name');
			page = 1;
			searchGoods();
		}
		function chooseOrder(ele){
			if(currentOrder){
				currentOrder.css('background-color','#ffc0cb');
			}
			currentOrder = $(ele);
			currentOrder.css('background-color','#87ceeb');
			order = $(ele).attr('name');
			searchGoods();
		}
		function deleteOrder(ele){
			var r=confirm("确认删除");
			if(r==false){
				return ;
			}
			$.ajax({
				   type: "POST",
				   url: "orderManageController.php",
				   data: "action=delete&cat="+cat+"&id="+$(ele).parent().attr('name'),
				   success: function(msg){
					 var dataObj=eval("("+msg+")");//转换为json对象
					  if(dataObj['status'] == 1){
                          $(ele).parent().remove();
					 } 
				   }
			 });
		}
		function changePage(ele){
			page = $(ele).attr('name');
			searchGoods();
		}
		function sendGoods(ele){
			if($(ele).attr('tag') == 1) return;
			$(ele).attr('tag',1);
			var str = "<tr style='background-color:#FFF5EE'><td colspan=15 >订单号：<input name='expressNum' value=''  type='text' /> ----- 快递名称：<input name='expressName' type='text' /> ---- <input type='button' onclick ='sendGoodsDo(this,"+$(ele).parent().attr('name')+")' value='确认' /><input onclick='sendGoodsCancel(this)' type='button' value='取消' /></td></tr>"
		    $(ele).parent().after(str);
		}
		function sendGoodsCancel(ele){
			$(ele).parent().parent().prev().children('td').attr('tag',0);
			$(ele).parent().parent().remove();
		}
		function sendGoodsDo(ele,id){
			var r=confirm("确认操作");
			if(r==false){
				return ;
			}
			var expressNum = $(ele).siblings("input[name='expressNum']").val();
			var expressName = $(ele).siblings("input[name='expressName']").val();
            
			$.ajax({
				   type: "POST",
				   url: "orderManageController.php",
				   data: "action=changeStatus&cat="+cat+"&id="+id+"&expressNum="+expressNum+"&expressName="+expressName,
				   success: function(msg){
					 var dataObj=eval("("+msg+")");//转换为json对象
					  if(dataObj['status'] == 1){
                         $(ele).parent().parent().remove();
						 searchGoods();	 
					 } 
				   }
			 });
		}
		
		function changeStatus(ele){
			
			var r=confirm("确认操作");
			if(r==false){
				return ;
			}
			$.ajax({
				   type: "POST",
				   url: "orderManageController.php",
				   data: "action=changeStatus&cat="+cat+"&id="+$(ele).parent().attr('name'),
				   success: function(msg){
					 var dataObj=eval("("+msg+")");//转换为json对象
					  if(dataObj['status'] == 1){
                         $(ele).parent().remove();
					 } 
				   }
			 });
			 
		}
		</script>
	</head>
<style>
.mytable
{
  
   border:1px;  
}
table,th,td{ 
 border : 1px solid black;
}
table td{
    text-align:center;
}
td{
  padding:10px;
}

.myUl
{
list-style-type: none;
line-height : 50px;
padding: 0px;
margin: 0px;
}
ul
{
list-style-type: none;
line-height : 50px;
padding: 0px;
margin: 0px;
}
.adAdLocationUl{
	list-style-type: none;
	line-height : 50px;
	padding: 0px;
	margin: 0px;
	background-color:#F5FFFA;
}
.adAdLocationUl>li{
	text-align:center;
	width:300px;
}
.controllDiv{
	width:1200px;
	height:40px;
	float:left;
}
.controllDiv span{
   float:left;
   margin-left:10px;
   background-color:#ffc0cb;
   padding:5px 5px 5px 5px;
   cursor:pointer;
}
.pageConDiv span{
	width:20px;
	text-align:center;
}
.pageConDiv div{
	float:left;
	margin-left:10px;
    background-color:#ffc0cb;
    padding:5px 5px 5px 5px;
	cursor:pointer;
	
}
</style>

<body>
		<div class="bgintor" style='height:800px'>				
			<div class="listintor">
				<div class="tit1">
					<ul>				
						<li style='text-align:center'>order Manger</li>
					</ul>		
				</div>
				<div class="header1"><img src="../images/square.gif" width="6" height="6" alt="" />
					<span>Location：order Manager ----  <strong id='titleMall'><?php echo  $shopLocation[$mallId] ;?> ---- <?php echo  $tableNameArr[$cat] ;?></strong></span>	
					
					
				</div>
				<div class="content" style='height:1000px'>
				<div class='controllDiv'>
				<span id='orginOrder' name='DESC' onclick='chooseOrder(this)' style='background-color:#87ceeb;'>In descending order according to time</span>
				<span name='ASC' onclick='chooseOrder(this)'>In increasing order according to time</span>
				
				<span id='orginType' style='margin-left:40px; background-color:#87ceeb;' onclick='chooseStatus(this)' name='-1' >Total</span>
				<span name=0 onclick='chooseStatus(this)'>ordered</span>
				<span name=1 onclick='chooseStatus(this)'>Paid</span>
				<span name=2 onclick='chooseStatus(this)'>Shipped</span>
				<span name=3 onclick='chooseStatus(this)'>received</span>
				<span name=4 onclick='chooseStatus(this)'>exchange goods</span>
				<span name=4 onclick='chooseStatus(this)'>Have a replacement</span>
				<span name=6 onclick='chooseStatus(this)'>wait sales return</span>
				<span name=7 onclick='chooseStatus(this)'>Have to return</span>
				<span name=8 onclick='chooseStatus(this)'>Have evaluation</span>
				<div class='pageConDiv' id='pageConDiv' style='float:right'>

				</div>
				</div>
				<table class='mytable' width="100%" style="float:left;" id='orderTable'>
				
			
				</table>
	
			</div>	
		
		</div>
		</div>
	</body>
	
<script type="text/javascript">

</script>

</html>