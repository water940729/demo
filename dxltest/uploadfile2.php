<html>
<head><title>uploadfile</title></head>
<body>

<!--表单的enctype属性必须指定为multipart/form-data-->
<form enctype = "multipart/form-data" action = "uploadfile1.php" method = "POST">
上传此文件：</br></br><input name = "myfile" type = "file" />
</br></br><input type = "submit" value = "提交上传" />
</form>
</body>
</html>