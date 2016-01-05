<?php
session_start();
if(!isset($_SESSION['id'])){
	echo "<script>parent.location.href='/admin_manage/index.html';</script>";
}
?>