<?php
	//添加焦点图
	require("../../conn/conn.php");
	$sql="select count(id) as total from goods_type1 where typebelong=$_SESSION[mall_id] and display=1";
	$result=mysql_query($sql);
	$row=mysql_fetch_array($result);
	$height_num=$row["total"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>首页管理</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="author" content="liuxiao@WiiPu -- http://www.wiipu.com" />
		<link rel="stylesheet" href="../css/style2.css" type="text/css" />
		<script src="../js/jquery-1.6.min.js" type="text/javascript"></script>
		<script type="text/javascript" src="../js/upload.js"></script>
		<script>
			function ajaxFileUpload(file_type)
			{
				var doing = '';
				$("#loading"+"_"+file_type).ajaxStart(function()
				{
					$(this).show();
					$("#logo"+"_"+file_type).html("loading……");
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
					$("#logo1"+"_"+file_type).html("loading……");
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
						var c = $("#upd1_pics").html();
							$("#upd1_pics").html(c +
							"<p><img src='"+ info[1] +"' width='100px'> <input type='checkbox' checked name='pics[]' value="+ info[1] +" /> "+info[1]
							+"</p>");
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
			$(function(){
				$("#weight").keyup(function(){
					var val=$(this).val();
					if(val!=""&&(val<1||val>9999)){
						alert("the number is not valid");
						$(this).val("");
						//return false;
					}
				});
			})
		</script>
	</head>
	<body>
		<div class="bgintor">				
			<div class="listintor">
				<div class="tit1">
					<ul>				
						<li><a href="#">homepage manage</a></li>
					</ul>		
				</div>
				<div class="header1"><img src="../images/square.gif" width="6" height="6" alt="" />
					<span>location:homepage manage －&gt; <strong>add focus</strong></span>
				</div>
				<div class="content">
					<form action="add_focus_do.php" method="post" id="doForm">
						<p>refer URL:<input class="in1" type="text" name="link_url"/></p><br/>
						<p>weight:<input class="in1" type="text" name="weight" id="weight"/>(1-9999，default 1)</p><br/>
						<p>upload: 
						 <input type="hidden" name="img1_url" id="image1_url">
						 <span id="upd1_pics" name=""></span>
						 <input type="file" name="file" id="file1_image"/>
							<span id="loading1_image" style="display:none;">
							<img src="../images/loading.gif" alt="loading...">
							</span>
							<span id="logo1_image"></span>
							<input type="button" value="upload" onclick="return ajaxFileUpload1('image');" 
							class="btn btn-large btn-primary" />(size:725*<?php echo $height_num*60-90;?>)
						</p>
						<br/>
						<input type="submit" value="add"></p>
					</form>
				</div>
			</div>	
		</div>
	</body>
</html>