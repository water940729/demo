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

$sql = 'select name from shop where id='.$shopId;
$result = mysql_fetch_row(mysql_query($sql));
	
$sql = 'select balanceMoney,useMoney,ratio from shop where id='.$shopId;
$res = mysql_fetch_row(mysql_query($sql));

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="author" content="liuxiao@WiiPu -- http://www.wiipu.com" />
		<link rel="stylesheet" href="../css/style2.css" type="text/css" />
		<script src="../js/jquery-1.6.min.js" type="text/javascript"></script>
		
<script type="text/javascript">
		
		var mallId = 0;
		var shopId =-1;
		var state  =-1;
		var page = 0;
		
		function searchGoods(){
			 
			 $.ajax({
				   type: "POST",
				   url: "financeController.php",
				   data: "action=search",
				   success: function(msg){
					 var dataObj=eval("("+msg+")");//转换为json对象
					 if(dataObj['status'] == 1){
						 $("#goodsTable").empty();
						 var str =' <tr class="t1" id="adTableLine">'+
						 	'<td width="10%">Status</td>'+
							'<td width="10%">Application Time</td>'+
							'<td width="10%">Handling time</td>'+
							'<td width="10%">Account Time</td>'+					
							'<td width="10%">Applications amount</td>'+
							'<td width="10%">Balance</td>'+
							'<td width="10%">Message</td>'+
							'<td width="10%">Operation</td>'+
						    '</tr>';
						  $("#goodsTable").append(str);
						  for(var i=0;i<dataObj['data'].length;i++){
							  var showStr;
						      var color;
						      var tag;
							 if(dataObj['data'][i]['state'] == 1){
								 showStr = 'Audited';
								 showStr1 = 'Cancel the audit';
								 color = '#FFFFCC';
								 tag = 1;
							 }else{
								  color = 'white';
								  showStr = 'Not audit';
								  showStr1 = 'Passed';
								  tag = 0;
							 }
							  str ="<tr tag='"+tag+"' style='background-color:"+color+"' name='"+dataObj['data'][i]['id']+"'>"+
							        "<td>"+dataObj['data'][i]['status']+"</td>"+
									"<td>"+dataObj['data'][i]['applyTime']+"</td>"+
									"<td>"+dataObj['data'][i]['disposeTime']+"</td>"+
									"<td>"+dataObj['data'][i]['successTime']+"</td>"+
									"<td id='tagShow'>"+dataObj['data'][i]['withdrawMoney']+"</td>"+
									"<td>"+dataObj['data'][i]['nowMoney']+"</td>"+
									"<td>"+dataObj['data'][i]['appendRes']+"</td>";
									
								if(dataObj['data'][i]['statusKey'] == 0){
									str += "<td style='cursor:pointer; ' onclick='reApply(this)' > "+'Withdraw'+"</td>"+
									       "</tr>";
								}else{
									str += "<td></td>"+
									       "</tr>";
								}
						    $("#goodsTable").append(str);
							if(page>0){
						        $("#upPage").css('display','block');
							}
						 }
					 }
				   }
				});
		}
		
		function checkGoods(ele){
			 mallId = $("#mallSelect option:selected").val();
		     shopId = -1;
		     state = $("#stateSelect option:selected").val();
			 if( $(ele).attr('name') == 'up'){
				 page = page - 1;
			 }else if( $(ele).attr('name') == 'down'){
				 page = page + 1;
			 }
			
			 searchGoods();
		}
	
		window.onload = function(){
			  searchGoods();
		}
		
		function reApply(ele){
			var id = $(ele).parent().attr('name');
			var r=confirm("Confirm to withdraw");
			if(r==false){
				return ;
			}
			 $.ajax({
				   type: "POST",
				   url: "financeController.php",
				   data: "action=reApply&id="+id,
				   success: function(msg){
					 var dataObj=eval("("+msg+")");//转换为json对象
					  if(dataObj['status'] == 1){
						 alert('Submitted successful'); 
                         searchGoods();						 
					  }   
				   }
				});
				
		}
		function apply(){
			
			var sum = $('#sumInput').val();
			var r=confirm("Confirm the audit withdrawal");
			if(r==false){
				return ;
			}
			 $.ajax({
				   type: "POST",
				   url: "financeController.php",
				   data: "action=apply&sum="+sum,
				   success: function(msg){
					 var dataObj=eval("("+msg+")");//转换为json对象
					  if(dataObj['status'] == 1){
						 alert('Submitted successful'); 
                         searchGoods();						 
					  }   
				   }
				});
		}
		</script>		
		<style>
.mytable
{
   width:1000px;
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
</style>

<body>
		<div class="bgintor" style='height:800px'>
				<div class="tit1">
					<ul>				
						<li style='text-align:center;line-height:35px;'>Commodity audit</li>
					</ul>		
				</div>				
			<div class="listintor">
				<div class="header1">
					<span>Location: Financial management ---- <strong><?php echo $result[0]; ?></strong></span>
					 
				</div>
				<div class="content" style='height:1000px;'>
				
				<div style='width:1000px;height:30px;margin-left:20px;font-size:18px;'>
				<span>
                <?php
				    echo 'Current Balance : '.$res[0].'    '.'Current available balance : '.$res[1].' Commission ratio:'.($res[2]*100).'%';
				?>
				</span>
				<span style='float:right ;font-size:14px; margin-right:30px;'>
				<span onclick='apply()' style="cursor:pointer;background-color:#FF7EAC;display:inline-block;width:110px;height:30px;line-height:30px;text-align:center;color:white;border-radius:5px;font-weight:bold;margin-bottom:5px;> 提现申请 ----</span>
				金额：
				<input id='sumInput' type='text' name='sum' style='width:50px;' />
				</span>
				</div>
				
				<table class='mytable' width="100%" style="float:left;" id='goodsTable'>
				
			
				</table>
			    </div>	
				</div>
	
			</div>	
	</body>
	

</html>
