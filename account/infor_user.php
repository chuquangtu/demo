<?php
	session_start();
	if(!isset($_SESSION["islogin"])) header("location: login.php");
	require '../libs/config.php';
	connect_db();
	$oldpwd = $newpwd = $renewpwd = $notice = "";
	if($_SERVER["REQUEST_METHOD"] === "POST") {
		if(isset($_POST["btn-change-avatar"])) {
			$user_avatar = $_FILES['user_avatar']['name'];
			$target = "user_avatar/" . basename($user_avatar);
			$id_user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM tbl_user WHERE username='" . $_SESSION["username"] . "'"));
			mysqli_query($conn, "UPDATE tbl_user_info SET avatar='" . $user_avatar . "' WHERE id_user='" . $id_user["id_user"] . "'");
			if(move_uploaded_file($_FILES['user_avatar']['tmp_name'], $target)) $uploaded = TRUE;
		}
		if(isset($_POST["changepwd"])) {
			$usr = trim($_SESSION["username"]);
			$oldpwd = addslashes($_POST["oldpwd"]);
			$newpwd = addslashes($_POST["newpwd"]);
			$renewpwd = addslashes($_POST["renewpwd"]);
			if($_POST["token"] === $_SESSION["token"]) {
				$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM tbl_user where username='" . $usr . "'"));
				if($user["password"] === sha1(md5($oldpwd) . $usr)) {
					if($newpwd === $renewpwd) {
						$qry = mysqli_query($conn, "UPDATE tbl_user SET password='" . sha1(md5($newpwd) . $usr) . "' WHERE username='" . $usr . "'");
						if($qry) $notice = '<div class="alert alert-success upload-success mt2" role="alert">Thay đổi mật khẩu thành công!</div>';
					} else {
						$notice = '<div class="alert alert-danger upload-success mt2" role="alert">Hai mật khẩu mới phải giống nhau!</div>';
					}
				} else {
					$notice = '<div class="alert alert-danger upload-success mt2" role="alert">Mật khẩu cũ không chính xác!</div>';
				}
			}
		}
	}
	if(isset($_GET['update_prd_success'])) if($_GET["update_prd_success"]) {
		echo '<div class="alert alert-primary fade show mx-auto" role="alert" id="update_product" style="text-align: center;">Sửa sản phẩm thành công</div>';
	}
	if(isset($_GET['update_news_success'])) if($_GET["update_news_success"]) {
		echo '<div class="alert alert-primary fade show mx-auto" role="alert" id="update_news" style="text-align: center;">Sửa tin tức thành công</div>';
	}

	$datauser = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM tbl_user WHERE username='" . $_SESSION["username"] . "'"));
	$datauserinfo = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM tbl_user_info WHERE id_user='" . $datauser["id_user"] . "'"));
	$title = "Tài khoản: " . $datauser["username"];
	$metadesc = "Trang cá nhân của " . $datauser["username"];
	if(isset($datauserinfo["avatar"])) {
		$avatar = "user_avatar/" . $datauserinfo["avatar"];
	} else {
		$avatar = "user_avatar/default_avatar.jpeg";
	}
	$metaimg = $avatar;
	require '../header.php';

