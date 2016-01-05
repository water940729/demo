<?php
	require_once('../../conn/conn.php');
	require("../system_manage/add_system_log.php");	
	$shop_id=$_POST['shop_id'];
	$name=addslashes($_POST['name']);
	$mall_id=$_POST['mall'];
	if($_POST['from']=='mall'){
		$mall_id=$_POST['mall_id'];
		$mall_name=$_POST['mall_name'];
		$url="../mall_manage/check_mall_shop.php?mall_id=$mall_id&mall_name=$mall_name";
	}else{
		$url="check_shop.php";
	}
	$sql="select name from shop where id=$shop_id";
	$result=mysql_query($sql);
	$rows=mysql_fetch_array($result);
	
	$select="select name from mall where id='$mall_id'";
	$result=mysql_query($select);
	$row=mysql_fetch_array($result);
	$mall_name=$row['name'];
	$pics=$_POST['pics'];
	
	$shop_detail=addslashes($_POST['detail']);
	$mtime=time();
	$update="update shop set name='$name',detail='$shop_detail',mall_id='$mall_id',mall_name='$mall_name',mtime='$mtime' where id='$shop_id'"; 
	if(mysql_query($update)){
		$select1="select sp_id from shop_pictures where shop_id=$shop_id";
		$result1=mysql_query($select1);
		while($row1=mysql_fetch_array($result1)){
			$sp_id=$row1["sp_id"];
			if(!in_array($sp_id,$pics)){
				$delete="delete from shop_pictures where sp_id='$sp_id'";
				mysql_query($delete);
			}	
		}
		$conn="Modified".$rows["name"]."shop,details：shop name:".$name.",shop introduction:".$shop_detail.",belongs to the mall:".$mall_name;
		if(add_system_log($conn)){
			echo "<script>alert('Modify success!');window.location.href='".$url."';</script>";		
		}else{
			echo "<script>alert('Modify failed,please try again!');window.location.href='".$url."';</script>";
		}
	}else{
		echo "<script>alert('Modify failed,please try again!');window.location.href='".$url."';</script>";
		echo mysql_error();
	}
?>
