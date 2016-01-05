<?php
	$request_uri=$_SERVER["REQUEST_URI"];
	$request=explode("/",$request_uri);

	if($request[1]=="admin_manage"&&isset($_SESSION["role"])&&$_SESSION["role"]==1){
		
	}elseif($request[1]=="mall_manage"&&isset($_SESSION["role"])&&$_SESSION["role"]==2){
		
	}elseif($request[1]=="shop_manage"&&isset($_SESSION["role"])&&$_SESSION["role"]==3){
		
	}else{
		$url="http://".$_SERVER["HTTP_HOST"]."/".$request[1];
		echo "<script>alert('请先登录');window.location.href='".$url."'</script>";
	}
?>