?>
<div class="container user-info">
	<div class="col-md-12">
		<div class="col-md-5 col-lg-5 iphone">
			<div class="col-md-12 screen">
				<div class="col-md-12 device">
					<i class="fa fa-signal"></i>
					<span>KHCN</span>
					<i class="fa fa-battery-3"></i>
					<i class="fa fa-wifi"></i>
				</div>
				<div class="col-md-12 file" style="margin-left: -23px;">
					<?php
						$notdata = 'Not found';
						$isorg = FALSE;
						if(isset($datauserinfo["id_org"]) !== NULL) {
							$isorg = TRUE;
							$datauserorg = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM tbl_org where id_org='" . $datauserinfo["id_org"] . "'"));
						}
					?>
					<table class="table-hover" cellpadding="5px;" style="font-size: 16px; height: 100%; margin:auto; width:max-content; ">
						<tr>
							<td>ID</td>
							<td>:</td>
							<td><?php echo $datauser["id_user"] ?></td>
						</tr>
						<tr>
							<td>Họ và tên</td>
							<td>:</td>
							<td>
								<?php echo $datauserinfo["full_name"] ?>
							</td>
						</tr>
						<tr>
							<td>Giới tính</td>
							<td>:</td>
							<td><?php echo $datauserinfo["gender"] == "m" ? "Nam" : "Nữ"; ?></td>
						</tr>
						<tr>
							<td>Email</td>
							<td>:</td>
							<td><?php echo $datauserinfo["email"] ?></td>
						</tr>
						<tr>
							<td>Phone</td>
							<td>:</td>
							<td> <?php echo 0 . $datauserinfo["phone"] ?></td>
						</tr>
						<tr>
							<td>Ngày sinh</td>
							<td>:</td>
							<td> <?php echo date('d/m/Y', strtotime($datauserinfo["birthday"])) ?></td>
						</tr>
						<tr>
							<td>Hình ảnh</td>
							<td>:</td>
							<td>
								<img src="<?php echo $avatar; ?>" style="width: 40px; height: 30px;">
							</td>
						</tr>
						<?php if($datauserinfo["id_org"] !== NULL) {
							echo '			
									<tr>
										<td>Tên tổ chức</td>
										<td>:</td>
										<td>' . $datauserorg['org_name'] . '</td>
									</tr>
									<tr>
										<td>Email tổ chức</td>
										<td>:</td>
										<td>' . $datauserorg['org_email'] . '</td>
									</tr>
									<tr>
										<td>Số điện thoại</td>
										<td>:</td>
										<td> 0' . $datauserorg['org_phone'] . '</td>
									</tr>
									<tr>
										<td>Địa chỉ</td>
										<td>:</td>
										<td>' . $datauserorg['org_address'] . '</td>
									</tr>
									<tr>
										<td>Website</td>
										<td>:</td>
										<td>' . $datauserorg['org_website'] . ' </td>
									</tr>';
						} ?>
						<tr>
							<td colspan="2"><a data-toggle="modal" href='#modal-id'>Đổi mật khẩu</a></td>
						</tr>
						<tr>
							<td colspan="2" style="width: max-content;">
								<a href="#modal-id-1" data-toggle="modal">Đổi ảnh đại diện</a></td>
						</tr>
					</table>
					<div class="row mt-1">
						<div class="col-10 offset-1">
							<?php
								if(isset($uploaded)) echo ' <div class="alert alert-success upload-success mt2" role="alert">Cập nhật ảnh đại diện thành công!</div>';
								echo $notice;
							?></div>
					</div>
				</div>
			</div>
			<div class="col-md-2 center1"></div>
		</div>
	</div>
</div>
<div class="modal fade" id="modal-id">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<div class="col-md-10" style="text-align: center;">Đổi mật khẩu</div>
				<div class="col-md-1">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"> &times;</button>
				</div>
			</div>
			<div class="modal-body">
				<form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="POST" role="form" class="form-login" id="change_password">
					<div class="form-group">
						<label for="oldpwd"><i class="fa fa-key"></i> Mật khẩu cũ</label>
						<input type="password" name="oldpwd" class="form-control" id="oldpwd" minlength="6" required>
						<br>
						<label for="newpwd"><i class="fa fa-key"></i> Mật khẩu mới</label>
						<input type="password" name="newpwd" class="form-control" id="newpwd" required minlength="6">
						<br>
						<label for="renewpwd"><i class="fa fa-key"></i> Nhập lại mật khẩu mới</label>
						<input type="password" name="renewpwd" class="form-control" id="renewpwd" required>
						<input type="hidden" name="token" value="<?php echo $_SESSION["token"] ?>">
					</div>
					<br>
					<button type="submit" class="btn btn-primary btn-login" name="changepwd">Xác nhận</button>
					<br>
				</form>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="modal-id-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<div class="col-md-10" style="text-align: center;">Đổi ảnh đại diện</div>
				<div class="col-md-1">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"> &times;</button>
				</div>
			</div>
			<div class="modal-body">
				<form action="infor_user.php" method="POST" role="form" class="form-login mt-0" enctype="multipart/form-data">
					<div class="form-group">
						<label><i class="fa fa-image"></i> Ảnh đại diện</label>
						<input type="file" name="user_avatar" class="form-control mb-2" id="file-avatar" accept="image/*">
						<img src="#" id="avatar" alt="" style="width: 150px; height: 100px; ">
					</div>
					<button type="submit" class="btn btn-primary btn-login btn-change-avatar" name="btn-change-avatar">Submit</button>
				</form>
			</div>
		</div>
	</div>
