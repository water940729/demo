<?php /* Smarty version Smarty-3.1.21, created on 2015-06-11 15:42:35
         compiled from "../../templates/advertisement/add_ad.html" */ ?>
<?php /*%%SmartyHeaderCode:123875380855793beb034733-73827196%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3524f4b4ffe2116624d4a1cc8ae6ac8c458013b9' => 
    array (
      0 => '../../templates/advertisement/add_ad.html',
      1 => 1434003761,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '123875380855793beb034733-73827196',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'array' => 0,
    'vo' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21',
  'unifunc' => 'content_55793beb08a9e4_17911649',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_55793beb08a9e4_17911649')) {function content_55793beb08a9e4_17911649($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="author" content="liuxiao@WiiPu -- http://www.wiipu.com" />
		<link rel="stylesheet" href="../css/style2.css" type="text/css" />
		<?php echo '<script'; ?>
 src="../../js/jquery-1.6.min.js" type="text/javascript"><?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
 type="text/javascript" src="../../js/upload.js"><?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
>
			$(function(){
				$(".select1").click(function(){
					var id=$(this).val();
					$.ajax({
						type:"POST",
						url:"getInfo.php",
						data:"id="+id,
						success:function(data){
							$(".info").remove();
							$("#adver").append(data);
						}
					});
				});
				$("#submit").click(function(){
					var $form=$(this).parents("form");
					
					var content=$form.serialize();
					$.ajax({
						type:"POST",
						url:"modify.php",
						data:content,
						success:function(data){
							if(data==1){
								alert("修改成功");
								location.reload();
							}else{
								alert(data);
							}
						}
					});
					return false;
				});
			});
		<?php echo '</script'; ?>
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
					<span>位置：广告管理 －&gt; <strong>修改广告位</strong></span>
				</div><div class="fromcontent">
			<form action="#" method="post" id="doForm">
				 <p id="adver">广告摆放位置：
				 <select name="select1">
					<option value="platform" class="select1">平台</option>
					<?php  $_smarty_tpl->tpl_vars['vo'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vo']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['array']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['vo']->key => $_smarty_tpl->tpl_vars['vo']->value) {
$_smarty_tpl->tpl_vars['vo']->_loop = true;
?>
					<option value="mall" class="select1"><?php echo $_smarty_tpl->tpl_vars['vo']->value['name'];?>
</option>
					<?php } ?>
				</select>
				 </p>
				<p>价位/月：<input class="in1" type="text" name="price" id="name" value="<?php echo $_smarty_tpl->tpl_vars['array']->value['hot_word'];?>
" /></p>
				<p><input type="submit" value="确定" id="submit" /></p>
			</form>
		</div>
	</div>
  </div>
 </body>
</html><?php }} ?>
