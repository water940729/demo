<?php
	include ("../../smarty.php"); //引入配置文件
    //$smarty->assign('name',$name); //用定义的变量$name的值("OK")替换掉模版中的<{$name}>
	
    $shopPage = isset($_GET['shopPage'])?$_GET['shopPage']:0;
	
	$result=mysql_query("select id,name from mall") or die("EDatabaseError");
	$shopLocation[0]='Sunflower mall homepage';
	while($array=mysql_fetch_array($result)){
		  $shopLocation[$array['id']]=$array['name'];
	}
	mysql_free_result($result);
	
	$result=mysql_query("select * from adLocation where pageLocation =$shopPage") or die("EDatabaseError");
		while($array=mysql_fetch_array($result)){
		  $adLocation[]=$array;
	}

$locationArr = array('Top','First floor','Second floor','Third floor','Fourth floor');	
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
									"<td onclick='setUse(this)' value='0'>Unused</td>"+
									"<td onclick='deleteLoc(this)'>"+'<a>Delete</a>'+"</td>"+
									"<td onclick='manageLoc(this)'>Manage</td>"+
					                "<td onclick='adAdver(this)'>Add</td>"+
									"</tr>";
						 $("#fristLineOfAdTable").after(trTag);
						 alert('Add successful');
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
							'<td width="10%">Advertisings</td>'+
							'<td width="10%">Start Time</td>'+
							'<td width="10%">Expiration Time</td>'+					
							'<td width="10%">Advertising Position</td>'+
							'<td width="10%">Delete</td>'+
							'<td width="10%">Top</td>'+
						    '</tr>';
						 $("#adTable").append(str);
						 var showStr;
						 var color;
						 var tag;
						 for(var i=0;i<dataObj['data'].length;i++){
							 
							 if(dataObj['data'][i]['show_flag'] == 1){
								 showStr = 'Cancel Top';
								 color = '#FFFFCC';
								 tag = 1;
							 }else{
								 color = 'white';
								 showStr = 'Top';
								 tag = 0;
							 }
							  str ="<tr tag='"+tag+"' style='background-color:"+color+"' name='"+dataObj['data'][i]['id']+"'>"+
							        "<td><img width=200px height=100px src='"+dataObj['data'][i]['img_path']+"'/></td>"+
									"<td>"+dataObj['data'][i]['start_time']+"</td>"+
									"<td>"+dataObj['data'][i]['end_time']+"</td>"+
									"<td>"+dataObj['data'][i]['link_url']+"</td>"+
									"<td onclick='deleteAd(this)'>Delete</td>"+
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
				var r=confirm("Confirm that the ads placed at the top the top");
			}else{
				var r=confirm("Confirm cancel set-top the AD set-top the AD");
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
							  old.children().last().html('Top');
							//$("#adTable tr[tag='1']>td[name='tagShow']").text('置顶');
							  ele.parentNode.style.backgroundColor = '#FFFFCC';
							  ele.innerHTML = 'Cancel Top';
							  ele.parentNode.setAttribute("tag",1);
						  }else{
							  ele.parentNode.style.backgroundColor = 'white';
							  ele.innerHTML = 'Top';
							  ele.parentNode.setAttribute("tag",0);
						  }
					 } else{ alert('Setup failed');}
				   }
			 });
		}
		function changePage(){
			var id = $("#direction option:selected").val();
			window.location.href="./adManage.php?shopPage="+id; 
		}
		function setUse(ele){
			 var r=confirm("Confirm the adjustment state of advertising");
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
                          alert('Setup successful');
						  val = (val == 1)?0:1;
						  ele.setAttribute('value',val);
						  var isUse = val?'Used':'Unused ';
						  ele.innerHTML = isUse;
					 } else{
						  alert('Setup failed');
					 }
				   }
			 });
		}
    }
		function deleteLoc(ele){
			 var r=confirm("Whether to remove the advertising")
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
                          alert('Setup successful');
						  ele.parentNode.remove();
					 } else{
						  alert('Setup failed');
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
						<li style='text-align:center'>Advertising Management</li>
					</ul>		
				</div>
				<div class="header1"><img src="../images/square.gif" width="6" height="6" alt="" />
					<span>Location: Advertising Management －&gt; <strong><?php echo $shopLocation[$shopPage]; ?></strong></span>
					
				   
										
					<span style="margin-left:200px;">Advertising mall location 
					<select id='direction'>
					<?php
					foreach($shopLocation as $k=>$val){
					     echo "<option value=$k>$val</option>";
					}
					?> 
					</select >
					<input type='button' value='Switch' onclick='changePage()' />
					
					
				</div>
				<div class="content" style='height:700px'>
					<table class='mytable' width="100%" style="float:left;" id='adLocationTable'>
					<tr><td  colspan=7 onclick='addLocationView()' style='background-color:#FFF0F5; font-size:12px;'>Add the advertising</td></tr>
						<tr class="t1" id='fristLineOfAdTable' >
							<td>Advertising identify </td>
							<td>Height </td>
							<td>Width </td>
							<td>Whether in use</td>
							<td>Delete</td>
							<td>Management</td>
							<td>Add</td>
						</tr>
					<?php 
	      foreach($adLocation as $val){
			  $isUse = !$val['hasShow']?'Used':'Unused';
		      echo "<tr name='$val[id]'>".
			        "<td>".$val['locationTag']."</td>".
					"<td>".$val['width']."</td>".
					"<td>".$val['height']."</td>".
					"<td onclick='setUse(this)' value='".$val['hasShow']."'>".$isUse."</td>".
					"<td onclick='deleteLoc(this)'>".'<a>Delete</a>'."</td>".
					"<td onclick='manageLoc(this)'>Management</td>".
					"<td onclick='adAdver(this)'>Add</td>".
			        "</tr>";
		        } 
		       ?>
					</table>
					
					<div id='controllDive' style='width:700px;height:500px;float:left;margin-left:50px;'>
					
					<form id='adAdLocation'  style='display:none;'  >
					<ul class='adAdLocationUl' >
					<li style='text-align:center; font-size:14px;'>Add the advertising</li>
					<li>Identify  <input type='text'  name='adTag'/></li>
					<li>Height  <input type='text'  name='width'/></li>
					<li>Width  <input type='text'  name='height'/></li>
					<li><input type='button' value='Submit' name='submit' onclick='addLocation()'/></li>
					</ul>
					</form>
					
					 
					<form id='adAdvertisement' target='hiddenFrame' method="post" action="insertAdControll.php" enctype="multipart/form-data" name='upload' style='display:none'>
					
						<ul  >
						<li>Directions:<input type="text" name='adName'/></li>
						<li>Start time:<input type="text" name='startTime' id='startTime' /></li>
						<li>End time:<input type="text" name='endTime' id='endTime' /></li>
                        <input type="hidden" name='adLocation' id='adLocationInput' />   
						<li>Image： <input name="imgfile" type="file" /> </li>
						<li><input type="submit" value='提交' onclick="return check()" /></li>
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