<?php
require '../libs/config.php';
connect_db();
session_start();
$result_topic =mysqli_query($conn, "select * from tbl_topic");
$result_partner = mysqli_query($conn, "select * from tbl_partner");
$sql = "SELECT * FROM tbl_product WHERE product_status = 1";
$query = mysqli_query($conn, $sql);
$total = mysqli_num_rows($query);
$per_page = 8;
$num_of_page = ceil($total / $per_page);
if(!isset($_GET['page'])) {
	$_GET['page'] = 1;
	$start = 0;
} else {
	$start = ($_GET['page'] - 1) * $per_page;
}
$sql2 = "SELECT * FROM tbl_product where product_status = 1 ORDER BY id_product DESC LIMIT $start,$per_page ";
$query2 = mysqli_query($conn, $sql2);
$title = "Sản phẩm";
$metadesc = "Sản phẩm về khoa học công nghệ mới nhất!";
require '../header.php';
?>
<div class="container">
	<form action="search_product.php" method="POST">
		<div class=" col-md-12 col-lg-12 search">
			<div class="row">
				<div class="col-md-4 col-lg-4 col-xs-4">
					<input class="form-control mr-sm-2 mt-2 form-search" name="key_words" type="search" placeholder="Search" aria-label="Search" id="search" style="width: 70%; float: left;">
					<button class="btn btn-outline-danger my-2 mt-1 ml-2" id="search_keywords" style="float: left;" type="submit">
						<i class="fa fa-search"></i>
					</button>	
				</div>
			</div>
		</div>
	</form>
	<div class="col-md-3 col-lg-3 col-xs-3">
		<a class="btn btn-primary" data-toggle="modal" href='#modal-id'>Tìm kiếm nhanh</a>
		<div class="modal fade" id="modal-id">
			<div class="modal-dialog" style="color: ">
				<div class="modal-content" style=" background:#f1f1f1 ;">
					<!-- Modal Header -->
					<div class="modal-header">
						<h4 class="modal-title">Sản phẩm bạn muốn tìm kiếm là gì ?</h4>
						<button type="submit" id="active_matching" class="close" data-dismiss="modal">&times;</button>
					</div>

					<!-- Modal body -->
					<form action="matching.php" method="POST">
						<div>
							<div class="col-md-12 col-lg-12">
								<div class="row">
									<div class="col-md-4 col-lg-4">
										<label><h5>Trạng thái</h5></label>
										<select class="btn btn-light" id="product_form" name="product_form">
											<option value="Hoàn thành">Hoàn thành</option>
											<option value="Đang sản xuất">Đang sản xuất</option>
											<option value="Ý tưởng">Ý tưởng</option>
										</select>
									</div>
									<div class="col-md-4 col-lg-4" >
										<label><h5>Loại đầu tư</h5></label>
										<select class=" btn btn-light" id="partner_type" name="partner_type">
											<?php while($row_partner = mysqli_fetch_assoc($result_partner)){ ?>
											<option value="<?php echo $row_partner['id_partner']?>"><?php echo $row_partner['partner_type']?></option>
											<?php }?>
										</select>

									</div>
								</div>
								<div class="col-md-12 col-lg-12" style="margin: 15px 0 0 -15px;">
									<label><h5>Lĩnh vực</h5></label>
									<br>
									<select class=" btn btn-light" id="topic_name" name="topic_name">
										<?php while($row_topic = mysqli_fetch_assoc($result_topic)) {?>
										<option value="<?php echo $row_topic['id_topic']?>"><?php echo $row_topic['topic_name']?></option>
										<?php }?>
									</select>
								</div>
							</div>
						</div>
						<br>
						<div class="col-md-4 col-lg-4">
							<button type="submit" class="btn btn-danger">Xem</button>
						</div>
					</form>
					<br>
				</div>
			</div>
		</div>
	</div>
</div>
<br>
<div class="container" id="area">
	<div class="col-md-12" id="KHTN"><h2 style="text-decoration: underline; color: #808080">Sản Phẩm</h2></div>
	<div class="row">
		<?php
		while($row1 = mysqli_fetch_array($query2)) {
			$tensp = unicode_convert($row1["product_name"]);
			?>

			<div class="col-md-6 col-lg-3 product" style="margin-top: 20px;">
				<div class="thumbnail prd ">
					<a href="<?php echo "view_product.php?id=" . $row1["id_product"] ?>">
						<img src="user_upload/<?php echo $row1['product_img'] ?>" alt="" class="img-responsive"
						style="height:150px; width:180px;"></a>
						<div class="caption">
							<br>
							<h6>
								<a class="title_product" href="<?php echo "view_product.php?id=" . $row1["id_product"] ?>" title="<?php echo $row1['product_name']; ?>"><?php echo $row1['product_name']; ?></a>
							</h6>
							<p>
								<a href="<?php echo "view_product.php?id=" . $row1["id_product"] ?>" class="btn btn-outline-primary" role="button">Xem</a>
								<a href="#" class="btn btn-outline-secondary" role="button">Quan tâm</a></p>
							</div>
						</div>
					</div>
					<?php
				}
				?>
			</div>
			<nav aria-label="Page navigation example" style="margin-top: 20px;">
				<ul class="pagination">
					<?php
					if($_GET['page'] > 1) {
						$first = 1;
						?>
						<li class="page-item">
							<a class="page-link" href="product.php?page=<?php echo $first ?>">Trước</a></li>
							<?php
						}
						?>
						<?php
						for($i = 1; $i <= $num_of_page; $i++) {
							if($_GET['page'] == $i) {
								?>
								<li class="page-item">
									<a class="page-link" href="product.php?page=<?php echo $i ?>"><?php echo $i ?></a></li>
									<?php
								} else {
									?>
									<li class="page-item">
										<a class="page-link" href="product.php?page=<?php echo $i ?>"><?php echo $i ?></a></li>
										<?php
									}
								}
								?>
								<?php if($_GET['page'] < $num_of_page) {
									$last = $num_of_page;
									?>
									<li class="page-item"><a class="page-link" href="product.php?page=<?php echo $last ?>">Cuối</a></li>
									<?php
								}
								?>
							</ul>
						</nav>
					</div>

					<script type="text/javascript">
						$(document).ready(function () {
							$(".title_product").tooltip();
						});
					</script>
					<?php require '../footer.php'; ?>
					<script type="text/javascript">
						$(document).ready(function () {
							$("#search_keywords").click(function(){
								$("#area").load("search_product.php#area");
							});
						});
					</script>

