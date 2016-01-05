<?php 
	require_once('../../conn/conn.php'); 
	$type_id=$_GET["type_id"];
	$role=$_SESSION["mall_id"];
	$area="";
	$area=" where role=$role";
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
			$(function () {
				$("#select_mall").change(function(){
					var id=$(this).val();
					$.ajax({
						type:"POST",
						url:"getShop.php",
						data:"id="+id,
						success:function(msg){
							$("#select_shop").append(msg);
						}
					})
				});
			})
		</script>
	</head>
	<body>
	<div class="bgintor">
		<div class="tit1">
			<ul>				
				<li><a href="#">试用管理</a> </li>
			</ul>		
		</div>
	<div class="listintor">
		<div class="header1"><img src="../images/square.gif" width="6" height="6" alt="" />
			<span>位置：试用管理 －&gt; <strong>分类管理</strong> －&gt; <strong>添加商品</strong></span>
		</div>		
		<div class="fromcontent">
			<form action="add_trail_goods_do.php" method="post" id="doForm">
				<p><font style="font-size:15px;color:red">商品基本信息:</font></p>
				<p>商品名称：<input class="in1" type="text" name="goodsName" id="goodsName"/>(*)</p>						
				<p>所属店铺：<select id="select_mall" name="mall">
				<option value="0" select="selected">--请选择商场--</option>
				<?php
					$sql="select id,name from mall";
					$result=mysql_query($sql);
					while($row=mysql_fetch_array($result)){
				?>
				<option value="<?php echo $row["id"]?>"><?php echo $row["name"];?></option>
				<?php
					}
				?>
				</select>
				<select id="select_shop" name="shop"><option value="0" select="selected">--请选择店铺--</option></select>
				(*不选择表示商城自营)
				<p>商品价格：<input class="in1" type="text" name="price" id="price"/>(*请输入一个数字)</p><br>						
				<p>商品原价：<input class="in1" type="text" name="original_price" id="original_price"/>(可不填)</p><br>							
				<p>商品数量：<input class="in1" type="text" name="num" id="num"/>(*请输入一个数字)</p><br>
				<p>商品属性1：<input class="in1" type="text" name="extattribute1">(没有可不填，格式   属性名:属性1,属性2,属性  多个属性之间用英文逗号隔开，属性名用英文分号隔开)</p><br/>
				<p>商品属性2：<input class="in1" type="text" name="extattribute2">(没有可不填，格式   属性名:属性1,属性2,属性  多个属性之间用英文逗号隔开，属性名用英文分号隔开)</p><br/>
				<p>商品属性3：<input class="in1" type="text" name="extattribute3">(没有可不填，格式   属性名:属性1,属性2,属性  多个属性之间用英文逗号隔开，属性名用英文分号隔开)</p><br/>
				<p><font style="font-size:15px;color:red">商品SEO信息:</font></p>	
				<p>商品关键字：<input type="text" name="keyword">(多个关键字，用英文逗号隔开)</p>
				<p>商品简介：
					<textarea cols="20" rows="3" id='goodsDesc' name='goodsDesc'></textarea>
				</p><br>
				
				<p><font style="font-size:15px;color:red">商品图片简介:</font></p>	
				<p>图片上传: 
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
					</script>
				<input type="hidden" value="<?php echo $type_id;?>" name="type_id"/>
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

	function check()
	{
						var f=document.getElementById('doForm');
						if(f.title.value=="")
						{
							alert('文章标题不能为空');
							f.title.focus();
							return false;
						}
						f.submit();
	}
/*
var editor = new UE.ui.Editor();
editor.render('editor');
*/
form=document.getElementById("doForm");
function check()
{
	if(form.goodsName.value=="")
	{
		alert('请填写商品名称！');
		form.goodsName.focus();
		return false;
	}
	if(form.price.value=="") 
	{
		alert('请填写商品价格！');
		form.price.focus();
		return false;
	}
	if(form.num.value==""||isNaN(form.num.value))
	{
		alert('请填写商品数量！');
		form.num.focus();
		return false;
	}
	if(form.goodsName.value!=""&&form.price.value!="")
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
                	//alert(data);
                    data=data.replace('<pre>','');
                    data=data.replace('</pre>','');
                    var info=data.split('|');
                    if(info[0]=="E")
                        alert(info[1]);
                    else{
                    	var c = document.getElementById('upd_pics').innerHTML;
                        //document.getElementById('upd_pics').innerHTML= c + 
                        		"<p><img src='"+ info[1] +"' width='100'> ["+ info[1] +"]"+
                        		"</p>";
                        document.getElementById('upd_pics').innerHTML= c + 
                        		"<p><img src='"+ info[1] +"' width='100'> <input type='checkbox' checked name='pics[]' value="+ info[1] +" /> "+info[1]+
                        		"</p>";
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
			alert('请先选择要导入的文件');
			return false;
		}
	}
	$(function(){
	});
</script>
