<?php
	require("../../conn/conn.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>超市管理</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="author" content="liuxiao@WiiPu -- http://www.wiipu.com" />
		<link rel="stylesheet" href="../css/style2.css" type="text/css" />
		<script src="../js/jquery-1.6.min.js" type="text/javascript"></script>
		<!--<script type="text/javascript" src="../js/jquery-1.9.1.min.js"></script>-->		
		<script type="text/javascript" src="../js/upload.js"></script>
		<script type="text/javascript" src="../js/jquery.simple-color.js"></script>
		<script>
			function check()
			{
				var form=document.getElementById("doForm");
				if(form.floor_name.value=="")
				{
					alert('请填写楼层名称！');
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
					$("#logo"+"_"+file_type).html("上传中……");
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
					$("#logo1"+"_"+file_type).html("上传中……");
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
						alert("请输入合法的数！");
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
					}
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
						<li><a href="#">超市管理</a></li>
					</ul>		
				</div>
				<div class="header1"><img src="../images/square.gif" width="6" height="6" alt="" />
					<span>位置：超市管理 －&gt; <strong>添加楼层</strong></span>
				</div>
				<div class="content">
					<form action="add_floor_do.php" method="post" id="doForm">
						<p>楼层名称:<input class="in1" type="text" name="floor_name"/></p><br/>
						<p>楼层权重:<input class="in1" type="text" name="weight" id="weight"/>(输入1-9999中的任意数，数值越大楼层越靠前，默认为1)</p><br/>
						<p>楼层背景色选择:
							<input type="hidden" id="simple_color_value" name="simple_color_value" value=""/>
							<input class='simple_color_kitchen_sink' value='#993300'/>
						</p>
						<br/>
						<input type="button" value="确定添加" onclick="return check()"></p>
						<input type="hidden" value="<?=$type?>" name="type">
						<input type="hidden" value="<?=$id?>" name="id">
					</form>
				</div>
			</div>	
		</div>
	</body>
</html>