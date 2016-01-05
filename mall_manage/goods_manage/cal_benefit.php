<?php
	/*
	计算收益
	*/
	require_once('../../conn/conn.php');	
	//$mall_id=$_POST["mall_id"];
	$shop_id=$_POST["shop_id"];
	$price=$_POST["price"];
	$mall_id=$_SESSION["mall_id"];
	if($mall_id>0){
		if($shop_id>0){
			if($_SESSION["role"]=3){
				//商铺在添加
			}else{
				//商场在添加
				$sql="select ratio,mall_id from shop where id=$shop_id";
				$result=mysql_query($sql);
				$row=mysql_fetch_array($result);
				$ratio2_temp=$row["ratio"];
				$sql2="select ratio from mall where id=$mall_id";
				$result=mysql_query($sql2);
				$row=mysql_fetch_array($result);
				$ratio1_temp=$row["ratio"];
				$price=$price*(1-$ratio1_temp/100)*(1-$ratio2_temp/100);				
			}
		}else{
			//各个商场自营
			$sql2="select ratio from mall where id=$mall_id";
			$result=mysql_query($sql2);
			$row=mysql_fetch_array($result);
			$ratio1_temp=$row["ratio"];
			$price=$price*(1-$ratio1_temp/100);
		}
		echo "Benefit".$price;
	}else{
		//
		if($shop_id>0){
			$sql="select ratio,mall_id from shop where id=$shop_id";
			$result=mysql_query($sql);
			$row=mysql_fetch_array($result);
			$ratio2_temp=$row["ratio"];
			$mall_id_temp=$row["mall_id"];
			$sql2="select ratio from mall where id=$mall_id_temp";
			$result=mysql_query($sql2);
			$row=mysql_fetch_array($result);
			$ratio1_temp=$row["ratio"];
			$price=$price*$ratio1_temp/100*$ratio2_temp/100;
		}else{
			//商城自营	
		}
		echo "Benefit".$price;	
	}
	