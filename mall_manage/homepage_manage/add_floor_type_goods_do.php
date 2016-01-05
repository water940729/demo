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
		$sql="insert into homePageGoods(floor_type_id,goods_id,goods_name,weight,role) values($floor_type_id,$goods_id,'{$goods_name}',$weight,$role)";
		$urls="recommend.php";
	}
	$sql="insert into homePageGoods(floor_type_id,goods_id,goods_name,weight,role) values($floor_type_id,$goods_id,'{$goods_name}',$weight,$role)";
	if(mysql_query($sql)){
		$where=$floor_type_id==0?"Command":"FloorNumber".$floor_type_id;
		$content="Added".$goods_name."to".$where;
		if(add_system_log($content)==1){
			if(!empty($urls)){
				//echo "<script>alert('添加成功!');window.location.href='".$urls."';</script>";
				$url=$urls;
			}else{
				$url="floor_type_goods_manage.php?id=$floor_type_id";		
			}
			echo "<script>alert('Add success!');window.location.href='".$url."';</script>";
			//echo $url;
		//echo $content;
		}else{
			if(!empty($urls)){
				$url=$urls;
			}else{
				$url="floor_type_goods_add.php?id=$goods_id&name=$goods_name&floorid=$floor_type_id";
			}
			echo "<script>alert('Add failed,please try again!');window.location.href='".$url."';</script>";
			//echo $content;
			//echo add_system_log($content);
		}
		//	$id=$_GET["id"];
		//	$name=$_GET["name"];
		//	$floorid=$_GET["floorid"];
		//$id=$_GET["id"];//分类id
	}else{
		if(!empty($urls)){
			$url=$urls;
		}else{
			$url="floor_type_goods_add.php?id=$goods_id&name=$goods_name&floorid=$floor_type_id";
		}
		echo "<script>alert('Add failed,please try again!');window.location.href='".$url."';</script>";
	}
	//echo $sql;
?>