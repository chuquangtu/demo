<?php
	require '../libs/config.php';
	session_start();
	connect_db();
	if(isset($_SESSION['islogin'])){
		if($_SESSION['islogin']){
			$sql = "select id_user from tbl_user where username = '".$_SESSION['username']."'";
			$query =mysqli_fetch_assoc( mysqli_query($conn, $sql));
		}
	}
	mysqli_query($conn,"SET NAMES utf8");
	$datatopic = mysqli_query($conn,"SELECT * FROM tbl_topic");
	$datatype_product = mysqli_query($conn,"SELECT * FROM tbl_type_product");
	$datapartner = mysqli_query($conn,"SELECT * FROM tbl_partner");
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		if(isset($_POST["news_title"], $_POST["news_image"], $_POST["news_content"], $_POST["news_author"] )){
			$news_title = addslashes($_POST["news_title"]);
			$news_image = addslashes($_POST["news_image"]);
			$news_content = addslashes($_POST["news_content"]);
			$news_author = addslashes($_POST["news_author"]);
			$datanews = mysqli_query($conn, "INSERT INTO tbl_news(news_title, news_img, news_content, news_author, id_user, create_date, update_date) VALUES ('".$news_title."', '".$news_image."', '".$news_content."', '".$news_author."', '".$query['id_user']."', NOW(), NOW())");
			if($datanews == TRUE){
				echo '<div class="alert alert-success fade show mx-auto text-center" role="alert">Đăng tin tức thành công, xin chờ xét duyệt</div>';
			} else {
				echo '<div class="alert alert-success fade show mx-auto text-center" role="alert">Đăng tin tức thất bại, vui lòng thử lại</div>';
			}
			}

	}
	$title = "Đăng tin tức mới";
	require '../header.php';
?>
<div class="container" id="post_news">
	<div class="col-md-12">
		<h2 style="margin-left: 15px;">Đăng tin tức</h2>
		<div class="col-md-10">
			<form action="#" method="POST" role="form"  runat="server" >
				<input type="text" name="news_title" class="form-control" placeholder="Tiêu đề" required>
				<br>
				<input type="file" name="news_image" class="form-control" id="news_img" accept="image/*" required>
				<br>
				<img src="#" id="news_image" alt="" style="width: 150px; height: 100px; ">
				<br><br>
				<textarea name="news_content" id="news_content"></textarea>
				<br>
				<input type="text" name="news_author" class="form-control" placeholder="Tác giả" >
				<br>
				<input type="submit" class="btn btn-info" name="" value="Đăng">
			</form>
		</div>
	</div>
	<br>
	<h4><a href=""></a></h4>
</div>
<script type="text/javascript" src="../assets/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="../assets/ckeditor/ckfinder/ckfinder.js"></script>
<script type="text/javascript">
    CKEDITOR.replace( 'news_content');
</script>
<script>
    function readURL1(input) {
        if (!(input.files && input.files[0])) {
            return;
        }
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#news_image').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
    $("#news_img").change(function(){
        readURL1(this);
    });
</script>
<?php
	require '../footer.php'
?>

