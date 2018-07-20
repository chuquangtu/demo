<?php
	session_start();
	if(isset($_SESSION["islogin"])){}
	else header("location: login.php");
	require '../libs/config.php';
	connect_db();
	if(isset($_GET['id']))
		$query_product = mysqli_query($conn, "select * from tbl_product where id_product = '" . $_GET['id'] . "'");
	$title = "Chỉnh sửa sản phẩm";
	require '../header.php';
?>
<div class="container">
	<h2>Sửa tin tức</h2>
	<form action="xl_update_product.php" method="POST" style="font-size: x-large">
		<table class="table-hover" >
			<?php while($row_product = mysqli_fetch_assoc($query_product))
			{
				?>
				<tr>
					<td><label>ID</label></td>
					<td><input type="text" value="<?php echo $row_product['id_product']?>" name="id" class="btn btn-outline-secondary m-2"></td>
				</tr>
				<tr>
					<td style="width: 20%"><label>Tên sản phẩm</label></td>
					<td><input type="text" value="<?php echo $row_product['product_name']?>" name="name" class="btn btn-outline-secondary m-2" ></td>
				</tr>
				<tr>
					<td>Tác giả</td>
					<td><input type="text" value="<?php echo $row_product['product_author']?>" name="author" class="btn btn-outline-secondary m-2" ></td>
				</tr>
				<tr>
					<td>Tình trạng</td>
					<td><input type="text" value="<?php echo $row_product['product_form']?>" name="form" class="btn btn-outline-secondary m-2"  ></td>
				</tr>
				<tr>
					<td>Sở hữu trí tuệ</td>
					<td><input type="text" value="<?php
							echo $row_product['product_license']== "1" ? "Có" : "Không" ?>" name="license" class="btn btn-outline-secondary m-2" ></td>
				</tr>
				<tr>
					<td>Nội dung</td>
					<td><textarea style="text-align: justify" name="content" id="product_content"><?php echo $row_product['product_content']?>"</textarea></td>
				</tr>

			<?php } ?>
			<tr>
				<td></td>
				<td><button type="submit" class="btn btn-success m-3">Sửa</button></td>
			</tr>
		</table>
	</form>
</div>
<script type="text/javascript" src="../assets/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="../assets/ckeditor/ckfinder/ckfinder.js"></script>
<script type="text/javascript">
    CKEDITOR.replace( 'product_content');
</script>