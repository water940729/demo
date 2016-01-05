<?php
$array1 = array(
'a' => 'green',
'red',
'blue',
'd' => 'pink');

echo '<pre>';
print_r($array1);

$dh = opendir("upload");
print "打开的目录".$dh;
echo getcwd();

?>