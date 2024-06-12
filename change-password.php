<?php
require_once "inc/init.php";
if (isset($_SESSION['logged_username'])) {
    $user = User::findUsername($pdo, $_SESSION['logged_username']);
    if ($user->role == "admin") {
        header("location: 404.php");
        exit();
    }
}
$username = "";
$usernameError = "";
$password = "";
$passwordConfirm = "";
$passwordError = "";
$passwordConfirmError = "";
$code = "";
$codeError = "";
$success = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['form-check-code'])) {
        $code = $_POST['code-forgot-password'];
        $password = $_POST['user-password'];
        $passwordConfirm = $_POST['user-password-confirm'];
        if (empty($code)) {
            $codeError = "Không được để trống";
        } else if ($code != $_SESSION['verificationCode']) {
            $codeError = "Mã xác thực không dúng";
        }
        if (empty($password)) {
            $passwordError = "Không được để trống!";
        } else if (!preg_match("/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/", $password)) {
            $passwordError = "Phải có hơn 8 ký tự, chữ hoa, chữ thường, số và ký tự đặc biệt.";
            $password = "";
        }
        if (empty($passwordConfirm)) {
            $passwordConfirmError = "Không được để trống!";
        }
        if ($passwordConfirm != $password) {
            $passwordConfirmError = "Mật khẩu không khớp.";
            $passwordConfirm = "";
        }
        if (empty($codeError) && empty($passwordError) && empty($passwordConfirmError)) {
            if (User::changePassword($pdo, $_SESSION['account-change-password'], $password)) {
                $success = "Đổi mật khẩu thành công";
                $password = "";
                $passwordConfirm = "";
            } else {
                $success = "Đổi mật khẩu không thành công";
                $password = "";
                $passwordConfirm = "";
            }
        }
    }
}
$title = "Đổi mật khẩu";
require_once "inc/header.php";
?>
<div class="breadcrumb-area gray-bg">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="index.php">Trang chủ</a></li>
                <li class="active"> Đổi mật khẩu </li>
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
                        <h4 class="active"> Đổi mật khẩu </h4>
                    </div>
                    <div class="tab-content">
                        <div>
                            <div class="login-form-container">
                                <div class="login-register-form">
                                    <form action="" method="post">
                                        <input class="mb-1" type="text" name="code-forgot-password" placeholder="Mã xác thực">
                                        <span class="text-danger"><?= $codeError ?></span>

                                        <input class="mb-1 mt-4" type="password" name="user-password" placeholder="Mật khẩu" value="<?= $password ?>">
                                        <span class="text-danger"><?= $passwordError ?></span>

                                        <input class="mb-1 mt-4" type="password" name="user-password-confirm" placeholder="Nhập lại mật khẩu" value="<?= $passwordConfirm ?>">
                                        <span class="text-danger"><?= $passwordConfirmError ?></span>
                                        <div class="button-box mt-4 ">
                                            <button type="submit" name="form-check-code"><span>Xác nhận</span></button>
                                            <span class="text-danger"><?= $success ?></span>
                                            <div class="login-toggle-btn">
                                                <a href="login-register.php">Về trang đăng nhập?</a>
                                            </div>
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