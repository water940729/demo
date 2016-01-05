<?php
	require_once('../../conn/conn.php');
	require_once('../../conn/sqlHelper.php');
	$sqlhelper = new sqlHelper();
	$id=$_SESSION["role"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title> Add mall</title>
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
				<li><a href="#">Add mall</a> </li>
			</ul>		
		</div>
	<div class="listintor">
		<div class="header1"><img src="../images/square.gif" width="6" height="6" alt="" />
			<span>Location: the mall management －&gt; <strong>Add mall</strong></span>
		</div>		
		<div class="fromcontent">
			<form action="add_mall_do.php" method="post" id="doForm">
				<p>Mall name:<input class="in1" type="text" name="name" id="name"/></p>	
				<p>Mall poster upload: 
				 <input type="hidden" name="img_url" id="image_url">
				 <span id="upd_pics" name=""></span>
				 <input type="file" name="file" id="file_image"/>
				 	<span id="loading_image" style="display:none;">
				 	<img src="../images/loading.gif" alt="loading...">
				 	</span>
				 	<span id="logo_image"></span>
                    <input type="button" value="上传" onclick="return ajaxFileUpload('image');" 
                    class="btn btn-large btn-primary" />(*The poster size: Less then 500*500)
				</p>	
				<br>
				Mall address:		
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
					City:							
				    <select name="city" id="city" onchange="obtain_county(this.value)">						
					</select>	
					District:
					 <select name="county" id="county" >						
					</select>	
				</p>
				<!--
				<p>详细地址：<textarea rows="3" name="detailAddressInfo" cols="100" id="detailAddressInfo" placeholder="不需要重复填写省市区，必须大于5个字符，小于120个字符" onblur="checkAddress()"></textarea></p>
				-->
				<p>Detailed address:<textarea rows="3" name="detailAddressInfo" cols="100" id="detailAddressInfo" placeholder="Don't need to repeat to fill in provinces, must be greater than five characters, less than 120 characters" ></textarea></p><?php //onblur="checkAddress()"?>
				<p>Merchant's brief introduction:<textarea  id="introduceInfo" name="introduceInfo" rows="10" ></textarea>
				</p>
				<p><input type="button" value="Confirm" onclick="return check()"/></p>
			</form>
		</div>
	</div>
  </div>
 </body>
</html>
<script>
flag=0;
form=document.getElementById("doForm");
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
				alert("You entered a wrong address, please re-enter");
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
	if(form.name.value=="")
	{
		alert('Please fill in the Merchant name!');
		form.name.focus();
		return false;
	}
	/*var mobie=form.phone;
	var a = /^((\(\d{3}\))|(\d{3}\-))?13\d{9}|14[57]\d{8}|15\d{9}|18\d{9}$/ ; 
	 if(mobie.value.length!=11||!mobie.value.match(a)&&mobie.value!="")  
	{            
		alert("请输入正确的手机号码!");
		mobie.focus();
		return false;
							 
	}
	*/
	if(form.province.value=="")
	{
		alert('Please fill out the mall province!');
		form.province.focus();
		return false;
	} 
	if(form.city.value=="")
	{
		alert('Please fill in the shopping mall in city!');
		form.city.focus();
		return false;
	}
	if(form.county.value=="")
	{
		alert('Please fill out the shopping district.');
		form.county.focus();
		return false;
	}
	if(form.detailAddressInfo.value=="")
	{
		alert('Please fill out the stores detailed address!');
		form.detailAddressInfo.focus();
		return false;
	}
	
	if(form.introduceInfo.value=="")
	{
		alert("Please fill out the store");
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