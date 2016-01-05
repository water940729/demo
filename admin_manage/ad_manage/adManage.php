<?php
	//include ("../../smarty.php"); //引入配置文件
    //$smarty->assign('name',$name); //用定义的变量$name的值("OK")替换掉模版中的<{$name}>
	include ("../../conn/conn.php");
	

    if($_SESSION['role'] == 1){
		$shopPage = isset($_GET['shopPage'])?$_GET['shopPage']:0;
	}else if($_SESSION['role'] == 2){
		$shopPage = $_SESSION['mall_id'];	
	}
	
	$result=mysql_query("select id,name from mall") or die("数据库异常");
	    $shopLocation[0]='';
	 while($array=mysql_fetch_array($result)){
		  $shopLocation[$array['id']]=$array['name'];
	 }
	 
	mysql_free_result($result);
	$result=mysql_query("select * from adLocation where pageLocation =$shopPage") or die("数据库异常");
		while($array=mysql_fetch_array($result)){
		  $adLocation[]=$array;
	 }
    

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="author" content="liuxiao@WiiPu -- http://www.wiipu.com" />
		<link rel="stylesheet" href="../css/style2.css" type="text/css" />
		<script src="../js/jquery-1.6.min.js" type="text/javascript"></script>
		 <script type="text/javascript" src="./laydate/laydate.dev.js"></script>
		<script type="text/javascript">
		
		var shopPage = <?php echo $shopPage ;?>;
		var shopPageName = '<?php echo $shopLocation[$shopPage]; ?>';
		var currentNode=0;
		var currentLocationId = 0;
		
		function addLocation(){
			 var adTag = $("input[name='adTag']").val();
			 var width = $("input[name='width']").val();
			 var height = $("input[name='height']").val();
			 
			 $.ajax({
				   type: "POST",
				   url: "adManageController.php",
				   data: "action=adLocation&pageLocation="+shopPage+"&width="+width+"&height="+height+"&locationTag="+adTag,
				   success: function(msg){
					 var dataObj=eval("("+msg+")");//转换为json对象
					if(dataObj['status'] == 1){
						// var isUse = !dataObj['data']['hasShow']?'未使用':'已经使用';
						 var trTag = "<tr name='"+dataObj['data']['id']+"'>"+
									"<td>"+dataObj['data']['locationTag']+"</td>"+
									"<td>"+dataObj['data']['width']+"</td>"+
									"<td>"+dataObj['data']['height']+"</td>"+
									"<td onclick='setUse(this)' value='0'>never used</td>"+
									"<td onclick='deleteLoc(this)'>"+'<a>delete</a>'+"</td>"+
									"<td onclick='manageLoc(this)'>manage</td>"+
					                "<td onclick='adAdver(this)'>add</td>"+
									"</tr>";
						 $("#fristLineOfAdTable").after(trTag);
						 alert('success');
					 } 
				   }
				});
		}
		
	function manageLoc(ele){
		document.getElementById('adAdLocation').style.display = 'none';
		document.getElementById('adAdvertisement').style.display = 'none';
		document.getElementById('adTable').style.display = 'block';
		   
		if(currentNode){currentNode.style.backgroundColor ='white';}
			ele.parentNode.style.backgroundColor ='#FFF0F5';
			currentNode = ele.parentNode;
			document.getElementById('adLocationInput').value = currentNode.getAttribute("name");
			
		 currentLocationId =  currentNode.getAttribute("name");
		  $.ajax({
				   type: "POST",
				   url: "adManageController.php",
				   data: "action=search&locationId="+currentLocationId,
				   success: function(msg){
					 var dataObj=eval("("+msg+")");//转换为json对象
					 if(dataObj['status'] == 1){
						 $("#adTable").empty();
						 var str =' <tr class="t1" id="adTableLine">'+
							'<td width="10%">photo</td>'+
							'<td width="10%">begin time</td>'+
							'<td width="10%">end time</td>'+					
							'<td width="10%">refer</td>'+
							'<td width="10%">delete</td>'+
							'<td width="10%">top</td>'+
						    '</tr>';
						 $("#adTable").append(str);
						 var showStr;
						 var color;
						 var tag;
						 for(var i=0;i<dataObj['data'].length;i++){
							 
							 if(dataObj['data'][i]['show_flag'] == 1){
								 showStr = 'cancel top';
								 color = '#FFFFCC';
								 tag = 1;
							 }else{
								 color = 'white';
								 showStr = 'top';
								 tag = 0;
							 }
							  str ="<tr tag='"+tag+"' style='background-color:"+color+"' name='"+dataObj['data'][i]['id']+"'>"+
							        "<td><img width=200px height=100px src='"+dataObj['data'][i]['img_path']+"'/></td>"+
									"<td>"+dataObj['data'][i]['start_time']+"</td>"+
									"<td>"+dataObj['data'][i]['end_time']+"</td>"+
									"<td>"+dataObj['data'][i]['link_url']+"</td>"+
									"<td onclick='deleteAd(this)'>delete</td>"+
									"<td onclick='topin(this)' name='tagShow'>"+showStr+"</td>"+
									"</tr>";
						    $("#adTable").append(str);
						 }
					 }
				   }
				});  
	}
		function addLocationView(){
			document.getElementById('adTable').style.display = 'none';
			document.getElementById('adAdLocation').style.display = 'block';
			document.getElementById('adAdvertisement').style.display = 'none';
		}
		function adAdver(ele){

			document.getElementById('adTable').style.display = 'none';
			document.getElementById('adAdLocation').style.display = 'none';
			document.getElementById('adAdvertisement').style.display = 'block';
			if(currentNode){currentNode.style.backgroundColor ='white';}
			ele.parentNode.style.backgroundColor ='#FFF0F5';
			currentNode = ele.parentNode;
			document.getElementById('adLocationInput').value = currentNode.getAttribute("name");
		}
		
		function deleteAd(ele){
			var id = ele.parentNode.getAttribute("name");
			$.ajax({
				   type: "POST",
				   url: "adManageController.php",
				   data: "action=deleteAd&id="+id,
				   success: function(msg){
					 var dataObj=eval("("+msg+")");//转换为json对象
					  if(dataObj['status'] == 1){
                         ele.parentNode.parentNode.removeChild(ele.parentNode); 
					 } 
				   }
			 });
		}
		function topin(ele){


			var id = ele.parentNode.getAttribute("name");
			var tag = ele.parentNode.getAttribute("tag");
			if(tag==0){
				var r=confirm("Make sure");
			}else{
				var r=confirm("Make sure");
			}
			if(r==false){
				return ;
			}
			$.ajax({
				   type: "POST",
				   url: "adManageController.php",
				   data: "action=topIn&id="+id,
				   success: function(msg){
					 var dataObj=eval("("+msg+")");//转换为json对象t
					  if(dataObj['status'] == 1){
                          if(tag==0){
							 var old = $("#adTable tr[tag='1']");
							  old.attr("tag",0);
							  old.css({ background: "white" });
							  old.children().last().html('top');
							  ele.parentNode.style.backgroundColor = '#FFFFCC';
							  ele.innerHTML = 'cancel top';
							  ele.parentNode.setAttribute("tag",1);
						  }else{
							  ele.parentNode.style.backgroundColor = 'white';
							  ele.innerHTML = 'top';
							  ele.parentNode.setAttribute("tag",0);
						  }
					 } else{ alert('failed');}
				   }
			 });
		}
		function changePage(){
			var id = $("#direction option:selected").val();
			window.location.href="./adManage.php?shopPage="+id; 
		}
		function setUse(ele){
			 var r=confirm("Make");
			 if (r==true)
				{
				  var id = ele.parentNode.getAttribute("name");
				  var val = ele.getAttribute("value");
				   $.ajax({
				   type: "POST",
				   url: "adManageController.php",
				   data: "action=setUse&id="+id+"&value="+val,
				   success: function(msg){
					 var dataObj=eval("("+msg+")");//转换为json对象t
					  if(dataObj['status'] == 1){
                          alert('success');
						  val = (val == 1)?0:1;
						  ele.setAttribute('value',val);
						  var isUse = val?'used':'never use';
						  ele.innerHTML = isUse;
					 } else{
						  alert('failed');
					 }
				   }
			 });
		}
    }
		function deleteLoc(ele){
			 var r=confirm("Make sure")
			  if (r==true)
				{
				   var id = ele.parentNode.getAttribute("name");
				   $.ajax({
				   type: "POST",
				   url: "adManageController.php",
				   data: "action=deleteLoc&id="+id,
				   success: function(msg){
					 var dataObj=eval("("+msg+")");//转换为json对象t
					  if(dataObj['status'] == 1){
                          alert('succeed');
						  ele.parentNode.remove();
					 } else{
						  alert('failed');
					 }
				   }
			 });
				}
		}
		</script>
	</head>
