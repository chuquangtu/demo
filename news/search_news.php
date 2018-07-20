<?php
	require '../libs/config.php';
	connect_db();
	session_start();
	require '../header.php';
	if(isset($_POST['keywords_news'])) {
	$keywords = mysqli_real_escape_string($conn, trim($_POST['keywords_news']));
	$sql = "select * from tbl_news where news_title like '%$keywords%'";
	$query3 = mysqli_query($conn, $sql);
	}

?>
<div class="container" id="area">
	<h1 style="margin-left: 15px; text-decoration: underline; color:#01315F">Tin Tức</h1>
	<br>
	<br>
	<div class="row">
		<div class="col-md-12 col-lg-9 col-xs-12 "  style="height: 200px;">
			<div class="row">
				<?php while($row_s = mysqli_fetch_assoc($query3)) { ?>
					<div class="col-md-6 col-lg-3 news-1 n-<?php echo $row_s['id_news'] ?>" style="height: 170px;">
						<div class="thumbnail news">
							<div class="img_news" style="text-align: center;">
								<a class="img-responsive" href="view_news.php?id=<?php echo $row_s['id_news'] ?>"><img src="../assets/img/<?php echo $row_s['news_img'] ?>"></a>
							</div>
							<a href="view_news.php?id=<?php echo $row_s['id_news'] ?>" class="eye-<?php echo $row_s['id_news'] ?>">
								<i class="fa fa-eye " id="eye" title="<?php echo $row_s['news_title'] ?>" style="font-size: 22px; position: absolute"></i>
							</a>
							<h6>
								<a href="view_news.php?id=<?php echo $row_s['id_news'] ?>" title="<?php echo $row_s['news_title'] ?>"><?php echo $row_s['news_title'] ?> </a>
								<p><i class="fa fa-calendar"></i> <?php echo $row_s['create_date'] ?></p>
							</h6>
						</div>
					</div>
					<script type="text/javascript">
                        $(document).ready(function () {
                            $(".fa-eye").tooltip();
                            $("h6 a").tooltip();
                            $(".n-<?php echo $row_s['id_news'] ?>").hover(function () {
                                $(".eye-<?php echo $row_s['id_news'] ?> i").show();
                            }, function () {
                                $(".eye-<?php echo $row_s['id_news'] ?> i").hide();
                            });
                        });
					</script>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
<?php require '../footer.php'; ?>
