<?php
	require_once("../../conn/conn.php");
	require_once("../function/pageClass.php");
	class order_List_Stats{
		private $type;
		private $status;
		private $id;
		function __construct($a1,$a2,$a3){
			$this->type=$a1;
			$this->status=$a2;
			$this->id=$a3;
		}
		function getNum(){
			if(isset($this->status)){
				$sql1="select count(order_id) as total from trail_orderlist where state=$this->status and $this->type=$this->id";
			}else{
				$sql1="select count(order_id) as total from trail_orderlist where $this->type=$this->id";
			}
			$result=mysql_query($sql1) or die("数据库异常".$sql1);
			$row=mysql_fetch_array($result);
			$num=$row["total"];
			return $num;
		}
		function getResult($a,$b){			
			if(isset($this->status)){
				$sql1="select order_id,user_id,mall_id,shop_id,good_id,num,price,username,rec_name,address,phone,state,time from trail_orderlist where state=$this->status and $this->type=$this->id order by order_id desc limit ".$a.",".$b;
			}else{
				$sql1="select order_id,user_id,mall_id,shop_id,good_id,num,price,username,rec_name,address,phone,state,time from trail_orderlist where $this->type=$this->id order by order_id desc limit ".$a.",".$b;
			}
			$result=mysql_query($sql1) or die("数据库异常"+$sql1);
			//$row=mysql_fetch_array($result);
			return $result;
		}
	}
	
	if(isset($_GET["page"])){
		$page=$_GET["page"];
	}else{
		$page=1;
	}
	$temp=substr($_GET["type"],-3,3);
	if($temp=="_id"){
		$type=$_GET["type"];
	}else{
		$type=$_GET["type"]."_id";	
	}
	$status=$_GET["state"];
	$id=$_GET["id"];
	$temp=$status?"&status=$status":null;
	$url="order_list_stats.php?type=".$type.$temp."&id=$id";
	
	$order_list_stats=new order_List_Stats($type,$status,$id);
	
	$num=$order_list_stats->getNum();//返回数据的记录数
	$pageClass=new pageClass($page,$url,$num);
	$pageClass->display_top();//显示页面顶部
	$array=$pageClass->getArray();//返回数据起始和终点位置
	$result=$order_list_stats->getResult($array["start"],$array["end"]);//返回查找到的数据
	$pageClass->display_data($result);
	$pageClass->display();
?>