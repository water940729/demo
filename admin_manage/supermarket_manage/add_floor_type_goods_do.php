<?php
	//添加楼层和推荐的商品
	require("../../conn/conn.php");
	require("../system_manage/add_system_log.php");	
	$floor_type_id=$_POST["floor_type_id"];
	$goods_id=$_POST["goods_id"];
	$goods_name=$_POST["goods_name"];
	$weight=trim($_POST["weight"]);
	$role=$_SESSION["mall_id"];
	if(empty($weight)){
		$weight=1;
	}
	if(!empty($_GET["from"])){
		$sql="insert into superPageGoods(floor_type_id,goods_id,goods_name,weight,role) values($floor_type_id,$goods_id,'{$goods_name}',$weight,$role)";
		$urls="recommend.php";
	}
	$sql="insert into superPageGoods(floor_type_id,goods_id,goods_name,weight,role) values($floor_type_id,$goods_id,'{$goods_name}',$weight,$role)";
	if(mysql_query($sql)){
		$where=$floor_type_id==0?"推荐":"楼层编号".$floor_type_id;
		$content="添加了".$goods_name."到".$where;
		if(add_system_log($content)==1){
			if(!empty($urls)){
				//echo "<script>alert('添加成功!');window.location.href='".$urls."';</script>";
				$url=$urls;
			}else{
				$url="floor_type_goods_manage.php?id=$floor_type_id";		
			}
			echo "<script>alert('添加成功!');window.location.href='".$url."';</script>";

		}else{
			if(!empty($urls)){
				$url=$urls;
			}else{
				$url="floor_type_goods_add.php?id=$goods_id&name=$goods_name&floorid=$floor_type_id";
			}
			echo "<script>alert('添加失败，请重新添加!');window.location.href='".$url."';</script>";
		}
	}else{
		if(!empty($urls)){
			$url=$urls;
		}else{
			$url="floor_type_goods_add.php?id=$goods_id&name=$goods_name&floorid=$floor_type_id";
		}
		echo "<script>alert('添加失败，请重新添加!');window.location.href='".$url."';</script>";
	}
?>