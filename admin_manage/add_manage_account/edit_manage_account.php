<?php
	require_once("../../conn/conn.php");
	$role=$_SESSION['role'];
	$shop_id=$_SESSION['shop_id'];
	$mall_id=$_SESSION['mall_id'];
	$id=$_SESSION['id'];
	if($role==2){
		$select="select * from mall where id='$mall_id'";
		$result=mysql_query($select);
		$row=mysql_fetch_array($result);
		$mall_name=$row['name'];
		$area="Malls Management ：".$mall_name;
	}else if($role==3){
		$select1="select name,mall_name from shop where id='$shop_id'";
		$result1=mysql_query($select1);
		//echo $select1;
		$row1=mysql_fetch_array($result1);
		$shop_name=$row1['name'];
		$mall_name=$row1['mall_name'];
		$area="Merchant Management：".$mall_name."->".$shop_name;
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title> Edit password</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="author" content="liuxiao@WiiPu -- http://www.wiipu.com" />
		<link rel="stylesheet" href="../css/style2.css" type="text/css"/>
		<script type="text/javascript" src="../js/jquery-1.6.2.min.js"></script>
    	<script type="text/javascript" src="../js/upload.js"></script>
    	<script type="text/javascript" src="../js/jquery-ui.min.js"></script>
	</head>
	<body>
	<div class="bgintor">
		<div class="tit1">
			<ul>				
				<li><a href="#">account manager</a> </li>
			</ul>		
		</div>
	<div class="listintor">
		<div class="header1"><img src="../images/square.gif" width="6" height="6" alt="" />
			<span>Location：account manager －&gt; <strong>edit password</strong></span>
		</div>		
		<div class="fromcontent">
			<form action="edit_manage_account_do.php" method="post" id="doForm">
				<p>username：<?=$_SESSION["name"]?></p>
				<input type="hidden" name="id" value=<?=$id?> />
				<p>role：
					<select name="role" id="role" disabled="disabled">
						<option value="0">----select----</option>
						<option value="1" <?php echo ($role==1?"selected":"")?> >Super Admin</option>
						<option value="2" <?php echo ($role==2?"selected":"")?> >Mall Admin</option>
						<option value="3" <?php echo ($role==3?"selected":"")?> >Merchant Admin</option>				
					</select>
				</p>
				<p><?=$area?></p>
				<p>Password：<input type="password" name="password" id="password"/> </p>
				<p>sure password：<input  onpaste="return false" type="password" name="password1" id="password1"/> </p>	
				<p><input type="button" value="sure" onclick="return check()"></p>
			</form>
		</div>
	</div>
  </div>
 </body>
</html>
<script>
$("input[name='name']").attr("value","<?=$account?>");
$("select[name='role']").find("option[value='<?=$role?>']").attr("selected",true);
form=document.getElementById("doForm");
function check()
{
	if(form.password.value=="")
	{
		alert('Please fill in the password！');
		form.password.focus();
		return false;
	}
	if(form.password1.value=="")
	{
		alert('Please fill in the sure password！');
		form.password1.focus();
		return false;
	}
	if(form.password.value!=form.password1.value)
	{
		alert('Entered passwords differ!');
		form.password1.focus();
		return false;
	}
	form.submit();
}
</script>
