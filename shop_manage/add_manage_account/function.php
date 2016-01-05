<?php 
	function getRole($role){
		if($role==1){
			return "Super Admin";
		}else if($role==2){
			return "Store admin";
		}else if($role==3){
			return "Merchants admin";
		}
	}
	function getRoleArea($role,$shop_id,$mall_id){
		$area="";
		if($role==2){
			$select="select name from mall where id='$mall_id'";
			$result=mysql_query($select);
			$row=mysql_fetch_array($result);
			$mall_name=$row['name'];
			$area=$mall_name;
		}else if($role==3){
			$select="select name,mall_name from shop where id='$shop_id'";
			$result=mysql_query($select);
			$row=mysql_fetch_array($result);
			$shop_name=$row['name'];
			$mall_name=$row['mall_name'];
			$area=$mall_name."->".$shop_name;
		}
		//echo $select;
		return $area;
	}
?>