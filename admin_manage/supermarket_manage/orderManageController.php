<?php


header("Content-type:text/html;charset=utf-8");
require_once('../../conn/conn.php');
require_once('../inc_function.php');


$controllArr = array('delete');
$tableName = 'super_orderlist';
$pageNum = 10;

$action = isset($_POST['action'])?$_POST['action']:'search';

if($action == 'search'){
	

	$order = isset($_POST['order'])?$_POST['order']:'DESC';
	$orderBy = isset($_POST['orderBy'])?$_POST['orderBy']:'id';
	$page = isset($_POST['page'])?intval($_POST['page']):1;
    $type = isset($_POST['type'])||!empty($_POST['type'])?$_POST['type']:'';
	
	if($type !== ''){
		$condition = ' where ordstatus = '.$type.' ';
	}else{$condition = '';}
	
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
		$conStr.='<div onclick="changePage(this)"  name="'.($page-1).'">上一页</div>';
	}
	for($i=$startPage;$i<=$endPage;$i++){
		if($page==$i){$color='#87ceeb';}else{$color='#ffc0cb';}
		$conStr.='<span onclick="changePage(this)" style="background-color:'.$color.'" name="'.$i.'">'.$i.'</span>';
	}
	if($page<$pageTotal){
		$conStr.='<div onclick="changePage(this)"  name="'.($page+1).'">下一页</div>';
	}

	
	//echo $conStr;exit();
	//echo $startPage.'----',$endPage;exit();
	
	$sql= 'select id,ordid,username,ordtime,productname,ordbuynum,ordprice,freight,ordfee,ordstatus,recname,recaddress from '.$tableName.$condition.' order by '.$orderBy.' '.$order.' limit '.(-1+$page)*$pageNum.','.$pageNumber;
	if($res = mysql_query($sql)){
		while($row = mysql_fetch_assoc($res)){
			$row['ordtime'] = date('Y-m-d',$row['ordtime']);
			$data[] = $row;
		}
		echo json_encode(array('status'=>1,'data'=>$data,'constr'=>$conStr,'headStr'=>'此分类下 总计: '.$total.'个订单'));
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
	
}else if($action == 'checkSendGoods'){
	if(isset($_POST['id'])){
		      $id=$_POST['id'];
		 }else{
			exit(json_encode(array('status'=>0)));
	   }
	$sql = "update $tableName set ordstatus = 2 where ordstatus = 1 and id=".$id;
	
	if(mysql_query($sql)){
		echo json_encode(array('status'=>1));
	}else{
		echo json_encode(array('status'=>0));
	}
	
}


?>