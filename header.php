<!DOCTYPE html>
<html lang="en">
<head prefix="og:http://ogp.me/ns# fb:http://ogp.me/ns/fb#">
	<meta charset="utf-8">
	<link rel="icon" href="<?php echo getdomain(); ?>/assets/img/icon.png">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta property="og:type" content="website">
	<meta property="og:title" content="<?php echo isset($title) ? $title . " | Thế giới công nghệ" : "Thế giới công nghệ";?>">
	<meta property="og:description" content="<?php echo isset($metadesc) ? $metadesc : "Thế giới công nghệ";?>">
	<meta property="og:image" content="<?php echo isset($metaimg) ? $metaimg : getdomain() . "/assets/img/Technology-World-Logo.svg";?>">
	<meta property="og:site_name" content="Thế giới công nghệ">
	<meta property="og:locale" content="vi_VN">
	<meta property="url" content="<?php echo strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5)) == "https" ? "https":"http" . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']?>">
	<!--	<meta property="fb:app_id">-->
	<!--	meta-social Twitter-->
	<meta name="twitter:title" content="<?php echo isset($title) ? $title . " | Thế giới công nghệ" : "Thế giới công nghệ";?>">
	<meta name="twitter:image" content="<?php echo isset($metaimg) ? $metaimg : getdomain() . "/assets/img/Technology-World-Logo.svg";?>">
	<meta name="twitter:desciption" content="<?php echo isset($metadesc) ? $metadesc : "Bấm để xem nội dung!";?>">
	<meta name="twitter:site" content="<?php echo strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5)) == "https" ? "https":"http" . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']?>">
	<title>
		<?php echo isset($title) ? $title . " | Thế giới công nghệ" : "Thế giới công nghệ";?>
	</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<link rel="stylesheet" href="<?php echo getdomain(); ?>/assets/css/styles.min.css">
	<link rel="stylesheet" href="<?php echo getdomain(); ?>/assets/css/styles.product.css">
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
	<script src="<?php echo getdomain();?>/assets/js/jquery-1.9.1.min.js"></script>
	<?php
	if($_SERVER["PHP_SELF"] == "/project/khcn2/account/infor_user.php") echo '<link rel="stylesheet" href="' . getdomain() . '/assets/css/infor-user.css">';
		//if($_SERVER["PHP_SELF"] == "/account/infor_user.php") echo '<link rel="stylesheet" href="' . getdomain() . '/assets/css/infor-user.css">';
	if($_SERVER["PHP_SELF"] == "/news.php") echo '<link rel="stylesheet" href="' . getdomain() . '/assets/css/styles.product.css">';
	?>
</head>
<style>
.navbar{
	background: #FFDE17;
}
.nav-item{
	color: white;
}
#private a{
	padding: 5px 10px;
	background: #BF1E2D;
	color: white;
	border-radius: 5px;
}
#inner{
    transform: rotate(45deg);
    -ms-transform: rotate(45deg);
    -webkit-transform: rotate(45deg);
    -o-transform: rotate(45deg);
    -moz-transform: rotate(45deg); 
    background-color:#BF1E2D;
    width:35px;
    height:35px;
    top: 7px;
    left: -21px;
    position:relative;
    -moz-border-radius: 7px;
    border-radius: 7px;
}

#outer {
  transform:rotate(90deg);
  -ms-transform: rotate(90deg);
    -webkit-transform: rotate(90deg);
    -o-transform: rotate(90deg);
    -moz-transform: rotate(90deg); 
    position: absolute;
    width: 70px;
    height: 140px;    
    top:0px;
    left:-35px;
     overflow: hidden;    
}

.nav-item a{
	padding: 5px 2px;
	color: #001020;
}

