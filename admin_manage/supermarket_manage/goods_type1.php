<?php 
/**
*一级分类显示
*
*/
	require_once("../../conn/conn.php");
	//一级分类
	
	//当前是几级分类
	$type=1;
	$id=0;
	//显示各自管理权限下的分类
	if($_SESSION["role"]==1){
		$where=" where typebelong=0";
	}else{
		$where=" where typebelong=$_SESSION[mall_id]";
	}
	//echo $where;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="author" content="liuxiao@WiiPu -- http://www.wiipu.com" />
		<link rel="stylesheet" href="../css/style2.css" type="text/css" />
		<script src="../js/jquery-1.6.min.js" type="text/javascript"></script>
		<script type="text/javascript" src="../js/upload.js"></script>
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
					<span>位置：超市管理 －&gt; 商品分类－&gt; <strong>一级分类</strong></span>
				</div>
				<div class="content">
					<form action="add_type_do.php" method="post" id="doForm">
						<p>分类名称：<input class="in1" type="text" name="goods_type"/></p><br/>
						<p>分类权重：<input class="in1 weight" type="text" name="weight" />(输入1-9999中的任意数，数值越大楼层越靠前，默认为1)</p><br/>
						<p>分类LOGO上传: 
						 <input type="hidden" name="img_url" id="image_url">
						 <span id="upd_pics" name=""></span>
						 <input type="file" name="file" id="file_image"/>
							<span id="loading_image" style="display:none;">
							<img src="../images/loading.gif" alt="loading...">
							</span>
							<span id="logo_image"></span>
							<input type="button" value="上传" onclick="return ajaxFileUpload('image');" 
							class="btn btn-large btn-primary" />(*LOGO尺寸：30*30以内)
						</p>	
						<p><input type="checkbox" name="display"/>是否首页分类显示</p><br/>
						<input type="button" value="确定添加" onclick="return check()"></p>
						<input type="hidden" value="<?=$type?>" name="type">
						<input type="hidden" value="<?=$id?>" name="id">
					</form>
					<form action="modify_type_do.php" method="post" id="replace" style="display:none;">
						<p>分类名称：<input class="in1" type="text" name="goods_type"/></p><br/>
						<p>分类权重：<input class="in1 weight" type="text" name="weight" />(输入1-9999中的任意数，数值越大楼层越靠前，默认为1)</p><br/>
						<p>分类LOGO：<img class="logo" src="" name="11"/></p>
						<p>分类LOGO上传: 
						 <input type="hidden" name="img_url" id="image_url">
						 <span id="upd_pics" name=""></span>
						 <input type="file" name="file" id="file_image"/>
							<span id="loading_image" style="display:none;">
							<img src="../images/loading.gif" alt="loading...">
							</span>
							<span id="logo_image"></span>'
							<input type="button" value="上传" onclick="return ajaxFileUpload('image');" 
							class="btn btn-large btn-primary" />(*LOGO尺寸：500*500以内)
						</p>	
						<p><input type="checkbox" name="display"/>是否首页分类显示</p><br/>
						<input type="button" value="确定修改" onclick="return checks()"></p>
						<input type="hidden" value="<?=$type?>" name="type">
						<input type="hidden" value="<?=$id?>" name="id">
					</form><br>
					<table style="width:100%">
						<tr class="t1">
							<td style="10%">序号</td>
							<td style="10%">分类LOGO</td>						
							<td style="10%">分类名称</td>
							<td style="10%">分类权重</td>
							<td style="10%">首页显示</td>
							<td style="10%">操作</td>
						</tr>
						<?php
						//查看商场的分类
						$select="select * from super_goods_type1".$where." order by weight desc";
						//echo $select;
						$res=mysql_query($select);
						while($row=mysql_fetch_array($res)){
							$type1_id=$row['id'];
							$type1_name=$row['name'];
						?>
							<tr>
								<td class="id"><?php echo $type1_id ?></td>
								<td class="logo"><img src="<?php echo $row["logo"] ?>" /></td>
								<td class="name"><?php echo $type1_name?></td>
								<td class="weight"><?php echo $row["weight"]?></td>
								<td class="display"><?php echo $row["display"]==1?"显示":"不显示";?></td>
								<td><a href="#" class="modify">修改</a>|<a href="goods_type2.php?id=<?=$type1_id?>&type1_name=<?=$type1_name?>">查看子分类</a>|<a href="javascript:void(0);" onclick="delete_foods(<?php echo $type1_id?>)">删除</a></td>
							</tr>
						<?php
						}
						?>
					</table>
				</div>
			</div>
		</div>
	</body>
</html>
<script>
$(function(){
	$(".modify").click(function(){
		$("#doForm").remove();
		var $parent=$(this).parent("td");
		var id=$parent.siblings(".id").text();
		var logo=$parent.siblings(".logo").children("img").attr("src");
		var name=$parent.siblings(".name").text();
		var weight=$parent.siblings(".weight").text();
		var display=$parent.siblings(".display").text();
		var $replace=$("#replace");
		$replace.children("input[name='id']").val(id);
		$replace.find("input[name='goods_type']").val(name);
		$replace.find(".logo").attr("src",logo);
		$replace.find(".weight").val(weight);
		if(display=="显示"){
			$replace.find(":checkbox").attr("checked","checked");	
		}else{
			$replace.find(":checkbox").removeAttr("checked");
		}
		$replace.show();
		return false;
	});
	$(".weight").keyup(function(){
		var val=$(this).val();
		if(val!=""&&(val<1||val>9999)){
			alert("请输入合法的数！");
			$(this).val("");
			//return false;
		}
	});
});
//添加商品分类时的检查
form=document.getElementById("doForm");
function check()
{
	if(form.goods_type.value=="")
	{
		alert('请填写分类名称！');
		form.name.focus();
		return false;
	}else{
		form.submit();
	}	
}
function delete_foods(id){
	if(confirm("确认删除吗")){
			$.post("delete_foods_do.php",
				{
					goods_id:id
				},
				function(data,status){
					if(data==1){
						alert("删除成功!");
						location.reload();
					}else{
						alert("删除失败");
					}
				}
			);
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
						var c = $("#upd_pics").html();
							$("#upd_pics").html(c +
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
//修改商品分类时的检查
forms=document.getElementById("replace");
function checks()
{
	if(forms.goods_type.value=="")
	{
		alert('请填写分类名称！');
		forms.name.focus();
		return false;
	}else{
		forms.submit();
	}	
}
</script>