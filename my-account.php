<?php
require_once "inc/init.php";
if (isset($_SESSION['logged_username'])) {
    $user = User::findUsername($pdo, $_SESSION['logged_username']);
    if ($user->role == "admin") {
        header("location: 404.php");
        exit();
    }
}
//form change account
$name = "";
$nameError = "";
$email = "";
$emailError = "";
$phone = "";
$phoneError = "";
$address = "";
$addressError = "";
$error = "";
//kiểm tra lại phần change thông tin account
//form change password
$password = "";
$passwordError = "";
$newPassword = "";
$newPasswordError = "";
$passwordConfirm = "";
$passwordConfirmError = "";
$error1 = "";

$user = User::findUsername($pdo, $_SESSION['logged_username']);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //form thay đổi thông tin người dùng
    if (isset($_POST['form-change-account'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        if (empty($name)) {
            $nameError = "Không được để trống.";
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
        // if (User::findEmail($pdo, $email)) {
        //     $emailError = "Email đã tồn tại.";
        // }
        if (!preg_match('/^\d{10}$/', $phone)) {
            $phoneError = "Số điện thoại không hợp lệ.";
            $phone = "";
        }
        if (empty($address)) {
            $addressError = "Không được để trống.";
        }
        if (empty($nameError) && empty($emailError) && empty($phoneError) && empty($addressError)) {
            if (User::updateUser($pdo, $user->username, $name, $phone, $email, $address, "customer")) {
                $error = "Thay đổi thông tin thành công.";
                $user = User::findUsername($pdo, $_SESSION['logged_username']);
                $_SESSION['logged_user'] = $user->name;
            } else {
                $error = "Thay đổi thông tin thất bại.";
            }
        }
    }
    //form đổi mật khẩu
    if (isset($_POST['form-change-password'])) {
        $password = $_POST['password'];
        $newPassword = $_POST['newPassword'];
        $passwordConfirm = $_POST['passwordConfirm'];
        if (empty($password)) {
            $passwordError = "Không được để trống.";
        } else if (!password_verify($password, $user->password)) {
            $passwordError = "Mật khẩu không đúng.";
        }
        if (empty($newPassword)) {
            $newPasswordError = "Không được để trống.";
        } else if (!preg_match("/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/", $newPassword)) {
            $newPasswordError = "Phải có hơn 8 ký tự, chữ hoa, chữ thường, số và ký tự đặc biệt.";
            $newPassword = "";
        }
        if (empty($passwordConfirm)) {
            $passwordConfirmError = "Không được để trống.";
        }
        if ($passwordConfirm != $newPassword) {
            $passwordConfirmError = "Mật khẩu không khớp.";
            $passwordConfirm = "";
        }
        if (empty($passwordError) && empty($newPasswordError) && empty($passwordConfirmError)) {
            if (User::changePassword($pdo, $user->username, $newPassword)) {
                $error1 = "Đổi mật khẩu thành công.";
            } else {
                $error1 = "Đổi mật khẩu thất bại.";
            }
        }
    }
    $_SERVER['REQUEST_METHOD'] = "GET";
}
$title = "Tài khoản";
require_once "inc/header.php";
?>
<div class="breadcrumb-area gray-bg">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="index.php">Trang chủ</a></li>
                <li class="active">Tài khoản </li>
            </ul>
        </div>
    </div>
</div>
<!-- my account start -->
<div class="myaccount-area pb-80 pt-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="ml-auto mr-auto col-lg-9">
                <div class="checkout-wrapper">
                    <div id="faq" class="panel-group">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 class="panel-title"><span>1</span> <a data-bs-toggle="collapse" href="#my-account-1">Chỉnh sửa thông tin tài khoản </a></h5>
                            </div>
                            <div id="my-account-1" class="panel-collapse collapse <?php if (isset($_POST['form-change-account'])) echo "show" ?>" data-bs-parent="#faq">
                                <div class="panel-body">
                                    <div class="billing-information-wrapper">
                                        <form action="" method="post">
                                            <div class="account-info-wrapper">
                                                <h4>Thông tin tài khoản</h4>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="billing-info">
                                                        <label>Họ và tên <span class="text-danger">*</span></label>
                                                        <input type="text" value="<?= $user->name ?>" name="name">
                                                        <span class="text-danger"><?= $nameError ?></span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="billing-info">
                                                        <label>Tên đăng nhập (Không thể thay đổi)</label>
                                                        <input type="text" value="<?= $user->username ?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-md-12">
                                                    <div class="billing-info">
                                                        <label>Email <span class="text-danger">*</span></label>
                                                        <input type="email" value="<?= $user->email ?>" name="email">
                                                        <span class="text-danger"><?= $emailError ?></span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="billing-info">
                                                        <label>Số điện thoại <span class="text-danger">*</span></label>
                                                        <input type="number" value="<?= $user->phone ?>" name="phone">
                                                        <span class="text-danger"><?= $phoneError ?></span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="billing-info">
                                                        <label>Địa chỉ <span class="text-danger">*</span></label>
                                                        <input type="text" value="<?= $user->address ?>" name="address">
                                                        <span class="text-danger"><?= $addressError ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="billing-back-btn">
                                                <div class="billing-back">
                                                    <a href="#"><i class="ion-arrow-up-c"></i> back</a>
                                                </div>
                                                <div class="billing-btn">
                                                    <span class="<?php if ($error == "Thay đổi thông tin thành công.") {
                                                                        echo "text-success";
                                                                    } else {
                                                                        echo "text-danger";
                                                                    }
                                                                    ?>"><?= $error ?></span>
                                                    <button type="submit" name="form-change-account">Continue</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 class="panel-title"><span>2</span> <a data-bs-toggle="collapse" href="#my-account-2">Đổi mật khẩu </a></h5>
                            </div>
                            <div id="my-account-2" class="panel-collapse collapse <?php if (isset($_POST['form-change-password'])) echo "show" ?>" data-bs-parent="#faq">
                                <div class="panel-body">
                                    <div class="billing-information-wrapper">
                                        <form action="" method="post">
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12">
                                                    <div class="billing-info">
                                                        <label>Mật khẩu cũ <span class="text-danger">*</span></label>
                                                        <input type="password" name="password" value="<?= $password ?>">
                                                        <span class="text-danger"><?= $passwordError ?></span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-md-12">
                                                    <div class="billing-info">
                                                        <label>Mật khẩu mới <span class="text-danger">*</span></label>
                                                        <input type="password" name="newPassword" value="<?= $newPassword ?>">
                                                        <span class="text-danger"><?= $newPasswordError ?></span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-md-12">
                                                    <div class="billing-info">
                                                        <label>Xác nhận mật khẩu <span class="text-danger">*</span></label>
                                                        <input type="password" name="passwordConfirm" value="<?= $passwordConfirm ?>">
                                                        <span class="text-danger"><?= $passwordConfirmError ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="billing-back-btn">
                                                <div class="billing-back">
                                                    <a href="#"><i class="ion-arrow-up-c"></i> back</a>
                                                </div>
                                                <div class="billing-btn">
                                                    <span class="<?php if ($error1 == "Đổi mật khẩu thành công.") {
                                                                        echo "text-success";
                                                                    } else {
                                                                        echo "text-danger";
                                                                    }
                                                                    ?>"><?= $error1 ?></span>
                                                    <button type="submit" name="form-change-password">Continue</button>
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
</div>
<?php
require_once "inc/footer.php";
?>