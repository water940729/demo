<?php
	require_once('function.php');
	$address=addslashes($_POST['address']);
	$result=getLogLat($address);
	$result1=json_decode($result);
	if($result1->result->precise==1)
	{
		echo 1;
	}else
	{
		echo 0;
	}
?>