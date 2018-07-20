<?php
	session_start();
	if(isset($_SESSION["islogin"])) {
		if($_SESSION["user_role"] !== "admin") header("location: ../index.php");
	} else header("location: login.php");
	require '../libs/config.php';
	connect_db();
	if(isset($_GET['id']))
		$query_news_delete = mysqli_query($conn, "delete from tbl_news where id_news = '".$_GET['id']."' ");
	header("location: admin.php?delete_news_success==true");
//		$result = mysqli_num_rows($query_news_delete);
//		if($result == 0){
//		header("location: admin.php");
//	}
?>