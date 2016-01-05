<?php /* Smarty version Smarty-3.1.21, created on 2015-05-22 17:21:59
         compiled from "../../templates/advertisement/manage.html" */ ?>
<?php /*%%SmartyHeaderCode:1303521848555e95e99aff27-48377866%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8a6bc4857cf0d35b3d1ed6947cb700a96d6a8401' => 
    array (
      0 => '../../templates/advertisement/manage.html',
      1 => 1432286349,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1303521848555e95e99aff27-48377866',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21',
  'unifunc' => 'content_555e95e9a2b670_57302491',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_555e95e9a2b670_57302491')) {function content_555e95e9a2b670_57302491($_smarty_tpl) {?><?php echo '<?php'; ?>

	require_once('../../conn/conn.php');
	require_once('../inc_function.php');
	$role=$_SESSION["role"];
	$area=" ";
	if($role==2){
		$mall_id=$_SESSION['mall_id'];
		$area=" where mall_id='$mall_id' ";
	}
<?php echo '?>'; ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="author" content="liuxiao@WiiPu -- http://www.wiipu.com" />
		<link rel="stylesheet" href="../css/style2.css" type="text/css" />
		<?php echo '<script'; ?>
 src="../js/jquery-1.6.min.js" type="text/javascript"><?php echo '</script'; ?>
>
	</head>
	<body>
		<div class="bgintor">				
			<div class="listintor">
				<div class="tit1">
					<ul>				
						<li><a href="#">广告管理</a></li>
					</ul>		
				</div>
				<div class="header1"><img src="../images/square.gif" width="6" height="6" alt="" />
					<span>位置：广告管理 －&gt; <strong>查看广告</strong></span>
				</div>
				<div class="content">
					<table width="100%">
						<tr class="t1">
							<td width="10%">广告编号</td>
							<td width="10%">广告位置</td>
							<td width="10%">到期时间</td>
							<td width="10%">广告价位</td>
						</tr>
					</table>
					<div class="page">
						<div class="pagebefore">当前页:<?php echo '<?php'; ?>
 echo $page;<?php echo '?>'; ?>
/<?php echo '<?php'; ?>
 echo $pagecount;<?php echo '?>'; ?>
页 每页 <?php echo '<?php'; ?>
 echo $pagesize<?php echo '?>'; ?>
 条</div>
						<div class="pageafter">
						<?php echo '<?php'; ?>
 echo showPage("ad_manage.php",$page,$pagecount,"../images");<?php echo '?>'; ?>

						<div class="clear"></div>
						</div>
					</div>
				</div>
			</div>	
		</div>
	</body>
</html><?php }} ?>
