
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="author" content="liuxiao@WiiPu -- http://www.wiipu.com" />
	</head>
	
<style>
ul
{
list-style-type: none;
line-height : 50px;
padding: 0px;
margin: 0px;
}
</style>	
<?php
    require_once('../../conn/conn.php');
	require_once('../inc_function.php');

// 配置文件       
$typeArr = array('jame','kurry','kebe','zhangweiping','dadiao');
$directionArr[0] = 'Sunflower mall homepage';
$sql1 = 'select id,name from mall';
$res = mysql_query($sql1);
    while($row = mysql_fetch_assoc($res)){
	    $directionArr[$row['id']] = $row['name'];
	} 
	


$locationArr = array('Top','First floor','Second floor','Third floor','Fourth floor');

//$directionArr = array('jame','kurry','kebe','zhangweiping','dadiao');
?>
 <form method="post" action="insertAdControll.php" enctype="multipart/form-data" name='upload'>
<ul>
<li>Directions:<input type="text" name='adName'/></li>
<li>Start Time: 
<select name='startYear' id='startYear'>

</select>Y
<select name='startMonth' id='startMonth'>
</select>M
<select name='startDay' id='startDay'>
</select>D
</li>
<li>End time: 
<select name='endYear' id='endYear'>
</select>Y
<select name='endMonth' id='endMonth'>
</select>M
<select name='endDay' id='endDay'>
</select>D
</li>
<li>Ad Type:<select name='adType'>
<?php foreach($typeArr as $k=>$value){
    ?>
	<option value ='<?php echo $k ; ?>'><?php echo $value ; ?></option>
   <?
} ?>
</select></li>
<li>Mall location:<select name='adLocation'>
<?php foreach($directionArr as $k=>$value){
    ?>
	<option value ='<?php echo $k ; ?>'><?php echo $value ; ?></option>
   <?
} ?>
</select></li>
<li>Position on the floor:<select name='adSecLocation'>
<?php foreach($locationArr as $k=>$value){
    ?>
	<option value ='<?php echo $k ; ?>'><?php echo $value ; ?></option>
   <?
} ?>
</select></li>

<li>Height: <input name="width" type="text" /> </li>
<li>Width: <input name="height" type="text" /> </li>

<li>Image: <input name="imgfile" type="file" /> </li>
<li><input type="submit" value='提交' onclick="return check()" /></li>
<ul>
</form>
</html>
<script type="text/javascript">
function $(id){
   return document.getElementById(id);
}
for(var i=1 ; i<=12 ; i++){
     var option=document.createElement("option");
     option.text=i;
	 option.value=i;
    $('startMonth').add(option);
}
for(var i=2015 ; i<=2020 ; i++){
     var option=document.createElement("option");
     option.text=i;
	 option.value=i;
    $('startYear').add(option);
}
for(var i=1 ; i<=12 ; i++){
     var option=document.createElement("option");
     option.text=i;
	 option.value=i;
    $('endMonth').add(option);
}
for(var i=2015 ; i<=2020 ; i++){
     var option=document.createElement("option");
     option.text=i;
	 option.value=i;
    $('endYear').add(option);
}
for(var i=1 ; i<=31 ; i++){
     var option=document.createElement("option");
     option.text=i;
	 option.value=i;
    $('startDay').add(option);
}
for(var i=1 ; i<=31 ; i++){
     var option=document.createElement("option");
     option.text=i;
	 option.value=i;
    $('endDay').add(option);
}
/*$('startMonth').onchange = function(){
    for(var i=1 ; i<=30 ; i++){
     var option=document.createElement("option");
     option.text=i;
	 option.value=i;
    $('startDay').add(option);	
}
}
$('startMonth').onchange = function(){
    for(var i=1 ; i<=31 ; i++){
     var option=document.createElement("option");
     option.text=i;
	 option.value=i;
    $('endDay').add(option);	
}
}
*/
/*$('endMonth').onchange = function(){
     for(var i=1 ; i<=30 ; i++){
     var option=document.createElement("option");
     option.text=i;
	 option.value=i;
    $('endDay').add(option);	
}
}*/

function check(){
  //  alert('aaa');
	return true;
}
</script>