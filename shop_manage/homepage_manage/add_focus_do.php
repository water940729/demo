<?php
//print_r($_POST);
	require("../../conn/conn.php");
	//$image_url=$_POST["pics1"][0]
	$role=$_SESSION["mall_id"];
	$sql="insert into shophomeFocus(image_url,link_url,weight,role) values('{$_POST["pics1"][0]}','{$_POST["link_url"]}',$_POST[weight],$role)";
	
	if(mysql_query($sql)){
		$id=mysql_insert_id();
		$content="Added focus figure, figure number is".$id;
		$url="manage_focus.php";
		echo "<script>alert('Add successful!');window.location.href='".$url."';</script>";
	}else{
		$url="add_focus.php";
		echo "<script>alert('Add failure!');window.location.href='".$url."';</script>";
	}
?>