</div>
<br>
<br>
<div class="container" id="product_list">
	<h1>Sản phẩm</h1>
	<div role="tabpanel" class="col-md-12 col-xs-12">
		<!-- Nav tabs -->
		<ul class="nav nav-tabs" role="tablist" id="tabs">
			<li role="presentation" class="active">
				<a href="#home" aria-controls="home" role="tab" data-toggle="tab">Sản phẩm đã hoàn thành</a>
			</li>
			<li role="presentation">
				<a href="#tab" aria-controls="tab" role="tab" data-toggle="tab">Sản phẩm đang hoàn thành</a>
			</li>
			<li role="presentation">
				<a href="#tab-1" aria-controls="tab" role="tab" data-toggle="tab">Ý tưởng</a>
			</li>
		</ul>
		<!-- Tab panes -->
		<div class="tab-content col-md-12 col-lg-12">
			<div role="tabpanel" class="tab-pane active" style="" id="home">
				<table class="table-hover " style=" width: 100%">
					<br>
					<tr>
						<td scope="col">ID</td>
						<td scope="col">Tên sản phẩm</td>
						<td scope="col" style=" width: 10%">Hình ảnh</td>
						<td scope="col">Trạng thái</td>
						<td scope="col">Hình thức</td>
						<td scope="col">Loại sản phẩm</td>
						<td scope="col">Lĩnh vực</td>
					</tr>
					<?php
						$datauser1 = mysqli_query($conn, "SELECT id_user FROM tbl_user WHERE username='" . $_SESSION["username"] . "'");
						$dt = mysqli_fetch_array($datauser1);
						$datauser2 = mysqli_query($conn, "SELECT tbl_product.product_img,tbl_product.product_name,tbl_product.id_product,tbl_product.product_form,tbl_product.product_status, tbl_topic.topic_name, tbl_type_product.type_product_name,
 							tbl_partner.partner_type from tbl_product,tbl_type_product, tbl_topic, tbl_partner where  product_form = 'Hoàn thành'
								AND tbl_product.id_type_product = tbl_type_product.id_type_product and tbl_product.id_partner = tbl_partner.id_partner AND tbl_product.id_topic = tbl_topic.id_topic and id_user = '" . $dt['id_user'] . "'");
						while($form1 = mysqli_fetch_assoc($datauser2)) {
							?>
							<tr>
								<td><?php echo $form1['id_product'] ?></td>
								<td><?php echo $form1['product_name'] ?></td>
								<td>
									<img src="../product/user_upload/<?php echo $form1['product_img'] ?>" style="width: 60px;height: 40px;">
								</td>
								<td><?php echo $form1['product_form'] ?></td>
								<td><?php echo $form1['product_status'] == 0 ? "Chưa duyệt" : "Đã duyệt" ?></td>
								<td><?php echo $form1['type_product_name'] ?></td>
								<td><?php echo $form1['topic_name'] ?></td>
								<td><a href="update_product.php?id=<?php echo $form1['id_product'] ?>">Sửa</a></td>
							</tr>
							<?php
						}
					?>
				</table>
			</div>
			<div role="tabpanel" class="tab-pane" style="margin-top: 25px;" id="tab">
				<table class=" table-hover " style="width: 100%">
					<tr>
						<td scope="col">ID</td>
						<td scope="col">Tên sản phẩm</td>
						<td scope="col" style=" width: 10%">Hình ảnh</td>
						<td scope="col">Trạng thái</td>
						<td scope="col">Hình thức</td>
						<td scope="col">Loại sản phẩm</td>
						<td scope="col">Lĩnh vực</td>
					</tr><?php
						$datauser3 = mysqli_query($conn, "SELECT tbl_product.product_img,tbl_product.product_name,tbl_product.id_product,tbl_product.product_form,tbl_product.product_status, tbl_topic.topic_name, tbl_type_product.type_product_name,
 							tbl_partner.partner_type from tbl_product,tbl_type_product, tbl_topic, tbl_partner where  product_form = 'Đang sản xuất'
								AND tbl_product.id_type_product = tbl_type_product.id_type_product and tbl_product.id_partner = tbl_partner.id_partner AND tbl_product.id_topic = tbl_topic.id_topic and id_user = '" . $dt['id_user'] . "'");
						while($form2 = mysqli_fetch_assoc($datauser3)) {
							?>
							<tr>
								<td><?php echo $form2['id_product'] ?></td>
								<td><?php echo $form2['product_name'] ?></td>
								<td>
									<img src="..product/user_upload/<?php echo $form2['product_img'] ?>" style="width: 60px;height: 40px;">
								</td>
								<td><?php echo $form2['product_form'] ?></td>
								<td><?php echo $form2['product_status'] == 0 ? "Chưa duyệt" : "Đã duyệt" ?></td>
								<td><?php echo $form2['type_product_name'] ?></td>
								<td><?php echo $form2['topic_name'] ?></td>
								<td><a href="update_product.php?id=<?php echo $form2['id_product'] ?>">Sửa</a></td>
							</tr>
							<?php
						}
					?>
				</table>
			</div>
			<div role="tabpanel" class="tab-pane" style="margin-top: 25px;" id="tab-1">
				<table class=" table-hover " style="width: 100%;">
					<tr>
						<td scope="col">ID</td>
						<td scope="col">Tên sản phẩm</td>
						<td scope="col" style=" width: 10%">Hình ảnh</td>
						<td scope="col">Trạng thái</td>
						<td scope="col">Hình thức</td>
						<td scope="col">Loại sản phẩm</td>
						<td scope="col">Lĩnh vực</td>
					</tr><?php
						$datauser4 = mysqli_query($conn, "SELECT tbl_product.product_img,tbl_product.product_name,tbl_product.id_product,tbl_product.product_form,tbl_product.product_status, tbl_topic.topic_name, tbl_type_product.type_product_name,
 							tbl_partner.partner_type from tbl_product,tbl_type_product, tbl_topic, tbl_partner where  product_form = 'Ý tưởng'
								AND tbl_product.id_type_product = tbl_type_product.id_type_product and tbl_product.id_partner = tbl_partner.id_partner AND tbl_product.id_topic = tbl_topic.id_topic and id_user = '" . $dt['id_user'] . "'");
						while($form3 = mysqli_fetch_assoc($datauser4)) {
							?>
							<tr>
								<td><?php echo $form3['id_product'] ?></td>
								<td><?php echo $form3['product_name'] ?></td>
								<td>
									<img src="../product/user_upload/<?php echo $form3['product_img']; ?>" alt="" style="width: 60px;height: 40px;">
								</td>
								<td><?php echo $form3['product_form'] ?></td>
								<td><?php echo $form3['product_status'] == 0 ? "Chưa duyệt" : "Đã duyệt" ?></td>
								<td><?php echo $form3['type_product_name'] ?></td>
								<td><?php echo $form3['topic_name'] ?></td>
								<td><a href="update_product.php?id=<?php echo $form3['id_product'] ?>">Sửa</a></td>
							</tr>
							<?php
						}
					?>
				</table>
			</div>
		</div>
		<br>
		<div class="col-md-2">
			<a class="btn btn-primary" href="../product/post.php#post_product">Đăng sản phẩm</a>
		</div>
	</div>
</div>
<br>
<br>
<br>
<div class="container" id="news_list">
	<h1>Tin tức</h1>
	<div role="tabpanel" class="col-md-12 col-xs-12">
		<!-- Nav tabs -->
		<ul class="nav nav-tabs" role="tablist">
			<li role="presentation" class="active">
				<a href="#home-1" aria-controls="home-1" role="tab" data-toggle="tab">Bài viết đã phê duyệt</a>
			</li>
			<li role="presentation">
				<a href="#tab_1" aria-controls="tab_1" role="tab" data-toggle="tab">Bài viết chưa phê duyệt</a>
			</li>
		</ul>
		<!-- Tab panes -->
		<div class="tab-content col-md-12 col-lg-12">
			<div role="tabpanel" class="tab-pane active" id="home-1">
				<table class="table-hover " style=" width: 100%" cellpadding="6px;">
					<tr>
						<td scope="col">ID</td>
						<td scope="col" style="width: 10%;">Tiêu đề</td>
						<td scope="col" style="width: 10%;">Hình ảnh</td>
						<td scope="col" style="width: 55%;">Nội dung</td>
						<td scope="col" style="width: 10%;">Trạng thái</td>
						<td scope="col" style="width: 20%;">Tác giả</td>
					</tr>
					<?php $query = mysqli_query($conn, "SELECT * FROM tbl_news where news_status = 1 and id_user = '" . $dt['id_user'] . "' ");
						while($row_n2 = mysqli_fetch_assoc($query)) {

							?>
							<tr>
								<td><?php echo $row_n2['id_news'] ?></td>
								<td><?php echo $row_n2['news_title'] ?></td>
								<td>
									<img src="../assets/img/<?php echo $row_n2['news_img'] ?>" style="width: 60px;height: 40px;">
								</td>
								<td style="text-align: justify"><?php echo $row_n2['news_content'] ?></td>
								<td style="text-align: justify"><?php echo $row_n2['news_status'] == 1 ? "Đã duyệt" : "Chưa duyệt"; ?></td>
								<td style="text-align: center"><?php echo $row_n2['news_author'] ?></td>
								<td><a href="update_news.php?id=<?php echo $row_n2['id_news'] ?>">Sửa</a></td>
							</tr>
						<?php } ?>
				</table>
			</div>
			<div role="tabpanel" class="tab-pane" id="tab_1">
				<table class="table-hover " style=" width: 100%" cellpadding="5px;">
					<tr>
						<td scope="col">ID</td>
						<td scope="col" style="width: 10%;">Tiêu đề</td>
						<td scope="col" style="width: 10%;">Hình ảnh</td>
						<td scope="col" style="width: 55%;">Nội dung</td>
						<td scope="col" style="width: 10%;">Trạng thái</td>
						<td scope="col" style="width: 50%;">Tác giả</td>
					</tr>
					<?php $query = mysqli_query($conn, "SELECT * FROM tbl_news where news_status = 0 and id_user = '" . $dt['id_user'] . "' ");
						while($row_n1 = mysqli_fetch_assoc($query)) {

							?>
							<tr>
								<td><?php echo $row_n1['id_news'] ?></td>
								<td><?php echo $row_n1['news_title'] ?></td>
								<td>
									<img src="../assets/img/<?php echo $row_n1['news_img'] ?>" style="width: 60px;height: 40px;">
								</td>
								<td style="text-align: justify"><?php echo $row_n1['news_content'] ?></td>
								<td style="text-align: justify"><?php echo $row_n1['news_status'] == 1 ? "Đã duyệt" : "Chưa duyệt"; ?></td>
								<td style="text-align: center"><?php echo $row_n1['news_author'] ?></td>
								<td><a href="update_news.php?id=<?php echo $row_n1['id_news'] ?>">Sửa</a></td>
							</tr>
						<?php } ?>
				</table>
			</div>
		</div>
		<div class="col-md-2">
			<a class="btn btn-primary" href="../news/post_news.php">Đăng tin tức</a>
		</div>
	</div>
</div>
<br>
<br>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/localization/messages_vi.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#change_password").validate({
            rules: {
                renewpwd: {
                    equalTo: "#newpwd"
                }
            },
            lang: "vi"
        });
        $('.upload-success').delay(3000).fadeOut();
    });

    function readURL1(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#avatar').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#file-avatar").change(function () {
        readURL1(this);
    });
</script>
<script>
    $(document).ready(function () {
        $("#update_news").fadeOut(3000);
        $("#update_product").fadeOut(3000);

    });
</script>
<?php require "../footer.php" ?>