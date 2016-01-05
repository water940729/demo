<?php
	require("../../conn/conn.php");
	if($_SESSION["role"]==1){
		$area="where role=0";
	}else{
		$area="where role=$_SESSION[mall_id]";
	}
	$sql="select name,type,background from floorManage ".$area;
	$result=mysql_query($sql);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Home page management</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="author" content="liuxiao@WiiPu -- http://www.wiipu.com" />
		<link rel="stylesheet" href="../css/style2.css" type="text/css" />
		<script src="../js/jquery-1.6.min.js" type="text/javascript"></script>
		<script type="text/javascript" src="../js/upload.js"></script>
		<script>
			function check()
			{
				var form=document.getElementById("doForm");
				if(form.floor_name.value=="")
				{
					alert('Please fill in the name!');
					form.name.focus();
					return false;
				}else{
					form.submit();
				}	
			}
			function ajaxFileUpload(file_type)
			{
				var doing = '';
				$("#loading"+"_"+file_type).ajaxStart(function()
				{
					$(this).show();
					$("#logo"+"_"+file_type).html("Uploading...");
				})
				.ajaxComplete(function(){
					$(this).hide();
					$("#logo"+"_"+file_type).html("");
				});
				$.ajaxFileUpload
				(
					{
					url:'../shop_manage/upload_image.php?type=' + file_type,
					secureuri:false,
					fileElementId:'file'+'_'+file_type,
					dataType: 'json',
					data:{},
					success: function (data, status)
					{
						data=data.replace('<pre>','');
						data=data.replace('</pre>','');
						var info=data.split('|');
						if(info[0]=="E")
						{
							alert(info[1]);
						}
						else
						{
							var c = document.getElementById('upd_pics').innerHTML;
								document.getElementById('upd_pics').innerHTML= c + 
											"<p><img src='"+ info[1] +"' width='100'> <input type='checkbox' checked name='pics[]' value="+ info[1] +" /> "+info[1]+
											"</p>";
						}
						
					},
					error: function (data, status, e)
					{
						 alert(e);
					}
				}
				
				)
				return false;
			}
			function ajaxFileUpload1(file_type)
			{
				var doing = '';
				$("#loading1"+"_"+file_type).ajaxStart(function()
				{
					$(this).show();
					$("#logo1"+"_"+file_type).html("Uploading...");
				})
				.ajaxComplete(function(){
					$(this).hide();
					$("#logo1"+"_"+file_type).html("");
				});
				$.ajaxFileUpload
				(
					{
					url:'../shop_manage/upload_image.php?type=' + file_type,
					secureuri:false,
					fileElementId:'file1'+'_'+file_type,
					dataType: 'json',
					data:{},
					success: function (data, status)
					{
						data=data.replace('<pre>','');
						data=data.replace('</pre>','');
						var info=data.split('|');
						if(info[0]=="E")
						{
							alert(info[1]);
						}
						else
						{
							var c = document.getElementById('upd1_pics').innerHTML;
								document.getElementById('upd1_pics').innerHTML= c + 
											"<p><img src='"+ info[1] +"' width='100'> <input type='checkbox' checked name='pics1[]' value="+ info[1] +" /> "+info[1]+
											"</p>";
						}
						
					},
					error: function (data, status, e)
					{
						 alert(e);
					}
				}
				
				)
				return false;
			}
			//删除楼层
			function delete_floor(id){
				if(confirm("Confirm Delete")){
					$.ajax({
						type:"POST",
						url:"delete_floor.php",
						data:"id="+id,
						success:function(msg){
							alert(msg);
							location.reload();
						}
					});
				}
			}
		</script>
	</head>
	<body>
		<div class="bgintor">				
			<div class="listintor">
				<div class="tit1">
					<ul>				
						<li><a href="#">Home page management</a></li>
					</ul>		
				</div>
				<div class="header1"><img src="../images/square.gif" width="6" height="6" alt="" />
					<span>Location: home page management －&gt; <strong>Floor management</strong></span>
				</div>
				<div class="content">
					<a href="add_floor.php">Add floor</a>
					<table width="100%">
						<tr class="t1">
							<td width="5%">Floor ID</td>
							<td width="5%">Floor name</td>
							<td width="10%">Floor weight</td>
							<!--<td width="10%">类别</td>-->
							<td width="10%">Background color</td>
							<?php if($_SESSION["role"]!=1){
								echo "<td width='10%'>Floor pictures</td>";
							
							}?>
							<td width="10%">Operation</td>
						</tr>
						<?php
							$pagesize=20;							
							$select="select count(*) as page_count from floorManage ".$area;
							$rest=mysql_query($select);
							$rs=mysql_fetch_array($rest);
							$count=$rs['page_count'];						
							if($count%$pagesize){
							$pagecount = intval($count/$pagesize)+1;
							}else{
								$pagecount = intval($count/$pagesize);
							}
							if(isset($_GET['page'])){
								$page=intval($_GET['page']);
							}else{
								$page=1;
							}
							$pagestart = ($page-1)*$pagesize;
							$sql1="select * from floorManage ".$area." order by weight desc limit ".$pagestart.",".$pagesize;
							$result1=mysql_query($sql1);
							while($row1=mysql_fetch_array($result1))
							{	
								$id=$row1['id'];
								$weight=$row1["weight"];
								$name=$row1['name'];
								$background=$row1["background"];
								$logo=$row1["logo"];
						?>
						<tr>
							<td><?php echo $id?></td>
							<td><?php echo $name?></td>
							<td><?php echo $weight?></td>
							<?php /*<td><?php echo $type?></td>*/?>
							<td><div style="margin:0 auto;background-color:<?php echo $background?>;width:80px;height:20px;"></div></td>
							<?php if($_SESSION["role"]!=1)echo "<td><img src='".$logo."'></td>";?>
							<td>
								<a href="floor_type.php?id=<?=$id?>&name=<?=$name?>">Classified Management</a>|
								<a href="modify_floor.php?id=<?=$id?>">Modify floor</a>|
								<a href="javascript:void(0);" onclick="delete_floor(<?php echo $id;?>)">Delete</a>
							</td>
						</tr>
						<?php
							}	
						?>
					</table>
					<?php	
						if($count==0){
							echo "<center><b>There is no relevant information!</b></center>";
						}else{
					?>
					<div class="page">
						<div class="pagebefore">Current page:<?php echo $page;?>/<?php echo $pagecount;?>page Each page <?php echo $pagesize?> one</div>
						<div class="pageafter">
						<?php echo showPage("check_goods.php",$page,$pagecount,"../images");?>
						<div class="clear"></div>
						</div>
					</div>
					<?php }?>
				</div>
			</div>	
		</div>
	</body>
</html>