<?php

header("Content-type: text/html; charset=utf-8"); 

require_once('../../conn/config.php');
require("../system_manage/add_system_log.php");	


$conn=mysql_connect(WIIDBHOST,WIIDBUSER,WIIDBPASS);
if (!$conn){
		die ('数据库连接失败');
	}
mysql_select_db(WIIDBNAME, $conn) or die ("没有找到数据库。");
mysql_query("set names utf8");

$action = isset($_POST['action'])?$_POST['action']:'';

if($action=="search"){
	
	$id = isset($_POST['id'])?$_POST['id']:'';
	
	$sql = 'select * from msgModule where catId='.$id;
	
	if($res = mysql_query($sql)){
		while($row = mysql_fetch_assoc($res)){
			//$row = stripslashes($row['msgContext']);
			$data[] = $row;
		}
		echo json_encode(array('status'=>1,'data'=>$data));
	}else{
		echo mysql_error();
		echo json_encode(array('status'=>0));
		
	}

}else if($action == 'edit'){
	$id = isset($_POST['id'])?$_POST['id']:0;
	$content = isset($_POST['content'])?$_POST['content']:0;
	
	$sql = 'select catId from msgModule where id='.$id;
	$res = mysql_fetch_row(mysql_query($sql));
	
	if($res[0] == 0){
		$content = strip_tags($content);
	}
	$sql = 'update msgModule set msgContext = "'.addslashes($content).'"  where id='.$id;
	if(mysql_query($sql)){
		echo json_encode(array('status'=>1));
		add_system_log('修改了模板id'.$_POST['id']);
	}else{
		echo mysql_error();
		echo json_encode(array('status'=>0));
		
	}
}else if($action == 'use'){
	$id = isset($_POST['id'])?$_POST['id']:0;
	$sql = 'select isUse from msgModule where id='.$id;
	$res = mysql_fetch_array(mysql_query($sql));
	$end = intval(!$res[0]);
	$sql = 'update msgModule set isUse = '.$end.' where id='.$id;
    if(mysql_query($sql)){
		add_system_log('修改了模板id'.$_POST['id']);
		echo json_encode(array('status'=>1,'state'=>$end));
	}else{
		echo mysql_error();
		echo json_encode(array('status'=>0));
	}	
}
?>