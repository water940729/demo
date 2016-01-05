<?php
require_once('../../conn/config.php');
$conn=mysql_connect(WIIDBHOST,WIIDBUSER,WIIDBPASS);

$configArr = array('短信模块','邮件系统');
$configArrColor = array('#faebd7','#b0e0e6','#98fb98');
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="author" content="liuxiao@WiiPu -- http://www.wiipu.com" />
		<link rel="stylesheet" href="../css/style2.css" type="text/css" />
		<script src="../js/jquery-1.6.min.js" type="text/javascript"></script>
		<script src="../js/ljqJs/nicEdit.js" type="text/javascript"></script>
		<script type="text/javascript">
		
		var dinstance;
		var id=0;
		var msgId = 0;
		var currentTr;
		var area;
		
		window.onload = function()
		  {
			  id = 0;
			  initTable();
			  $('#editDiv').css('display','none');	  
		  }
		function updateTable(ele){
			id = $(ele).attr('name');
			initTable();
			$('#editDiv').css('display','none');
		}
		function checkEdit(){
			     var c = ndinstance.getContent();  
                 $.ajax({
				   type: "POST",
				   url: "msgManageController.php",
				   data: "action=edit&id="+msgId+'&content='+c,
				   success: function(msg){
					 var dataObj=eval("("+msg+")");//转换为json对象
					 if(dataObj['status'] == 1){
						 alert('success');	 
					 }
				   }
				}); 
		}
		function changeTitle(){
			
		}
		function editContext(ele){
			
			if($(ele).parent().attr('state') == 1){
				  endEdit(ele);
				  return;
			}
			$(ele).parent().attr('state',1);
			$(ele).html('确认');
			msgId = $(ele).parent().attr('name');	
			var contentTd = $(ele).siblings("td[name='content']");
			var content = contentTd.html();
			contentTd.empty();
			var textStr = '<textarea cols="70" rows="10" id="area1">'+content+'</textarea>';
			contentTd.html(textStr);
			if(currentTr){
				currentTr.css("background-color","white");
			}
			currentTr = $(ele).parent();
			area = new nicEditor({fullPanel : true}).panelInstance('area1',{hasPanel : true});
		};
		
		function endEdit(ele){
			
			$(ele).html('编辑');
			currentTr.attr('state',0) ;
			var textStr = area.instanceById('area1').getContent();
			$.ajax({
				   type: "POST",
				   url: "msgManageController.php",
				   data: "action=edit&id="+msgId+'&content='+textStr,
				   success: function(msg){
					 var dataObj=eval("("+msg+")");//转换为json对象
					  if(dataObj['status'] == 1){
						    alert('修改成功');
							area.removeInstance('area1');
		                    area = null;
						 	currentTr.children("td[name='content']").empty();
			                currentTr.children("td[name='content']").html(textStr);
				    }else{
						   alert('修改失败');
					}
				 }
				});         
		}
		function backStyle(ele){
			$(ele).css("background-color","white");
		}
		function editTitle(ele){
			
		}
		function changeState(ele){
			msgId = $(ele).parent().attr('name');
			$.ajax({
				   type: "POST",
				   url: "msgManageController.php",
				   data: "action=use&id="+msgId,
				   success: function(msg){
					 var dataObj=eval("("+msg+")");//转换为json对象
					  if(dataObj['status'] == 1){
						 if(dataObj['state'] == 1){
								 var showStr = '已使用';
								 var showStr1 = '取消使用';
								 var color = '#FFFFCC';
								 var tag = 1;
							 }else{
								  var color = 'white';
								  var showStr = '未使用';
								  var showStr1 = '开始使用';
								  var tag = 0;
							 }
							$(ele).parent().css("background-color",color);
							$(ele).parent().children("[name='editButton']").html(showStr1);
							$(ele).siblings("[name='tagShow']").html(showStr);
							$(ele).parent().attr('tag',tag);
				   }
				 }
				});
		}
		function initTable(){
			 $.ajax({
				   type: "POST",
				   url: "msgManageController.php",
				   data: "action=search&id="+id,
				   success: function(msg){
					 var dataObj=eval("("+msg+")");//转换为json对象
					 if(dataObj['status'] == 1){
						 $("#myTable").empty();
						 var str =  '';
						    str +=' <tr>'+
							'<td >消息标题</td>'+
							'<td >标识</td>'+	
                            '<td width="70%" >消息内容</td>'+							
							'<td >是否正在使用</td>'+
							'<td >更改使用状态</td>'+
							'<td >编辑</td>'+
						    '</tr>';
						  $("#myTable").append(str);
						  var page = 0;
						  for(var i=0;i<dataObj['data'].length;i++){
							  var showStr;
						      var color;
						      var tag;
							 if(dataObj['data'][i]['isUse'] == 1){
								 showStr = '已使用';
								 showStr1 = '取消使用';
								 color = '#FFFFCC';
								 tag = 1;
							 }else{
								  color = 'white';
								  showStr = '未使用';
								  showStr1 = '开始使用';
								  tag = 0;
							 }
							  str = "<tr page='"+page+"' state=0 tag='"+tag+"' style='background-color:"+color+"' name='"+dataObj['data'][i]['id']+"'>"+
							        "<td onclick='editTitle(this) '>"+dataObj['data'][i]['msgName']+"</td>"+
									"<td >"+dataObj['data'][i]['catName']+"</td>"+
									"<td name='content' >"+dataObj['data'][i]['msgContext']+"</td>"+
									"<td name='tagShow' >"+showStr+"</td>"+
									"<td id='editButton' name='editButton' onclick='changeState(this)' style='cursor:pointer'>"+showStr1+"</td>"+
									"<td onclick='editContext(this)' > 编辑</td>"+
									"</tr>";
						    $("#myTable").append(str);
							page = page + 1;
						 }
					 }
				   }
				});
		}
		
		</script>
	</head>
