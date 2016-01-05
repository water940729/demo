<?php
	require_once('../../conn/conn.php'); 
	require_once('../check.php'); 
	require_once('../inc_function.php');
	//得到GET方法传递的值，确定进行的操作
	$act = sqlReplace(trim($_GET['act']));
	//检测$act的值
	if(!$act=='add'||!$act=='update'||!$act=='del'){
		alertInfo('非法操作！','',1);
	}
	$time = time();
	switch($act){
		//*增加
		case 'add':
			//得到sort_add传递的值，并检测
			$title = sqlReplace(trim($_POST['title']));
			$content = sqlReplace(trim($_POST['content']));
			$role=$_SESSION["role"];
			$belong=$_SESSION["shop_id"];
			$sql_add = "insert into articles (title,content,addtime,role,belong) " . 
				       " values('$title','$content',$time,$role,$belong)";			
			if(mysql_query($sql_add))
			{
				alertInfo('The article added successful','list.php',0);
			}else{
				alertInfo('The article add failure','',1);
			}
			break;
		case 'update':
			//得到sortlist传递的值，并检测
			$id = sqlReplace(trim($_POST['id']));
			$title = sqlReplace(trim($_POST['title']));
			$content = sqlReplace(trim($_POST['content']));

			if($id==""){
				alertInfo('Illegal operation','list.php',0);
			}
			$sql_update = "update articles set title='$title',content = '$content' where aid = ".$id;		
			if(mysql_query($sql_update))
			{
				alertInfo('The article added successful','list.php',0);
					//echo $content;
				//alertInfo('修改成功！','list.php',0);
			}else{
				alertInfo('Modify failure!','',1);
			}
			break;
		case 'del':
			//得到sortlist传递的值，并检测
			$id = sqlReplace(trim($_GET['id']));
			if($id==""){
				alertInfo('Illegal operation','list.php',0);
			}
			$sql_del = "delete from articles where aid = $id";
			if(mysql_query($sql_del)){
				alertInfo('Deleted successful','list.php',0);
					//echo $content;
			}
			break;
	}
	

	
?>