<?php

	 include ("../../conn/conn.php");
	 
if($_SESSION['role'] != 3){
	  exit();
}

if(isset($_SESSION['shop_id'])){
	$shopId = $_SESSION['shop_id'];
}else{
	exit();
}

if(isset($_GET['cat'])){
	$cat = $_GET['cat'];
}else{
	$cat = 0;
}
$tableNameArr = array('Mall','Group buying','Seckill','Try','Pre-sale');
$tableArr = array('orderlist','teambuy_orderlist','seckill_orderlist','trial_orderlist','book_orderlist');

$sql = 'select name from shop where id='.$shopId;
$result = mysql_fetch_row(mysql_query($sql));

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="author" content="liuxiao@WiiPu -- http://www.wiipu.com" />
		<link rel="stylesheet" href="../css/style2.css" type="text/css" />
		<script src="../js/jquery-1.6.min.js" type="text/javascript"></script>
		<script type="text/javascript">
		
					 
		 var type = '';
		 var cat = <?php  echo $cat; ?>;
		 var order = 'DESC';
		 var orderBy = 'id';
		 var page = 1;
		 var currentType;
		 var currentOrder;
		 var shopId= <?php  echo $shopId; ?>;
		 
		 function changeMall(){
			shopId = $("#direction").val();
			order = 'DESC';
			orderBy = 'id';
			page = 1;
			currentType='';
			currentOrder='';
			searchGoods();
		 }
		function searchGoods(){
			 
			 $.ajax({
				   type: "POST",
				   url: "orderManageController.php",
				   data: "action=search&cat="+cat+"&type="+type+"&order="+order+"&orderBy="+orderBy+"&page="+page+'&shopId='+shopId,
				   success: function(msg){
					 var dataObj=eval("("+msg+")");//转换为json对象
					 if(dataObj['status'] == 1){
						 $('#pageConDiv').empty();
						 $("#pageConDiv").append(dataObj['constr']);
						 
						 $("#orderTable").empty();
						//var headStr ='<tr><td colspan=11 >'+dataObj['headStr']+'</td></tr>';
						 //$("#orderTable").append(headStr);
						 var str ='<tr><td colspan=15 >'+dataObj['headStr']+'</td></tr>'+
						    ' <tr class="t1" id="adTableLine">'+
							'<td >Order ID</td>'+
							'<td >Order customer</td>'+							
							'<td >Product name</td>'+					
							'<td >Price</td>'+
							'<td >Addressee</td>'+
							'<td >Address</td>'+
							'<td >Order time</td>'+
							'<td>Payment amount</td>'+
							'<td>Courier name</td>'+
							'<td>Delivery order no.</td>'+
							'<td >Order Status</td>'+
							'<td >Delete</td>'+
							'<td >Operation</td>'+
						    '</tr>';
						  $("#orderTable").append(str);
						  if(!dataObj['data']) return;
						   for(var i=0;i<dataObj['data'].length;i++){
							  str ="<tr tag='' style='background-color:' name='"+dataObj['data'][i]['id']+"'>"+
							        "<td>"+dataObj['data'][i]['ordid']+"</td>"+
									"<td>"+dataObj['data'][i]['username']+"</td>"+
									"<td>"+dataObj['data'][i]['productname']+"</td>"+
									"<td>"+dataObj['data'][i]['ordprice']+"</td>"+
									"<td>"+dataObj['data'][i]['recname']+"</td>"+
									"<td>"+dataObj['data'][i]['recaddress']+"</td>"+
									"<td>"+dataObj['data'][i]['ordtime']+"</td>"+
									"<td>"+dataObj['data'][i]['ordfee']+"</td>"+
									"<td>"+dataObj['data'][i]['expressName']+"</td>"+
									"<td>"+dataObj['data'][i]['expressNum']+"</td>"+
									"<td>"+dataObj['data'][i]['stausStr']+"</td>"+
                                    "<td onclick='deleteOrder(this)' style='cursor:pointer'>Delete</td>";
							    if(dataObj['data'][i]['ordstatus'] == 1){
								   str = str + '<td onclick="sendGoods(this)" style="cursor:pointer" >Confirm</td></tr>';
							     }
								 else if(dataObj['data'][i]['ordstatus'] == 4){
									 str = str + '<td onclick="confirmReturn(this)" style="cursor:pointer" name="'+dataObj['data'][i]['ordid'] + ','+dataObj['data'][i]['productid']+'">Confirm</td></tr>';
								 }else{
								    str = str+'<td onclick="" style="cursor:pointer" ></td></tr>';
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
			var r=confirm("confirm deletion");
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
			var str = "<tr style='background-color:#FFF5EE'><td colspan=15 >The order no. :<input name='expressNum' value=''  type='text' /> ----- Courier name:<input name='expressName' type='text' /> ---- <input type='button' onclick ='sendGoodsDo(this,"+$(ele).parent().attr('name')+")' value='Confirm' /><input onclick='sendGoodsCancel(this)' type='button' value='Cancel' /></td></tr>"
		    $(ele).parent().after(str);
		}
		
		function confirmReturn(ele){
			name = $(ele).attr('name');
			order_num = name.split(',')[0];
			good_id = name.split(',')[1];
			$.post("../../Widget/confirm_returned", {"order_num":order_num, "good_id":good_id, "type":"1"}, function(data){
				if(data.status){
					//alert("confirm success");
					window.location.reload();
				} else {
					alert("something wrong");
				}
				//$('#right').load('../TabChange/order.html');
			}, "json")
		}
		function sendGoodsCancel(ele){
			$(ele).parent().parent().prev().children('td').attr('tag',0);
			$(ele).parent().parent().remove();
		}
		function sendGoodsDo(ele,id){
			var r=confirm("Confirm Operation");
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
			
			var r=confirm("Confirm Operation");
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
   width:1200px;
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
				<div class="tit1">
					<ul>				
						<li style='text-align:center;line-height:35px;'>Order Manage</li>
					</ul>		

				</div>
				<div class="header1"><img src="../images/square.gif" width="6" height="6" alt="" />
					<span>Location: Order Management ----   <strong><?php echo  $result[0];?></strong></span>	
					<!-- <span style='font-size:16px;'><a href='./orderManage.php?cat=0'>-----------------商城</a ></span><span style='font-size:16px;'><a href='./orderManage.php?cat=1' >---团购</a></span><span style='font-size:16px;' ><a href='./orderManage.php?cat=2' >---秒杀</a></span> -->
				</div>				
			<div class="listintor">

				<div class="content" style='height:1000px'>
				<div class='controllDiv'>
				<span id='orginOrder' name='DESC' onclick='chooseOrder(this)' style='background-color:#87ceeb;'>DESC Order</span>
				<span name='ASC' onclick='chooseOrder(this)'>ASC Order</span>
				
				<span id='orginType' style='margin-left:40px; background-color:#87ceeb;' onclick='chooseStatus(this)' name='' >All</span>
				<span name=0 onclick='chooseStatus(this)'>Paying</span>
				<span name=1 onclick='chooseStatus(this)'>Paid</span>
				<span name=2 onclick='chooseStatus(this)'>Delivering</span>
				<span name=3 onclick='chooseStatus(this)'>Received</span>
				<span name=4 onclick='chooseStatus(this)'>Returing</span>
				<span name=5 onclick='chooseStatus(this)'>Returned</span>
				<span name=6 onclick='chooseStatus(this)'>Finished</span>
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