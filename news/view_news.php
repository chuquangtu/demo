<?php
	require '../libs/config.php';
	session_start();
	connect_db();
	if(isset($_GET['id'])) {
		$id_news = $_GET['id'];
	} else {
		echo " Không tìm thấy bài viết";
	}
	$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM tbl_news where id_news ='" . $id_news . "' "));
	$title = $data["news_title"];
	if(strlen($data["news_content"]) <= 50) {
		$metadesc = strip_tags($data["news_content"]);
	} else {
		$metadesc = strip_tags(substr($data["news_content"], 0, 50) . '...');
	}
	$metaimg = $data["news_img"];
	require "../header.php";
?>
<div class="container">
	<div class="col-md-12">
		<h3><?php echo $data['news_title'] ?></h3>
		<!-- <div class="col-md-8" style="text-align: justify"><?php echo $data['news_img'] ?></div> -->
		<div class="col-md-8" style="text-align: justify"><?php echo $data['news_content'] ?></div>
	</div>
</div>
<?php
	require '../footer.php'
?>
