<?php
	session_start();
	if(isset($_SESSION["islogin"])){}
	else header("location: login.php");
	require '../libs/config.php';
	connect_db();
	if(isset($_GET['id'])) {
		$id_news = $_GET['id'];
	} else {
		header("location: admin.php");
	}
	$query_news = mysqli_query($conn, "select * from tbl_news where id_news = '" . $_GET['id'] . "'");
	$title = "Chỉnh sửa tin tức";
	require '../header.php';
?>
<div class="container">
	<h2>Sửa tin tức</h2>
	<form action="xl_update_news.php" method="POST" style="font-size: x-large">
		<table class="table-hover">
			<?php while($row_news = mysqli_fetch_assoc($query_news)) {
				?>
				<tr>
					<td><label>ID</label></td>
					<td>
						<input type="text" value="<?php echo $row_news['id_news'] ?>" name="id" class="btn btn-outline-secondary m-2">
					</td>
				</tr>
				<tr>
					<td style="width: 20%"><label>Tên tin tức</label></td>
					<td>
						<input type="text" value="<?php echo $row_news['news_title'] ?>" name="title" class="btn btn-outline-secondary m-2" >
					</td>
				</tr>
				<tr>
					<td>Tác giả</td>
					<td>
						<input type="text" value="<?php echo $row_news['news_author'] ?>" name="author" class="btn btn-outline-secondary m-2" >
					</td>
				</tr>
				<tr>
					<td>Nội dung</td>
					<td>
						<textarea style="text-align: justify" name="content" id="news_content"><?php echo $row_news['news_content'] ?>"</textarea>
					</td>
				</tr>
			<?php } ?>
			<tr>
				<td></td>
				<td>
					<button type="submit" class="btn btn-success m-3">Sửa</button>
				</td>
			</tr>
		</table>
	</form>
</div>
<script type="text/javascript" src="../assets/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="../assets/ckeditor/ckfinder/ckfinder.js"></script>
<script type="text/javascript">
    CKEDITOR.replace('news_content');
</script>