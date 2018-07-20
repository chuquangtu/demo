<?php
	require '../libs/config.php';
	connect_db();
	session_start();
	if(isset($_SESSION["islogin"])) {
		if($_SESSION["islogin"]) header("location: ../index.php");
	}
	$error = FALSE;
	$errorphone = $errormail = $errorpwd = $errorusr = $errormailorg = $errorphoneorg = "";
	$fullname = $gender = $phone = $birthday = $email = $username = $password = $password_repeat = $org_name = $org_email = $org_address = $org_website = $org_phone = "";
	$iscomapny = FALSE;
	if($_SERVER["REQUEST_METHOD"] === "POST") {
		$fullname = addslashes($_POST["fullname"]);
		$gender = $_POST["gender"];
		$phone = addslashes($_POST["phone"]);
		$birthday = addslashes($_POST["birthday"]);
		$email = addslashes($_POST["email"]);
		$username = addslashes(trim($_POST["username"]));
		$password = addslashes($_POST["password"]);
		$password_repeat = addslashes($_POST["password_repeat"]);

		if($_POST["org"] === "company") {
			$iscomapny = TRUE;
			$org_name = addslashes($_POST["org_name"]);
			$org_email = addslashes($_POST["org_email"]);
			$org_phone = addslashes($_POST["org_phone"]);
			$org_address = addslashes(trim($_POST["org_address"]));
			$org_website = addslashes($_POST["org_website"]);
		}
		$error = FALSE;
		if($iscomapny) {
			if(!preg_match("/^\+?(84|0)(1\d{9}|9\d{8}|8\d{8}|2\d{9})$/", $org_phone)) {
				$error = TRUE;
				$errorphoneorg = '<li><div id="errorphoneorg">Nhập đúng định dạng số điện thoại, bắt đầu bằng <strong>0</strong> hoặc <strong>+84</strong>!</div></li>';
			};
			if(!filter_var($org_email, FILTER_VALIDATE_EMAIL)) {
				$error = TRUE;
				$errormailorg = '<li><div id="errormailorg">Nhập đúng định dạng email!</div></li>';
			}
		}
		if(!($fullname !== NULL && $gender !== NULL && preg_match("/^\+?(84|0)(1\d{9}|9\d{8})$/", $phone) && $birthday !== NULL && filter_var($email, FILTER_VALIDATE_EMAIL) && $username !== NULL && $password !== NULL && $password_repeat !== NULL)) {
			if(!preg_match("/^\+?(84|0)(1\d{9}|9\d{8})$/", $phone)) {
				$error = TRUE;
				$errorphone = '<li><div id="errorphone">Nhập đúng định dạng số điện thoại, bắt đầu bằng <strong>0</strong> hoặc <strong>+84</strong>!</div></li>';
			};
			if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$error = TRUE;
				$errormail = '<li><div id="errormail">Nhập đúng định dạng email!</div></li>';
			}
		} elseif($error == FALSE) {
			$query_usr = mysqli_query($conn, "SELECT * FROM tbl_user where username='" . $username . "'");
			$query_infouser = mysqli_query($conn, "SELECT email FROM tbl_user_info where email='" . $email . "'");
			if((mysqli_num_rows($query_usr) == 0) && (mysqli_num_rows($query_infouser) == 0)) {
				if($password === $password_repeat) {
					$role = "member";
					$password = sha1(md5($password) . $username);
					$sql = "INSERT INTO tbl_user(username, password, role, create_date, update_date) VALUES ('" . $username . "', '" . $password . "', '" . $role . "', now(), now())";
					$query = mysqli_query($conn, $sql);

					if($query) {
						$id_user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id_user FROM tbl_user where username='" . $username . "'"));
						$query_userinfo = mysqli_query($conn, "INSERT INTO tbl_user_info(full_name, birthday, gender, phone, email, avatar, id_user, id_org, create_date, update_date) VALUES ('" . $fullname . "', '" . $birthday . "', '" . $gender . "', '" . $phone . "', '" . $email . "', NULL, '" . $id_user["id_user"] . "', NULL, now(), now())");

						if($iscomapny) {
							$query_org = mysqli_query($conn, "INSERT INTO tbl_org(org_name, org_email, org_phone, org_address, org_website, org_type, create_date, update_date) VALUES ('" . $org_name . "', '" . $org_email . "', '" . $org_phone . "', '" . $org_address . "', '" . $org_website . "', 'Doanh nghiệp', NOW(), NOW())");

							$orgid = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id_org FROM tbl_org ORDER BY id_org DESC LIMIT 1"));
							mysqli_query($conn, "UPDATE tbl_user_info SET id_org='" . $orgid["id_org"] . "' WHERE id_user='" . $id_user["id_user"] . "'");

						}
						header("location: login.php?signupsuccess=true");
					}
				} else {
					$error = TRUE;
					$errorpwd = '<li><div id="errorpwd">Hai mật khẩu phải trùng nhau!</div></li>';
				}
			} elseif(mysqli_num_rows($query_usr) > 0) {
				$error = TRUE;
				$errorusr = '<li><div id="errorusr">Tên đăng nhập đã tồn tại, hãy chọn tên khác!</div></li>';

			} elseif(mysqli_num_rows($query_infouser) > 0) {
				$error = TRUE;
				$errormail = '<li><div id="errormail">Email đã tồn tại</div></li>';

			}
		}
	}
	$title = "Đăng ký tài khoản";
	$metadesc = "Đăng ký tài khoản thành viên.";
	require '../header.php';
