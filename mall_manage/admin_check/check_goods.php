<?php
require_once('../../conn/config.php');
$conn=mysql_connect(WIIDBHOST,WIIDBUSER,WIIDBPASS);
	 
if (!$conn){
		die ('Database Connection Failed!');
	}
mysql_select_db(WIIDBNAME, $conn) or die ("Database Not Found!");
mysql_query("set names utf8");

$result=mysql_query("select id,name from mall") or die("Database Exception");

$shopLocation[0]='Sunflower Mall Homepage';
 while($array=mysql_fetch_array($result)){
	 $shopLocation[$array['id']]=$array['name'];
}
mysql_free_result($result);

if($_SESSION['role'] == 1){
  $sql = 'select id,name,shop_name,mall_id,price,discount,state from goods where state = 0 limit 20';
  $res = mysql_query($sql);
  
  while($row = mysql_fetch_array($res)){
	 $goodsList[] = $row;
  }
}else if($_SESSION['role'] == 2){
	$myArr = $shopLocation[$_SESSION['mall_id']];
	$shopLocation = '';
	$shopLocation[$_SESSION['mall_id']] = $myArr;
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
		
		var mallId = '<?php if($_SESSION['role'] == 1){echo -1;}else{echo $_SESSION['mall_id'];} ?>';
		var shopId =-1;
		var state  =-1;
		var page = 0;
		
		function searchGoods(){
			 
			 $.ajax({
				   type: "POST",
				   url: "check_goods_controller.php",
				   data: "action=search&mallId="+mallId+"&shopId="+shopId+"&state="+state+"&page="+page,
				   success: function(msg){
					 var dataObj=eval("("+msg+")");//转换为json对象
					 if(dataObj['status'] == 1){
						 $("#goodsTable").empty();
						 var str =' <tr class="t1" id="adTableLine">'+
							'<td width="10%">Goods Name</td>'+
							'<td width="10%">Mall</td>'+
							'<td width="10%">Price</td>'+					
							'<td width="10%">Discount</td>'+
							'<td width="10%">Verify State</td>'+
							'<td width="10%">Operations</td>'+
						    '</tr>';
						  $("#goodsTable").append(str);
						  for(var i=0;i<dataObj['data'].length;i++){
							  var showStr;
						      var color;
						      var tag;
							 if(dataObj['data'][i]['state'] == 1){
								 showStr = 'Has Verified';
								 showStr1 = 'Cancel Verify';
								 color = '#FFFFCC';
								 tag = 1;
							 }else{
								  color = 'white';
								  showStr = 'Not Verified';
								  showStr1 = 'Passed';
								  tag = 0;
							 }
							  str ="<tr tag='"+tag+"' style='background-color:"+color+"' name='"+dataObj['data'][i]['id']+"'>"+
							        "<td>"+dataObj['data'][i]['name']+"</td>"+
									"<td>"+dataObj['data'][i]['mall_id']+"</td>"+
									"<td>"+dataObj['data'][i]['price']+"</td>"+
									"<td>"+dataObj['data'][i]['discount']+"</td>"+
									"<td id='tagShow'>"+showStr+"</td>"+
									"<td onclick='checkInGoods(this)' name='controll' style='cursor:pointer'>"+showStr1+"</td>"+
									"</tr>";
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
		
		function checkInGoods(ele){
			var id = $(ele).parent().attr('name');
			var r=confirm("Verify Confirm");
			if(r==false){
				return ;
			}
			 $.ajax({
				   type: "POST",
				   url: "check_goods_controller.php",
				   data: "action=check&id="+id,
				   success: function(msg){
					 var dataObj=eval("("+msg+")");//转换为json对象
					  if(dataObj['status'] == 1){
						   $(ele).parent().attr('name',dataObj['state']);
						   var str = dataObj['state']==0 ? 'Passed':'Cancel Verify';
						   var str1 = dataObj['state']==1 ? 'Has Verified':'Not Verified';
						   var color = dataObj['state']==1 ? '#FFFFCC':'white';
						   $(ele).parent().css('background-color',color);
						   $(ele).siblings("#tagShow").html(str1);
						   $(ele).html(str);
					  }   
				   }
				});
		}
		
		window.onload = function(){
			  searchGoods();
		}
		</script>		
		<style>
.mytable
{
   width:800px;
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
</head>

<body>
		<div class="bgintor" style='height:800px'>
				<div class="tit1">
					<ul>				
						<li style='text-align:center'>Verify Goods</li>
					</ul>		
				</div>				
			<div class="listintor">
				<div class="header1">
					<span>Position:Verify Goods －&gt; <strong><?php echo $shopLocation[$shopPage]; ?></strong></span>
					 
				</div>
				<div class="content" style='height:800px;'>
				
				<div style='width:800px;height:40px;'>
				<span style='background-color:white;margin-left:20px; float:left' >Malls:
				<select id='mallSelect' >
				<?php if($_SESSION['role'] == 1){
					?>
				<option value='-1'>All</option>
			     <? } ?>
				<?php
					foreach($shopLocation as $k=>$val){
					     echo "<option value=$k>$val</option>";
					}
				?> 
				</select >
				</span>
				<span id='stateSelect' style=' margin-left:20px; float:left;'>Choose state:
				<select>
				<option value='-1'>A </option>
				<option value=0>Not Verified</option>
				<option value=1>Has Verified</option>
				</select>
				</span>
				
				<span style='background-color:white;margin-left:20px; float:left ; cursor:pointer' onclick='checkGoods()'>Search</span>
				
				<span id='upPage' style=' display:none; float:right ; cursor:pointer ; margin-right:100px' name='up' onclick='checkGoods(this)'>Preview</span>
				
				<span style=' float:right ; cursor:pointer ; display:block ; margin-right:20px ' name='down' onclick='checkGoods(this)' >Next</span>
				
				</div>
				
				<table class='mytable' width="100%" style="float:left;" id='goodsTable'>
				
			
				</table>

				</div>
	
			</div>	
	</body>
	

</html>

