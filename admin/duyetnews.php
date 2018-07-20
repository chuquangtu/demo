<?php
	session_start();
	if(isset($_SESSION["islogin"])){
		if($_SESSION["user_role"] == "member")
			header("location: ../infor_user.php");
	} else header("loaction: ../login.php");
	require '../libs/config.php';
	connect_db();
	if($_SESSION["user_role"] === "admin" || $_SESSION["user_role"] === "operator") {
		if(isset($_POST['id_news'])) {
			mysqli_query($conn, "UPDATE tbl_news SET news_status=1, update_date=NOW() WHERE id_news='" . $_POST["id_news"] . "'");
			header("location: admin.php#news");
		}

	if(isset($_POST['annews'])){
		mysqli_query($conn, "UPDATE tbl_news SET news_status=2, update_date=NOW() WHERE id_news='".$_POST["id_news"]."'");
		header("location: admin.php#news");
	}
	}