<?php
require_once('../../conn/config.php');
$conn=mysql_connect(WIIDBHOST,WIIDBUSER,WIIDBPASS);
	 
if (!$conn){
		die ('数据库连接失败');
	}
mysql_select_db(WIIDBNAME, $conn) or die ("没有找到数据库。");
mysql_query("set names utf8");

$result=mysql_query("select id,name from mall") or die("数据库异常");
	$shopLocation[0]='葵花商城首页';
	while($array=mysql_fetch_array($result)){
		  $shopLocation[$array['id']]=$array['name'];
	}
	mysql_free_result($result);
	

$action = isset($_POST['action'])?$_POST['action']:'index';

if($action == 'search'){

	$page = isset($_POST['page'])?$_POST['page']:0;
    $mallId = isset($_POST['mallId'])?$_POST['mallId']:-1;
	$shopId = isset($_POST['shopId'])?$_POST['shopId']:-1;
	$state = isset($_POST['state'])?$_POST['state']:-1; 
	

	
    if( ($mallId !=-1)  || ($shopId !=-1) || ($state !=-1)){
		$condition = ' where ';
	    $condition.= $mallId == -1? ' ' : ' mall_id = '.$mallId.' and';
		$condition.= $state == -1? ' ' : ' state = '.$state.' and';
		$condition.= $shopId == -1? ' ' : ' shop_id = '.$shopId.' and';
		$condition = substr($condition,0,strlen($condition)-5);
	}else{
		$condition = '';
	}	
	 $sql = 'select id,name,shop_name,mall_id,price,discount,state from goods '.$condition.' order by id DESC  limit '.$page.',10';
	 if($res = mysql_query($sql)){
		  while($row = mysql_fetch_assoc($res)){
			   $row['mall_id'] = $shopLocation[$row['mall_id']];
			   $goodsList[] = $row;
		  }
		  echo json_encode(array('status'=>1,'data'=>$goodsList));
	 }else{
		  echo json_encode(array('status'=>0));
	 }
	
	 
}else if($action == 'check'){

	$goodsId = isset($_POST['id'])?$_POST['id']:0;
	$sql = 'select state from goods where id='.$goodsId;
	$res = mysql_fetch_assoc(mysql_query($sql));
	if(!empty($res)){
		$state = $res['state'] == 1? 0 : 1 ;
	    $sql = "update goods set state = $state where id = ".$goodsId;
			if(mysql_query($sql)){
				  echo json_encode(array('status'=>1,'state'=>$state));
			}else{
				echo json_encode(array('status'=>0));
			}
	}else{
		echo json_encode(array('status'=>-1));
	}
}

?>