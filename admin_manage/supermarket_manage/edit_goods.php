<?php 
//修改商品
	require_once('../../conn/conn.php'); 
	$role=$_SESSION['role'];
	$shop_id=$_SESSION['shop_id'];
	$mall_id=$_SESSION['mall_id'];
	$area="";
	if($role==2){
		$area=" where mall_id='$mall_id'";
	}else if($role==3){
		$area=" where id='$shop_id'";
	}
	$from=$_GET['from'];
	
	$goods_id=$_GET['goods_id'];
	$select="select * from super_goods where id=$goods_id";
	$result=mysql_query($select);
	$row=mysql_fetch_array($result);
	$goods_name=$row['name'];
	$goods_shop_id=$row['shop_id'];
	$goods_shop_name=$row['shop_name'];
	$goods_mall_id=$row['mall_id'];
	$goods_mall_name=$row['mall_name'];
	$goods_price=$row['price'];
	$original_price=$row["original_price"];
	$goods_type1_id=$row['type1'];
	$goods_type2_id=$row['type2'];
	$goods_type3_id=$row["type3"];
	$goods_keywords=$row['goods_keywords'];
	$goods_desc=$row['goods_desc'];
	$goods_info=$row['goods_info'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>超市管理</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="author" content="liuxiao@WiiPu -- http://www.wiipu.com" />
		<link rel="stylesheet" href="../css/style2.css" type="text/css"/>
		<script type="text/javascript" src="../js/jquery-1.6.2.min.js"></script>
    	<script type="text/javascript" src="../js/upload.js"></script>
    	<script type="text/javascript" src="../js/jquery-ui.min.js"></script>
		<script type="text/javascript" charset="utf-8" src="../js/ueditor.config.js"></script>
        <script type="text/javascript" charset="utf-8" src="../js/ueditor.all.min.js"> </script>
        <script type="text/javascript" charset="utf-8" src="../js/lang/zh-cn/zh-cn.js"></script>
	</head>
	<body>
	<div class="bgintor">
		<div class="tit1">
			<ul>				
				<li><a href="#">超市管理</a> </li>
			</ul>		
		</div>
	<div class="listintor">
		<div class="header1"><img src="../images/square.gif" width="6" height="6" alt="" />
			<span>位置：超市管理 －&gt; <strong>修改商品</strong></span>
		</div>		
		<div class="fromcontent">
			<form action="edit_goods_do.php" method="post" id="doForm">
				<input type="hidden" value="<?=$goods_id?>" name="goods_id"/>
				<input type="hidden" value="<?=$from?>" name="from"/>
				<?php 
					if($from=="shop"){
				?>
					<input type="hidden" value="<?=$_GET["shop_id"]?>" name="shop_id"/>
					<input type="hidden" value="<?=$_GET["shop_name"]?>" name="shop_name"/>
				<?php
					}
				?>
				<p><font style="font-size:15px;color:red">商品基本信息:</font></p>
				<p>商品名称：<input class="in1" type="text" name="goodsName" id="goodsName" value="<?=$goods_name?>"/></p>
				
				<p>所属商家：
					<select class="in1" name="shop" id="shop">
					<?php
						$sql1="select id,name from shop".$area;
						$result1=mysql_query($sql1);
						while($row1=mysql_fetch_array($result1))
						{	
							$shop_id=$row1['id'];
							$shop_name=$row1['name'];
					?>
							<option value="<?php echo $shop_id?>" <?php echo ($shop_id==$goods_shop_id?"selected":"")?>><?php echo $shop_name?></option>
					<?php
						}	
					?>
					</select>
				</p>
				<p>商品类别：
					分类1：
					<select class="in1" name="goodsType" id="goodsType" onchange=choose_type(this.value)>
					<?php
						$sql1="select * from goods_type1";
						$result1=mysql_query($sql1);
						while($row1=mysql_fetch_array($result1))
						{	
							$type1_id=$row1['id'];
							$name=$row1['name'];
					?>
							<option value="<?php echo $type1_id." ".$name?>" <?php echo ($type1_id==$goods_type1_id?"selected":"")?>><?php echo $name?></option>
					<?php
						}	
					?>
					</select>&nbsp;&nbsp;&nbsp;&nbsp;
					分类2：
					<select name="type2" id="type2" onchange=choose_type2(this.value)>
					<?php 
						$sql2="select * from super_goods_type2 where type1_id=$goods_type1_id";					
						$result2=mysql_query($sql2);
						while($row2=mysql_fetch_array($result2)){
							$type2_id=$row2['id'];
							$type2_name=$row2['name'];
					?>
							<option value="<?php echo $type2_id." ".$type2_name?>" <?php echo ($type2_id==$goods_type2_id?"selected":"")?>><?php echo $type2_name?></option>
					<?php 
						}
					?>
					</select>
					分类3：
					<select name="type3" id="type3">
					<?php 
						$sql3="select * from super_goods_type3 where type2_id=$goods_type2_id";					
						$result3=mysql_query($sql3);
						while($row3=mysql_fetch_array($result3)){
							$type3_id=$row3['id'];
							$type3_name=$row3['name'];
					?>
							<option value="<?php echo $type3_id." ".$type3_name?>" <?php echo ($type3_id==$goods_type3_id?"selected":"")?>><?php echo $type3_name?></option>
					<?php 
						}
					?>
					</select>					
				<p>商品价格：<input class="in1" type="text" name="price" id="price" value=<?=$goods_price?> />(*请输入一个数字)</p>	
				<p>商品原价：<input class="in1" type="text" name="original_price" id="original_price" value=<?=$original_price?> />(可不填)</p>	
				<p>商品数量：<input class="in1" type="text" name="goodsnum" id="goodsnum"/>(*请输入一个数字)</p>	
				</p><br>
				
				<p><font style="font-size:15px;color:red">商品SU信息:</font></p>	
				<p>商品关键字：<input class="in1" type="text" name="keywords" id="keywords" value="<?=$goods_keywords?>"/>(各个关键字以空格分开)</p>
				<p>商品简介：
					<textarea cols="20" rows="3" id='goodsDesc' name='goodsDesc'><?=$goods_desc?></textarea>
				</p><br>
				
				<p><font style="font-size:15px;color:red">商品图片简介:</font></p><br>
				<?php 
					$sql3="select * from super_goods_pictures where goods_id='$goods_id'";
					//echo $sql3;
					$result3=mysql_query($sql3);
					while($row3=mysql_fetch_array($result3)){
						$gp_id=$row3["gp_id"];
						$pic_url=$row3["pic_url"];
				?>
				<img src="<?php echo $pic_url?>" width="100" ><input type='checkbox' checked name='pics[]' value="<?=$gp_id?>"/> 
				<?php
					}
				?>
				<p>添加图片: 
					 <span id="upd_pics"></span>
					 <input type="file" name="file" id="file" onchange="check_file()"/>
					 	<span id="loading" style="display:none;">
					 	<img src="../images/loading.gif" alt="loading...">
					 	</span>
					 	<span id="logo"></span>
                        <input type="hidden" name="filename" id="filename" value="" />
						<input type="hidden" name="goods_desc" id="goods_desc" value="" />
                        <input type="button" value="上传" onclick="return ajaxFileUpload();" 
                        class="btn btn-large btn-primary" />
					</p>
				<p>
				<p>商品描述:</p>
					<script id="editor" type="text/plain" name="goods_info" style="width:1024px;height:300px;">
						<?=$goods_info?>
					</script>
				<input type="button" value="提交" onclick="return check()"></p>
			</form>
		</div>
	</div>
  </div>
 </body>
</html>
<script>
var editor = new UE.ui.Editor();
editor.render('editor');
form=document.getElementById("doForm");
//检查输入是否为空,以及输入格式是否正确

function choose_type(value){
	var type2=$('#type2');
	type2.html("");
	$.post("choose_type.php",
		{
			type:1,
			value:value
		},
		function(data,status){
			 data=eval('('+data+')');
			for (var i=0;i<data.length ;i++ )
			{
				var div="<option value='"+data[i].id+"'>"+data[i].name+"</option>";
				type2.append(div);
			}	
		}	
	)
}
function choose_type2(value){
	var type3=$('#type3');
	type3.html("");
	$.post("choose_type2.php",
		{
			type:1,
			value:value
		},
		function(data,status){
			 data=eval('('+data+')');
			for (var i=0;i<data.length ;i++ )
			{
				var div="<option value='"+data[i].id+"'>"+data[i].name+"</option>";
				type3.append(div);
			}	
		}	
	)
}
function check()
{
	if(form.goodsName.value=="")
	{
		alert('请填写商品名称！');
		form.goodsName.focus();
		return false;
	}
	if(form.goodsType.value=="") 
	{
		alert('请填写商品类型！');
		form.goodsType.focus();
		return false;
	}
	if(form.price.value=="") 
	{
		alert('请填写商品价格！');
		form.price.focus();
		return false;
	}
	if(form.goodsnum.value=="") 
	{
		alert('请填写商品数量！');
		form.price.focus();
		return false;
	}	
	if(form.goodsName.value!=""&&form.goodsType.value!=""&&form.price.value!=""&&form.goodsnum.value!="")
	{
		form.submit();
	}	 
}
function ajaxFileUpload()
        {
        var doing = '';
        $("#loading")
        .ajaxStart(function(){
            $(this).show();
            document.getElementById('logo').innerHTML="图片上传中……";
        })
        .ajaxComplete(function(){
                $(this).hide();
            document.getElementById('logo').innerHTML= doing;
        });
		$.ajaxFileUpload
        (
            {
                url:'upload_image.php?type=articles',
                secureuri:false,
                fileElementId:'file',
                dataType: 'json',
                data:{name:'logan', id:'id'},
                success: function (data, status)
                {
                    data=data.replace('<pre>','');
                    data=data.replace('</pre>','');
                    var info=data.split('|');
                    if(info[0]=="E")
                        alert(info[1]);
                    else{
						$.post("add_goods_pics_do.php",
							{
								goods_id:<?=$goods_id?>,
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
            }
        )
        return false;
    }
    function check_file() {
            $("#spanMsg").html('');
    }
	function exportClick() {
		$("#spanMsg").html('');
		if ($("#file").val() == '') {
			alert('请先选择要导入的文件');
			return false;
		}
	}
	$(function(){
	});
</script>
