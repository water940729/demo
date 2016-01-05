<?php 
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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Commodity management</title>
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
						var price=$(this).val();
						$.ajax({
							url:"cal_benefit.php",
							type:"POST",
							data:"&price="+price,
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
		<div class="header1">
			<span>Location: Commodity management －&gt; <strong>Add Commodity</strong></span>
		</div>		
		<div class="fromcontent">
			<form action="add_goods_do.php" method="post" id="doForm">
				<p><font style="font-size:15px;color:red">Commodity basic information:</font></p>
				<p>Name of commodity:<input class="in1" type="text" name="goodsName" id="goodsName"/></p>
				<p>Commodity categories:
					Category 1:
					<select class="in1" name="goodsType" id="goodsType" onclick=choose_type(this.value) style="width:100px;height:25px;">
					<?php
						$sql1="select * from goods_type1";
						$result1=mysql_query($sql1);
						while($row1=mysql_fetch_array($result1))
						{	
							$type1_id=$row1['id'];
							$name=$row1['name'];
					?>
							<option value="<?php echo $type1_id." ".$name?>"><?php echo $name?></option>
					<?php
						}	
					?>
					</select>&nbsp;&nbsp;&nbsp;&nbsp;
					Category 2:							
				    <select name="type2" id="type2" onclick=choose_type2(this.value) style="width:100px;height:25px;">
					</select>&nbsp;&nbsp;&nbsp;&nbsp;
					Category 3:							


				    <select name="type3" id="type3" onclick=choose_type3(this.value)>						
					</select></p>
				<div id="attribute">
				</div>
				<p>Commodity prices:<input class="in1" type="text" name="price" id="price"/><span class="ratio" style="color:red;"></span>(*Please enter a number)</p>	
				<p>Commodity price:<input class="in1" type="text" name="original_price" id="original_price"/>(*Please enter a number)</p>	
				<p>Commodity quantity:<input class="in1" type="text" name="goodsnum" id="goodsnum"/>(*Please enter a number)</p>	
				<br>
				
				<p>Commodity optional attribute 1:<input class="in1" type="text" name="extattribute1">(Not have to fill in ，format   Attribute Name:Attribute1,Attribute2,Attribute3  Use commas between multiple attributes, attribute names with a semicolon)</p><br/>
				<p>Commodity optional attribute 2:<input class="in1" type="text" name="extattribute2">(Not have to fill in ，format   Attribute Name:Attribute1,Attribute2,Attribute3  Use commas between multiple attributes, attribute names with a semicolon)</p><br/>
				<p>Commodity optional attribute 3:<input class="in1" type="text" name="extattribute3">(Not have to fill in ，format   Attribute Name:Attribute1,Attribute2,Attribute3  Use commas between multiple attributes, attribute names with a semicolon)</p><br/>

				
				<p><font style="font-size:15px;color:red">Commodity's SEO information:</font></p>	
				<p>Commodity keywords:<input class="in1" type="text" name="keywords" id="keywords"/>(The keywords separated by Spaces)</p>
				<p>Commodity description:
					<textarea cols="20" rows="3" id='goodsDesc' name='goodsDesc' style="vertical-align:top;"></textarea>
				</p><br>
				
				<p><font style="font-size:15px;color:red">Commodity image profile:</font></p>	
				<p>Image upload: 
					 <span id="upd_pics"></span>
					 <input type="file" name="file" id="file" onchange="check_file()"/>
					 	<span id="loading" style="display:none;">
					 	<img src="../images/loading.gif" alt="loading...">
					 	</span>
					 	<span id="logo"></span>
                        <input type="hidden" name="filename" id="filename" value="" />
						<input type="hidden" name="goods_desc" id="goods_desc" value="" />
                        <input type="button" value="Upload" onclick="return ajaxFileUpload();" 
                        class="btn btn-large btn-primary" />
					</p>
				<p>
				<p>Commodity description:</p>
					<script id="editor" type="text/plain" name="goods_info" style="width:1024px;height:300px;">
					</script>
					<!--
 
				<input type="button" value="提交" class="add_sub" onclick="return check()"></p>
-->
				<p>Packaging and parameters:</p>
					<script id="editor2" type="text/plain" name="package_info" style="width:1024px;height:300px;">
					</script>
				<p>After-sale protection:</p>
					<script id="editor3" type="text/plain" name="sales_support" style="width:1024px;height:300px;">
					</script>						
				<input type="button" value="Submit" onclick="return check()" class="add_sub" ></p>
<!-- 87a560e119dc5aadca51ed528b2002eb4b9f0650-->
			</form>
		</div>
	</div>
  </div>
 </body>
</html>
<script>
var editor = new UE.ui.Editor();
editor.render('editor');
var editor2 = new UE.ui.Editor();
editor2.render('editor2');
var editor3 = new UE.ui.Editor();
editor3.render('editor3');

/*
var editor = new UE.ui.Editor();
editor.render('editor');
*/
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
				var div="<option value='"+data[i].id+" "+data[i].name+"'>"+data[i].name+"</option>";
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
				var div="<option value='"+data[i].id+" "+data[i].name+"'>"+data[i].name+"</option>";
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
				data+=":<select name=attribute[]><option value=0>请选择</option>"
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
	if(form.original_price.value=="") 
	{
		alert('Please fill in the commodity old price!');
		form.original_price.focus();
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
                	//alert(data);
                    data=data.replace('<pre>','');
                    data=data.replace('</pre>','');
                    var info=data.split('|');
                    if(info[0]=="E")
                        alert(info[1]);
                    else{
						var c = $("#upd_pics").html();
							$("#upd_pics").html(c +
							"<p><img src='"+ info[1] +"' width='100px'> <input type='checkbox' checked name='pics[]' value="+ info[1] +" /> "+info[1]
							+"</p>");
						var pic_url=info[1];
						/*$.ajax({
							  url: "uploadPic_ajax.php",  
							  type: "POST",
							  data:{url:pic_url},
							  dataType: "json",
							  error: function(){},  
							  success: function(data){ }
						});*/ 
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
