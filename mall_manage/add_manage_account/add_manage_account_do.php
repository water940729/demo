<?php
/*
添加管理员


*/
	include_once("../../conn/conn.php");
	require("../system_manage/add_system_log.php");	
	require("../../function_class/sms.class.php");
	require("../../function_class/mail.class.php");		
	$name=$_POST['name'];
	$role=$_POST['role'];
	$passwd=$_POST['password'];
	
	$username=$_POST["username"];
	$phone=trim($_POST["phone"]);
	$email=trim($_POST["email"]);
	
	$passwd=md5($passwd);
	$time=time();
	if($role==1){
		$insert ="insert into admin_manage(name,passwd,role,time) values('$name','$passwd','$role','$time')";
		$roles="SuperAdmin";
	}elseif($role==2){
		$mall=$_POST['mall'];
		$insert ="insert into admin_manage(name,passwd,role,mall_id,time) values('$name','$passwd','$role','$mall','$time')";
		$roles="MallManager,mall number is:".$mall;
	}else{
		$shop=$_POST['shop'];
		$select="select mall_id from shop where id='$shop'";
		$result=mysql_query($select);
		$row=mysql_fetch_array($result);
		$mall_id=$row['mall_id'];
		$insert ="insert into admin_manage(name,passwd,role,mall_id,shop_id,time) values('$name','$passwd','$role','$mall_id','$shop','$time')";
		$roles="StoreManager,store number is:".$shop;
	}
	
	//发送短信通知
	if($role==1){
		$sql="select msgContext from msgModule where catID=0 and catName='addadmin'";
	}else if($role==2){
		$sql="select msgContext from msgModule where catID=0 and catName='addmall'";
	}else{
		$sql="select msgContext from msgModule where catID=0 and catName='addshop'";	
	}
	$msgresult=mysql_query($sql);
	$row=mysql_fetch_array($msgresult);
	$sms=new Sms();
	$sms->sendSMS($phone,$row["msgContext"]);
	
	
	//发送邮件通知
	if($role==1){
		$sql="select msgContext from msgModule where catID=1 and catName='addadmin'";
	}else if($role==2){
		$sql="select msgContext from msgModule where catID=1 and catName='addmall'";
	}else{
		$sql="select msgContext from msgModule where catID=1 and catName='addshop'";	
	}
	$msgresult=mysql_query($sql);
	$row=mysql_fetch_array($msgresult);
	$system_info_result=mysql_query("select * from system_info");
	$system_info=mysql_fetch_array($system_info_result);
	$smtp_info=explode("@",$system_info["email"]);
	$smtpserver = "smtp.".$smtp_info[1];
	$smtpserverport = 25;
	$smtpusermail = $system_info["email"];
	$smtpemailto = $email;
	$smtpuser = $smtpusermail;
	$smtppass = $system_info["email_pass"];
	$mailsubject = "Sunflower Mall";
	$mailbody = $row["msgContext"];
	$mailtype = "HTML";
	$smtp = new smtp($smtpserver,$smtpserverport,true,$smtpuser,$smtppass,$smtpusermail);
	$smtp->sendmail($smtpemailto, $smtpusermail,"water", $mailsubject, $mailbody, $mailtype); 	
	
		
	if(mysql_query($insert)){
		$content="Added an account,infos:username".$name.",access".$roles;
		if(add_system_log($content)==1){
			$url="manage_account.php";
			echo "<script>alert('Add success!');window.location.href='".$url."';</script>";
		}else{
			echo "<script>alert('Add failed,please add again!');window.location.href='add_manage_account.php';</script>";
	   }
	}else{
	   echo "<script>alert('Add failed,please add again!');window.location.href='add_manage_account.php';</script>";
	}
?>