<style>
.listDiv span{
      width:120px;	
	  height:40px;
	  font-size:18px;
	  float:left;
	  text-align:center;
	  line-height: 40px;
	  cursor:pointer;
}
td{
	height:80px;
	cursor:pointer;
}
textarea{resize:none;}

.myUl{
	margin-top:40px;
	float:left;
	list-style-type : none;
	font-size:14px;
}
</style>

<body>
		<div class="bgintor" style='height:800px'>				
			<div class="listintor">
				<div class="tit1">
					<ul>				
						<li style='text-align:center'>消息管理</li>
					</ul>		
				</div>
				<div class="header1"><img src="../images/square.gif" width="6" height="6" alt="" />
					<span>位置：消息管理 －&gt; <strong><?php echo $shopLocation[$shopPage]; ?></strong></span>	
				</div>
				<div class="content" style='height:1000px'>
	             <div class='listDiv' style='height:400px ; width:120px ; float:left;'>
				 <?php
				    foreach($configArr as $key=>$val){
						echo '<span onclick="updateTable(this)" name='.$key.' style="background-color:'.$configArrColor[$key].'" >'.$val.'</span>';
					}					
				 ?>
				<ul class='myUl'>请按照标准修改模板
				<li>验证码:</br>(|validNum|) </li>
				<li>名称:</br>(|userName|) </li>
				<li>商品名称:</br>(|goodsName|)</li>
				<li>订单号:</br>(|orderNum|) </li>
				<li>验证码:</br>(|validNum|) </li>
				</ul>
				</div>
				  
				 <table id='myTable' style='float:left; display:block; width:1000px; margin-left:50px;' ></table>
				 
				 <div id='editDiv' style='height:300px; width:300px; float:left; display:block; margin-left:50px; '>
				
				 <textarea cols="50" rows='10' id="area1">
				 
				 </textarea>
				 <div><span onclick='checkEdit()' style='background-color:#faebd7'>确认修改</span><span style='background-color:#faebd7'>取消修改</span></div>
				 </div>
				 
			</div>	
		
		</div>
	</body>
	
<script type="text/javascript">

</script>

</html>