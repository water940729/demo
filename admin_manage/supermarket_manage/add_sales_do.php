<?php
	require_once('../../conn/conn.php'); 
	require_once('../check.php'); 
	require_once('../inc_function.php');
	require("../system_manage/add_system_log.php");
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
			$sql_add = "insert into super_articles (title,content,addtime) " . 
				       " values('$title','$content',$time)";
			if(mysql_query($sql_add))
			{
				$content="添加了一篇文章，文章名".$title;
				if(add_system_log($content)==1){
					alertInfo('文章添加成功','manage_sales.php',0);
					//echo $content;
				}else{
					alertInfo('文章添加失败','',1);
					//echo $content;
					//echo add_system_log($content);
				}
			}else{
				alertInfo('文章添加失败','',1);
			}
			break;
		case 'update':
			//得到sortlist传递的值，并检测
			$id = sqlReplace(trim($_POST['id']));
			$title = sqlReplace(trim($_POST['title']));
			$content = sqlReplace(trim($_POST['content']));

			if($id==""){
				alertInfo('非法操作','manage_sales.php',0);
			}
			$sql_update = "update super_articles set title='$title',content = '$content' where aid = ".$id;		
			if(mysql_query($sql_update))
			{
				$content="修改了一篇文章，文章名".$title;
				if(add_system_log($content)==1){
					alertInfo('文章添加成功','manage_sales.php',0);
					//echo $content;
				}else{
					alertInfo('文章添加失败','',1);
					//echo $content;
					//echo add_system_log($content);
				}
				//alertInfo('修改成功！','manage_sales.php',0);
			}else{
				alertInfo('修改失败！','',1);
			}
			break;
		case 'del':
			//得到sortlist传递的值，并检测
			$id = sqlReplace(trim($_GET['id']));
			if($id==""){
				alertInfo('非法操作','manage_sales.php',0);
			}
			$sql_del = "delete from super_articles where aid = $id";
			if(mysql_query($sql_del)){
				$content="删除了一篇文章，文章编号".$title;
				if(add_system_log($content)==1){
					alertInfo('删除成功','manage_sales.php',0);
					//echo $content;
				}else{
					alertInfo('文章删除失败','',1);
					//echo $content;
					//echo add_system_log($content);
				}
			}
			break;
	}
	

	
?>