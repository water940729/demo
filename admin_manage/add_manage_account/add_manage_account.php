<?php
	require_once('../../conn/sqlHelper.php');
	include_once("../../conn/conn.php");	
	$sqlhelper = new sqlHelper();
	$role=$_SESSION['role'];
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title> add account</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="author" content="liuxiao@WiiPu -- http://www.wiipu.com" />
		<link rel="stylesheet" href="../css/style2.css" type="text/css"/>
		<script type="text/javascript" src="../js/jquery-1.6.min.js"></script>
    	<script type="text/javascript" src="../js/upload.js"></script>
    	<script type="text/javascript" src="../js/jquery-ui.min.js"></script>
	</head>
	<body>
		<div class="bgintor">
			<div class="tit1">
				<ul>				
					<li><a href="#">account manager</a></li>
				</ul>		
			</div>
			<div class="listintor">
				<div class="header1"><img src="../images/square.gif" width="6" height="6" alt="" />
					<span>Location：account manager －&gt; <strong>add account</strong></span>
				</div>		
				<div class="fromcontent">
					<form action="add_manage_account_do.php" method="post" id="doForm">
						<p>username：<input class="in1" type="text" name="name" id="name" onblur="return check_name()"/><font id="notice"></font></p>
						<br>
						<div>ro&nbsp;&nbsp;le：
							<select name="role" id="role" onchange=choose_area(this.value)>
								<option value="0">----Select----</option>
								<?php 
									if($role==1){
								?>
								<option value="1">super manager</option>
								<option value="2">mall manager</option>
								<?php
									}else{
										
								?>
								<option value="3">Merchants administrator</option>
								<?php 
									}
								?>
							</select>
							<span id="area" name="area">
							</span>
						</div>
						<p>name：<input class="in1" type="text" name="username" id="username"/></p>
						<p>phone：<input class="in1" type="text" name="phone" id="phone"/></p>
						<p>email：<input class="in1" type="text" name="email" id="email"/></p>
						<p>password：<input class="in1" type="password" name="password" id="password"/></p>
						<p>ensuer passwd：<input class="in1" type="password" name="password1" id="password1"/></p>	
						<p><input type="button" value="sure" onclick="return check()"></p>
					</form>
				</div>
			</div>
		</div>
	
<script>
flag=0;
form=document.getElementById("doForm");
function choose_area(value){
	var area=$("#area");
	area.text("");
	$.post("choose_area.php",
	{
		value:value
	},
	function(data,status){
		data=eval('('+data+')');
		var div;
		if(value==2){
			div="&nbsp;&nbsp;Please select a store management:<select name='mall' id='mall'>";
		}else if(value==3){
			div="&nbsp;&nbsp;Please select a management businesses:<select name='shop' id='shop'>";
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
		alert('请填写用户名！');
		form.name.focus();
		return false;
	}
	if(form.role.value==0)
	{
		alert('请选择角色！');
		form.role.focus();
		return false;
	}
	if(form.username.value==0)
	{
		alert('请填写姓名！');
		form.username.focus();
		return false;
	}	
	if(form.phone.value=="")
	{
		alert('请填写手机号！');
		form.phone.focus();
		return false;
	}
	if(form.email.value=="")
	{
		alert('请填写邮箱！');
		form.email.focus();
		return false;
	}	
	if(form.password.value=="")
	{
		alert('请填写密码！');
		form.password.focus();
		return false;
	}
	if(form.password1.value=="")
	{
		alert('请填写确认密码！');
		form.password1.focus();
		return false;
	}
	if(form.password.value!=form.password1.value)
	{
		alert('密码不一致!');
		form.password1.focus();
		return false;
	}
	if(flag==1){		
		form.submit();
	}else{
		alert('请重新填写用户名！');
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
				$("#notice").html("(用户名已存在)");
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
</body>
</html>