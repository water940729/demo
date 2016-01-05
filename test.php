<?php
	//引入发送邮件类
	require("mail.php");
	//邮箱服务器
	$smtpserver = "smtp.163.com";
	//端口
	$smtpserverport = 25;
	//邮箱账号
	$smtpusermail = "15249243295@163.com";
	//收件人邮箱
	$smtpemailto = "1107745359@qq.com";
	//你的邮箱账号
	$smtpuser = $smtpusermail;
	//你的邮箱密码
	$smtppass = "nyklwqwycemhmvki";

	//SMTP服务器的用户密码 
	//邮件主题 

	$mailsubject = "测试邮件发送";

	//邮件内容 

	$mailbody = "PHP+MySQL";

	//邮件格式（HTML/TXT）,TXT为文本邮件 

	$mailtype = "TXT";
	



	//这里面的一个true是表示使用身份验证,否则不使用身份验证. 
	$smtp = new smtp($smtpserver,$smtpserverport,true,$smtpuser,$smtppass,$smtpusermail);

	//是否显示发送的调试信息 

	//$smtp->debug = TRUE;

	$smtp->sendmail($smtpemailto, $smtpusermail,"water", $mailsubject, $mailbody, $mailtype); 	