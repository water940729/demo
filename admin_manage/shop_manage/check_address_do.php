<?php
	require_once('function.php');
	$address=$_POST['address'];
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