<?php
	session_start();
	if(isset($_SESSION["islogin"])) {
} else header("location: login.php");
	require '../libs/config.php';
	connect_db();
	if(isset($_POST['id']) and isset($_POST['name']) and isset($_POST['author']) and isset($_POST['content']) and isset($_POST['form']) and isset($_POST['license'])) $id = $_POST['id'];
	$name = $_POST['name'];
	$author = $_POST['author'];
	$content = $_POST['content'];
	$form = $_POST['form'];
	$license = $_POST['license'];
	$query_update = mysqli_query($conn, "update tbl_product set product_name = '" . $name . "', product_content = '" . $content . "', product_author = '" . $author . "',product_license = '" . $license . "',product_form = '" . $form . "' where id_product = '" . $id . "' ");
	if($query_update == TRUE) {
		header("location: infor_user.php?update_prd_success==true");
	} else {
		header("location: infor_user.php");
	}