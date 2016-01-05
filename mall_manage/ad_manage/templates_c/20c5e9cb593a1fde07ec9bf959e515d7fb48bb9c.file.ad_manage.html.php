<?php /* Smarty version Smarty-3.1.21, created on 2015-05-19 18:13:54
         compiled from "../../templates/advertisement/ad_manage.html" */ ?>
<?php /*%%SmartyHeaderCode:1816034132555aec80d31f68-39392441%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '20c5e9cb593a1fde07ec9bf959e515d7fb48bb9c' => 
    array (
      0 => '../../templates/advertisement/ad_manage.html',
      1 => 1432030431,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1816034132555aec80d31f68-39392441',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21',
  'unifunc' => 'content_555aec80db2065_64834065',
  'variables' => 
  array (
    'url' => 0,
    'array' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_555aec80db2065_64834065')) {function content_555aec80db2065_64834065($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
		function ajaxFileUpload(file_type)
					{
						var doing = '';
						$("#loading"+"_"+file_type).ajaxStart(function()
						{
							$(this).show();
							$("#logo"+"_"+file_type).html("上传中……");
						})
						.ajaxComplete(function(){
							$(this).hide();
							$("#logo"+"_"+file_type).html("");
						});
						$.ajaxFileUpload
						(
							{
							url:'upload_image.php?type=' + file_type,
							secureuri:false,
							fileElementId:'file'+'_'+file_type,
							dataType: 'json',
							data:{},
							success: function (data, status)
							{
								data=data.replace('<pre>','');
								data=data.replace('</pre>','');
								var info=data.split('|');
								if(info[0]=="E")
								{
									alert(info[1]);
								}
								else
								{
									if (file_type == "image")
									{
										//$("#upd"+"_"+file_type).html("<p><img src='"+ info[1] +"' width='100'> ["+ info[1] +"]"+"</p>");
										var c = document.getElementById('shop_images').innerHTML;
										document.getElementById('shop_images').innerHTML= c + 
													"<p><img src='"+ info[1] +"' width='100'> <input type='checkbox' checked name='pics[]' value="+ info[1] +" /> "+info[1]+
													"</p>";
									}
									else if(file_type == "file")
									{
										$("#upd"+"_"+file_type).html("<p> ["+ info[1] +"]"+"</p>");
									}
									//var pic_url=info[1];
									//$("#"+file_type+"_url").val(pic_url);
								}
								
							},
							error: function (data, status, e)
							{
								 alert(e);
							}
						}
						
						)
						return false;
					}
			$(function(){
					
					
				$("#submit").click(function(){
					var $form=$(this).parents("form");
					
					var content=$form.not("input[type='file']").not("input[type='button']").serialize();
					$.ajax({
						type:"POST",
						url:"../../admin_manage/system_manage/system_modify.php",
						data:content,
						success:function(data){
							if(data==1){
								alert("修改成功");
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
						<li><a href="#">系统设置</a></li>
					</ul>		
				</div>
				<div class="header1"><img src="../images/square.gif" width="6" height="6" alt="" />
					<span>位置：系统设置 －&gt; <strong>系统信息</strong></span>
				</div><div class="fromcontent">
			<form action="http://<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
/admin_manage/system_manage/system_modify.php" method="post" id="doForm">
				<p>广告名称：<select>

				</select></p>			
				 <p>广告到期时间：
				 </p>
				 <p>广告图片：
				 <?php if (($_smarty_tpl->tpl_vars['array']->value['pics'])) {?>
				 <img src="<?php echo $_smarty_tpl->tpl_vars['array']->value['pics'];?>
" width="50px" height="60px" alt="网站LOGO"/>
				 <?php }?>
				 <span id="shop_images" name=""></span>
				 <input type="file" name="file" id="file_image"/>
				 	<span id="loading_image" style="display:none;">
				 	<img src="../../admin_manage/images/loading.gif" alt="loading...">
				 	</span>
				 	<span id="logo_image"></span>
                    <input type="button" value="上传" onclick="return ajaxFileUpload('image');" 
                    class="btn btn-large btn-primary" />(*海报尺寸：500*500以内)	
				</p>					
				<br>
				<p>广告显示位置</p>
				<p><input type="submit" value="确定" id="submit" /></p>
			</form>
		</div>
	</div>
  </div>
 </body>
</html><?php }} ?>
