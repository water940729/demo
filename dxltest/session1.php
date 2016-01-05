<?php 
session_start();

$_SESSION['user'] = "KingKong";
$_SESSION['explain'] = "这是session1的session变量";
echo "这个页面已经通过session保存了一些变量";
echo '</br><a href = "session2.php">进入session2.php</a>查看这些变量值';
?>