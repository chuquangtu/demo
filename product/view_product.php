<?php
	require '../libs/config.php';
	connect_db();
	session_start();
	if(isset($_GET['id'])) {
		$product_id = $_GET['id'];
	} else {
		header("location: index.php");
	}
	$sql = "select * from tbl_product where id_product = '$product_id'";
	$query = mysqli_query($conn, $sql);
	$data = mysqli_fetch_assoc($query);
	$title = $data["product_name"];
	if(strlen($data["product_content"]) >= 50) {
		$metadesc = strip_tags($data["product_content"]);
	} else {
		$metadesc = strip_tags(substr($data["product_content"], 0, 50) . '...');
	}
	$metaimg = $data["product_img"];
	require "../header.php";
?>
<div class="container">
	<form>
		<div class=" col-md-12 col-lg-12 search">
			<div class="row">
				<div class="col-md-4 col-lg-4 col-xs-4">
					<input class="form-control mr-sm-2 mt-2 form-search" type="search" placeholder="Search" aria-label="Search" id="search" style="width: 70%; float: left;">
					<button class="btn btn-outline-danger my-2 mt-1 ml-2" style="float: left;" type="submit">
						<i class="fa fa-search"></i>
					</button>
				</div>
			</div>
		</div>
	</form>
</div>
<br>
<div class="container">
		<div class="col-md-12" style="margin-left:15px;">
			<h1><?php echo $data['product_name']; ?></h1>
		</div>
		<div class="col-md-12 " >
			<div class="col-md-12" style="text-align: justify; ">
			<?php echo $metadesc; ?>
				
			</div>
				<div class="col-md-3 " style="float: right;"><i><?php echo $data['product_author']; ?></i>
			</div>
		</div>
		<br>
		<br>
		<div class="col-md-8">
			<table class="table">
				<tr>
					<th>Tác giả</th>
					<td><?php echo $data['product_author'] ?></td>
					<th>Lĩnh vực</th>
					<td><?php
							$topic_name = mysqli_fetch_assoc(mysqli_query($conn, "SELECT topic_name FROM tbl_topic WHERE id_topic = '" . $data['id_topic'] . "'"));
							echo $topic_name["topic_name"];
						?></td>
				</tr>
				<tr>
					<th>Trạng thái sản phẩm</th>
					<td><?php echo $data['product_form'] ?></td>
					<th>Loại sản phẩm</th>
					<td><?php
							$type_prd_name = mysqli_fetch_assoc(mysqli_query($conn, "SELECT type_product_name FROM tbl_type_product WHERE id_type_product = '" . $data['id_type_product'] . "'"));
							echo $type_prd_name["type_product_name"];
						?></td>
				</tr>
			</table>
		</div>
	</div>
<?php require '../footer.php' ?>
