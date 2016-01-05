<?php
	require_once('../../conn/conn.php');
	require_once('../inc_function.php');
	// 配置文件  
	



    $topLoc = isset($_GET['topLoc'])?	$_GET['topLoc'] : 0;
    $secLoc = isset($_GET['secLoc'])?	$_GET['secLoc'] : 0;
    $condition = ' where '.'top_location='.$topLoc.' and second_location='.$secLoc;

$typeArr = array('jame','kurry','kebe','zhangweiping','dadiao');

$directionArr[0] = 'Sunflower mall homepage';
$sql1 = 'select id,name from mall';
$res = mysql_query($sql1);
    while($row = mysql_fetch_assoc($res)){
	    $directionArr[$row['id']] = $row['name'];
	} 
	
$locationArr = array('Top','First floor','Second floor','Third floor','Fourth floor');
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="author" content="liuxiao@WiiPu -- http://www.wiipu.com" />
		<link rel="stylesheet" href="../css/style2.css" type="text/css" />
		<script src="../js/jquery-1.6.min.js" type="text/javascript">
		</script>
	</head>

	<body>
		<div class="bgintor">				
			<div class="listintor">
				<div class="tit1">
					<ul>				
						<li><a href="#">Advertising Management </a></li>
					</ul>		
				</div>
				<div class="header1"><img src="../images/square.gif" width="6" height="6" alt="" />
					<span>Location: Advertising Management  －&gt; <strong>View Advertisements </strong></span>
					<span style="margin-left:30px;">Advertising mall location 
					<select id='direction'>
					<?php
					foreach($directionArr as $k=>$val){
					     echo "<option value=$k>$val</option>";
					}
					?> 
					</select >
					<span>Advertising floor location 
					<select id='location'>
					<?php
					foreach($locationArr as $k=>$val){
					     echo "<option value=$k>$val</option>";
					}
					?> 
					</select>
					<button onclick="searchLoc()" type='button'>Searching</button>
					</span>
				</div>
				<div class="content">
					<table width="100%">
						<tr class="t1">
							<td width="10%">Advertising mall location</td>
							<td width="10%">Advertising floor location </td>
							<td width="10%">Advertisings images</td>
							<td width="10%">Start Time</td>
							<td width="10%">Expiration time</td>						
							<td width="10%">Advertising position</td>
							<td width="10%">Operation </td>
							<td width="10%">Operation </td>
						</tr>
						<?php
							
							$sql1="select * from advertisement ".$condition." order by id desc ";
							 
							$result1=mysql_query($sql1);
							while($row1=mysql_fetch_array($result1))
							{	
								$id=$row1['id'];
								$start=date("Y-m-d h:i:s" ,$row1["start_time"]);
								$deadline=date("Y-m-d h:i:s" ,$row1['end_time']);
								$topLocation=$row1["top_location"];
								$secLocation=$row1["second_location"];
								$url=$row1["link_url"];
								$location=$row1["show_flag"];
								$array=split(",", $location);
								//$price=$ini_array[$array[0]."_price"][$array[1]];
								$price = $row1["ad_type"];
								$photo=$row1['img_path'];
								$show=$row1['show_flag'];
						?>
						<tr>
							<td><?php echo $directionArr[$topLocation]?></td>
							<td><?php echo $locationArr[$secLocation]?></td>
							<td><img src="<?php echo $photo?>" width="50px" height="30px"></td>
							<td><?php echo $start?></td>
							<td><?php echo $deadline?></td>
							<td><?php echo $url?></td>
							<td><a href='./adControll.php?action=delete&&id=<?php echo $id; ?>'>Delete </a></td>
							<?php
							if($show == 0){
							?>
							    <td><a href='./adControll.php?action=topIn&&secLoc=<?php echo $secLoc; ?>&&topLoc=<?php echo $topLoc; ?>&&id=<?php echo $id; ?>'>置顶</a></td>
							<?
							}else{?>
							    <td>At top</td>
							<?
							}
							?>
							
						</tr>
						<?php
							}	
						?>
					</table>
				</div>
			</div>	
		</div>
	</body>
<script type="text/javascript"  language="JavaScript" >


function searchLoc(){

   var topLoc = document.getElementById('direction').value;
   var secLoc = document.getElementById('location').value;
   
   window.location.href="./ad_manage.php?topLoc="+topLoc+"&secLoc="+secLoc;
   
  // header("Location:./ad_manage.php")
  /* var topLoc = $('direction').value;
   var secLoc = $('location').value;
   $.ajax({
   type: "POST",
   url: "./adManageController.php",
   data: "action=search&topLoc="+topLoc+"&secLoc="+secLoc,
   success: function(msg){
   
     alert( "Data Saved: " + msg );
	 
   }
});*/
}
</script>
</html>

