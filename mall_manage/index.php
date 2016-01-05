<?php   
	$PUBLIC = 'http://'.$_SERVER['HTTP_HOST'].'/Public';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Mall Login</title>
	<link href="<?php echo $PUBLIC ;?>/Css/mall_login.css" type="text/css" rel="stylesheet">
	<script src="<?php echo $PUBLIC ;?>/Js/jquery/jquery.js"></script>
	<script src="<?php echo $PUBLIC ;?>/Js/mall_login/index.js"></script>
	<script>

		$(function(){
			$(".login").click(function(){
				var value1=$("#buss_name").val();
				var value2=$("#buss_psd").val();
				$.ajax({
					type:"POST",
					data:"name="+value1+"&pwd="+value2,
					url:"login.php",
					success:function(msg){
					var dataObj=eval("("+msg+")");//转换为json对象
					if(dataObj['status'] == 1){
						window.location.href="./admin_center.php";
					}else{
						alert("Password Error!");
					 }
				   }
				});
			});
			
			$(".form_contain div input").keydown(function(ev){
			if(ev.keyCode==13){
				$(".login").click();
			}
		});
		})
	</script>
</head>
<body>
<div class="out_con">
	<div class="logo_name">
		<div class="logo"><img src="<?php echo $PUBLIC ;?>/image/mall_login/logo.jpg" /></div>
		<div class="name"><img src="<?php echo $PUBLIC ;?>/image/mall_login/name.jpg" /></div>
	</div>
	<div class="container">
	<div class="inner_con">
		<div class="form_contain">
			<div>
				<label for="buss_name">Mall Name</label>
				<input type="text" id="buss_name" />
			</div>
			<div>
				<label for="buss_psd">Password</label>
				<input type="password" id="buss_psd" />
			</div>
			<div>
				<input type="checkbox" id="auto" />
				<label for="auto" id="auto_login">Autologin</label>
				<a href="javascript:alert('Contact Mall Manager')" id="forget">forgot password?</a>
			</div>
			<input type="submit" class="login" value="Login">
		</div>
		</div>
	</div>
</div>
</body>
</html>
<script>

</script>