<?php
	require_once('../../conn/conn.php'); 
	require_once('../check.php'); 
	require_once('../inc_function.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title> 文章列表</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="author" content="liuxiao@WiiPu -- http://www.wiipu.com" />
		<link rel="stylesheet" href="../css/style2.css" type="text/css"/>
	</head>
	<body>
		<div class="bgintor">
			<div class="tit1">
				<ul>
					<li><a href="list.php">文章列表</a> </li>
					<li class="l1"><a href="add.php" target="mainFrame" >添加文章</a> </li>
				</ul>		
			</div>
			<div class="listintor">
				<div class="header1"><img src="../images/square.gif" width="6" height="6" alt="" />
					<span>位置：文章管理 －&gt; <strong>文章列表</strong></span>
				</div>
				<div class="header2"><span>文章列表</span></div>
				<div class="header3">
					<a href="add.php"><img class="img2" src="../images/act_add.gif" width="14" height="14" alt="新建" /> <strong>添加</strong> </a>
				</div>
				<div class="content">
					<form action="#" method="post" name="listForm">
						<table width="100%">
							<tr class="t1">
								<td width="80%">文章标题</td>
								<td width="10%">发布时间</td>
								<td width="5%">修改</td>
								<td width="5%">删除</td>
							</tr>
							<?php
				
$pagesize=20;
$select="select count(*) as page_count from articles";

$rest=mysql_query($select);
$rs=mysql_fetch_array($rest);
$count=$rs['page_count'];
if($count%$pagesize){
$pagecount = intval($count/$pagesize)+1;
}else{
        $pagecount = intval($count/$pagesize);
}
if(isset($_GET['page'])){
        $page=intval($_GET['page']);
}else{
        $page=1;
}
$pagestart = ($page-1)*$pagesize;

$query="select * from articles order by aid desc limit ".$pagestart.",".$pagesize;
//echo($query);
								$rs=mysql_query($query);
								$i=0;
								while($rows = mysql_fetch_array($rs)){
									$i++;
							?>
							<tr>
								<td><a href="/article/alist/id/<?php echo $rows["aid"] ?>" target="_blank"><?php echo $rows["title"] ?></a>
								</td>
								<td><?php echo date("Y-m-d H:i", $rows["addtime"]) ?></td>
								<td><a href="update.php?id=<?php echo $rows['aid'];?>"><img width="9" height="9" alt="编辑" src="../images/dot_edit.gif"></a></td>
								<td><a href="javascript:if(confirm('您确定要删除吗？')){location.href='do.php?act=del&id=<?php echo $rows['aid'];?>'}"><img width="9" height="9" alt="删除" src="../images/dot_del.gif"></a></td>
							</tr>
							<?php }?>
							<input type="hidden" name="i" value="<?php echo $i;?>" />
						</table>
					</form>
					<div class="page">
                        <div class="pagebefore">当前页:<?php echo $page;?>/<?php echo $pagecount;?>页 每页 <?php echo $pagesize?> 条</div>
                        <div class="pageafter">
                            <?php echo showPage("list.php",$page,$pagecount,"/admin_manage/images");?>
                             <div class="clear"></div>
                        </div>
                    </div>
				</div>
			</div>
		</div>
	</body>
</html>
