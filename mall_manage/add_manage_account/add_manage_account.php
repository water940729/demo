<?php
	require_once('../../conn/sqlHelper.php');	 
	$sqlhelper = new sqlHelper();
	$role=$_SESSION['role'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title> AddAccounts</title>
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
					<li><a href="#">AccountManage</a></li>
				</ul>		
			</div>
			<div class="listintor">
				<div class="header1">
					<span>Position:AccountManage －&gt; <strong>AddAccounts</strong></span>
				</div>		
				<div class="fromcontent">
					<form action="add_manage_account_do.php" method="post" id="doForm">
						<p>Username:<input class="in1" type="text" name="name" id="name" onblur="return check_name()" style="height:15px;width:150px;"/><font id="notice"></font></p>
						<br>
						<div>Charactor:
							<select name="role" id="role" onchange=choose_area(this.value)>
								<option value="0">----Choose----</option>
								<?php 
									if($role==1){
								?>
								<option value="1">Super Admin</option>
								<option value="2">Mall Manager</option>
								<?php
									}else{
								?>
								<option value="3">Store Manager</option>
								<?php 
									}
								?>
							</select>
							<span id="area" name="area">
							</span>
						</div>
						<p>Name:<input class="in1" type="text" name="username" id="username"/></p>
						<p>Cellphone:<input class="in1" type="text" name="phone" id="phone"/></p>
						<p>Email:<input class="in1" type="text" name="email" id="email"/></p>						
						<p>Password<input type="password" name="password" id="password"/></p>
						<p>Confirm:<input type="password" name="password1" id="password1"/></p>	
						<p><input type="button" value="Submit" onclick="return check()" class="confirm"></p>
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
			div="&nbsp;&nbsp;Choose the mall to manage:<select name='mall' id='mall'>";
		}else if(value==3){
			div="&nbsp;&nbsp;Choose the store to manage:<select name='shop' id='shop'>";
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
		alert('Input your usename!');
		form.name.focus();
		return false;
	}
	if(form.role.value==0)
	{
		alert('Choose your charactor!');
		form.role.focus();
		return false;
	}
	if(form.username.value==0)
	{
		alert('Input your name!');
		form.username.focus();
		return false;
	}	
	if(form.phone.value=="")
	{
		alert('Input your cellphone number!');
		form.phone.focus();
		return false;
	}
	if(form.email.value=="")
	{
		alert('Input your Email address!');
		form.email.focus();
		return false;
	}	
	if(form.password.value=="")
	{
		alert('Input the password!');
		form.password.focus();
		return false;
	}
	if(form.password1.value=="")
	{
		alert('Confirm the passwrod!');
		form.password1.focus();
		return false;
	}
	if(form.password.value!=form.password1.value)
	{
		alert('Password inconformity!');
		form.password1.focus();
		return false;
	}
	if(flag==1){		
		form.submit();
	}else{
		alert('Please resume load your username');
		form.name.focus();
		return false;		
	}	
}
function check_name(){
	$.post("check_manage_name.php",
		{
			account:form.name.value
		},
		function(data,status){			
			if(data==1){
				$("#notice").html("(Username has exists)");
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
