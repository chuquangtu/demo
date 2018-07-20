<?php
	require '../libs/config.php';
	connect_db();
	session_start();
	if(isset($_SESSION["islogin"])) {
		if($_SESSION["islogin"]) header("location: ../index.php");
	}
	$error = "";
	$username = $password = "";
	if($_SERVER["REQUEST_METHOD"] === "POST") {
		$username = strtolower(addslashes(trim($_POST["username"])));
		$password = addslashes($_POST["password"]);
		$query = mysqli_query($conn, "SELECT * FROM tbl_user WHERE lower(username)='" . $username . "' AND password='" . sha1(md5($password) . $username) . "'");
		if(mysqli_num_rows($query) > 0) {
			$data = mysqli_fetch_assoc($query);
			if(empty($_SESSION['token'])) {
				$_SESSION['token'] = bin2hex(random_bytes(32));
			}
			$token = $_SESSION['token'];
			$_SESSION["islogin"] = TRUE;
			$_SESSION["username"] = $username;
			$_SESSION["user_role"] = $data["role"];
			setcookie("remember_user", $username, "", "/", "", FALSE, TRUE);
			header("location: ../matching.php");
		} else {
			$error = '<div class="form-text text-danger" style="font-size: 1rem; margin-top: -25px;" id="errorlogin">Tài khoản hoặc mật khẩu không chính xác!</div>';
		}
	}
	$title = "Đăng nhập";
	$metadesc = "Trang đăng nhập - Thế giới công nghệ.";
	require '../header.php';
?>
	<div style="padding: 50px 0; background: lightblue;">
		<div class="login-form">
			<?php if(isset($_GET["signupsuccess"])) {
				if($_GET["signupsuccess"]) {
					echo '<div class="alert alert-success fade show mx-auto" role="alert">Đăng ký tài khoản thành công</div>';
				}
			} ?>
			<div class="login-logo">
				<img src="../assets/img/Technology-World-Logo.svg" width="250px">
				<span class="login-slogan">Đăng nhập để bắt đầu chia sẻ</span>
			</div>
			<form class="form-login" action="login.php" method="post">
				<div class="form-group">
					<input class="form-input" type="text" name="username" placeholder="Tên đăng nhập" id="usernamelogin" minlength="5" required/>
					<div class="line"></div>
					<?php echo $error ?>
				</div>
				<div class="form-group">
					<input class="form-input" type="password" name="password" placeholder="Mật khẩu" id="passwordlogin" required/>
					<div class="line"></div>
					<?php echo $error ?>
				</div>
				<button class="btn btn--primary mt-15" type="submit" id="submit">Đăng nhập</button>
				<!--<div class="text-center">
					<a class="form-forgot-pwd" href="javascript:void(0)">Quên mật khẩu?</a>
				</div>-->
			</form>
			<div class="form-footer">
				<span class="link-to-signup">Chưa có tài khoản?</span><a class="btn btn--secondary" href="javascript:void(0)">Tạo</a>
			</div>
		</div>
	</div>
	<script>
        if ($("#errorlogin").length > 0) {
            var inputlogin = $("#usernamelogin, #passwordlogin");
            inputlogin.css("border-bottom", "2px solid red");
            inputlogin.focus(function () {
                inputlogin.css("border", "none")
            });
            inputlogin.focusout(function () {
                inputlogin.css("border-bottom", "2px solid #d0d0d0")
            })
        }
	</script>
<?php require '../footer.php' ?>