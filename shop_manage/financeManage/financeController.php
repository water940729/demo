<?php

include ("../../conn/conn.php");

if($_SESSION['role'] != 3){
	  exit();
}

if(isset($_SESSION['shop_id'])){
	$shopId = $_SESSION['shop_id'];
}else{
	exit();
}

$action = isset($_POST['action'])?$_POST['action']:'';
$tableName = 'shopWithdraw';
$statusArr= array('Pending','Checked','Drawings','Successful','Rejected');

if($action == 'apply'){

	if($_SESSION['shop_id']){
		$shopId = $_SESSION['shop_id'];
	}else{
		json_encode(array('status'=>0));
	}

	if( isset($_POST['sum']) && (!empty($_POST['sum'])) && is_numeric($_POST['sum']) && $_POST['sum']>0 ){
		
		$sum = $_POST['sum'];
		$sql = 'select  balanceMoney,useMoney from `shop` where id='.$shopId;

		$res = mysql_fetch_array(mysql_query($sql));

		$balance = $res[0];
		$total = $res[1];
		if($total <= $sum){echo json_encode(array('status'=>0));exit();}
		$sql = 'update `shop` set useMoney='.($total-$sum).' where id='.$shopId;
	    if(mysql_query($sql)){
		$time = time();
		$sql = 'insert into shopWithdraw (applyTime,shopId,mallId,withdrawMoney,nowMoney) values('.$time.','.$shopId.','.$_SESSION['mall_id'].','.floatval($sum).','.floatval($total-$sum).')';
		if(mysql_query($sql)){
			echo json_encode(array('status'=>1));
		}else{
			echo json_encode(array('status'=>0));
		}
		}else{
			echo mysql_error();
		}
	}else{
		
		echo json_encode(array('status'=>0));
	}	
}else if($action == 'search'){
	
	 if($_SESSION['shop_id']){
		$shopId = $_SESSION['shop_id'];
	}else{
		json_encode(array('status'=>0));
	}
	$sql = 'select * from shopWithdraw where shopId='.$shopId.' order by applyTime DESC';
	if($res = mysql_query($sql)){
		while($row = mysql_fetch_assoc($res)){
			$row['applyTime'] = date("Y-m-d H:i:s",$row['applyTime']);
			$row['disposeTime'] = empty($row['disposeTime'])?'':date("Y-m-d H:i:s",$row['disposeTime']);
			$row['successTime'] = empty($row['successTime'])?'':date("Y-m-d H:i:s",$row['successTime']);
			//echo $statusArr[0];
			$row['statusKey'] = $row['status'];
			$row['status'] = $statusArr[$row['status']];
			$data[]=$row;
		}
		echo json_encode(array('status'=>1,'data'=>$data));
	}else{
		echo json_encode(array('status'=>0));
	}
	
}else if($action == 'reApply'){
	$id = $_POST['id'];
	$sql = "select status,withdrawMoney,shopId from $tableName where id = $id ";
	$res = mysql_fetch_row(mysql_query($sql));
	if($res[0] == 0){
		$sql = "update  $tableName set status = 4 where id = $id ";
		if(mysql_query($sql)){
		 	mysql_query('update shop set useMoney = useMoney +'.$res[1].' where id='.$res[2]);
			exit(json_encode(array('status'=>1,'data'=>$data)));
		}else{
			exit(json_encode(array('status'=>0,'data'=>$data)));
		}
	}else{
		exit(json_encode(array('status'=>0,'data'=>$data)));
	}
}


?>