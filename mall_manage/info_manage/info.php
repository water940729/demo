<?php
	require_once('../../conn/conn.php');
	require_once('../../conn/sqlHelper.php');
	$sqlhelper = new sqlHelper();	
	$sql="select * from mall where id=$_SESSION[mall_id]";
	$result=mysql_query($sql);
	$row=mysql_fetch_array($result);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>GoodsManage</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="author" content="liuxiao@WiiPu -- http://www.wiipu.com" />
		<link rel="stylesheet" href="../css/style2.css" type="text/css"/>
		<script type="text/javascript" src="../js/jquery-1.6.2.min.js"></script>
    	<script type="text/javascript" src="../js/upload.js"></script>
    	<script type="text/javascript" src="../js/jquery-ui.min.js"></script>
		<script type="text/javascript" charset="utf-8" src="../js/ueditor.config.js"></script>
        <script type="text/javascript" charset="utf-8" src="../js/ueditor.all.min.js"> </script>
        <script type="text/javascript" charset="utf-8" src="../js/lang/zh-cn/zh-cn.js"></script>
		<script>
		</script>		
	</head>
	<body>
	<div class="bgintor">
		<div class="tit1">
			<ul>				
				<li><a href="#">GoodsManage</a> </li>
			</ul>		
		</div>
	<div class="listintor">
		<div class="header1">
			<span>Position:GoodsManage －&gt; <strong>AddGoods</strong></span>
		</div>		
		<div class="fromcontent">
			<form action="modify_info.php" method="post" id="doForm">
				<p>GoodsName:<input class="in1" type="text" disabled name="name" id="name" value='<?=$row["name"]?>'/></p>	
				<p>EarningsRatio:<input class="in1" type="text" disabled name="ratio" id="ratio" value='<?=$row["ratio"]?>'/></p>（example:80 means mall earns 80%,store earns 20%）
				<p>Mall LOGO Upload:
				<img src="<?=$row["image_url"]?>" width="100" ><input type='checkbox' checked name='pics[]' value="<?=$mp_id?>"/> 
				 <input type="hidden" name="img_url" id="image_url">
				 <span id="upd_pics" name=""></span>
				 <input type="file" name="file" id="file_image"/>
				 	<span id="loading_image" style="display:none;">
				 	<img src="../images/loading.gif" alt="loading...">
				 	</span>
				 	<span id="logo_image"></span>
                    <input type="button" value="Upload" onclick="return ajaxFileUpload('image');" 
                    class="btn btn-large btn-primary" />(*Post LOGO：289*110)
				</p>	
				<br>
				MallAddress:		
				    <select name="province" id="province" onchange="obtain_city(this.value)">
						<?php
							$sql = "select province_name from county group by province_name";
							$provinces = $sqlhelper->execute_more($sql);
						  
							for($i=0;$i<count($provinces);$i++)
							{					
						?>
							<option value="<?php echo $provinces[$i]['province_name']?>"><?php echo $provinces[$i]['province_name']?></option>
						<?php
							}
						?>							
					</select>
					City：							
				    <select name="city" id="city" onchange="obtain_county(this.value)">						
					</select>	
					Area：
					 <select name="county" id="county" >						
					</select>	
				</p>
				<!--
				<p>详细地址：<textarea rows="3" name="detailAddressInfo" cols="100" id="detailAddressInfo" placeholder="不需要重复填写省市区，必须大于5个字符，小于120个字符" onblur="checkAddress()"></textarea></p>
				-->
				<p>DetailAddress:<textarea style="vertical-align:top;font-size:14px;color:#353535;font-family:'microsoft yahei'" rows="3" name="detailAddressInfo" cols="100" id="detailAddressInfo" placeholder="Don't need to repeat fill in the address,longer than 5 characters,less than 120 characters" value='<?=$row["detail_address"]?>'></textarea></p><?php //onblur="checkAddress()"?>
				<p>MerchantInfomation:<textarea  id="introduceInfo" name="introduceInfo" rows="10" value='<?=$row["introduceInfo"]?>'></textarea>
				</p>
				<p>ServiceQQ：<input class="in1" type="text" name="qq" value='<?=$row["qq"]?>'/>
				<p>ServiceAlitalk：<input class="in1" type="text" name="wangwang" value='<?=$row["wangwang"]?>'/>
				<p><input type="button" value="Submit" onclick="return check()"/></p>
			</form>
		</div>
	</div>
  </div>
 </body>
</html>
<script>
form=document.getElementById("doForm");

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
		url:'../../admin_manage/shop_manage/upload_image.php?type=' + file_type,
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
				$.post("../../admin_manage/add_mall_pictures_do.php",
					{
						mall_id:<?=$mall_id?>,
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
							alert("添加图片失败");
						}
					}
				);
			}
			
		},
		error: function (data, status, e)
		{
			 alert(e);
		}
	});
	return false;
}
function checkAddress()
{
	var add=$("textarea[name='detailAddressInfo']").val();
	if(add!=""){
		var provice=$("select[name='province']").val();
		var city=$("select[name='city']").val();
		var county=$("select[name='county']").val();
		flag=0;
		add=""+provice+city+county+add;
		$.post("check_address_do.php",
		{
			address:add
		},
		function(data,status){
			if(data==0){
				alert("您输入的地址有误请重新填写");
				//doForm.detailAddressInfo.focus();
			}else if(data==1){
				flag=1;
			}
		});
	}
	else
	{
		return false;
	}
}

function check()
{
	if(form.province.value=="")
	{
		alert('请填写商场所在省！');
		form.province.focus();
		return false;
	} 
	if(form.city.value=="")
	{
		alert('请填写商场所在市！');
		form.city.focus();
		return false;
	}
	if(form.county.value=="")
	{
		alert('请填写商场所在区！');
		form.county.focus();
		return false;
	}
	if(form.detailAddressInfo.value=="")
	{
		alert('请填写商场详细地址！');
		form.detailAddressInfo.focus();
		return false;
	}
	
	if(form.introduceInfo.value=="")
	{
		alert("请填写商场简介");
		form.introduceInfo.focus();
		return false;
	}
	/*
	if(flag==0){
		alert('您输入的地址有误，请重新填写详细地址！');
		return false;
	}
	*/
	form.submit();
}
function obtain_city(value)
{
	var city=$('#city');
	city.html("");
	$.post('ajax_obtain_city.php',
	{
		province_name:value
	},
	function(data,status)
	{
        data=eval('('+data+')');
		for (var i=0;i<data.length ;i++ )
		{
			var div="<option value='"+data[i].city_name+"'>"+data[i].city_name+"</option>";
			city.append(div);
		}
	});
}


function obtain_county(value)
{
	var province_name=$("#province").val();
	var county=$('#county');

	
	county.html("");
	$.post('ajax_obtain_county.php',
	{
		province_name:province_name,
		city_name:value
	},
	function(data,status)
	{
        data=eval('('+data+')');
		for (var i=0;i<data.length ;i++ )
		{
			var div="<option value='"+data[i].county_name+"'>"+data[i].county_name+"</option>";
			county.append(div);
		}
		
	});
}
</script>