<style>
.mytable
{
   width:400px;
   border:1px;  
}
table,th,td{ 
 border : 1px solid black;
}
table td{
    text-align:center;
}
td{
  padding:10px;
}

.myUl
{
list-style-type: none;
line-height : 50px;
padding: 0px;
margin: 0px;
}
ul
{
list-style-type: none;
line-height : 50px;
padding: 0px;
margin: 0px;
}
.adAdLocationUl{
	list-style-type: none;
	line-height : 50px;
	padding: 0px;
	margin: 0px;
	background-color:#F5FFFA;
}
.adAdLocationUl>li{
	text-align:center;
	width:300px;
}
</style>

<body>
		<div class="bgintor" style='height:800px'>				
			<div class="listintor">
				<div class="tit1">
					<ul>				
						<li style='text-align:center'>ad manage</li>
					</ul>		
				</div>
				<div class="header1"><img src="../images/square.gif" width="6" height="6" alt="" />
					<span>location：ad manage  <strong><?php echo $shopLocation[$shopPage]; ?></strong></span>
					
				   
					<?php 
					    if($_SESSION['role'] == 1){
                           ?>					
					     <span style="margin-left:200px;">location </span>
					     <select id='direction'>
					     <?php
					     foreach($shopLocation as $k=>$val){
					         echo "<option value=$k>$val</option>";
					       } 
					 ?> 
					</select >
					<input type='button' value='switch' onclick='changePage()' />
					<?php
					    }
					?>
					
				</div>
				<div class="content" style='height:700px'>
					<table class='mytable' width="100%" style="float:left;" id='adLocationTable'>
					<tr><td  colspan=7 onclick='addLocationView()' style='background-color:#FFF0F5; font-size:12px;cursor:pointer;'>add tag</td></tr>
						<tr class="t1" id='fristLineOfAdTable' >
							<td>tag</td>
							<td>height</td>
							<td>width</td>
							<td>used</td>
							<td>delete</td>
							<td>manage</td>
							<td>add</td>
						</tr>
					<?php 
	      foreach($adLocation as $val){
			  $isUse = !$val['hasShow']?'never use':'used';
		      echo "<tr name='$val[id]'>".
			        "<td>".$val['locationTag']."</td>".
					"<td>".$val['width']."</td>".
					"<td>".$val['height']."</td>".
					"<td onclick='setUse(this)' value='".$val['hasShow']."' style='cursor:pointer;'>".$isUse."</td>".
					"<td onclick='deleteLoc(this)' style='cursor:pointer;'>".'<a>delete</a>'."</td>".
					"<td onclick='manageLoc(this)' style='cursor:pointer;'>manage</td>".
					"<td onclick='adAdver(this)' style='cursor:pointer;'>add</td>".
			        "</tr>";
		        } 
		       ?>
					</table>
					
					<div id='controllDive' style='width:700px;height:500px;float:left;margin-left:50px;'>
					
					<form id='adAdLocation'  style='display:none;'  >
					<ul class='adAdLocationUl' >
					<li style='text-align:center; font-size:14px;cursor:pointer;'>add tag</li>
					<li>tag  <input type='text'  name='adTag'/></li>
					<li>height  <input type='text'  name='width'/></li>
					<li>width  <input type='text'  name='height'/></li>
					<li><input type='button' value='submit' name='submit' onclick='addLocation()'/></li>
					</ul>
					</form>
					
					 
					<form id='adAdvertisement' target='hiddenFrame' method="post" action="insertAdControll.php" enctype="multipart/form-data" name='upload' style='display:none'>
					
						<ul  >
						<li>refer：<input type="text" name='adName'/></li>
						<li>begin time：<input type="text" name='startTime' id='startTime' /></li>
						<li>end time：<input type="text" name='endTime' id='endTime' /></li>
                        <input type="hidden" name='adLocation' id='adLocationInput' />   
						<li>photo: <input name="imgfile" type="file" /> </li>
						<li><input type="submit" value='submit' onclick="return check()" /></li>
						</ul>
						</form>
						<table cellspacing=0 width=650px  style='float:left;display:none;margin-left:10px' id='adTable'>
					    </table>				
					</div>	
				</div>
	
			</div>	
		 <iframe name='hiddenFrame'  width="0" height="0" frameborder="0"> </iframe>
		</div>
	</body>
	
<script type="text/javascript">

 laydate({
            elem: '#startTime',
								 choose: function(datas){ //选择日期完毕的回调
						
					}
        });
 laydate({
            elem: '#endTime',
								 choose: function(datas){ //选择日期完毕的回调
						
					}
        });
		

function check(){
  //  alert('aaa');
	return true;
}
</script>

</html>