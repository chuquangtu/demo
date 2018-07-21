<?php
	require './libs/config.php';
	session_start();
	connect_db();
	require 'header.php';
	$query = mysqli_query($conn, "SELECT * FROM tbl_product where product_status = 1 ORDER BY id_product DESC  limit 0,4  ");
?>
<?php if(isset($_SESSION["islogin"])) {
	$result_topic =mysqli_query($conn, "select * from tbl_topic");
	$result_partner = mysqli_query($conn, "select * from tbl_partner");

?>
<style type="text/css">
	@media screen and (min-width: 500px;){
		.navbar{
			height: 130px;
	}
}
</style>
<!--	<script>-->
<!--        $(document).ready(function(){-->
<!--            $('#myModal').show();-->
<!--            $('.close').click( function(){-->
<!--                $('.modal').hide();-->
<!--            });-->
<!--        });-->
<!--	</script>-->
<?php }?>

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.min.js"></script>

	<script>
        $(document).ready(function(){
            $('.slider').bxSlider();
        });
	</script>

	<body>

	<div class="slider" style="margin: 0px" >
		<div><img style="width: 100%" src="<?php echo getdomain(); ?>/assets/img/01.jpg"></div>
		<div><img style="width: 100%" src="<?php echo getdomain(); ?>/assets/img/02.jpg"></div>
		<div><img style="width: 100%" src="<?php echo getdomain(); ?>/assets/img/03.jpg"></div>
		<div><img style="width: 100%" src="<?php echo getdomain(); ?>/assets/img/04.jpg"></div>
	</div>

<br>
<div class="container">
	<div class="col-md-12">
		<h2 style="text-decoration: underline; color: #808080">Sản phẩm mới</h2>
	</div>
	<div class="row">
		<?php while($row = mysqli_fetch_assoc($query)) { ?>
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
			<?php
		}
		?>
	</div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $(".product_name").tooltip();
    });
</script>


<?php require'footer.php';?>

<br>
<br>