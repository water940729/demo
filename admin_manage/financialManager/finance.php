<?php

	 include ("../../conn/conn.php");
	 
	 if($_SESSION['role'] == 1){
		$shopPage = isset($_GET['shopPage'])?$_GET['shopPage']:0;
		$sql = 'select balanceMoney,useMoney from system_info ';
		$result=mysql_query($sql) or die(mysql_error());
		$siteMoney = mysql_fetch_array($result);
	}else if($_SESSION['role'] == 2){
		$shopPage = $_SESSION['mall_id'];	
	}
	
	$result=mysql_query("select id,name,ratio,balanceMoney,useMoney from mall") or die(mysql_error());
	 while($array=mysql_fetch_array($result)){
		  $mallList[]=$array;
	 }
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="author" content="liuxiao@WiiPu -- http://www.wiipu.com" />
		<link rel="stylesheet" href="../css/style2.css" type="text/css" />
		<script src="../js/jquery-1.6.min.js" type="text/javascript"></script>
		
					 
		
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
			<div class="listintor">
				<div class="tit1">
					<ul>				
						<li style='text-align:center'>finance statistic</li>
					</ul>		
				</div>
				<div class="header1"><img src="../images/square.gif" width="6" height="6" alt="" />
					<span>location：finance statistic ----  <strong id='titleMall'><?php echo  $shopLocation[$mallId] ;?></strong></span>	
					

					
				</div>
				<div class="content" style='height:1000px'>
				<table class='mytable' width="100%" style="float:left;" id='orderTable'>

				<tr style='background-color:white;'><td colspan=4 style='font-size:16px;'>total balance：<?php  echo $siteMoney['useMoney'];  ?></td></tr>
				<tr style='background-color:#B0E0E6;'><td>name</td><td>revenue ratio</td><td>balance</td><td>available balance</td></tr>
				   
				<?php
				   foreach($mallList as $val){
					   
					   echo "<tr><td>$val[name]</td><td>$val[ratio]</td><td>$val[balanceMoney]</td><td>$val[useMoney]</td></tr>";
				   }
				
				?>
			
				</table>
	
			</div>	
		
		</div>
		</div>
	</body>
	
<script type="text/javascript">

</script>

</html>