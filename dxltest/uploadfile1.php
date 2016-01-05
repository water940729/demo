<?php
$upload_path = "/home/chenhuanyang/local/apache/htdocs/dxltest/upload/";
echo $upload_path ;

$dest_file = $upload_path.basename($_FILES['myfile']['name']);

if(move_uploaded_file($_FILES['myfile']['tmp_name'],$dest_file))
{
	echo "文件已经上传到服务器目录的upload目录下！";
} 
else
{
	echo "上传文件时发生一个错误".$_FILES['myfile']['error'];
}
?>