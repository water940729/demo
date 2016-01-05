<?php
	//修改商城
	
	require_once('../../conn/conn.php');
	$mall_id=addslashes($_POST["mall_id"]);
	$name=addslashes($_POST['name']);
	$province=addslashes($_POST['province']);
	$city=addslashes($_POST['city']);
	$county=addslashes($_POST['county']);
	$detailAddressInfo=addslashes($_POST['detailAddressInfo']);
	$pics=addslashes($_POST['pics']);
	$introduceInfo=addslashes($_POST['introduceInfo']);
	$ratio=$_POST["ratio"];
	
	$time=time();
	$last="select name from mall where id=$mall_id";
	$result=mysql_query($last);
	$row=mysql_fetch_array($result);
	$lastname=$row["name"];
	if(empty($_POST["addpics"])){
		$update="update mall set name='$name',ratio='$ratio',province='$province',city='$city',county='$county',detail_address='$detailAddressInfo',introduceInfo='$introduceInfo' where id='$mall_id'";
	}else{
		$update="update mall set name='$name',ratio='$ratio',province='$province',city='$city',county='$county',detail_address='$detailAddressInfo',image_url='{$_POST["addpics"][0]}',introduceInfo='$introduceInfo' where id='$mall_id'";	
	}
	if(mysql_query($update)){
		$content="修改了".$lastname."商场，修改内容为：商城名".$name."，地址".$province.$city.$county."，详细信息".$detailAddressInfo."，简介".$introduceInfo;
		$admin_name=$_SESSION["name"];
		$log="insert into system_log(admin_name,content,time) values('{$admin_name}','{$content}',$time)";
		mysql_query($log);
		/*$select1="select mp_id from mall_pictures where mall_id='$mall_id'";
		$result1=mysql_query($select1);
		while($row1=mysql_fetch_array($result1)){
			$mp_id=$row1["mp_id"];
			if(!in_array($mp_id,$pics)){
				$delete="delete from mall_pictures where mp_id='$mp_id'";
				mysql_query($delete);
			}	
		}
		*/
		echo "<script>alert('修改成功!');window.location.href='check_mall.php';</script>";
		//print_r($_POST);
	}else{
		echo "<script>alert('修改失败,请重新添加!');window.location.href='check_mall.php';</script>";
		echo mysql_error();
	}
	
?>
