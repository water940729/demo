<?php
	require_once('../../conn/conn.php');
	require("../system_manage/add_system_log.php");	
	$shop_id=$_POST['shop_id'];
	$name=addslashes($_POST['name']);
	$ratio=$_POST["ratio"];
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
	$pics=count($_POST['pics'])-1;
	$shop_detail=addslashes($_POST['detail']);
	$mtime=time();
	$update="update shop set name='$name',ratio='$ratio',detail='$shop_detail',logo='{$_POST[pics][$pics]}',mall_id='$mall_id',mall_name='$mall_name',mtime='$mtime' where id='$shop_id'"; 
	if(mysql_query($update)){
		/*$select1="select sp_id from shop_pictures where shop_id=$shop_id";
		$result1=mysql_query($select1);
		while($row1=mysql_fetch_array($result1)){
			$sp_id=$row1["sp_id"];
			if(!in_array($sp_id,$pics)){
				$delete="delete from shop_pictures where sp_id='$sp_id'";
				mysql_query($delete);
			}	
		}
		*/
		$conn="修改了".$rows["name"]."店铺，修改内容为：店铺名".$name.",店铺简介".$shop_detail."，所属商城".$mall_name;
		if(add_system_log($conn)){
			echo "<script>alert('修改成功!');window.location.href='".$url."';</script>";		
		}else{
			echo "<script>alert('修改失败,请重试!');window.location.href='".$url."';</script>";
		}
	}else{
		echo "<script>alert('修改失败,请重试!');window.location.href='".$url."';</script>";
		echo mysql_error();
	}
?>
