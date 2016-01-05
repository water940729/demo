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
	
	$time=time();
	$last="select name from mall where id=$mall_id";
	$result=mysql_query($last);
	$row=mysql_fetch_array($result);
	$lastname=$row["name"];
	if(empty($_POST["addpics"])){
		$update="update mall set name='$name',province='$province',city='$city',county='$county',detail_address='$detailAddressInfo',introduceInfo='$introduceInfo' where id='$mall_id'";
	}else{
		$update="update mall set name='$name',province='$province',city='$city',county='$county',detail_address='$detailAddressInfo',image_url='{$_POST["addpics"][0]}',introduceInfo='$introduceInfo' where id='$mall_id'";	
	}
	if(mysql_query($update)){
		$content="Modified".$lastname."Mall,details:mall name:".$name.",address".$province.$city.$county."details".$detailAddressInfo.",brief introduction".$introduceInfo;
		$admin_name=$_SESSION["name"];
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
		echo "<script>alert('Modify success!');window.location.href='check_mall.php';</script>";
		//print_r($_POST);
	}else{
		echo "<script>alert('Modify failed,please try again!');window.location.href='check_mall.php';</script>";
		echo mysql_error();
	}
	
?>
