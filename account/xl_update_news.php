<?php
	session_start();
	if(isset($_SESSION["islogin"])) {
	} else header("location: login.php");
	require '../libs/config.php';
	connect_db();
	if(!isset($_POST['id'])){
		echo "không có";
	}
	if(isset($_POST['id']) and isset($_POST['title']) and isset($_POST['author']) and isset($_POST['content']) and isset($_POST['hot']))
		$title = $_POST['title'];
		$author = $_POST['author'];
		$content = $_POST['content'];
		$sql = "update tbl_news set news_title = '".$title."' ,news_content = '".$content ."', news_author = '".$author."', news_status = 0 where id_news = '".$_POST['id']."'  ";
		$query_update = mysqli_query($conn, $sql);
	if($query_update == TRUE) {
		header("location: infor_user.php?update_news_success==true");
	} else {
		header("location:infor_user.php");
	}
