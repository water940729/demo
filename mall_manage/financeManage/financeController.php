<?php

include ("../../conn/conn.php");

$action = isset($_POST['action'])?$_POST['action']:'';

if($_SESSION['role'] != 2){
	  exit();
}

if(isset($_SESSION['mall_id'])){
	$mallId = $_SESSION['mall_id'];
}else{
	exit();
}

$result=mysql_query("select id,name from shop where mall_id =".$mallId) or die("Database Exception");
	    $shopList[0]='';
while($array=mysql_fetch_array($result)){
		$shopList[$array['id']]=$array['name'];
	 }
	 
	 
$statusArr= array('Waitting','Has Verified','Drawing','Succeed','Refused');
$pageNum = 5;

if($action == 'apply'){

	if($_SESSION['mall_id']){
		$mallId = $_SESSION['mall_id'];
	}else{
		json_encode(array('status'=>0));
	}

	if( isset($_POST['sum']) && (!empty($_POST['sum'])) && is_numeric($_POST['sum']) && $_POST['sum']>0 ){
		
		$sum = $_POST['sum'];
		$sql = 'select  balanceMoney,useMoney from `mall` where id='.$mallId;

		$res = mysql_fetch_array(mysql_query($sql));

		$balance = $res[0];
		$total = $res[1];
		if($total <= $sum){echo json_encode(array('status'=>0,'msg'=>'Balance is not enough'));exit();}
		$sql = 'update `mall` set useMoney='.($total-$sum).' where id='.$mallId;
	    if(mysql_query($sql)){
		$time = time();
		$sql = 'insert into withdrawManage (applyTime,mallId,withdrawMoney,nowMoney) values('.$time.','.$mallId.','.floatval($sum).','.floatval($total-$sum).')';
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
	
	 if($_SESSION['mall_id']){
		$mallId = $_SESSION['mall_id'];
	}else{
		json_encode(array('status'=>0));
	}
	$sql = 'select * from withdrawManage where mallId='.$mallId.' order by applyTime DESC';

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
}

if($action == 'searchShop'){
	

	$order = isset($_POST['order'])?$_POST['order']:'DESC';
	$orderBy = isset($_POST['orderBy'])?$_POST['orderBy']:'id';
	$page = isset($_POST['page'])?intval($_POST['page']):1;
    $type = isset($_POST['type'])||!empty($_POST['type'])?$_POST['type']:'';
	$tableName = 'shopWithdraw';
	
	$condition = ' where  1=1 and ';
	
	if($type !== ''){
		$condition .= ' status = '.$type.' and ';
	}else{$condition .= '';}
	
	$condition.=  ' mallId ='.$mallId;
	$sql ='select count(*) as number from '.$tableName.$condition;
	if($res = mysql_query($sql)){
		$row = mysql_fetch_assoc($res);
		$total = $row['number'];
	}else{
		 echo json_encode(array('status'=>0));
		 exit();
	}
	
	$pageTotal = ceil($total/$pageNum);
	$pageNumber = $pageTotal<=$page?$total%$pageNum:$pageNum;
	$pageShow = 5;
	
	$startPage = 0;
	$endPage = 0;
	
	if( floor($pageShow/2) >= $page  ){
		$startPage = 1; 
	}else{
		$startPage = $page-2;
	}
	
	if( floor($pageShow/2) > ($pageTotal-$page) ){
		$endPage = $pageTotal; 
		if(($endPage + 1 - $startPage) < $pageShow){
			$startPage = ($startPage-floor($pageShow/2))>0?($startPage-floor($pageShow/2)) : 1;
		}
	}else{
		$endPage = $page+2;
		if(($endPage + 1 - $startPage) < $pageShow){
			$endPage = $startPage + 4;
		}
	}
    

	if($page>1){
		$conStr.='<div onclick="changePage(this)"  name="'.($page-1).'">Previous</div>';
	}
	for($i=$startPage;$i<=$endPage;$i++){
		if($page==$i){$color='#87ceeb';}else{$color='#ffc0cb';}
		$conStr.='<span onclick="changePage(this)" style="background-color:'.$color.'" name="'.$i.'">'.$i.'</span>';
	}
	if($page<$pageTotal){
		$conStr.='<div onclick="changePage(this)"  name="'.($page+1).'">Next</div>';
	}

	
	
	$sql= 'select * from '.$tableName.$condition.' order by '.$orderBy.' '.$order.' limit '.(-1+$page)*$pageNum.','.$pageNumber;
	if($res = mysql_query($sql)){
		while($row = mysql_fetch_assoc($res)){
			$row['applyTime'] = $row['applyTime']==0?'':date('Y-m-d',$row['applyTime']);
			$row['disposeTime'] = $row['disposeTime']==0?'':date('Y-m-d',$row['disposeTime']);
			$row['successTime'] = $row['successTime']==0?'':date('Y-m-d',$row['successTime']);
			$row['shop'] = $shopList[$row['shopId']];
			$row['tag'] = $row['status'];
			$row['status'] = $statusArr[$row['status']];
			$data[] = $row;
		}
		echo json_encode(array('status'=>1,'data'=>$data,'constr'=>$conStr,'headStr'=>'Current Sort Total: '.$total.'Requests'));
	}else{
		echo json_encode(array('status'=>0));
		exit();
	}
	
}else if($action == 'delete'){
	
	if(isset($_POST['id'])){
		     $id=$_POST['id'];
		 }else{
			   exit(json_encode(array('status'=>0)));
	     }
	$sql = "delete from $tableName where id=".$id;
	
	if(mysql_query($sql)){
		echo json_encode(array('status'=>1));
	}else{
		echo json_encode(array('status'=>0));
	}
}else if($action == 'changeStatus'){
	if(isset($_POST['id'])){
		      $id=$_POST['id'];
		 }else{
			exit(json_encode(array('status'=>0)));
	   }
	$tableName = 'shopWithdraw';
    $sql = "select status from $tableName where id=$id";
	$res = mysql_fetch_row(mysql_query($sql));
	$status = $res[0];
	$status = $status + 1;
	
	if($status == 1){
		$relations = ' ,disposeTime='.time().' ';  
	}
	if($status == 3){
		$relations = ' ,successTime='.time().' ';  
	}
	$sql = "update $tableName set status = $status".$relations." where  id=".$id;
	
	if(mysql_query($sql)){
		if($status == 3){
			 $sql = "select withdrawMoney,shopId from $tableName where id=$id";
			 $res = mysql_fetch_row(mysql_query($sql));
			 $sql = "update shop set balanceMoney = balanceMoney-$res[0] where id = $res[1]";
			 if(mysql_query($sql)){
				 exit(json_encode(array('status'=>1)));
			 }else{
				 exit(json_encode(array('status'=>0)));
			 }
		}
		 exit(json_encode(array('status'=>1)));
	}else{
		echo json_encode(array('status'=>0));
	}
}else if($action == 'reDrow'){
	$tableName = 'shopWithdraw';
	if(isset($_POST['id'])){
		      $id=$_POST['id'];
		 }else{
			exit(json_encode(array('status'=>0)));
	   }
	$sql = "select status,withdrawMoney,shopId from $tableName where id = $id ";
	$res = mysql_fetch_row(mysql_query($sql));
	
	$sql = "update $tableName set status = 4 where  id=".$id;
	if(mysql_query($sql)){
		mysql_query('update shop set useMoney = useMoney +'.$res[1].' where id='.$res[2]);
		echo json_encode(array('status'=>1));
	}else{
		echo json_encode(array('status'=>0));
	}
	
}else if($action == 'reApply'){
	$tableName = 'withdrawManage';
	$id = $_POST['id'];
	$sql = "select status,withdrawMoney,mallId from $tableName where id = $id ";
	$res = mysql_fetch_row(mysql_query($sql));
	if($res[0] == 0){
		$sql = "update  $tableName set status = 4 where id = $id ";
		if(mysql_query($sql)){
			mysql_query('update mall set useMoney = useMoney +'.$res[1].' where id='.$res[2]);
			
			exit(json_encode(array('status'=>1,'data'=>$data)));
		}else{
			exit(json_encode(array('status'=>0,'data'=>$data)));
		}
	}else{
		exit(json_encode(array('status'=>0,'data'=>$data)));
	}
}

?>