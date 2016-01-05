<?php 
/**
*二级分类显示
*
*/
	require_once("../../conn/conn.php");
	//一级分类
	$type1_id=$_GET['id'];
	$type=2;
	$select="select * from goods_type1 where id=$type1_id";
	$result=mysql_query($select);
	$row=mysql_fetch_array($result);
	$type1_name=$row['name'];
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
						<li><a href="#">GoodsSort</a></li>
					</ul>		
				</div>
				<div class="header1"><img src="../images/square.gif" width="6" height="6" alt="" />
					<span>Position:GoodsManage -&gt; GoodsSort-&gt; <strong>SortLevel2</strong></span>
				</div>
				<div class="content">
					<div style="text-align:left">
						<p>CurrentSort:<?=$type1_name?></p><br>
						<form action="add_type_do.php" method="post" id="doForm">
							<p>SortName:<input class="in1" type="text" name="goods_type"/>	
							<input type="button" value="SureToAdd" onclick="return check()"></p>
							<input type="hidden" value=2 name="type">
							<input type="hidden" value="<?=$type1_id?>" name="type1_id">
						</form>
					</div>
					<br/>
					<table style="width:100%">
						<tr class="t1">
							<td style="10%">No.</td>
							<td style="10%">SortName</td>
							<td style="10%">Operation</td>
						</tr>
						<?php
						$select="select * from goods_type2 where type1_id='$type1_id'";
						$res=mysql_query($select);
						while($row=mysql_fetch_array($res)){
							$type2_id=$row['id'];
							$type2_name=$row['name'];
						?>
							<tr>
								<td><?php echo $type2_id ?></td>
								<td><?php echo $type2_name?></td>
								<td><a href="<?php echo "goods_type3.php?id=$type1_id&&type_name=$type2_name&&type1_id=$type2_id";?>">CheckChildSort</a>|<a href="<?php echo "modify_shop_food.php?id=$type2_id";?>">Modify</a>|<a href="javascript:void(0);" onclick="delete_foods2(<?php echo $type2_id ?>)">Delete</a></td>
							</tr>
						<?php
						}
						?>
					</table>
					<a href='goods_type1.php'>Back</a>
				</div>
			</div>
		</div>
	</body>
</html>
<script>
form=document.getElementById("doForm");
function check()
{
	if(form.goods_type.value=="")
	{
		alert('Input name of this sort!');
		form.name.focus();
		return false;
	}else{
		form.submit();
	}	
}
function delete_foods2(id){
		if(confirm("Confirm to delete?")){
			$.post("delete_foods2_do.php",
				{
					goods_id:id
				},
				function(data,status){
					if(data==1){
						alert("Delete success!");
						location.reload();
					}else{
						alert(data);
						alert("Delete failed!");
					}
				}
			);
		}
}
</script>