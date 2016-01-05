<?php
require_once('../../conn/config.php');
$conn=mysql_connect(WIIDBHOST,WIIDBUSER,WIIDBPASS);
	 
if (!$conn){
		die ('数据库连接失败');
	}
mysql_select_db(WIIDBNAME, $conn) or die ("没有找到数据库。");
mysql_query("set names utf8");

$result=mysql_query("select id,name from mall") or die("数据库异常");
$shopLocation[0]='葵花商城首页';
while($array=mysql_fetch_array($result)){
	$shopLocation[$array['id']]=$array['name'];
}
mysql_free_result($result);
	
  $sql = 'select id,name,shop_name,mall_id,price,discount,state from goods where state = 0 limit 20';
  $res = mysql_query($sql);
  
  while($row = mysql_fetch_array($res)){
	 $goodsList[] = $row;
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
		
		var mallId = -1;
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
							'<td width="10%">商品名称</td>'+
							'<td width="10%">商城</td>'+
							'<td width="10%">价格</td>'+					
							'<td width="10%">折扣</td>'+
							'<td width="10%">审核状态</td>'+
							'<td width="10%">操作</td>'+
						    '</tr>';
						  $("#goodsTable").append(str);
						  for(var i=0;i<dataObj['data'].length;i++){
							  var showStr;
						      var color;
						      var tag;
							 if(dataObj['data'][i]['state'] == 1){
								 showStr = '已审核';
								 showStr1 = '取消审核';
								 color = '#FFFFCC';
								 tag = 1;
							 }else{
								  color = 'white';
								  showStr = '未审核';
								  showStr1 = '通过审核';
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
			var r=confirm("确认审核");
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
						   var str = dataObj['state']==0 ? '通过审核':'取消审核';
						   var str1 = dataObj['state']==1 ? '已审核':'未审核';
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

<body>
		<div class="bgintor" style='height:800px'>				
			<div class="listintor">
				<div class="tit1">
					<ul>				
						<li style='text-align:center'>商品审核</li>
					</ul>		
				</div>
				<div class="header1"><img src="../images/square.gif" width="6" height="6" alt="" />
					<span>位置：商品审核 －&gt; <strong><?php echo $shopLocation[$shopPage]; ?></strong></span>
					 
				</div>
				<div class="content" style='height:800px;'>
				
				<div style='width:800px;height:40px;'>
				<span style='background-color:white;margin-left:20px; float:left' >选择商城 :
				<select id='mallSelect' >
				<option value='-1'>所有</option>
				<?php
					foreach($shopLocation as $k=>$val){
					     echo "<option value=$k>$val</option>";
					}
				?> 
				</select >
				</span>
				<span id='stateSelect' style=' margin-left:20px; float:left;'>选择状态 :
				<select>
				<option value='-1'>所有</option>
				<option value=0>未审核</option>
				<option value=1>已审核</option>
				</select>
				</span>
				
				<span style='background-color:white;margin-left:20px; float:left ; cursor:pointer' onclick='checkGoods()'>搜索</span>
				
				<span id='upPage' style=' display:none; float:right ; cursor:pointer ; margin-right:100px' name='up' onclick='checkGoods(this)'>上一页</span>
				
				<span style=' float:right ; cursor:pointer ; display:block ; margin-right:20px ' name='down' onclick='checkGoods(this)' >下一页</span>
				
				</div>
				
				<table class='mytable' width="100%" style="float:left;" id='goodsTable'>
				
			
				</table>
			    </div>	
				</div>
	
			</div>	
	</body>
	

</html>

