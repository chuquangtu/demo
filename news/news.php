<?php
	require '../libs/config.php';
	connect_db();
	session_start();
	$query2 = mysqli_query($conn, "select * from tbl_news where news_status = 1 ");
	$total = mysqli_num_rows($query2);
	$per_page = 4;
	$num_of_page = ceil($total / $per_page);
	if(!isset($_GET['page'])) {
		$_GET['page'] = 1;
		$start = 0;
	} else {
		$start = ($_GET['page'] - 1) * $per_page;
	}
	$query3 = mysqli_query($conn, "select * from tbl_news where news_status = 1 limit $start, $per_page ");
	$query1 = mysqli_query($conn, "select * from tbl_news where news_hot = 1 and news_status = 1 order by id_news DESC limit 0,5");
	$title = "Tin tức";
	$metadesc = "Tin tức về khoa học công nghệ mới nhất!";
	require '../header.php';
?>
<style>
	body{
		background:#047AC4;
	}
</style>
<div class="container">
	<form method="POST" action="search_news.php">
		<div class=" col-md-12 col-lg-12 search" id="area">
			<div class="row">
				<div class="col-md-4 col-lg-4 col-xs-4">
					<input class="form-control mr-sm-2 mt-2 form-search" type="search" name="keywords_news" placeholder="Search" aria-label="Search" id="search" style="width: 70%; float: left;">
					<button class="btn btn-outline-danger my-2 mt-1 ml-2" style="float: left;" id="search_news" type="submit">
						<i class="fa fa-search"></i>
					</button>
				</div>
			</div>
		</div>
	</form>
</div>
<br>
<br>
<br>
<div class="container" id="container" id="area_1">
	<div class="row">
		<div class="col-md-12 col-lg-3 col-xs-12 tintuchot" style="background:  #ffffff; overflow: scroll; overflow-x: hidden ;border: 1px solid #B30041;">
			<h3 style="color: #cc3300; margin-top: 10px;">Tin nóng </h3>
			<?php while($row_query1 = mysqli_fetch_assoc($query1)) { ?>
				<div class="row" style="border-bottom: 2px solid #FF9400;padding-top: 10px;">
					<div class="col-md-5 col-lg-5">
						<img src="../assets/img/<?php echo $row_query1['news_img'] ?> " id="img-news-hot" style="width: 100%; margin:4px 2px;" alt="">
					</div>
					<div class="col-md-7 col-lg-7">
						<a class="title_news_hot" style="color: #EB591D;" href="view_news.php?id=<?php echo $row_query1['id_news'] ?>"><strong><?php echo $row_query1['news_title'] ?> </strong></a>
						<p style=" font-size: 12px; color: gray;">
							<i class="fa fa-calendar"></i> <?php echo $row_query1['create_date'] ?></p>
					</div>
				</div>
				<?php
			}
			?>
		</div>
		<div class="col-md-12 col-lg-9 col-xs-12 " >
			<h1 style=" ">Tin Tức</h1>
			<br>
			<div class="row" style="background:">
				<?php while($row = mysqli_fetch_assoc($query3)) { ?>
					<div class="col-md-6 col-lg-3 news-1 n-<?php echo $row['id_news'] ?>" style="height: 180px; margin-top: 10px; background: none;">
						<div class="thumbnail news" style="height:180px; background: yellow;">
							<div class="img_news" style="text-align: center;">
								<a class="img-responsive" href="view_news.php?id=<?php echo $row['id_news'] ?>"><img src="../assets/img/<?php echo $row['news_img'] ?>"></a>
							</div>
							<a href="view_news.php?id=<?php echo $row['id_news'] ?>" class="eye-<?php echo $row['id_news'] ?>">
								<i class="fa fa-eye " id="eye" title="<?php echo $row['news_title'] ?>" style="font-size: 22px; position: absolute"></i>
							</a>
							<h6>
								<a href="view_news.php?id=<?php echo $row['id_news'] ?>" title="<?php echo $row['news_title'] ?>"><?php echo $row['news_title'] ?> </a>
								<p><i class="fa fa-calendar"></i> <?php echo $row['create_date'] ?></p>
							</h6>
						</div>
					</div>
					<script type="text/javascript">
                        $(document).ready(function () {
                            $(".fa-eye").tooltip();
                            $("h6 a").tooltip();
                            $(".n-<?php echo $row['id_news'] ?>").hover(function () {
                                $(".eye-<?php echo $row['id_news'] ?> i").show();
                            }, function () {
                                $(".eye-<?php echo $row['id_news'] ?> i").hide();
                            });
                        });
					</script>
				<?php } ?>
			</div>
		</div>
		<nav aria-label="Page navigation example" style="margin-top: 20px;">
			<ul class="pagination">
				<?php
					if($_GET['page'] > 1) {
						$first = 1;
						?>
						<li class="page-item">
							<a class="page-link" href="news.php?page=<?php echo $first ?>">Trước</a></li>
						<?php
					}
				?>
				<?php
					for($i = 1; $i <= $num_of_page; $i++) {
						if($_GET['page'] == $i) {
							?>
							<li class="page-item">
								<a class="page-link" href="news.php?page=<?php echo $i ?>"><?php echo $i ?></a></li>
							<?php
						} else {
							?>
							<li class="page-item">
								<a class="page-link" href="news.php?page=<?php echo $i ?>"><?php echo $i ?></a></li>
							<?php
						}
					}
				?>
				<?php if($_GET['page'] < $num_of_page) {
					$last = $num_of_page;
					?>
					<li class="page-item"><a class="page-link" href="news.php?page=<?php echo $last ?>">Cuối</a></li>
					<?php
				}
				?>
			</ul>
		</nav>
	</div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $(".fa-eye").tooltip();
        $("h6 a").tooltip();
        $(".n-<?php echo $row['id_news'] ?>").hover(function () {
            $(".eye-<?php echo $row['id_news'] ?> i").show();
        }, function () {
            $(".eye-<?php echo $row['id_news'] ?> i").hide();
        });
    });
</script>
<script>
	$(document).ready(function () {
		$("#search_news").click(function(){
		   $("#area_1").load("search_news.php#area");
		});
    });
</script>
<?php require '../footer.php' ?>
<style type="text/css">
	@media only screen and (max-width: 400px){
		.search{
		}
		.tintuchot{
		}
		#img-news-hot{
			display: none;
		}
		.title_news_hot{
			font-size: 24px;
		}
		h3{
			font-size: 30px;
		}
		.news-1{
			margin-top: 30px;
		}
	}
</style>