?>
<style>
	.form-group input{
		font-family: FontAwesome;
	}
</style>
<div class="register-photo" style="margin-top:0; background: #2e9ad0;">
	<div class="form-container">
		<form method="post" id="create_account" action="signup.php">
			<h2 class="text-center" style="margin-top:-28px;"><strong>Đăng ký</strong> tài khoản mới.</h2>
			<div class="input-group">
				<?php
					if($error) {
						echo '<div class="alert alert-danger alert-dismissible fade show mx-auto" role="alert"><ul id="alert_signup">' . $errorusr . $errorphoneorg . $errorphone . $errormailorg . $errormail . $errorpwd . '</ul><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
					}
				?>
			</div>
			<div><strong>Tài khoản</strong> của bạn thuộc:
				<label style="margin-left: 20px;" for="person">Cá nhân</label>
				<input type="radio" id="person"  name="org" required <?php echo (!$iscomapny) ? "checked" : "" ?> value="person">
				<label for="company">Tổ chức, doanh nghiệp</label>
				<input type="radio" id="company" name="org" required value="company" <?php echo ($iscomapny) ? "checked" : "" ?>>
				<label for="company">Tổ chức giáo dục</label>
				<input type="radio" id="school" name="org" required value="school" <?php echo ($iscomapny) ? "checked" : "" ?>>
			</div>
			<div id="info_org">
				<div class="form-group"><span id="check_org_name"></span>
					<input class="form-control" type="text" name="org_name" id="org_name" placeholder="&#xf0c0; Tên tổ chức" required value="<?php echo $org_name ?>">
				</div>
				<div class="form-group"><span id="check_org_email"></span>
					<input class="form-control" type="email" name="org_email" id="org_email" placeholder=" &#xf0e0; Email tổ chức" required value="<?php echo $org_email ?>">
				</div>
				<div class="form-group"><span id="check_org_phone"></span>
					<input class="form-control" type="number" name="org_phone" id="org_phone" placeholder="&#xf098; SĐT tổ chức" minlength="10" maxlength="11" required value="<?php echo $org_phone ?>">
				</div>
				<div class="form-group"><span id="check_org_address"></span>
					<input class="form-control" type="text" name="org_address" id="org_address" placeholder="&#xf2bb; Địa chỉ" required value="<?php echo $org_address ?>">
				</div>
				<div class="form-group"><span id="check_org_website"></span>
					<input class="form-control" type="text" name="org_website" id="org_website" placeholder="&#xf08e; Website" value="<?php echo $org_website ?>">
				</div>
				<div class="form-group">
					<label>Thông tin người đại diện</label>
				</div>
			</div>
			<div class="form-group">
				<input class="form-control" type="text" name="fullname" placeholder=" Họ tên *" id="fullname" minlength="2" required value="<?php echo $fullname; ?>" aria-required="true">
			</div>
			<div class="form-group">
				<select class="form-control" style="color: #8f8f8f;" id="gender" title="Giới tính" name="gender" aria-required="true" required>
					<option class="form-control" value="m" <?php echo $gender == "m" ? "selected" : "" ?>>Nam</option>
					<option class="form-control" value="f" <?php echo $gender == "f" ? "selected" : "" ?>>Nữ</option>
				</select>
			</div>
			<div class="form-group">
				<span id="check_phone"></span>
				<input class="form-control" type="number" name="phone" placeholder="&#xf095; Số điện thoại" id="phone" minlength="10" maxlength="11" value="<?php echo $phone; ?>" required>
			</div>
			<div class="form-group"><span></span>
				<input type="text" class="form-control" id="birthday" name="birthday" placeholder="Ngày sinh: ngày/tháng/năm" onfocus="(this.type='date')" required value="<?php echo ($birthday !== "") ? date('d/m/Y', strtotime($birthday)) : ""; ?>" aria-required="true">
			</div>
			<div class="form-group"><span id="check_email"></span>
				<input class="form-control" type="email" name="email" placeholder="&#xf0e0; Email *" id="email" required value="<?php echo $email; ?>" aria-required="true">
			</div>
			<div class="form-group"><span id="check_username"></span>
				<input class="form-control" type="text" name="username" placeholder="&#xf007; Tên đăng nhập *" id="username" minlength="5" required value="<?php echo $username; ?>" aria-required="true">
			</div>
			<div class="form-group"><span id="check_password"></span>
				<input class="form-control" type="password" name="password" placeholder=" &#xf084; Mật khẩu *" id="password" minlength="6" required value="<?php echo $password; ?>" aria-required="true">
			</div>
			<div class="form-group"><span id="check_repassword"></span>
				<input class="form-control" type="password" name="password_repeat" placeholder="&#xf084; Nhập lại mật khẩu *" id="repassword" required aria-required="true">
			</div>
			<div class="form-group">
				<div class="form-check">
					<label class="form-check-label">
						<input class="form-check-input" type="checkbox" id="checkbox" required aria-required="true" name="checkbox">Tôi đồng ý với điều khoản của trang web.</label>
				</div>
			</div>
			<div class="form-group">
				<button class="btn btn-primary btn-block" type="submit" id="signup-btn">Đăng ký</button>
			</div>
			<a href="#" class="already"></a>
		</form>
	</div>
</div>
<script>
    if (($("#errorphone").length > 0)) {
        $("#phone").css("border", "2px solid red")
    }

    if (($("#errormail").length > 0)) {
        $("#email").css("border", "2px solid red")
    }

    if (($("#errorpwd").length > 0)) {
        $("#password_repeat").css("border", "2px solid red");
    }

    if (($("#errorusr").length > 0)) {
        $("#username").css("border", "2px solid red");
    }
    if (($("#errorphoneorg").length > 0)) {
        $("#org_phone").css("border", "2px solid red");
    }
    if (($("#erroremailorg").length > 0)) {
        $("#org_email").css("border", "2px solid red");
    }
    $(document).ready(function () {
        $("#info_org").hide();
        $("#company, #person").change(function () {
            if ($("#company").is(":checked")) {
                $("#info_org").show();
            }
            if ($("#person").is(":checked")) {
                $("#info_org").hide();
            }
        })
    });
</script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/localization/messages_vi.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#create_account").validate({
            rules: {
                password_repeat: {
                    equalTo: "#password"
                }
            },
            lang: "vi"
        });
    });
</script>
<?php require '../footer.php' ?>
