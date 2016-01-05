<?php
	require_once('../../conn/conn.php'); 
	require_once('../check.php'); 
	require_once('../inc_function.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title> Article list</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="author" content="liuxiao@WiiPu -- http://www.wiipu.com" />
		<link rel="stylesheet" href="../css/style2.css" type="text/css"/>
	</head>
	<body>
		<div class="bgintor">
			<div class="tit1">
				<ul>
					<li><a href="list.php">Article list</a> </li>
					<li class="l1"><a href="add.php" target="mainFrame" >Add article</a> </li>
				</ul>		
			</div>
			<div class="listintor">
				<div class="header1">
					<span>Location: Article management －&gt; <strong>Article list</strong></span>
				</div>
				<div class="header2"><span>Article list</span></div>
				<div class="header3">
					<a href="add.php"><img class="img2" src="../images/act_add.gif" width="14" height="14" alt="New" /> <strong>Add</strong> </a>
				</div>
				<div class="content">
					<form action="#" method="post" name="listForm">
						<table width="100%">
							<tr class="t1">
								<td width="80%">Title</td>
								<td width="10%">Add time</td>
								<td width="5%">Modify</td>
								<td width="5%">Delete</td>
							</tr>
							<?php
				
$pagesize=20;
$select="select count(*) as page_count from articles where role=3 and belong=$_SESSION[shop_id]";

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

$query="select * from articles where role=3 and belong=$_SESSION[shop_id] order by aid desc limit ".$pagestart.",".$pagesize;
								$rs=mysql_query($query);
								$i=0;
								while($rows = mysql_fetch_array($rs)){
									$i++;
							?>
							<tr>
								<td><a href="/shop/alist/id/<?php echo $rows["aid"] ?>" target="_blank"><?php echo $rows["title"] ?></a>
								</td>
								<td><?php echo date("Y-m-d H:i", $rows["addtime"]) ?></td>
								<td><a href="update.php?id=<?php echo $rows['aid'];?>"><img width="9" height="9" alt="Edit" src="../images/dot_edit.gif"></a></td>
								<td><a href="javascript:if(confirm('Are you sure you want to delete?')){location.href='do.php?act=del&id=<?php echo $rows['aid'];?>'}"><img width="9" height="9" alt="Delete" src="../images/dot_del.gif"></a></td>
							</tr>
							<?php }?>
							<input type="hidden" name="i" value="<?php echo $i;?>" />
						</table>
					</form>
					<div class="page">
                        <div class="pagebefore">Current page:<?php echo $page;?>/<?php echo $pagecount;?>Page Each page <?php echo $pagesize?> One</div>
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
