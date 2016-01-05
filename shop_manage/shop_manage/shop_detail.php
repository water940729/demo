<?php 
require_once("../../conn/conn.php");
$shop_id=$_GET['shop_id'];
$select="select count(*) as count from shop_food_sort where shop_id='$shop_id'";
$result=mysql_query($select);
$row=mysql_fetch_array($result);
$count=$row["count"];

$select1="select * from shop where shop_id='$shop_id'";
$result1=mysql_query($select1);
$row1=mysql_fetch_array($result1);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="author" content="liuxiao@WiiPu -- http://www.wiipu.com" />
		<link rel="stylesheet" href="../css/style2.css" type="text/css" />
		<script src="../js/jquery-1.6.min.js" type="text/javascript"></script>
	</head>
	<body>
		<div class="bgintor">				
			<div class="listintor">
				<div class="tit1">
					<ul>				
						<li><a href="#">Check the merchants</a></li>
					</ul>		
				</div>
				<div class="header1"><img src="../images/square.gif" width="6" height="6" alt="" />
					<span>Location: merchants management －&gt; Check the merchants－&gt; <strong>Check the dishes</strong></span>
				</div>
				<div class="content">
				<p><h2>The current merchants:<?=$row1["shop_name"]?></h2><p><br>
				<div style="text-align:left">
				<a href="add_shop_food_sort.php?shop_id=<?php echo $shop_id ?>"><input type="button" value="Add food classification"  style="font-size:20px;"></a>
				<a href="add_shop_food.php?shop_id=<?php echo $shop_id ?>"><input type="button" value="Add food"  style="font-size:20px;"></a>
				</div>
				<br/>
				<br/>
				<table style="width:100%">
					<tr class="t1">
						<td style="10%">Dishes</td>
						<td style="10%">Price</td>
						<!--<td style="10%">预计送达时间</td>-->
						<td style="10%">Taste</td>
						<td style="10%">Food classification</td>
						<!--<td style="30%">菜品简介</td>-->
						<td style="10%">Internet pictures</td>
						<td style="10%">Operation</td>
					</tr>
					<?php
					$select="select * from food where shop_id=$shop_id";
					$res=mysql_query($select);
					while($row=mysql_fetch_array($res)){
						$food_id=$row['food_id'];
						$food_name=$row['food_name'];
						$food_time_expected=$row['food_time_expected'];
						$food_flavor_type=$row['food_flavor_type'];
						$food_introduce_info=$row['food_introduce_info'];
						$food_price=$row['food_price'];
						$food_img_url=$row['food_img_url'];
						$food_type_id=$row['food_type_id'];
						$food_sort=$row['food_sort'];
					?>
						<tr>
							<td><?php echo $food_name ?></td>
							<td><?php echo $food_price?></td>
							<td><?php echo $food_flavor_type ?></td>
							<td><?php echo $food_sort?></td>
							<td><img style="width:40px;height:40px" src='<?php echo $food_img_url ?>'></td>
							<td><a href="modify_shop_food.php?food_id=<?=$food_id?>&shop_id=<?=$shop_id?>">Modify</a>|<a href="javascript:if(confirm('Are you sure you want to delete the dishes?')){location.href='delete_food.php?food_id=<?php echo $food_id ?>&shop_id=<?php echo $shop_id ?>'}">Delete</a></td>
						</tr>
					<?php
					}
					?>
				</table>
				<a href="check_shop.php">Return to view the merchants</a>