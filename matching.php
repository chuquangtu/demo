<?php
	require './libs/config.php';
	session_start();
	connect_db();
	require 'header.php';
	if(isset($_SESSION["islogin"]))
		if(isset($_POST['product_form'],$_POST['partner_type'],$_POST['topic_name'])){
			$_topic =$_POST['topic_name'];
			$_partner =$_POST['partner_type'];
			$_product = $_POST['product_form'];
			$result_maching= mysqli_query($conn, "select * from tbl_product where product_form='.$_topic.' and id_partner= '.$_partner.' and id_topic = '$_topic.'"  );
			echo $result_maching;
	}else{
			echo "khong co bien";
		}
?>
<div class="container">
	<div class="col-md-12">
		<h2 style="text-decoration: underline; color: #808080">Sản phẩm mới</h2>
	</div>
	<div class="row">
		<?php while($row = mysqli_fetch_assoc($result_maching)){ ?>
			<div class="col-md-6 col-lg-3 product">
				<div class="thumbnail prd ">
					<a href="product/view_product.php?id=<?php echo $row['id_product'] ?>">
						<img src=" ./product/user_upload/<?php echo $row['product_img'] ?>" alt="" class="img-responsive" style
						="height:150px; width:180px;"></a>
					<div class="caption">
						<br>
						<h6><a class="product_name" href="product/view_product.php?id=<?php echo $row['id_product'] ?>" title="<?php echo $row['product_name']?>"><?php echo $row['product_name']?></a></h6>
						<p><a href="product/view_product.php?id=<?php echo $row['id_product'] ?>" class="btn btn-outline-primary" role="button">Xem</a>
							<a href="#" class="btn btn-outline-secondary" role="button">Quan tâm</a></p>
					</div>
				</div>

			</div>
		<?php } ?>
	</div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $(".product_name").tooltip();
    });
</script>
