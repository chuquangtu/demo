<?php
	session_start();
	if(isset($_SESSION["islogin"])){
		if($_SESSION["user_role"] == "member")
			header("location: ../infor_user.php");
	} else header("loaction: ../login.php");
	require '../libs/config.php';
	connect_db();
	if($_SESSION["user_role"] === "admin" || $_SESSION["user_role"] === "operator" ){
		if(isset($_POST["id_product"])){
			$query = mysqli_query($conn, "UPDATE tbl_product SET product_status=1, update_date=NOW() WHERE id_product='".$_POST["id_product"]."'");
			header("location: admin.php#product");
		}

		if(isset($_POST['ansp'])){
		$query = mysqli_query($conn, "UPDATE tbl_product SET product_status=2, update_date=NOW() WHERE id_product='".$_POST["id_product"]."'");
		header("location: admin.php#product");
			}

	}
