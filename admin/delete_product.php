<?php
	session_start();
	if(isset($_SESSION["islogin"])) {
		if($_SESSION["user_role"] !== "admin") header("location: ../index.php");
	} else header("location: login.php");
	require '../libs/config.php';
	connect_db();
	if(isset($_GET['id']))
		$query_product_delete = mysqli_query($conn, "delete from tbl_product where id_product = '".$_GET['id']."' ");
	header("location: admin.php?delete_prd_success==true");
	//		$result = mysqli_num_rows($query_news_delete);
	//		if($result == 0){
	//		header("location: admin.php");
	//	}
?>