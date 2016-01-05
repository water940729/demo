<?php
	require_once('../../conn/sqlHelper.php');	 
	$sqlhelper = new sqlHelper();
	$role=$_SESSION['role'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Add account</title>
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
					<li><a href="#">Account Management</a></li>
				</ul>		
			</div>
			<div class="listintor">
				<div class="header1"><img src="../images/square.gif" width="6" height="6" alt="" />
					<span>Location: account management －&gt; <strong>Add account</strong></span>
				</div>		
				<div class="fromcontent">
					<form action="add_manage_account_do.php" method="post" id="doForm">
						<p>Name&nbsp;e：<input class="in1" type="text" name="name" id="name" onblur="return check_name()"/><font id="notice"></font></p>
						<br>
						<div>Rol&nbsp;&nbsp;e:
							<select name="role" id="role" onchange=choose_area(this.value)>
								<option value="0">----Please Select----</option>
								<?php 
									if($role==1){
								?>
								<option value="1">Super Admin</option>
								<option value="2">Mall admin</option>
								<?php
									}else{
								?>
								<option value="3">Merchants admin</option>
								<?php 
									}
								?>
							</select>
							<span id="area" name="area">
							</span>
						</div>
						<p>Pass&nbsp;&nbsp;word：<input type="password" name="password" id="password"/></p>
						<p>Confirm password:<input type="password" name="password1" id="password1"/></p>	
						<p><input type="button" value="Confirm" onclick="return check()"></p>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>
<script>
flag=0;
form=document.getElementById("doForm");
function choose_area(value){
	var area=$("#area");
	area.html("");
	$.post("choose_area.php",
	{
		value:value
	},
	function(data,status){
		data=eval('('+data+')');
		var div;
		if(value==2){
			div="&nbsp;&nbsp;Please select a store to management:<select name='mall' id='mall'>";
		}else if(value==3){
			div="&nbsp;&nbsp;Please select a Merchant to management:<select name='shop' id='shop'>";
		}
		for (var i=0;i<data.length;i++)
		{
			div+="<option value='"+data[i].id+"'>"+data[i].name+"</option>";	
		}
		div+="</select>";
		area.append(div);
	});
}
function check()
{
	if(form.name.value=="")
	{
		alert('Please fill in the user name!');
		form.name.focus();
		return false;
	}
	if(form.role.value==0)
	{
		alert('Please select a role!');
		form.role.focus();
		return false;
	}
	if(form.password.value=="")
	{
		alert('Please fill in password!');
		form.password.focus();
		return false;
	}
	if(form.password1.value=="")
	{
		alert('Please fill in the confirm password!');
		form.password1.focus();
		return false;
	}
	if(form.password.value!=form.password1.value)
	{
		alert('Passwords do not match!');
		form.password1.focus();
		return false;
	}
	if(flag==1){		
		form.submit();
	}else{
		alert('Please fill in the user name again.');
		form.name.focus();
		return false;		
	}	
}
function check_name(){
	$.post("check_manage_name.php",
		{
			account:form.name.value,
		},
		function(data,status){			
			if(data==1){
				$("#notice").html("(User name already exists)");
				$("#notice").css("color","red");
				flag=0;
			}else{
				$("#notice").html("");
				flag=1;
			}
		}
	);
}
</script>