</style>
<body>
	<nav class="navbar  navbar-expand-md navigation-clean-button" style="font-size: larger;padding:  0; margin: 0; color: white;">
		<div class="container-fluid">
			<a class="navbar-brand" href="<?php echo getdomain(); ?>/index.php">
				<img src="<?php echo getdomain(); ?>/assets/img/Technology-World-Logo.svg" style="width: 300px; height: 100px;" class="img-responsive logo-item">
			</a>
			<button class="navbar-toggler" data-toggle="collapse" data-target="#navcol-1" style="margin-top: -30px; margin-left: 20px;">
				<span class="sr-only">Toggle navigation</span>
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navcol-1" >
				<ul class="navbar-nav mr-auto lv1" ">
					<li class="nav-item"  id="private" role="presentation">
						<a class="nav-link"  href="<?php echo getdomain(); ?>/index.php"><i class="fa fa-home"></i> Trang chủ</a>
						<div id="outer"><div id="inner"></div></div>
					</li>

					<li class="nav-item" role="presentation">
						<a class="nav-link" href="<?php echo getdomain(); ?>/product/product.php"> <i class="fa fa-cubes"></i> Sản phẩm</a>
						<ul class="dropdown-menu lv2 mt-1">
							<li class="nav-item">
								<a class="nav-link" href="<?php echo getdomain(); ?>/index.php">Khoa Học Tự Nhiên</a>
								<ul class="dropdown-menu lv3">
									<li class="nav-item">
										<a class="nav-link" href="<?php echo getdomain(); ?>/index.php">Toán Học</a></li>
										<li class="nav-item">
											<a class="nav-link" href="<?php echo getdomain(); ?>/product/product.php">KH Thông Tin &amp; Máy Tính</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" href="<?php echo getdomain(); ?>/news/news.php">Vật Lý</a></li>
											<li class="nav-item"><a class="nav-link" href="#">Hóa Học</a></li>
											<li class="nav-item"><a class="nav-link" href="#">Khoa Học Trái Đất</a></li>
											<li class="nav-item"><a class="nav-link" href="#">Khoa Học Sinh Học Nông Nghiệp</a></li>
											<li class="nav-item"><a class="nav-link" href="#">Cơ Học</a></li>
										</ul>
									</li>
									<li class="nav-item">
										<a class="nav-link" href="<?php echo getdomain(); ?>/product/product.php">Khoa Học Kỹ Thuật và Công Nghệ</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" href="<?php echo getdomain(); ?>/news/news.php">Khoa Học Y, Dược</a></li>
										<li class="nav-item"><a class="nav-link" href="#">Khoa Học Nông Nghiệp</a></li>
										<li class="nav-item"><a class="nav-link" href="#">Khoa Học Xã Hội</a></li>
										<li class="nav-item"><a class="nav-link" href="#">Khoa Học Nhân Văn</a></li>
										<li class="nav-item"><a class="nav-link" href="#">Khác</a></li>
									</ul>
								</li>
								<li class="nav-item" role="presentation">
									<a class="nav-link" href="<?php echo getdomain(); ?>/news/news.php"><i class="fa fa-newspaper-o"></i> Tin tức</a></li>
									<li class="nav-item" role="presentation"><a class="nav-link" href="#"> <i class="fa fa-graduation-cap"></i> Giới thiệu</a></li>
									<li class="nav-item" role="presentation"><a class="nav-link" href="#"><i class="fa fa-gift"></i> Cơ hội đầu tư</a></li>
								</ul>
								<span class="navbar-text actions">
									<?php

									if(isset($_SESSION["islogin"])) {
										if($_SESSION["islogin"]) {
											$query = mysqli_fetch_assoc(mysqli_query($conn,"select *,tbl_user.username from tbl_user, tbl_user_info where username = '".$_SESSION['username']."' and tbl_user.id_user = tbl_user_info.id_user"));
											if($query['avatar']==""){
												$query['avatar']='test.png';
											}
											echo '
											<span class="infor-user">Chào <strong>' . $_SESSION["username"] . '</strong>
											<img src="'.getdomain().'/account/user_avatar/'.$query['avatar'].'" width="30" height="30" style="margin:0 4px 10px 4px; border-radius: 50% "> 
											<i class="fa fa-cog"></i>	
											<div class="dropdown-content" style="height: 120px; width: 100%; padding:0 0 10px 10px">
											<a href="' . getdomain() . '/account/infor_user.php"><i class="fa fa-user"></i> Hồ sơ cá nhân</a>
											<a href="' . getdomain() . '/account/infor_user.php#product_list"><i class="fa fa-product-hunt"></i> Sản phẩm</a>
											<a href="' . getdomain() . '/account/infor_user.php#news_list"><i class="fa fa-newspaper-o"></i> Tin tức</a>
											<a href="' . getdomain() . '/account/logout.php"><i class="fa fa-power-off"></i> Đăng xuất</a>
											</div>				
											</span>';
										}
									} else {
										echo '<span class="navbar-text actions">
										<a class="login" href="' . getdomain() . '/account/login.php"><i class="fa fa-lock"></i> Đăng nhập</a>
										<a class="btn btn-light" role="button" href="' . getdomain() . '/account/signup.php">Đăng ký</a>
										</span>';
									} ?>
								</span>
							</div>
						</div>
					</nav>
