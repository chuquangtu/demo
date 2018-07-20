<?php
	session_start();
	if(isset($_SESSION["islogin"])) {
		if($_SESSION["user_role"] == "member") header("location: ../index.php");
	} else header("location: ../account/login.php");
	require '../libs/config.php';
	connect_db();
	if(isset($_GET['update_news_success'])) if($_GET["update_news_success"]) {
		echo '<div class="alert alert-primary fade show mx-auto" role="alert" id="update_news" style="text-align: center;">Sửa tin tức thành công</div>';
	}
	if(isset($_GET['delete_prd_success'])) if($_GET["delete_prd_success"]) {
		echo '<div class="alert alert-primary fade show mx-auto" role="alert" id="delete_prd" style="text-align: center;">Xóa sản phẩm thành công</div>';
	}
	if(isset($_GET['delete_news_success'])) if($_GET["delete_news_success"]) {
		echo '<div class="alert alert-primary fade show mx-auto" role="alert" id="delete_news" style="text-align: center;">Xóa tin tức thành công</div>';
	}
	require '../header.php';
?>
	<div class="col-xl-12">
		<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
			<li class="nav-item d-flex justify-content-between align-items-center" style="margin: 5px;">
				<a class="nav-link active" id="pills-member-tab" data-toggle="pill" href="#member" role="tab" aria-controls="pills-member" aria-selected="true" style="padding:5px;">Thành viên
					<?php
						$slmember = 0;
						$slmember = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tbl_user_info "));
						if($slmember > 0) echo '
				<span class="badge badge-danger badge-pill">' . $slmember . '</span>' ?></a>
			</li>
			<li class="nav-item d-flex justify-content-between align-items-center" style="margin: 5px;">
				<a class="nav-link" id="pills-product-tab" data-toggle="pill" href="#product" role="tab" aria-controls="pills-product" aria-selected="false" style="padding:5px;">Sản phẩm
					<?php
						$slproduct = 0;
						$slproduct = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tbl_product where product_status=0"));
						if($slproduct > 0) echo '
				<span class="badge badge-danger badge-pill">' . $slproduct . '</span>' ?></a>
			</li>
			<li class="nav-item d-flex justify-content-between align-items-center" style="margin: 5px;">
				<a class="nav-link" id="pills-news-tab" data-toggle="pill" href="#news" role="tab" aria-controls="pills-news" aria-selected="false" style="padding:5px;">Tin tức
					<?php
						$slnews = 0;
						$slnews = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tbl_news where news_status=0"));
						if($slnews > 0) echo '
				<span class="badge badge-danger badge-pill">' . $slnews . '</span>' ?></a>
			</li>
			<li class="nav-item d-flex justify-content-between align-items-center">
				<a class="nav-link" id="pills-introduction-tab" data-toggle="pill" href="#introduction" role="tab" aria-controls="pills-introduction" aria-selected="false" style="padding:5px;">Giới thiệu</a>
			</li>
			<li class="nav-item d-flex justify-content-between align-items-center" style="margin: 5px;">
				<a class="nav-link" id="pills-menu-tab" data-toggle="pill" href="#menu" role="tab" aria-controls="pills-menu" aria-selected="false" style="padding:5px;">Menu</a>
			</li>
		</ul>
		<div class="tab-content" id="pills-tabContent">
			<div class="tab-pane fade show active" id="member" role="tabpanel" aria-labelledby="pills-member-tab">
				<div class="input-group col justify-content-end mb-2">
					<div class="input-group-prepend">
				        <span class="input-group-text" id="searchproducticon">
							<i class="fa fa-search fa-flip-horizontal" aria-hidden="true"></i>
				        </span>
					</div>
					<input type="text" class="form-control col-4" placeholder="Tìm kiếm thành viên" id="searchmember"
					       aria-describedby="searchmember">
				</div>
				<?php
					$query_mem = mysqli_query($conn, "select tbl_user_info.*, tbl_user.username from tbl_user_info, tbl_user WHERE tbl_user_info.id_user = tbl_user.id_user");
					$data_mem = array();
					while($row_mem = mysqli_fetch_assoc($query_mem)) $data_mem[] = $row_mem;
				?>
				<table class="table table-hover table-bordered tbl_user_info">
					<thead>
					<tr>
						<th scope="col">ID</th>
						<th scope="col" style="width: 20%;">Fullname</th>
						<th scope="col" style="width: 10%;">Giới tính</th>
						<th scope="col" style="width: 5%;">Email</th>
						<th scope="col">Số điện thoại</th>
						<th scope="col" style="width: 20%;">Hình ảnh</th>
						<th scope="col" style="width: 10%;">Username</th>
					</tr>
					</thead>
					<tbody>
					<?php
						foreach($data_mem as $item_mem) {
							?>
							<tr>
								<td scope="row"><?php echo $item_mem["id_user_info"] ?></td>
								<td><?php echo $item_mem["full_name"] ?></td>
								<td><?php echo $item_mem["gender"] == "m" ? "Nam" : "Nữ"; ?></td>
								<td><?php echo $item_mem["email"] ?></td>
								<td><?php echo 0 . $item_mem["phone"] ?></td>
								<td>
									<img src="<?php echo getdomain() . './product/user_upload/' . $item_mem["avatar"] ?>" width="100px">
								</td>
								<td><?php echo $item_mem["username"] ?></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
			<div class="tab-pane fade" id="product" role="tabpanel" aria-labelledby="pills-product-tab">
				<div class="input-group col justify-content-end mb-2">
					<div class="input-group-prepend">
				        <span class="input-group-text" id="searchproducticon">
							<i class="fa fa-search fa-flip-horizontal" aria-hidden="true"></i>
				        </span>
					</div>
					<input type="text" class="form-control col-4" placeholder="Tìm kiếm sản phẩm" id="searchproduct"
					       aria-describedby="searchproducticon">
				</div>
				<?php
					$query = mysqli_query($conn, "SELECT * FROM  tbl_product where product_status = 1 || product_status = 0 ");
					$data = array();
					while($row = mysqli_fetch_assoc($query)) $data[] = $row;
				?>
				<table class="table table-hover table-bordered tbl_product">
					<thead>
					<tr>
						<th scope="col">ID</th>
						<th scope="col" style="width: 20%;">Tên sản phẩm</th>
						<th scope="col" style="width: 10%;">Tác giả</th>
						<th scope="col" style="width: 5%;">Trạng thái</th>
						<th scope="col" style="width: 20%;">Hình ảnh</th>
						<th scope="col">Nội dung</th>
						<th scope="col" style="width: 10%;">Xét duyệt</th>
					</tr>
					</thead>
					<tbody>
					<?php foreach($data as $item) { ?>
						<tr>
							<td scope="row"><?php echo $item["id_product"] ?></td>
							<td><?php echo $item["product_name"] ?></td>
							<td><?php echo $item["product_author"] ?></td>
							<td><?php echo $item["product_status"] == 0 ? "Chưa duyệt" : "Đã duyệt" ?></td>
							<td>
								<img src="<?php echo getdomain() . '/product/user_upload/' . $item["product_img"] ?>" width="100px">
							</td>
							<td><?php echo $item["product_content"] ?></td>
							<td>
								<script>
                                    function confirmq() {
                                        return confirm('Duyệt bài này?');
                                    }
								</script>
								<?php
									if($item["product_status"] == 0) echo '<form method="post" action="duyetsp.php">
												<button type="submit" class="btn btn-primary m-2" name="ansp"></a>Ẩn</button>
												<input type="hidden" value="' . $item["id_product"] . '" name="id_product">
												<button type="submit" class="btn btn-success" onclick="confirmq();">Duyệt</button>
											</form>'; ?>
							</td>
							<?php if($_SESSION["user_role"] == "admin") echo '
								<td><a href="delete_product.php?id=' . $item["id_product"] . '">Xóa</a></td>' ?>
						</tr>
					<?php } ?>
					</tbody>
				</table>
			</div>
			<div class="tab-pane fade" id="news" role="tabpanel" aria-labelledby="pills-news-tab">
				<div class="input-group col justify-content-end mb-2">
					<div class="input-group-prepend">
				        <span class="input-group-text" id="searchnewsicon">
							<i class="fa fa-search fa-flip-horizontal" aria-hidden="true"></i>
				        </span>
					</div>
					<input type="text" class="form-control col-4" placeholder="Tìm kiếm sản phẩm" id="searchnews"
					       aria-describedby="searchproducticon">
				</div>
				<?php
					$query_n = mysqli_query($conn, "SELECT * FROM  tbl_news where news_status = 0 || news_status = 1");
					$data_n = array();
					while($row_n = mysqli_fetch_assoc($query_n)) $data_n[] = $row_n;
				?>
				<table class="table table-hover table-bordered tbl_news">
					<thead>
					<tr>
						<th scope="col">ID</th>
						<th scope="col" style="width: 20%;">Tên bài viết</th>
						<th scope="col" style="width: 10%;">Hình ảnh</th>
						<th scope="col" style="width: 5%;">Trạng thái</th>
						<th scope="col" style="width: 20%;">Tác giả</th>
						<th scope="col">Nội dung</th>
						<th scope="col" style="width: 10%;">Xét duyệt</th>
					</tr>
					</thead>
					<tbody>
					<?php foreach($data_n as $item_n) { ?>
						<tr>
							<td scope="row"><?php echo $item_n["id_news"] ?></td>
							<td><?php echo $item_n["news_title"] ?></td>
							<td>
								<img class="img-responsive" src="<?php echo getdomain() . '/assets/img/' . $item_n["news_img"] ?>" width="100px">
							</td>
							<td><?php echo $item_n["news_status"] == 0 ? "Chưa duyệt" : "Đã duyệt" ?></td>
							<td><?php echo $item_n["news_author"] ?></td>
							<td><?php echo $item_n["news_content"] ?></td>
							<td>
								<script>
                                    function confirmq() {
                                        return confirm('Duyệt bài này?');
                                    }
								</script>
								<?php
									if($item_n["news_status"] == 0) echo '<form method="post" action="duyetnews.php">
												<button type="submit" class="btn btn-primary m-2" name="annews"></a>Ẩn</button>
												<input type="hidden" value="' . $item_n["id_news"] . '" name="id_news">
												<button type="submit" class="btn btn-success" onclick="confirmq();">Duyệt</button>
											</form>';
								?>
							</td>
							<?php if($_SESSION["user_role"] == "admin") {
								echo '<td><a href="update_news.php?id=' . $item_n["id_news"] . '">Sửa</a></td>
								<td><a href="delete_news.php?id=' . $item_n["id_news"] . '">Xóa</a></td>';
							} ?>
						</tr>
					<?php } ?>
					</tbody>
				</table>
			</div>
			<div class="tab-pane fade" id="introduction" role="tabpanel" aria-labelledby="pills-introduction-tab">...</div>
			<div class="tab-pane fade" id="menu" role="tabpanel" aria-labelledby="pills-menu-tab">
				<div class="container">
					<div class="col-md-12">
						<div class="row">
							<div class="col-md-8">
								<table class="table table-hover tbl_menu_lv1">
									<thead>
									<tr>
										<th>ID</th>
										<th>Tên menu</th>
									</tr>
									</thead>
									<tbody>
									<?php $menu1 = mysqli_query($conn, "select * from tbl_menu_lv1 ");
										while($row_menu1 = mysqli_fetch_assoc($menu1)) {
											?>
											<tr>
												<td><?php echo $row_menu1['id_menu1'] ?></td>
												<td><?php echo $row_menu1['name_menu1'] ?></td>
												<td><a href="#">Sửa</a></td>
												<td><a href="#">Xóa</a></td>
											</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
							<div class="col-md-4">
								<button class="btn btn-danger">Thêm</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script>
        $("#searchproduct").keyup(function () {
            _this = this;
            $.each($(".tbl_product tbody tr"), function () {
                if ($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
                    $(this).hide();
                else
                    $(this).show();
            });
        });
        $("#searchnews").keyup(function () {
            _this = this;
            $.each($(".tbl_news tbody tr"), function () {
                if ($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
                    $(this).hide();
                else
                    $(this).show();
            });
        });
	</script>
	<script>
        $(document).ready(function () {
            $("#update_news").fadeOut(3000);
            $("#delete_prd").fadeOut(3000);
            $("#delete_news").fadeOut(3000);
        });
	</script>
<?php
	require "../footer.php"
?>