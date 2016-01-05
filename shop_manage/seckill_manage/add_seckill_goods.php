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
		<link type="text/css" href="../js/timepick/css/jquery-ui-1.8.17.custom.css" rel="stylesheet" />
		 <link type="text/css" href="../js/timepick/css/jquery-ui-timepicker-addon.css" rel="stylesheet" />

		<script type="text/javascript" src="../js/timepick/js/jquery-ui-1.8.17.custom.min.js"></script>
		<script type="text/javascript" src="../js/timepick/js/jquery-ui-timepicker-addon.js"></script>
		<script type="text/javascript" src="../js/timepick/js/jquery-ui-timepicker-zh-CN.js"></script>	
		<script>		
			$(function () {
				$("#start").datetimepicker({
					//showOn: "button",
					//buttonImage: "./css/images/icon_calendar.gif",
					//buttonImageOnly: true,
					showSecond: true,
					timeFormat: 'hh:mm:ss',
					stepHour: 1,
					stepMinute: 1,
					stepSecond: 1
				});
				$("#end").datetimepicker({
					//showOn: "button",
					//buttonImage: "./css/images/icon_calendar.gif",
					//buttonImageOnly: true,
					showSecond: true,
					timeFormat: 'hh:mm:ss',
					stepHour: 1,
					stepMinute: 1,
					stepSecond: 1
				});
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
				<li><a href="#">Seckill management</a> </li>
			</ul>		
		</div>
	<div class="listintor">
		<div class="header1"><img src="../images/square.gif" width="6" height="6" alt="" />
			<span>Location: Seckill management －&gt; <strong>Classified Management </strong> －&gt; <strong>Add Commodity</strong></span>
		</div>		
		<div class="fromcontent">
			<form action="add_seckill_goods_do.php" method="post" id="doForm">
				<p><font style="font-size:15px;color:red">Commodity basic information:</font></p>
				<p>Name of commodity:<input class="in1" type="text" name="goodsName" id="goodsName"/>(*)</p>						
				<p>The store belongs to:<select id="select_mall" name="mall">
				<option value="0" select="selected">--Please select a store--</option>
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
				<select id="select_shop" name="shop"><option value="0" select="selected">--Please select a store--</option></select>
				(*Not choose means mall proprietary)
				<p>Commodity prices:<input class="in1" type="text" name="price" id="price"/>(*Please enter a number)</p><br>			
				<p>Start time:
				<input type="text" id="start" name="start" value="" class="text" >(*)<br/></p>						
				<p>End time:<!--<input class="in1" type="text" name="end" id="goodsName"/>-->
				<input type="text" id="end" name="end" value="" class="text">(*)<br/></p>						
				<p>Quantity:<input class="in1" type="text" name="num" id="num"/>(*Please enter a number)</p><br>
				<p>Commodity attribute 1:<input class="in1" type="text" name="extattribute1">(Don't have to fill, format   Attribute Name:Attribute1,Attribute2,Attribute3  Use commas between multiple attributes, attribute names with a semicolon)</p><br/>
				<p>Commodity attribute 2:<input class="in1" type="text" name="extattribute2">(Don't have to fill, format   Attribute Name:Attribute1,Attribute2,Attribute3  Use commas between multiple attributes, attribute names with a semicolon)</p><br/>
				<p>Commodity attribute 3:<input class="in1" type="text" name="extattribute3">(Don't have to fill, format   Attribute Name:Attribute1,Attribute2,Attribute3  Use commas between multiple attributes, attribute names with a semicolon)</p><br/>
				<p><font style="font-size:15px;color:red">Commodity SEO information:</font></p>	
				<p>Commodity keywords:<input type="text" name="keyword">(Multiple keywords, use commas)</p>
				<p>Commodity description:
					<textarea cols="20" rows="3" id='goodsDesc' name='goodsDesc'></textarea>
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
							alert('A title cannot be empty');
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
		alert('Please fill in the name of commodity!');
		form.goodsName.focus();
		return false;
	}
	if(form.price.value=="") 
	{
		alert('Please fill in the commodity price!');
		form.price.focus();
		return false;
	}
	if(form.start.value=="")
	{
		alert('Please fill in the goods start time!');
		form.start.focus();
		return false;
	}
	if(form.end.value=="")
	{
		alert('Please fill out the goods end of time!');
		form.end.focus();
		return false;
	}
	if(form.num.value==""||isNaN(form.num.value))
	{
		alert('Please fill in the quantity!');
		form.num.focus();
		return false;
	}
	if(form.goodsName.value!=""&&form.price.value!=""&&form.start.value!=""&&form.end.value!="")
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
			alert('Please choose the file you want to import');
			return false;
		}
	}
	$(function(){
	});
</script>
