<?php
$fp = fopen("/home/chenhuanyang/local/apache/htdocs/dxltest/data/info.dat",'r');
if(!fp)
{
	echo "<b>Error：打开文件错误，请检查目录是否正确，或稍后再试！</b>";
	exit;
}
while(!feof($fp))
{
	$line = fgets($fp);
	echo $line;
	echo "<br/><br/>";
}

echo "利用系统函数取得的根目录路径：".$_SERVER['DOCUMENT_ROOT'];
#  /home/chenhuanyang/local/apache/htdocs
echo "<br/><br/>";

$file  = "data.txt";
$content = "内容标题\r\n内容第一行\r\n内容第二行\r\n";
if(!fp == fopen($file,'a+'))
{
echo "打开失败";
exit;
}

if(fputs($fp,$content) === false)
{
echo "写入失败！";
exit;
}

echo "写入文件成功！";
$getcontent = file($file);
echo "文件内容：\r\n";
print_r($getcontent);
fclose($fp);
echo "文件大小：".filesize($file);
?>