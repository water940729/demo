<?php

include ("../../conn/conn.php");
if($_SESSION['role'] != 2){
	  exit();
}

if(isset($_SESSION['mall_id'])){
	$shopId = $_SESSION['mall_id'];
}else{
	exit();
}

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
		 var order = 'DESC';
		 var orderBy = 'id';
		 var page = 1;
		 var currentType;
		 var currentOrder;
		 
		function searchGoods(){
			 
			 $.ajax({
				   type: "POST",
				   url: "financeController.php",
				   data: "action=searchShop&type="+type+"&order="+order+"&orderBy="+orderBy+"&page="+page,
				   success: function(msg){
					 var dataObj=eval("("+msg+")");//转换为json对象
					 if(dataObj['status'] == 1){
						 $('#pageConDiv').empty();
						 $("#pageConDiv").append(dataObj['constr']);
						 $("#orderTable").empty();
						// var headStr ='<tr><td colspan=11 >'+dataObj['headStr']+'</td></tr>';
						 //$("#orderTable").append(headStr);
						  var str =' <tr class="t1" id="adTableLine">'+
						    '<td >Applying Store</td>'+
						 	'<td>State</td>'+
							'<td >Apply Time</td>'+
							'<td >Handle Time</td>'+
							'<td>Receive Time</td>'+					
							'<td>Amount</td>'+
							'<td>Balance</td>'+
							'<td >Message</td>'+
							'<td >Refuse</td>'+
							'<td >Operations</td>'+
						    '</tr>';
						  $("#orderTable").append(str);
						  if(!dataObj['data'])return;
						   for(var i=0;i<dataObj['data'].length;i++){		 
                            str ="<tr name='"+dataObj['data'][i]['id']+"'>"+
							        "<td>"+dataObj['data'][i]['shop']+"</td>"+
							        "<td>"+dataObj['data'][i]['status']+"</td>"+
									"<td>"+dataObj['data'][i]['applyTime']+"</td>"+
									"<td>"+dataObj['data'][i]['disposeTime']+"</td>"+
									"<td>"+dataObj['data'][i]['successTime']+"</td>"+
									"<td id='tagShow'>"+dataObj['data'][i]['withdrawMoney']+"</td>"+
									"<td>"+dataObj['data'][i]['nowMoney']+"</td>"+
									"<td>"+dataObj['data'][i]['appendRes']+"</td>";
									
									if(dataObj['data'][i]['tag'] < 3){
										str+="<td onclick='reDrow(this)'>Refuse</td>";
									}else{
										str+="<td onclick='' ></td>";
									}
									
									 if(dataObj['data'][i]['tag'] == 0){
								     str = str + '<td onclick="changeStatus(this)" style="cursor:pointer" >Verify</td></tr>';
							         }else if(dataObj['data'][i]['tag'] == 1){
									 str = str + '<td onclick="changeStatus(this)" style="cursor:pointer" >Draw</td></tr>';
								     }else if(dataObj['data'][i]['tag'] == 2){
									 str = str + '<td onclick="changeStatus(this)" style="cursor:pointer" >Draw Success</td></tr>';
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
			var r=confirm("Sure to delete");
			if(r==false){
				return ;
			}
			$.ajax({
				   type: "POST",
				   url: "orderManageController.php",
				   data: "action=delete&id="+$(ele).parent().attr('name'),
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
		function reDrow(ele){
			var r=confirm("Sure to operate");
			if(r==false){
				return ;
			}
			$.ajax({
				   type: "POST",
				   url: "financeController.php",
				   data: "action=reDrow&id="+$(ele).parent().attr('name'),
				   success: function(msg){
					 var dataObj=eval("("+msg+")");//转换为json对象
					  if(dataObj['status'] == 1){
                         //$(ele).parent().remove();
						 searchGoods();
					 } 
				   }
			 });
		}
		function changeStatus(ele){
			
			var r=confirm("Sure to operate");
			if(r==false){
				return ;
			}
			$.ajax({
				   type: "POST",
				   url: "financeController.php",
				   data: "action=changeStatus&id="+$(ele).parent().attr('name'),
				   success: function(msg){
					 var dataObj=eval("("+msg+")");//转换为json对象
					  if(dataObj['status'] == 1){

                        // $(ele).parent().remove();
						 searchGoods();
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
						<li style='text-align:center'>Finance Manage</li>
					</ul>		
				</div>				
			<div class="listintor">
				<div class="header1">
					<span>Position:Draw Manage <strong><?php echo $shopLocation[$shopPage]; ?></strong></span>	
				</div>
				<div class="content" style='height:1000px'>
				<div class='controllDiv'>
				<span id='orginOrder' name='DESC' onclick='chooseOrder(this)' style='background-color:#87ceeb;'>Desc By Time</span>
				<span name='ASC' onclick='chooseOrder(this)'>Asc By Time</span>
				
				<span id='orginType' style='margin-left:40px; background-color:#87ceeb;' onclick='chooseStatus(this)' name='' >All</span>
				<span name=0 onclick='chooseStatus(this)'>Waiting</span>
				<span name=1 onclick='chooseStatus(this)'>Has Verified</span>
				<span name=2 onclick='chooseStatus(this)'>Drawing</span>
				<span name=3 onclick='chooseStatus(this)'>Succeed</span>
				<span name=4 onclick='chooseStatus(this)'>Refused</span>
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