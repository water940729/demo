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
		<script type="text/javascript" src="../../js/showdate.js"></script>
		<script type="text/javascript" src="../js/laydate.js"></script>		
		<script>
		var start = {
			elem: '#start',
			format: 'YYYY/MM/DD hh:mm:ss',
			min: laydate.now(), //设定最小日期为当前日期
			max: '2099-06-16 23:59:59', //最大日期
			istime: true,
			istoday: false,
			choose: function(datas){
				 end.min = datas; //开始日选好后，重置结束日的最小日期
				 end.start = datas //将结束日的初始值设定为开始日
			}
		};
		var end = {
			elem: '#end',
			format: 'YYYY/MM/DD hh:mm:ss',
			min: laydate.now(),
			max: '2099-06-16 23:59:59',
			istime: true,
			istoday: false,
			choose: function(datas){
				start.max = datas; //结束日选好后，重置开始日的最大日期
			}
		};
		laydate(start);
		laydate(end);
		</script>
	</head>
	<body>
	<div class="bgintor">
		<div class="tit1">
			<ul>				
				<li><a href="#">Seckillmanage</a> </li>
			</ul>		
		</div>
	<div class="listintor">
		<div class="header1"><img src="../images/square.gif" width="6" height="6" alt="" />
			<span>Position:Seckillmanage －&gt; <strong>Sortmanage</strong> －&gt; <strong>AddGoods</strong></span>
		</div>		
		<div class="fromcontent">
			<form action="add_goods_do.php" method="post" id="doForm">
				<p><font style="font-size:15px;color:red">GoodsInformation::</font></p>
				<p>GoodsName:<input class="in1" type="text" name="goodsName" id="goodsName"/>(*)</p>						
				<p>GoodsPrice:<input class="in1" type="text" name="price" id="price"/>(*Input a number)</p><br>			
				<p>StartTime:
				<input type="text" id="start" name="start" value="" class="text" onclick="laydate()">(*)<br/></p>						
				<p>EndTime:<!--<input class="in1" type="text" name="end" id="goodsName"/>-->
				<input type="text" id="end" name="end" value="" onclick="return Calendar('end')" class="text">(*)<br/></p>						
				<p>Amount:<input class="in1" type="text" name="num" id="num"/>(*Input a number)</p><br>
				<p>Property1:<input class="in1" type="text" name="extattribute1">(fill or not,format   names:property1,property2,property3  Properties divided by ',',names devided by ';')</p><br/>
				<p>Property2:<input class="in1" type="text" name="extattribute2">(fill or not,format   names:property1,property2,property3  Properties divided by ',',names devided by ';')</p><br/>
				<p>Property3:<input class="in1" type="text" name="extattribute3">(fill or not,format   names:property1,property2,property3  Properties divided by ',',names devided by ';')</p><br/>
				<p><font style="font-size:15px;color:red">Goods SU Info:</font></p>	
				<p>GoodsIntroduction:
					<textarea cols="20" rows="3" id='goodsDesc' name='goodsDesc'></textarea>
				</p><br>
				
				<p><font style="font-size:15px;color:red">GoodsImage:</font></p>	
				<p>ImageUpload: 
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
				<p>GoodsDescription:</p>
					<script id="editor" type="text/plain" name="goods_info" style="width:1024px;height:300px;">
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
editor.render('editor');

	function check()
	{
						var f=document.getElementById('doForm');
						if(f.title.value=="")
						{
							alert('Article title cannot be empty');
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
		alert('Input name of goods!');
		form.goodsName.focus();
		return false;
	}
	if(form.price.value=="") 
	{
		alert('Input price of goods!');
		form.price.focus();
		return false;
	}
	if(form.start.value=="")
	{
		alert('Input start time!');
		form.start.focus();
		return false;
	}
	if(form.end.value=="")
	{
		alert('Input end time!');
		form.end.focus();
		return false;
	}
	if(form.num.value==""||!isNaN(form.num.value))
	{
		alert('Input the amount!');
		form.num.focus();
		return false;
	}
	if(form.goodsName.value!=""&&form.goodsType.value!=""&&form.price.value!=""&&form.start.value!=""&&form.end.value!="")
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
            document.getElementById('logo').innerHTML="Image uploading...";
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
			alert('Choose the file to import');
			return false;
		}
	}
	$(function(){
	});
</script>
