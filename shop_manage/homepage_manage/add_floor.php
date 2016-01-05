<?php
	require("../../conn/conn.php");
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
		<script type="text/javascript" src="../js/jquery-1.9.1.min.js"></script>
		<script type="text/javascript" src="../js/jquery.simple-color.js"></script>
		<script>
			function check()
			{
				var form=document.getElementById("doForm");
				if(form.floor_name.value=="")
				{
					alert('Please fill out the name of floor!');
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
			$(function(){
				$("#weight").keyup(function(){
					var val=$(this).val();
					if(val!=""&&(val<1||val>9999)){
						alert("Please enter the legal number!");
						$(this).val("");
						//return false;
					}
				});
				$("#addType").click(function(){
					var name=$("option:selected").text();
					var prev=$.trim($("#prev").val());//去除首尾空格
					if(prev==""){
						var content=name;
					}else{
						var content=prev+","+name;
					}
					$("#prev").val(content);
					return false;
				});
				$('.simple_color_kitchen_sink').simpleColor({
					boxHeight: 40,
					cellWidth: 20,
					cellHeight: 20,
					chooserCSS: { 'border': '1px solid #660033' },
					displayCSS: { 'border': '1px solid red' },
					displayColorCode: true,
					livePreview: true,
					onSelect: function(hex, element) {
					  //alert("You selected #" + hex + " for input #" + element.attr('class'));
					  $("#simple_color_value").val("#"+hex);
					  //alert($("#simple_color_value").val());
					},
					/*onCellEnter: function(hex, element) {
					  console.log("You just entered #" + hex + " for input #" + element.attr('class'));
					},
					onClose: function(element) {
					  alert("color chooser closed for input #" + element.attr('class'));
					}
					*/
				});
			})
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
					<span>Location: home page management －&gt; <strong>Add floor</strong></span>
				</div>
				<div class="content">
					<form action="add_floor_do.php" method="post" id="doForm">
						<p>Floor name:<input class="in1" type="text" name="floor_name"/></p><br/>
						<p>Floor weight:<input class="in1" type="text" name="weight" id="weight"/>(Input number between 1 to 9999, the greater the numerical figure the more, the default is 1)</p><br/>
						<p>Floor background color choice:
							<input type="hidden" id="simple_color_value" name="simple_color_value" value=""/>
							<input class='simple_color_kitchen_sink' value='#993300'/>
						</p>
						<?php if($_SESSION["role"]!=1){
						?>
						<p>Floor LOGO upload: 
						 <input type="hidden" name="img1_url" id="image1_url">
						 <span id="upd1_pics" name=""></span>
						 <input type="file" name="file" id="file1_image"/>
							<span id="loading1_image" style="display:none;">
							<img src="../images/loading.gif" alt="loading...">
							</span>
							<span id="logo1_image"></span>
							<input type="button" value="Upload" onclick="return ajaxFileUpload1('image');" 
							class="btn btn-large btn-primary" />
						</p>
						<?php
						}?>
						<br/>
						<input type="button" value="Sure to add" onclick="return check()"></p>
						<input type="hidden" value="<?=$type?>" name="type">
						<input type="hidden" value="<?=$id?>" name="id">
					</form>
				</div>
			</div>	
		</div>
	</body>
</html>