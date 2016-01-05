<?php

header("Content-type:text/html;charset=utf-8");
	require_once('../../conn/conn.php');
	require_once('../inc_function.php');
$controllArr = array('delete');

$action = isset($_POST['action'])?$_POST['action']:'';

if($action=="adLocation"){
	$pageLocation = isset($_POST['pageLocation'])?$_POST['pageLocation']:0;
	$width = isset($_POST['width'])?$_POST['width']:0;
	$height = isset($_POST['height'])?$_POST['height']:0;
	$locationTag = isset($_POST['locationTag'])?$_POST['locationTag']:'';
	
	$sql="insert into adLocation (pageLocation,locationTag,width,height) values($pageLocation,'$locationTag',$width ,$height)";
	if(mysql_query($sql)){
		$sql = 'select * from adLocation order by id DESC limit 1 ';
		$res =mysql_fetch_assoc(mysql_query($sql));
		echo json_encode(array('status'=>1,'data'=>$res));
	}else{
		echo json_encode(array('status'=>0);
	}
}
if( $action=="deleteLoc"){
	$locationId = isset($_POST['id'])?$_POST['id']:0;
	$sql = 'delete from `adLocation`  where id='.$locationId;
	if(mysql_query($sql)){
		echo json_encode(array('status'=>1));
	}else{
		echo json_encode(array('status'=>0));
	}
}

if( $action=="setUse"){
	$locationId = isset($_POST['id'])?$_POST['id']:0;
	$val = isset($_POST['value'])?$_POST['value']:0;
	$val = ($val==0)?1:0;
	$sql = 'update `adLocation` set hasShow='.$val.' where id ='.$locationId;
	if(mysql_query($sql)){
		echo json_encode(array('status'=>1));	
	}else{
		echo mysql_error();
	}
}
 if($action=='search'){
    $locationId = isset($_POST['locationId'])?$_POST['locationId']:0;
	
    $sql = 'select id,start_time,end_time,img_path,show_flag,link_url from advertisement where adLocation='.$locationId;
	if($res = mysql_query($sql)){
		while($row = mysql_fetch_assoc($res)){
			$data[] = $row;
		}
		echo json_encode(array('status'=>1,'data'=>$data));
	}else{
		echo json_encode(array('status'=>0));
		
	}
}


if($action == 'deleteAd'){
	$id = isset($_POST['id'])?$_POST['id']:0;
	if($id == 0) return;
	$sqll = "select image_url  advertisement where id=$id";
	$res = mysql_query($sqll);
	$filePath =  mysql_fetch_array($sqll);
	
	$sql = "delete from advertisement where id=$id";
	
	if(mysql_query($sql)){
		unlink ( $filePath[0] );
        echo json_encode(array('status'=>1));
	}else{
        echo 0;
	}
}

 if($action == 'topIn'){
 
    $id = isset($_POST['id'])?$_POST['id']:0;
	$sql ='select show_flag,adLocation from advertisement where id='.$id;
	$res = mysql_fetch_assoc(mysql_query($sql));
	
	if($res['show_flag'] == 0){
		
		 $sql= "select count(*) as number from advertisement where show_flag = 1 and adLocation=".$res['adLocation'] ;
		 $res1 = mysql_fetch_assoc(mysql_query($sql));
		 if($res1['number']>0){
			 $sql= "update advertisement set show_flag = 0 where adLocation=".$res['adLocation'];
			 mysql_query($sql);
		 }
		 $sql= 'update advertisement set show_flag = 1 where id='.$id;
		 mysql_query($sql);
         $sql= "update adLocation set adId = $id where id=".$res['adLocation'];
		 mysql_query($sql);
		 echo json_encode(array('status'=>1));
		 
	}else{
		 $sql= 'update advertisement set show_flag = 0 where id='.$id;
		 mysql_query($sql) ;
         $sql= "update adLocation set adId = 0 where id=".$res['adLocation'];
		 mysql_query($sql) ;
		 echo json_encode(array('status'=>1));
	}
	
}
?>