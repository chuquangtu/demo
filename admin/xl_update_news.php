<?php
	session_start();
	if(isset($_SESSION["islogin"])) {
		if($_SESSION["user_role"] !== "admin") header("location: ../index.php");
	} else header("location: login.php");
	require '../libs/config.php';
	connect_db();
	if(isset($_POST['id']) and isset($_POST['title']) and isset($_POST['author']) and isset($_POST['content'])and isset($_POST['hot']))
		$id = $_POST['id'];
	$title = $_POST['title'];
	$author =  $_POST['author'];
	$hot =  $_POST['hot'];
	$content =  $_POST['content'];
	$query_update = mysqli_query($conn,"update tbl_news set news_title = '".$title."', news_content = '".$content."', news_author = '".$author."', news_hot = 1, news_status= 0 where id_news = '".$id."' ");
	if($query_update == true){
		header("location: admin?update_news_success==true");
	}else {
		header("location:admin.php");
	}

?>