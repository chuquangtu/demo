<?php
	require '../libs/config.php';
	session_start();
	connect_db();

	if(isset($_SESSION['islogin'])) {
		if($_SESSION['islogin']) {
			$sql = "select id_user from tbl_user where username = '" . $_SESSION['username'] . "'";
			$query = mysqli_fetch_assoc(mysqli_query($conn, $sql));
		}
	}
	mysqli_query($conn, "SET NAMES utf8");
	$datatopic = mysqli_query($conn, "SELECT * FROM tbl_topic");
	$datatype_product = mysqli_query($conn, "SELECT * FROM tbl_type_product");
	$datapartner = mysqli_query($conn, "SELECT * FROM tbl_partner");
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		if(isset($_POST["product_name"], $_POST["product_author"], $_POST["product_license"], $_POST["product_deadline"], $_POST["product_form"], $_POST["product_expense"], $_FILES["product_image"], $_POST["product_content"], $_POST["id_topic"], $_POST["id_type_product"], $_POST["id_partner"])) {
			$product_name = addslashes($_POST["product_name"]);
			$product_author = addslashes($_POST["product_author"]);
			$product_license = addslashes($_POST["product_license"]);
			if($_POST["product_license"] == 1){
				$product_license = 1;
			}
			else{
				$product_license = 0;
			}
			$product_deadline = addslashes($_POST["product_deadline"]);
			$product_form = addslashes($_POST["product_form"]);
			$product_expense = addslashes($_POST["product_expense"]);
			//				$product_image = addslashes($_POST["product_image"]);
			$product_content = addslashes($_POST["product_content"]);
			$id_topic = addslashes($_POST["id_topic"]);
			$id_type_product = addslashes($_POST["id_type_product"]);
			$id_partner = addslashes($_POST["id_partner"]);
			$product_image = $_FILES['product_image']['name'];
			$target = "user_upload/" . basename($product_image);
			$dataproduct = mysqli_query($conn, "INSERT INTO tbl_product(product_name, product_author, product_license, product_deadline, product_form, product_expense, product_img, product_content,id_user, id_topic, id_type_product, id_partner, create_date, update_date ) 
		VALUES ('" . $product_name . "', '" . $product_author . "', '" . $product_license . "', '" . $product_deadline . "', '" . $product_form . "', '" . $product_expense . "', '" . $product_image . "','" . $product_content . "', '" . $query['id_user'] . "', '" . $id_topic . "', '" . $id_type_product . "', '" . $id_partner . "', NOW(), NOW())");
			if($dataproduct == TRUE && move_uploaded_file($_FILES['product_image']['tmp_name'], $target)) {
				echo '<div class="alert alert-success fade show mx-auto text-center" role="alert">Đăng sản phẩm thành công, xin chờ xét duyệt</div>';
			} else {
				echo '<div class="alert alert-success fade show mx-auto text-center" role="alert">Đăng sản phẩm thất bại, vui lòng thử lại</div>';
			}
		} else {
			echo "khong ket noi";
		}
	}
	$title = "Đăng sản phẩm mới";
	require '../header.php';
?>
<div class="container" id="post_product">
	<div class="col-md-12">
		<h2 style="margin-left: 15px;">Đăng sản phẩm</h2>
		<div class="col-md-10">
			<form action="#" method="POST" role="form" runat="server" enctype="multipart/form-data">
				<input type="text" name="product_name" class="form-control" placeholder="Tên sản phẩm" required>
				<br>
				<input type="text" name="product_author" class="form-control" placeholder="Tác giả" required>
				<br>
				<select class="form-control" required name="product_license">
					<option value="" style="color: gray">Sản phẩm có chứng nhận sở hữu trí tuệ ?</option>
					<option value="1">Có</option>
					<option value="0">Không</option>
				</select>
				<br>
				<input type="date" name="product_deadline" class="form-control" placeholder="Ngày hoàn thành sản phẩm(nếu có): mm/dd/yyyy" required>
				<br>
				<select class="form-control" name="product_form" required>
					<option value="">Trạng thái sản phẩm</option>
					<option value="1">Hoàn thành</option>
					<option value="2">Đang sản xuất</option>
					<option value="3">Ý tưởng</option>
				</select>
				<br>
				<div class="input-group">
					<input type="text" name="product_expense" class="form-control" placeholder="Chi phí sản xuất">
					<div class="input-group-prepend">
						<div class="input-group-text">VNĐ</div>
					</div>
				</div>
				<br>
				<br>
				<input type="file" name="product_image" class="form-control" id="product_img" accept="image/*" required>
				<img src="#" id="image" alt="" style="width: 200px;">
				<br>
				<!--				<img src="--><?php //echo getdomain() .'/'  ?><!--" id="image" alt="" style="width: 150px; height: 100px; ">-->
				<br>
				<br>
				<textarea name="product_content" id="product_content" required></textarea>
				<br>
				<select name="id_topic" class="form-control" required>
					<option value="" id="op1">Lĩnh vực / Ngành</option>
					<?php while($rowtopic = mysqli_fetch_assoc($datatopic)) {
						?>
						<option value="<?php echo $rowtopic['id_topic'] ?>"><?php echo $rowtopic['topic_name'] ?></option>
					<?php } ?>
				</select>
				<br>
				<select name="id_type_product" class="form-control" required>
					<option value="">Loại sản phẩm</option>
					<?php while($rowtype_product = mysqli_fetch_assoc($datatype_product)) {
						?>
						<option value="<?php echo $rowtype_product['id_type_product'] ?>"><?php echo $rowtype_product['type_product_name'] ?></option>
					<?php } ?>
				</select>
				<br>
				<select name="id_partner" class="form-control" required>
					<option value="">Hình thức đầu tư</option>
					<?php while($rowpartner = mysqli_fetch_assoc($datapartner)) {
						?>
						<option value="<?php echo $rowpartner['id_partner'] ?>"><?php echo $rowpartner['partner_type'] ?></option>
					<?php } ?>
				</select>
				<br>
				<input type="submit" class="btn btn-info" name="" value="Đăng">
			</form>
		</div>
	</div>
</div>
<br>
<br>
<script type="text/javascript" src="../assets/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="../assets/ckeditor/ckfinder/ckfinder.js"></script>
<script type="text/javascript">
    CKEDITOR.replace('product_content');
</script>
<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#image').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#product_img").change(function () {
        readURL(this);
    });
</script>
<?php
	require '../footer.php'
?>
