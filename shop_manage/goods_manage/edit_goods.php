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
	$select="select * from goods where id=$goods_id";
	$result=mysql_query($select);
	$row=mysql_fetch_array($result);
	$goods_name=$row['name'];
	$goods_shop_id=$row['shop_id'];
	$goods_shop_name=$row['shop_name'];
	$goods_mall_id=$row['mall_id'];
	$goods_mall_name=$row['mall_name'];
	$goods_price=$row['price'];
	$goodsnum=$row["goodsnum"];
	$original_price=$row["original_price"];
	$extattribute1=$row["extattribute1"];
	$extattribute2=$row["extattribute2"];
	$extattribute3=$row["extattribute3"];	
	$goods_type1_id=$row['type1'];
	$goods_type2_id=$row['type2'];
	$goods_type3_id=$row["type3"];
	$goods_keywords=$row['goods_keywords'];
	$goods_desc=$row['goods_desc'];
	$goods_info=$row['goods_info'];
	$package_info=$row["package_info"];
	$sales_support=$row["sales_support"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>商品管理</title>
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
			$(function(){
				//计算收益
				$("#price").blur(function(){
					if($(this).val()==0){
						alert("Please enter the commodity prices");
					}else{
						var id=$("#shop").val();
						var price=$(this).val();
						$.ajax({
							url:"cal_benefit.php",
							type:"POST",
							data:"shop_id="+id+"&price="+price,
							success:function(msg){
								$(".ratio").text();
								$(".ratio").text(msg);
							}
						})
					}
				})				
			})
		</script>
	</head>
	<body>
	<div class="bgintor">
		<div class="tit1">
			<ul>				
				<li><a href="#">Commodity management</a> </li>
			</ul>		
		</div>
	<div class="listintor">
		<div class="header1"><img src="../images/square.gif" width="6" height="6" alt="" />
			<span>Location: Commodity management －&gt; <strong>Modify Commodity</strong></span>
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
				<p><font style="font-size:15px;color:red">Commodity basic information:</font></p>
				<p>Commodity name:<input class="in1" type="text" name="goodsName" id="goodsName" value="<?=$goods_name?>"/></p>
				
				<p>Affiliated merchant:
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
				<p>Commodity categories:
					Category 1:
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
					Category 2:
					<select name="type2" id="type2" onchange=choose_type2(this.value)>
					<?php 
						$sql2="select * from goods_type2 where type1_id=$goods_type1_id";					
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
					Category 3:
					<select name="type3" id="type3" onchange=choose_type3(this.value)>
					<?php 
						$sql3="select * from goods_type3 where type2_id=$goods_type2_id";					
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
				<div id="attribute">
				</div>					
				<p>Commodity prices:<input class="in1" type="text" name="price" id="price" value=<?=$goods_price?> /><span class="ratio" style="color:red;"></span>(*Please enter a number)</p>	
				<p>Commodity old price:<input class="in1" type="text" name="original_price" id="original_price" value=<?=$original_price?> />(Mobile)</p>	
				<p>Quantity:<input class="in1" type="text" name="goodsnum" id="goodsnum" value=<?=$goodsnum?> />(*Please enter a number)</p>	
				</p><br>
				
				
				<p>Commodity optional attribute 1:<input class="in1" type="text" name="extattribute1" value="<?=$extattribute1?>">(Not have to fill in ，format   Attribute Name:Attribute1,Attribute2,Attribute3  Use commas between multiple attributes, attribute names with a semicolon)</p><br/>
				<p>Commodity optional attribute 2:<input class="in1" type="text" name="extattribute2" value="<?=$extattribute2?>">(Not have to fill in ，format   Attribute Name:Attribute1,Attribute2,Attribute3  Use commas between multiple attributes, attribute names with a semicolon)</p><br/>
				<p>Commodity optional attribute 3:<input class="in1" type="text" name="extattribute3" value="<?=$extattribute3?>">(Not have to fill in ，format   Attribute Name:Attribute1,Attribute2,Attribute3  Use commas between multiple attributes, attribute names with a semicolon)</p><br/>
								
				<p><font style="font-size:15px;color:red">Commodity SU information:</font></p>	
				<p>Commodity keywords:<input class="in1" type="text" name="keywords" id="keywords" value="<?=$goods_keywords?>"/>(The keywords separated by Spaces)</p>
				<p>Commodity description:
					<textarea cols="20" rows="3" id='goodsDesc' name='goodsDesc'><?=$goods_desc?></textarea>
				</p><br>
				
				<p><font style="font-size:15px;color:red">Commodity image profile:</font></p><br>
				<?php 
					$sql3="select * from goods_pictures where goods_id='$goods_id'";
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
				<p>Add picture : 
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
				<p>Commodity description:</p>
					<script id="editor1" type="text/plain" name="goods_info" style="width:1024px;height:300px;">
						<?=$goods_info?>
					</script>
				<p>Packaging and parameters:</p>
					<script id="editor2" type="text/plain" name="package_info" style="width:1024px;height:300px;">
						<?=$package_info?>
					</script>
				<p>After-sale protection:</p>
					<script id="editor3" type="text/plain" name="sales_support" style="width:1024px;height:300px;">
						<?=$sales_support?>
					</script>
				<input type="button" value="Submit" onclick="return check()"></p>
			</form>
		</div>
	</div>
  </div>
 </body>
</html>
<script>
var editor = new UE.ui.Editor();
editor.render('editor1');
var editor2 = new UE.ui.Editor();
editor2.render('editor2');
var editor3 = new UE.ui.Editor();
editor3.render('editor3');
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
function choose_type3(value){
	var type3=$('#attribute');
	type3.html("");
	$.ajax({
		url:"choose_type3.php",
		data:"value="+value,
		type:"POST",
		dataType:"json",
		success:function(msg){
			data="";
			for(var i in msg){
				data+="<p>"+msg[i]["name"];
				data+=":<select name=attribute[]><option value=0>Please Select</option>"
				for(var j in msg[i]["value"]){
					data+="<option value="+msg[i]["value"][j]+">"+msg[i]["value"][j]+"</option>";
				}
				data+="</select>"
				data+="</p>";
			}
			type3.append(data);
		}
	});
}
function check()
{
	if(form.goodsName.value=="")
	{
		alert('Please fill in the name of commodity!');
		form.goodsName.focus();
		return false;
	}
	if(form.goodsType.value=="") 
	{
		alert('Please fill in the commodity type!');
		form.goodsType.focus();
		return false;
	}
	if(form.price.value=="") 
	{
		alert('Please fill in the commodity price!');
		form.price.focus();
		return false;
	}
	if(form.goodsnum.value=="") 
	{
		alert('Please fill in the quantity!');
		form.price.focus();
		return false;
	}	
	if(form.goodsName.value!=""&&form.goodsType.value!=""&&form.price.value!="")
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
            document.getElementById('logo').innerHTML="Picture uploading...";
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
							+"</p>");							}else{
									alert("Add images failure");
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
			alert('Please choose the file you want to import');
			return false;
		}
	}
	$(function(){
	});
</script>
