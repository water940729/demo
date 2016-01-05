<?php
	require("../../conn/conn.php");
	if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])&&strtolower($_SERVER['HTTP_X_REQUESTED_WITH'])=='xmlhttprequest'){
		$id=$_POST["id"];
		$sql="select id,name from shop where mall_id=".$id;
		$result=mysql_query($sql);
		$data="";
		while($row=mysql_fetch_array($result)){
			$data="<option value='".$row["id"]."'>".$row["name"]."</option>";
		}
		echo $data;
	}else{
		$url="http://".$_SERVER["HTTP_HOST"]."/admin_manage/index.html";
		echo "<script>alert('非法访问');window.location.href='".$url."'</script>";
	}