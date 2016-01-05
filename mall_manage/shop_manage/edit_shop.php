<?php
	require_once('../../conn/conn.php');
	require_once('sqlHelper.php');
	$sqlhelper = new sqlHelper();
	
	$role=$_SESSION["role"];
	$shop_id=$_SESSION['shop_id'];
	$mall_id=$_SESSION['mall_id'];
	$area="";
	if($role==2){
		$area=" where id='$mall_id'";
	}
	
	$edit_shop_id=$_GET["shop_id"];
	$select="select * from shop where id='$edit_shop_id'";
	$result=mysql_query($select);
	$row=mysql_fetch_array($result);
	$shop_name=$row["name"];
	$shop_detail=$row["detail"];
	$shop_mall_id=$row["mall_id"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title> ShopManage</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="author" content="liuxiao@WiiPu -- http://www.wiipu.com" />
		<link rel="stylesheet" href="../css/style2.css" type="text/css"/>
		<link rel="stylesheet" type="text/css" href="../css/jquery.datetimepicker.css"/>
		<script type="text/javascript" src="../js/jquery-1.6.2.min.js"></script>
		<script type="text/javascript" src="../js/upload.js"></script>
	</head>
	<body>
	<div class="bgintor">
		<div class="tit1">
			<ul>				
				<li><a href="#">ShopManage</a> </li>
			</ul>		
		</div>
	<div class="listintor">
		<div class="header1"><img src="../images/square.gif" width="6" height="6" alt="" />
			<span>Position:ShopManage －&gt; <strong>ModifyShop</strong></span>
		</div>		
		<div class="fromcontent">
			<form action="edit_shop_do.php" method="post" id="doForm">
				<input type="hidden" value="<?=$edit_shop_id?>" name="shop_id">
				<?php 
					if($_GET["from"]){
				?>	
					<input type="hidden" value="mall" name="from">
					<input type="hidden" value="<?=$_GET['mall_id']?>" name="mall_id">
					<input type="hidden" value="<?=$_GET['mall_name']?>" name="mall_name">
				<?php
					}
				?>
				<p>Shopname:<input class="in1" type="text" name="name" id="name" value="<?=$shop_name?>" /></p>	
				<p>Belongs(Mall):
				<select class="in1" name="mall" id="mall"></p>
				<?php 
					$select="select * from mall".$area;
					$result=mysql_query($select);
					while($row=mysql_fetch_array($result)){
				?>
					<option value=<?=$row['id']?> <?php echo ($shop_mall_id==$row['id']?"selected":""); ?> ><?=$row['name']?></option>
				<?php
					}
				?>
				</select><br><br>
				<p>ShopLogo:
				<?php 
					$sql3="select * from shop_pictures where shop_id='$edit_shop_id'";
					$result3=mysql_query($sql3);
					while($row3=mysql_fetch_array($result3)){
						$sp_id=$row3["sp_id"];
						$pic_url=$row3["pic_url"];
				?>
						<img src="<?=$pic_url?>" width="100" ><input type='checkbox' checked name='pics[]' value="<?=$sp_id?>"/> 
				<?php
					}
				?>
				</p>
				<p> 
				 <span id="upd_pics" name=""></span>
				 ContinueUploading:
				 <input type="hidden" name="img_url" id="image_url">
				 <input type="file" name="file" id="file_image"/>
				 	<span id="loading_image" style="display:none;">
				 	<img src="../images/loading.gif" alt="loading...">
				 	</span>
				 	<span id="logo_image"></span>
                    <input type="button" value="Upload" onclick="return ajaxFileUpload('image');" 
                    class="btn btn-large btn-primary" />(*PostSize:In 500*500)
				</p><br>				
				<!--
				<p>详细地址：<textarea rows="3" name="detailAddressInfo" cols="100" id="detailAddressInfo" placeholder="不需要重复填写省市区，必须大于5个字符，小于120个字符" onblur="checkAddress()"></textarea></p>
				-->
				<p>ShopIntroduction:
					<textarea  id="detail" name="detail" rows="10" >
						<?=$shop_detail?>
					</textarea>
				</p>
				<p><input type="button" value="Commit" onclick="return check()"/></p>
			</form>
		</div>
	</div>
  </div>
 </body>
</html>
<script>
form=document.getElementById("doForm");
function check()
{
	if(form.name.value=="")
	{
		alert('Input shop name!');
		form.name.focus();
		return false;
	}
	if(form.detail.value=="")
	{
		alert("Input shop introduction!");
		form.detail.focus();
		return false;
	}
	form.submit();
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
		url:'upload_image.php?type=' + file_type,
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
				$.post("add_shop_pictures_do.php",
					{
						shop_id:<?=$edit_shop_id?>,
						pic_url:info[1]
					},
					function(data,status){
						data=eval('('+data+')');
						if(data['result']==1){
						var c = $("#upd_pics").html();
							$("#upd_pics").html(c +
							"<p><img src='"+ info[1] +"' width='100px'> <input type='checkbox' checked name='pics[]' value="+ info[1] +" /> "+info[1]
							+"</p>");
						}else{
							alert("Add image failed!");
						}
					}
				);
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

</script>