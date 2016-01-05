<?php
	require("../../conn/conn.php");
	$sql="select * from floorManage where id=$_GET[id]";
	$result=mysql_query($sql);
	$row=mysql_fetch_array($result);
	/*
							<p>楼层类别:<input type="text" class="in1" name="floor_type" id="prev" value="<?php echo $row["type"];?>"/>（多个类别之间用英文,隔开，可自己定义）
						<select name="typename">
							<?php
								$sql="select * from goods_type1 where typebelong=$_SESSION[mall_id]";
								$result=mysql_query($sql);
								while($rows=mysql_fetch_assoc($result)){
									echo "<option value='{$rows["id"]}'>$rows[name]</option>";
								}
							?>
						</select> <button id="addType">添加</button></p><br/>
	*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>HomepageManage</title>
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
					alert('Input floor name!');
					form.name.focus();
					return false;
				}else{
					form.submit();
				}	
			}
			function ajaxFileUpload1(file_type)
			{
				var doing = '';
				$("#loading1"+"_"+file_type).ajaxStart(function()
				{
					$(this).show();
					$("#logo1"+"_"+file_type).html("Uploading");
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
						alert("Input an illegal number!");
						$(this).val("");
						//return false;
					}
				});
				/*$("#addType").click(function(){
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
				*/
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
						<li><a href="#">HomepageManage</a></li>
					</ul>		
				</div>
				<div class="header1"><img src="../images/square.gif" width="6" height="6" alt="" />
					<span>Position:HomepageManage －&gt; <strong>AddFloor</strong></span>
				</div>
				<div class="content">
					<form action="modify_floor_do.php" method="post" id="doForm">
						<p>FloorName:<input class="in1" type="text" name="floor_name" value="<?php echo $row['name'];?>"/></p><br/>
						<p>FloorWeight:<input class="in1" type="text" name="weight" id="weight" value="<?php echo $row['weight'];?>"/>(Input any number between 1 & 9999,The larger the numerical floor the top,Default is 1)</p><br/>
						<p>CurrentColor:<div style="background-color:<?php echo $row['background'];?>;width:80px;height:20px;"></div></p><br/>
						<p>BackgroundColor:
							<input type="hidden" id="simple_color_value" name="simple_color_value" value=""/>
							<input class='simple_color_kitchen_sink' value='#993300'/>
						</p>
						<?php if($_SESSION["role"]!=1){
						?>
						<p>Floor LOGO Upload: 
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
						<input type="button" value="SureToModify" onclick="return check()"></p>
						<input type="hidden" value="<?=$type?>" name="type">
						<input type="hidden" value="<?=$row['id']?>" name="id">
					</form>
				</div>
			</div>	
		</div>
	</body>
</html>