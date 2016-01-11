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
		<title> Add Store</title>
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
				<li><a href="#">Add Store</a> </li>
			</ul>		
		</div>
	<div class="listintor">
		<div class="header1"><img src="../images/square.gif" width="6" height="6" alt="" />
			<span>Location：Store Manager －&gt; <strong>Add Store</strong></span>
		</div>		
		<div class="fromcontent">
			<form action="add_shop_do.php" method="post" id="doForm">
				<p>Store：<input class="in1" type="text" name="name" id="name"/></p>
				<p>earnings ratio：<input class="in1" type="text" name="ratio" id="ratio"/></p>（For example: 80 indicates a pay market 80%, shops with 20%）	
				<p>Store logo Uploading: 
				 <input type="hidden" name="img_url" id="image_url">
				 <span id="shop_images" name=""></span>
				 <input type="file" name="file" id="file_image" style="display:none;"/>
				 	<input type="button" value="chose file" style="margin-right:100px;" onclick="file_image.click()"/>
				 	<span id="loading_image" style="display:none;">
				 	<img src="../images/loading.gif" alt="loading...">
				 	</span>
				 	<span id="logo_image"></span>
                    <input type="button" value="uploading" onclick="return ajaxFileUpload('image');" 
                    class="btn btn-large btn-primary" />(*Poster size：in 431*110)
				</p>				
				<p>Store description：<textarea  id="introduceInfo" name="introduceInfo" rows="10" ></textarea>
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
		alert('Please enter store name！');
		form.name.focus();
		return false;
	}
	if(form.introduceInfo.value=="")
	{
		alert("Please enter store description");
		form.introduceInfo.focus();
		return false;
	}
	if(form.ratio.value=="")
	{
		alert("Please enter store earnings ratio");
		form.ratio.focus();
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
		$("#logo"+"_"+file_type).html("uploading……");
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
					var c = $("#shop_images").html();
					$("#shop_images").html(c +
						"<p><img src='"+ info[1] +"' width='100px'> <input type='checkbox' checked name='pics[]' value="+ info[1] +" /> "+info[1]
					+"</p>");					
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