<?php
require_once "inc/init.php";
if (isset($_SESSION['logged_username'])) {
    $user = User::findUsername($pdo, $_SESSION['logged_username']);
    if ($user->role == "admin") {
        header("location: 404.php");
        exit();
    }
}
$title = "Đăng nhập & Đăng ký";
require_once "class/User.php";
$username = "";
$password = "";
$usernameError = "";
$passwordError = "";
$error = "";
$name = "";
$address = "";
$username1 = "";
$password1 = "";
$nameError = "";
$passwordConfirm = "";
$email = "";
$phone = "";
$usernameError1 = "";
$passwordError1 = "";
$passwordConfirmError = "";
$emailError = "";
$phoneError = "";
$error1 = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['form-login'])) { #form login submit
        $username = $_POST['user-name'];
        $password = $_POST['user-password'];
        if (empty($username)) {
            $usernameError = "Không được để trống.";
        }
        if (empty($password)) {
            $passwordError = "Không được để trống.";
        }
        if (empty($usernameError) && empty($passwordError)) {
            // if (User::check_login($pdo, $username, $password)) {
            //     header("Location: index.php");
            //     exit();
            // } else {
            //     $error = "Đăng nhập không thành công.";
            // }
            $error = User::check_login($pdo, $username, $password);
        }
    }
    if (isset($_POST['form-register'])) { #form register submit
        $active_tab = "lg2";
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
                User::check_login($pdo, $username1, $password1);
            } else {
                $error1 = "Đăng ký không thành công.";
            }
        }
    }
}

require_once "inc/header.php";
?>
<div class="breadcrumb-area gray-bg">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="index.php">Trang chủ</a></li>
                <li class="active"> Đăng nhập / Đăng ký </li>
            </ul>
        </div>
    </div>
</div>
<div class="login-register-area pt-95 pb-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7 col-md-12 ml-auto mr-auto">
                <div class="login-register-wrapper">
                    <div class="login-register-tab-list nav">
                        <a class="<?php if (!isset($active_tab) || $active_tab === "lg1") echo 'active'; ?>" data-bs-toggle="tab" href="#lg1">
                            <h4> Đăng nhập </h4>
                        </a>
                        <a class="<?php if (isset($active_tab) && $active_tab === "lg2") echo 'active'; ?>" data-bs-toggle="tab" href="#lg2">
                            <h4> Đăng ký </h4>
                        </a>
                    </div>
                    <div class="tab-content">
                        <div id="lg1" class="tab-pane <?php if (!isset($active_tab) || $active_tab === "lg1") echo 'active'; ?>">
                            <div class="login-form-container">
                                <div class="login-register-form">
                                    <!-- form login -->
                                    <form action="login-register.php" method="post">
                                        <input class="mb-1" type="text" name="user-name" placeholder="Tài khoản" value="<?= $username ?>">
                                        <span class="text-danger"><?= $usernameError ?></span>
                                        <input class="mb-1 mt-4" type="password" name="user-password" placeholder="Mật khẩu">
                                        <span class="text-danger"><?= $passwordError ?></span>
                                        <div class="button-box">
                                            <div class="login-toggle-btn">
                                                <input type="checkbox">
                                                <label>Ghi nhớ tôi</label>
                                                <a href="forgot-password.php">Quên mật khẩu?</a>
                                            </div>
                                            <button type="submit" name="form-login"><span>Đăng nhập</span></button>
                                            <span class="text-danger"><?= $error ?></span>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div id="lg2" class="tab-pane <?php if (isset($active_tab) && $active_tab === "lg2") echo 'active'; ?>">
                            <div class="login-form-container">
                                <div class="login-register-form">
                                    <form action="login-register.php" method="post">
                                        <input class="mb-1" type="text" name="user-name" placeholder="Tài khoản" value="<?= $username1 ?>">
                                        <span class="text-danger"><?= $usernameError1 ?></span>

                                        <input class="mb-1 mt-4" type="password" name="user-password" placeholder="Mật khẩu" value="<?= $password1 ?>">
                                        <span class="text-danger"><?= $passwordError1 ?></span>

                                        <input class="mb-1 mt-4" type="password" name="user-password-confirm" placeholder="Nhập lại mật khẩu" value="<?= $passwordConfirm ?>">
                                        <span class="text-danger"><?= $passwordConfirmError ?></span>

                                        <input class="mb-1 mt-4" name="name" placeholder="Họ và tên" type="text" value="<?= $name ?>">
                                        <span class="text-danger"><?= $nameError ?></span>

                                        <input class="mb-1 mt-4" name="user-email" placeholder="Email" type="email" value="<?= $email ?>">
                                        <span class="text-danger"><?= $emailError ?></span>

                                        <input class="mb-1 mt-4" type="text" name="phone-number" placeholder="Số điện thoại" value="<?= $phone ?>">
                                        <span class="text-danger"><?= $phoneError ?></span>

                                        <input class="mb-1 mt-4" type="text" name="address" placeholder="Địa chỉ" value="<?= $address ?>">
                                        <div class="button-box mt-4 ">
                                            <button type="submit" name="form-register"><span>Đăng ký</span></button>
                                            <span class="text-danger"><?= $error1 ?></span>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
require_once "inc/footer.php";
?>