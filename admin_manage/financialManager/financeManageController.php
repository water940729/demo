<?php

header("Content-type:text/html;charset=utf-8");
require_once('../../conn/conn.php');
require_once('../inc_function.php');
require("../system_manage/add_system_log.php");	

$statusArr= array('待处理','已审核','提款中','已成功','已驳回');

$controllArr = array('delete');
$tableName = 'withdrawManage';
$pageNum = 10;

$result=mysql_query("select id,name from mall") or die("数据库异常");
	    $shopLocation[0]='葵花商城首页';
while($array=mysql_fetch_array($result)){
		$shopLocation[$array['id']]=$array['name'];
	 }
	 
$action = isset($_POST['action'])?$_POST['action']:'search';

if($action == 'search'){
	

	$order = isset($_POST['order'])?$_POST['order']:'DESC';
	$orderBy = isset($_POST['orderBy'])?$_POST['orderBy']:'id';
	$page = isset($_POST['page'])?intval($_POST['page']):1;
    $type = isset($_POST['type'])||!empty($_POST['type'])?$_POST['type']:'';
	
	if($type !== ''){
		$condition = ' where status = '.$type.' ';
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

	
	
	$sql= 'select * from '.$tableName.$condition.' order by '.$orderBy.' '.$order.' limit '.(-1+$page)*$pageNum.','.$pageNumber;

	if($res = mysql_query($sql)){
		while($row = mysql_fetch_assoc($res)){
			$row['applyTime'] = $row['applyTime']==0?'':date('Y-m-d',$row['applyTime']);
			$row['disposeTime'] = $row['disposeTime']==0?'':date('Y-m-d',$row['disposeTime']);
			$row['successTime'] = $row['successTime']==0?'':date('Y-m-d',$row['successTime']);
			$row['mall'] = $shopLocation[$row['mallId']];
			$row['tag'] = $row['status'];
			$row['status'] = $statusArr[$row['status']];
			$data[] = $row;
		}
		echo json_encode(array('status'=>1,'data'=>$data,'constr'=>$conStr,'headStr'=>'此分类下 总计: '.$total.'个请求'));
	}else{
		echo json_encode(array('status'=>0));
		exit();
	}
	
}else if($action == 'changeStatus'){
    
	if(isset($_POST['id'])){
		      $id=$_POST['id'];
		 }else{
			exit(json_encode(array('status'=>0)));
	   }
    $sql = "select status from $tableName where id=$id";
	$res = mysql_fetch_row(mysql_query($sql));
	$status = $res[0];
	$status = $status + 1;
	$relations = '';
	if($status == 1){
		$relations = ' ,disposeTime='.time().' ';  
	}
	if($status == 3){
		$relations = ' ,successTime='.time().' ';  
	}
	$sql = "update $tableName set status = $status".$relations." where  id=".$id;
	
	if(mysql_query($sql)){
		if($status == 3){
			 $sql = "select withdrawMoney,mallId from $tableName where id=$id";
			 $res = mysql_fetch_row(mysql_query($sql));
			 $sql = "update mall set balanceMoney = balanceMoney-$res[0] where id = $res[1]";
			 if(mysql_query($sql)){
				 exit(json_encode(array('status'=>1)));
				 add_system_log('修改'.$id.'的提现状态');
			 }else{
				 exit(json_encode(array('status'=>0)));
			 }
		}
		 exit(json_encode(array('status'=>1)));
		 add_system_log('修改'.$id.'的提现状态');
	}else{
		echo json_encode(array('status'=>0));
	}
	
}else if($action == 'reDrow'){
	if(isset($_POST['id'])){
		      $id=$_POST['id'];
		 }else{
			exit(json_encode(array('status'=>0)));
	   }
	 $sql = "select status,withdrawMoney,mallId from $tableName where id = $id ";
	 $res = mysql_fetch_row(mysql_query($sql));
	 
	 $sql = "update $tableName set status = 4 where id=".$id;
	if(mysql_query($sql)){
		mysql_query('update mall set useMoney = useMoney +'.$res[1].' where id='.$res[2]);
		echo json_encode(array('status'=>1));
		add_system_log('驳回了'.$id.'的提现请求');
	}else{
		echo json_encode(array('status'=>0));
	}
}

?>