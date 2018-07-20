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
<a class="btn btn-primary" data-toggle="modal" href='#modal-id'>Trigger modal</a>
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
				<button type="submit" class="btn btn-danger" data-dismiss="modal">Xem</button>
			</div>
			</form>
			<br>
		</div>
	</div>
</div>
<!--	<script>-->
<!--        $(document).ready(function(){-->
<!--            $('#myModal').show();-->
<!--            $('.close').click( function(){-->
<!--                $('.modal').hide();-->
<!--            });-->
<!--        });-->
<!--	</script>-->
<?php }?>
<div class="container" style="max-width: 1500px;">
		<div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
			<!-- <script type="text/javascript" src="assets/js/jquery-1.9.1.min.js"></script> -->
			<script type="text/javascript" src="assets/js/jssor.core.js"></script>
			<script type="text/javascript" src="assets/js/jssor.utils.js"></script>
			<script type="text/javascript" src="assets/js/jssor.slider.js"></script>
			<script type="text/javascript" src="assets/js/script.min.js"></script>
			<div class="img-responesive" id="sliderb_container" style="position: relative; width:1366px;
			height: 500px;">
				<div u="loading" style="position: absolute; top: 0; left: 0;">
					<div style="filter: alpha(opacity=70); opacity:0.7; position: absolute; display: block;
				background-color: #000; top: 0; left: 0;width: 100%;height:100%;">
					</div>
					<div style="position: absolute; display: block; background: url(assets/img/loading.gif) no-repeat center center;
			top: 0; left: 0;width: 100%;height:100%;">
					</div>
				</div>
				<!-- Slides Container -->
				<div class="img-responesive" u="slides" style="cursor: move; position: absolute; left: 0px; top: 0px; width:1366px; height: 500px;
				overflow: hidden;">
					<div>
						<img u=image src="assets/img/004.jpg"/>
						<div u="thumb">Do you notice it is draggable by mouse/finger?</div>
					</div>
					<div>
						<img u=image src="assets/img/BANNER.png"/>
						<div u="thumb">Did you drag by either horizontal or vertical?</div>
					</div>
					<div>
						<img u=image src="assets/img/banner1.png"/>
						<div u="thumb">Do you notice navigator responses when drag?</div>
					</div>
					<div>
						<img u=image src="assets/img/007.jpg"/>
						<div u="thumb">Do you notice arrow responses when click?</div>
					</div>
				</div>
				<!-- ThumbnailNavigator Skin Begin -->
				<div u="thumbnavigator" class="sliderb-T" style="position: absolute; bottom: 0px; left: 0px; height:45px; width:1366px;">
					<div style="filter: alpha(opacity=40); opacity:0.4; position: absolute; display: block;
	background-color: #000000; top: 0; left: 0; width: 100%; height: 100%;">
					</div>
					<!-- Thumbnail Item Skin Begin -->
					<div u="slides">
						<div class="img-responesive" u="prototype" style="POSITION: absolute; WIDTH:1366px; HEIGHT: 45px; TOP: 0; LEFT: 0;">
							<thumbnailtemplate style="font-family: verdana,sans-serif; font-weight: normal; POSITION: absolute; WIDTH: 100%; HEIGHT: 100%; TOP: 0; LEFT: 0; color:#fff; line-height: 45px; font-size:20px; padding-left:10px;"></thumbnailtemplate>
						</div>
					</div>
					<!-- Thumbnail Item Skin End -->
				</div>
				<!-- ThumbnailNavigator Skin End -->
				<!-- navigator container -->
				<div u="navigator" class="jssorn01" style="position: absolute; bottom: 16px; right: 10px;">
					<!-- navigator item prototype -->
					<div u="prototype" style="POSITION: absolute; WIDTH: 12px; HEIGHT: 12px;"></div>
				</div>
				<!-- Navigator Skin End -->
				<span u="arrowleft" class="jssord05l" style="width: 40px; height: 40px; top: 240px; left: 8px;">
</span>
				<!-- Arrow Right -->
				<span u="arrowright" class="jssord05r" style="width: 40px; height: 40px; top: 240px; right: 8px">
</span>
			</div>
		</div>
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