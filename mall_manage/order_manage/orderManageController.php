<?php


header("Content-type:text/html;charset=utf-8");
require_once('../../conn/conn.php');
require_once('../inc_function.php');

$result=mysql_query("select id,name from mall") or die("Database error");
	    $shopLocation[0]='SunflowerMall';
while($array=mysql_fetch_array($result)){
		$shopLocation[$array['id']]=$array['name'];
	 }
	 
$statusArr= array('Ordered','Paied','Delivered','Taken','WaitingToChange','Changed','Returning','Returned','Evaluated');

$controllArr = array('delete');
$pageNum = 10;

$action = isset($_POST['action'])?$_POST['action']:'search';

$tableNameArr = array('orderlist','teambuy_orderlist','seckill_orderlist','trial_orderlist','book_orderlist');
if(isset($_POST['cat'])){
	$tableName = $tableNameArr[$_POST['cat']];
}else{
	$tableName = 'orderlist';
}

$mallId = $_SESSION['mall_id'];

if($action == 'search'){
	

	$order = isset($_POST['order'])?$_POST['order']:'DESC';
	$orderBy = isset($_POST['orderBy'])?$_POST['orderBy']:'id';
	$page = isset($_POST['page'])?intval($_POST['page']):1;
	$type = isset($_POST['type'])||!empty($_POST['type'])?$_POST['type']:-1;
    $mallId = isset($_POST['mallId'])||!empty($_POST['mallId'])?$_POST['mallId']:'';
	$shopId = isset($_POST['shopId'])||!empty($_POST['shopId'])?$_POST['shopId']:0;

	$sql = 'select id,name from shop where mall_id='.$mallId;
	$res = mysql_query($sql);
	while($row = mysql_fetch_assoc($res)){
		$shopList[$row['id']] = $row['name'];
	}	
	$shopList[0] = 'Self-support';
	
	$condition = ' where 1=1 ';
	if($mallId !== ''){
		$condition.= ' and mall_id = '.$mallId.' ';
	}
	if($shopId != -1){
		$condition.= ' and shop_id = '.$shopId.' ';
	}
	if($type != -1){
		$condition.= ' and ordstatus = '.$type.' ';
	}
	
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
		$conStr.='<div onclick="changePage(this)"  name="'.($page-1).'">Last</div>';
	}
	for($i=$startPage;$i<=$endPage;$i++){
		if($page==$i){$color='#87ceeb';}else{$color='#ffc0cb';}
		$conStr.='<span onclick="changePage(this)" style="background-color:'.$color.'" name="'.$i.'">'.$i.'</span>';
	}
	if($page<$pageTotal){
		$conStr.='<div onclick="changePage(this)"  name="'.($page+1).'">Next</div>';
	}

	
	//echo $conStr;exit();
	//echo $startPage.'----',$endPage;exit();
	
	$sql= 'select id,ordid,mall_id,shop_id,username,ordtime,productname,ordbuynum,ordprice,freight,ordfee,ordstatus,recname,recaddress,expressName,expressNum from '.$tableName.$condition.' order by '.$orderBy.' '.$order.' limit '.(-1+$page)*$pageNum.','.$pageNumber;
   // echo $sql.'aaaaa';
	if($res = mysql_query($sql)){
		while($row = mysql_fetch_assoc($res)){
			$row['ordtime'] = date('Y-m-d',$row['ordtime']);
			$row['stausStr'] = $statusArr[$row['ordstatus']];
			$row['mall'] = $shopLocation[$row['mall_id']];
			$row['shop'] = $shopList[$row['shop_id']];
			$row['right'] =($row['mall_id']==$mallId && $row['shop_id']==0 )?1:0; 
			$data[] = $row;
		}
		echo json_encode(array('status'=>1,'data'=>$data,'constr'=>$conStr,'headStr'=>'InThisSort Total: '.$total.'Orders'));
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
	$sql = "select ordstatus,mall_id,shop_id from $tableName where id=$id";
	$res = mysql_fetch_row(mysql_query($sql));
	if($res[1]!=$mallId || $res[2]!=0 ){exit(json_encode(array('status'=>0)));}
	
	$status = $res[0];
	if($res[0] == 4){
	     $expressName = $_POST['expressName'];
		 $expressNum = $_POST['expressNum'];
		 $status = $status + 1 ;
	     $sql = "update $tableName set ordstatus = $status,expressName='$expressName',expressNum='$expressNum',handletime=".time()." where id=".$id;
		 if(mysql_query($sql)){
			exit(json_encode(array('status'=>1)));
		}else{
			exit(son_encode(array('status'=>0)));
		}
	}
	if($res[0] == 1){
	     $expressName = $_POST['expressName'];
		 $expressNum = $_POST['expressNum'];
		 $status = $status + 1 ;
	     $sql = "update $tableName set ordstatus = $status,expressName='$expressName',expressNum='$expressNum' where id=".$id;
		 if(mysql_query($sql)){
			exit(json_encode(array('status'=>1)));
		}else{
			exit(son_encode(array('status'=>0)));
		}
	}
	
	if ($res[0] == 6){
		 $status = $status + 1 ;
	     $sql = "update $tableName set ordstatus = $status,,handletime=".time()." where id=".$id;
		if(mysql_query($sql)){
			echo json_encode(array('status'=>1));
		}else{
			echo json_encode(array('status'=>0));
		}
	}else{
		echo json_encode(array('status'=>0));
	}
}


?>