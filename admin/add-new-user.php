<?php
require_once "inc_admin/init.php";
if (isset($_SESSION['logged_username'])) {
    $user = User::findUsername($pdo, $_SESSION['logged_username']);
    if ($user->role == "customer") {
        header("location: ../404.php");
        exit();
    }
} else {
    header("location: ../404.php");
    exit();
}
$name = "";
$username1 = "";
$password1 = "";
$passwordConfirm = "";
$email = "";
$phone = "";
$address = "";
$usernameError1 = "";
$passwordError1 = "";
$passwordConfirmError = "";
$emailError = "";
$phoneError = "";
$nameError = "";
$error1 = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $username1 = $_POST['user-name'];
    $password1 = $_POST['user-password'];
    $passwordConfirm = $_POST['user-password-confirm'];
    $email = $_POST['user-email'];
    $phone = $_POST['phone-number'];
    $address = $_POST['address'];
    if (empty($username1)) {
        $usernameError1 = "Không được để trống.";
    } else if (!preg_match("/^[a-zA-Z0-9_]{5,}$/", $username1)) {
        $usernameError1 = "Tài khoản phải hơn 5 ký tự và không có ký tự đặc biệt.";
    } else if (User::findUsername($pdo, $username1)) {
        $usernameError1 = "Tài khoản đã tồn tại.";
    }
    if (empty($password1)) {
        $passwordError1 = "Không được để trống!";
    } else if (!preg_match("/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/", $password1)) {
        $passwordError1 = "Phải có hơn 8 ký tự, chữ hoa, chữ thường, số và ký tự đặc biệt.";
        $password = "";
    }
    if ($passwordConfirm != $password1) {
        $passwordConfirmError = "Mật khẩu không khớp.";
        $passwordConfirm = "";
    }
    if (empty($name)) {
        $nameError = "Không được để trống!";
    } else if (!preg_match("/^[\p{L}\s']+$/u", $name)) {
        $nameError = "Không được có ký dự đặc biệt và số.";
        $name = "";
    }
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        if (strpos($email, '@gmail.com') == false) {
            $emailError = "Email không hợp lệ.";
            $email = "";
        }
    } else {
        $emailError = "Email không hợp lệ.";
    }
    if (User::findEmail($pdo, $email)) {
        $emailError = "Email đã tồn tại";
    }
    if (!preg_match('/^\d{10}$/', $phone)) {
        $phoneError = "Số điện thoại không hợp lệ.";
        $phone = "";
    }
    if (empty($usernameError1) && empty($nameError) && empty($passwordError1) && empty($passwordConfirmError) && empty($emailError) && empty($phoneError)) {
        if (User::register($pdo, $username1, $password1, $name, $phone, $email, $address, "customer")) {
            $error1 = "Đăng ký thành công.";
        } else {
            $error1 = "Đăng ký không thành công.";
        }
    }
}

require_once "inc_admin/header.php"; ?>
<!-- main-content -->
<div class="main-content">
    <!-- main-content-wrap -->
    <div class="main-content-inner">
        <!-- main-content-wrap -->
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Add New User</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="home_admin.php">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <a href="all-user.php">
                            <div class="text-tiny">User</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">Add New User</div>
                    </li>
                </ul>
            </div>
            <!-- add-new-user -->
            <div class="wg-box">
                <div class="left">
                    <h5 class="mb-4">Account</h5>
                    <div class="body-text">Fill in the information below to add a new account</div>
                </div>
                <!-- <div class="right flex-grow">
                        <fieldset class="name mb-24">
                            <div class="body-title mb-10">Name</div>
                            <input class="flex-grow" type="text" placeholder="Username" name="name" tabindex="0" value="" aria-required="true" required="">
                        </fieldset>
                        <fieldset class="email mb-24">
                            <div class="body-title mb-10">Email</div>
                            <input class="flex-grow" type="email" placeholder="Email" name="email" tabindex="0" value="" aria-required="true" required="">
                        </fieldset>
                        <fieldset class="password mb-24">
                            <div class="body-title mb-10">Password</div>
                            <input class="password-input" type="password" placeholder="Enter password" name="password" tabindex="0" value="" aria-required="true" required="">
                            <span class="show-pass">
                                <i class="icon-eye view"></i>
                                <i class="icon-eye-off hide"></i>
                            </span>
                        </fieldset>
                        <fieldset class="password">
                            <div class="body-title mb-10">Confirm password</div>
                            <input class="password-input" type="password" placeholder="Confirm password" name="password" tabindex="0" value="" aria-required="true" required="">
                            <span class="show-pass">
                                <i class="icon-eye view"></i>
                                <i class="icon-eye-off hide"></i>
                            </span>
                        </fieldset>
                    </div> -->
                <div class="right flex-grow">
                    <form action="add-new-user.php" method="POST">
                        <div class="mb-10">
                            <input class="mb-1" type="text" name="user-name" placeholder="Tài khoản" value="<?= $username1 ?>">
                            <span class="text-danger fs-3"><?= $usernameError1 ?></span>
                        </div>
                        <div class="mb-10">
                            <input class="mb-1 mt-4" type="password" name="user-password" placeholder="Mật khẩu" value="<?= $password1 ?>">
                            <span class="text-danger fs-3"><?= $passwordError1 ?></span>
                        </div>
                        <div class="mb-10">
                            <input class="mb-1 mt-4" type="password" name="user-password-confirm" placeholder="Nhập lại mật khẩu" value="<?= $passwordConfirm ?>">
                            <span class="text-danger fs-3"><?= $passwordConfirmError ?></span>
                        </div>
                        <div class="mb-10">
                            <input class="mb-1 mt-4" name="name" placeholder="Họ và tên" type="text" value="<?= $name ?>">
                            <span class="text-danger fs-3"><?= $nameError ?></span>
                        </div>
                        <div class="mb-10">
                            <input class="mb-1 mt-4" name="user-email" placeholder="Email" type="email" value="<?= $email ?>">
                            <span class="text-danger fs-3"><?= $emailError ?></span>
                        </div>
                        <div class="mb-10">
                            <input class="mb-1 mt-4" type="number" name="phone-number" placeholder="Số điện thoại" value="<?= $phone ?>">
                            <span class="text-danger fs-3"><?= $phoneError ?></span>
                        </div>
                        <div class="mb-10">
                            <input class="mb-1 mt-4 fs-3" type="text" name="address" placeholder="Địa chỉ" value="<?= $address ?>">
                        </div>
                        <div class="col-6 button-box mt-4 ">
                            <button class="tf-button w180" type="submit">Save</button>
                            <span class="text-danger fs-3"><?= $error1 ?></span>
                        </div>
                        <div class="col-6 button-box mt-4 ">
                            <a href="all-user.php">Go back</a>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /add-new-user -->
        </div>
        <!-- /main-content-wrap -->
    </div>
    <!-- /main-content-wrap -->
    <!-- bottom-page -->
    <div class="bottom-page">
        <div class="body-text">Copyright © 2024 Remos. Design with</div>
        <i class="icon-heart"></i>
        <div class="body-text">by <a href="https://themeforest.net/user/themesflat/portfolio">Themesflat</a> All rights reserved.</div>
    </div>
    <!-- /bottom-page -->
</div>
<!-- /main-content -->
<?php require_once "inc_admin/footer.php"; ?>