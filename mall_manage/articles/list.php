<?php
	require_once('../../conn/conn.php'); 
	require_once('../check.php'); 
	require_once('../inc_function.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title> Article List</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="author" content="liuxiao@WiiPu -- http://www.wiipu.com" />
		<link rel="stylesheet" href="../css/style2.css" type="text/css"/>
	</head>
	<body>
		<div class="bgintor">
			<div class="tit1">
				<ul>
					<li><a href="list.php">Article List</a> </li>
					<li class="l1"><a href="add.php" target="mainFrame" >Add Articles</a> </li>
				</ul>		
			</div>
			<div class="listintor">
				<div class="header1">
					<span>Position:Articles Manage －&gt; <strong>Article List</strong></span>
				</div>
				<div class="header2"><span>Article List</span></div>
				<div class="header3">
					<a href="add.php"><img class="img2" src="../images/act_add.gif" width="14" height="14" alt="新建" /> <strong>Add</strong> </a>
				</div>
				<div class="content">
					<form action="#" method="post" name="listForm">
						<table width="100%">
							<tr class="t1">
								<td width="80%">Article Title</td>
								<td width="10%">Publish Time</td>
								<td width="5%">Modify</td>
								<td width="5%">Delete</td>
							</tr>
							<?php
				
$pagesize=20;
$select="select count(*) as page_count from articles where role=2 and belong=$_SESSION[mall_id]";

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

$query="select * from articles where role=2 and belong=$_SESSION[mall_id] order by aid desc limit ".$pagestart.",".$pagesize;
								$rs=mysql_query($query);
								$i=0;
								while($rows = mysql_fetch_array($rs)){
									$i++;
							?>
							<tr>
								<td><a href="/mall/alist/id/<?php echo $rows["aid"] ?>/m/<?php echo $_SESSION["mall_id"]?>" target="_blank"><?php echo $rows["title"] ?></a>
								</td>
								<td><?php echo date("Y-m-d H:i", $rows["addtime"]) ?></td>
								<td><a href="update.php?id=<?php echo $rows['aid'];?>"><img width="9" height="9" alt="edit" src="../images/dot_edit.gif"></a></td>
								<td><a href="javascript:if(confirm('Sure to delete?')){location.href='do.php?act=del&id=<?php echo $rows['aid'];?>'}"><img width="9" height="9" alt="delete" src="../images/dot_del.gif"></a></td>
							</tr>
							<?php }?>
							<input type="hidden" name="i" value="<?php echo $i;?>" />
						</table>
					</form>
					<div class="page">
                        <div class="pagebefore">This Page:<?php echo $page;?>/<?php echo $pagecount;?>page Every page <?php echo $pagesize?> items</div>
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
