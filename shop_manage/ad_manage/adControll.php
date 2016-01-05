<?php

	require_once('../../conn/conn.php');
	require_once('../inc_function.php');
	
header("Content-type:text/html;charset=utf-8");

$controllArr = array('delete');

$action = isset($_GET['action'])?$_GET['action']:'';

if($action == 'delete'){
	$id = isset($_GET['id'])?$_GET['id']:0;
	if($id == 0) return;
	$sqll = "select image_url  advertisement where id=$id";
	$res = mysql_query($sqll);
	$filePath =  mysql_fetch_array($sqll);
	
	$sql = "delete from advertisement where id=$id";
	
	if(mysql_query($sql)){
		unlink ( $filePath[0] );
		?>
		<script  type="text/javascript"> 
		         alert('Deleted success'); 
		         history.back();
		</script>
		<?
	}else{
		?>
		<script  type="text/javascript"> alert('Delete failure');
		history.back();
		</script>
		<?
	}
}else if($action == 'topIn'){
 
    $id = isset($_GET['id'])?$_GET['id']:0;
    if($id == 0) return;
	$topLoc = isset($_GET['topLoc'])?	$_GET['topLoc'] : 0;
    $secLoc = isset($_GET['secLoc'])?	$_GET['secLoc'] : 0;
    $condition = ' where top_location='.$topLoc.' and second_location='.$secLoc;
	$sql = 'update advertisement set show_flag = 0 '.$condition;
	if(mysql_query($sql)){
	    $sql= 'update advertisement set show_flag = 1 where id='.$id;
		if(mysql_query($sql)){
		    ?>
		<script  type="text/javascript"> 
		         alert('Top success'); 
		         history.back();
		</script>
		<?
		}
	 }else{
	  ?>
		 <script  type="text/javascript"> 
		         alert('Top failure'); 
		         history.back();
		</script>
		<?
	}
}

?>