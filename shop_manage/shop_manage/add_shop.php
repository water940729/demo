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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title> Add the shop</title>
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
				<li><a href="#">Add the shop</a> </li>
			</ul>		
		</div>
	<div class="listintor">
		<div class="header1"><img src="../images/square.gif" width="6" height="6" alt="" />
			<span>Location: shop management －&gt; <strong>Add the shop</strong></span>
		</div>		
		<div class="fromcontent">
			<form action="add_shop_do.php" method="post" id="doForm">
				<p>Shop name:<input class="in1" type="text" name="name" id="name"/></p>	
				<?php
					if($_GET["mall_id"]){
						$query="select id,name from mall where id=$_GET[mall_id]";
						$result=mysql_query($query);
						$row=mysql_fetch_array($result);
				?>
				<p>The mall:
				<select class="in1" name="mall" id="mall"></p>				
				<?php

						echo"<option value='{$_GET[mall_id]}'>{$row['name']}</option>";
				?>
				<?php
					}else{
				?>
				<p>The mall:
				<select class="in1" name="mall" id="mall"></p>
				<?php 
					$select="select * from mall".$area;
					$result=mysql_query($select);
					while($row=mysql_fetch_array($result)){
				?>
					<option value=<?=$row['id']?> ><?=$row['name']?></option>
				<?php
						}
					}
				?>
				</select>
				<p>Shop logo upload: 
				 <input type="hidden" name="img_url" id="image_url">
				 <span id="shop_images" name=""></span>
				 <input type="file" name="file" id="file_image"/>
				 	<span id="loading_image" style="display:none;">
				 	<img src="../images/loading.gif" alt="loading...">
				 	</span>
				 	<span id="logo_image"></span>
                    <input type="button" value="上传" onclick="return ajaxFileUpload('image');" 
                    class="btn btn-large btn-primary" />(*The poster size: Less then 500*500)
				</p>				
				<p>Shop description:<textarea  id="introduceInfo" name="introduceInfo" rows="10" ></textarea>
				</p>
				<p><input type="button" value="Confirm" onclick="return check()"/></p>
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
		alert('Please fill out the shop name!');
		form.name.focus();
		return false;
	}
	if(form.introduceInfo.value=="")
	{
		alert("Please fill in the store");
		form.introduceInfo.focus();
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
				if (file_type == "image")
				{
					//$("#upd"+"_"+file_type).html("<p><img src='"+ info[1] +"' width='100'> ["+ info[1] +"]"+"</p>");
					var c = document.getElementById('shop_images').innerHTML;
					document.getElementById('shop_images').innerHTML= c + 
                        		"<p><img src='"+ info[1] +"' width='100'> <input type='checkbox' checked name='pics[]' value="+ info[1] +" /> "+info[1]+
                        		"</p>";
				}
				else if(file_type == "file")
				{
					$("#upd"+"_"+file_type).html("<p> ["+ info[1] +"]"+"</p>");
				}
				//var pic_url=info[1];
				//$("#"+file_type+"_url").val(pic_url);
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