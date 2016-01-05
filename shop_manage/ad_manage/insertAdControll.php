
<?php

    require_once('../../conn/conn.php');
	require_once('../inc_function.php');
	
header("Content-type:text/html;charset=utf-8");



// 配置文件       
$adImagPath =  $_SERVER['DOCUMENT_ROOT'].'/images/adImage';
$adImagFilePath  = '/Img'.date('Y-m-d',time());
 if(!file_exists ($adImagPath.$adImagFilePath)){
	  if(mkdir($adImagPath.$adImagFilePath)){
		  chmod ( $adImagPath.$adImagFilePath , 0777 );
	  }
 }


//echo $adImagPath;

$adName = !isset($_POST['adName'])? "" :$_POST['adName']; 
$adType = !isset($_POST['adType'])? 0 :$_POST['adType']; 
$adLocation = !isset($_POST['adLocation'])? 0 :$_POST['adLocation']; 
$startTime=!isset($_POST['startTime'])? 0 :$_POST['startTime']; 
$endTime=!isset($_POST['endTime'])? 0 :$_POST['endTime']; 

if (isset($_FILES['imgfile']) 
&& is_uploaded_file($_FILES['imgfile']['tmp_name']))
{
$targetFile = $adImagPath.$adImagFilePath.'/';
$imgFile = $_FILES['imgfile'];
$imgFileName = time().$imgFile['name'];
$imgType = $imgFile['type'];
$imgSize = $imgFile['size'];
$imgTmpFile = $imgFile['tmp_name'];
move_uploaded_file($imgTmpFile, $targetFile.$imgFileName);
$imageUrl =  'http://'.$_SERVER['HTTP_HOST'].'/images/adImage'.$adImagFilePath.'/'.$imgFileName;
$validType = false;
$upRes = $imgFile['error'];
if ($upRes == 0)
{
if ($imgType == 'image/jpeg'
|| $imgType == 'image/png'
|| $imgType == 'image/gif')
{
$validType = true;
}
}
}
//``````$imageUrl = basename(basename($imageUrl));
$sql = "insert into advertisement
(start_time,end_time,img_path,ad_type,show_flag,adLocation , link_url) values(
'$startTime','$endTime','$imageUrl',$adType,0,$adLocation,'$adName')";

//if(!mysql_query($sql)){ echo mysql_error() ; }

if(mysql_query($sql)){
   ?>
		<script  type="text/javascript"> alert('Add successful');		history.back(); </script>
	<?
}else{
	echo mysql_error();
	?>
		<script  type="text/javascript"> alert('Add failure');		history.back(); </script>
		<?
}

?>