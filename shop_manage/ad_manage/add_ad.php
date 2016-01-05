<?php
	include ("../../smarty.php"); //引入配置文件
    //$smarty->assign('name',$name); //用定义的变量$name的值("OK")替换掉模版中的<{$name}>
	$result=mysql_query("select id,name from mall") or die("EDatabaseError");
	while($array=mysql_fetch_array($result)){
		  $shopLocation[]=$array;
	}
	mysql_free_result($result);
	
	$result=mysql_query("select * from adLocation") or die("EDatabaseError");
		while($array=mysql_fetch_array($result)){
		  $adLocation[]=$array;
	}

$locationArr = array('Top','First floor','Second floor','Third floor','Fourth floor');	
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
table
{
   width:400px;
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
</style>

<body>
		<div class="bgintor">				
			<div class="listintor">
				<div class="tit1">
					<ul>				
						<li><a href="#">Advertising Management</a></li>
					</ul>		
				</div>
				<div class="header1"><img src="../images/square.gif" width="6" height="6" alt="" />
					<span>Location: Advertising Management －&gt; <strong>View Advertisements</strong></span>
					<span style="margin-left:30px;">Advertising mall location 
					<select id='direction'>
					<?php
					foreach($directionArr as $k=>$val){
					     echo "<option value=$k>$val</option>";
					}
					?> 
					</select >
					<span>Advertising floor location 
					<select id='location'>
					<?php
					foreach($locationArr as $k=>$val){
					     echo "<option value=$k>$val</option>";
					}
					?> 
					</select>
					<button onclick="searchLoc()" type='button'>Searching</button>
					</span>
				</div>
				<div class="content">
					<table width="100%">
						<tr class="t1">
							<td>Mall location</td>
							<td>Floor location</td>
							<td>Advertising rates/Month</td>
							<td>Using ?</td>
							<td>Ad Links</td>
							<td>Operation</td>
						</tr>
						<?php 
	      foreach($adLocation as $val){
		  //var_dump($val);
		      echo "<tr>".
			        "<td>".$shopLocation[$val['topLocation']]['name']."</td>".
			        "<td>".$locationArr[1]."</td>".
					"<td>".$val['price']."</td>".
					"<td>".$val['price']."</td>".
					"<td>".$val['price']."</td>".
					"<td>".'<a>Delete</a>'."</td>".
			        "</tr>";
		  } 
		?>
					</table>
				</div>
			</div>	
		</div>
	</body>
	
</html>