<?php
	require '../libs/config.php';
	connect_db();
	session_start();
	require '../header.php';
	if(isset($_POST['key_words']))
		$key = mysqli_real_escape_string($conn, trim($_POST['key_words']));
		$sql = "select * from tbl_product where product_name like '%$key%'";
		$query2 = mysqli_query($conn, $sql);


?>
<div class="container" id="area">
	<div class="col-md-12" id="KHTN"><h2 style="text-decoration: underline; color: #808080">Sản Phẩm</h2></div>
	<div class="row">
		<?php
			while($row1 = mysqli_fetch_array($query2)) {
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
</div>
<?php require'../footer.php' ?>
