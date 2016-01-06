<!DOCTYPE html>
<html lang="en">
<?php   
	$PUBLIC = 'http://'.$_SERVER['HTTP_HOST'].'/Public';
?>
<head>
	<meta charset="UTF-8">
	<title>Merchants login</title>
	<script src="<?php echo $PUBLIC ;?>/Js/jquery/jquery.js"></script>
	<link href="<?php echo $PUBLIC ;?>/Css/shop_login.css" type="text/css" rel="stylesheet">
	<script src="<?php echo $PUBLIC ;?>/Js/shop_login/index.js"></script>
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
						alert("ERROR Incorrect username or password");
					}
				   }
				});
			})
			
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
		<div class="name"><img src="<?php echo $PUBLIC ;?>/image/shop_login/name.jpg" /></div>
	</div>
	<div class="container">
	<div class="inner_con">
		<div class="form_contain">
			<div>
				<label for="buss_name">Merchant Name </label>
				<input type="text" id="buss_name" />
			</div>
			<div>
				<label for="buss_psd">Password</label>
				<input type="password" id="buss_psd" />
			</div>
			<div>
				<input type="checkbox" id="auto" />
				<label for="auto" id="auto_login">Auto Login</label>
				<a onclick="javascript:alert('Please contact the store administrator')">LOST PASSWORD?</a>
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
