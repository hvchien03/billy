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
$username = $_GET['username'];
if (empty($username)) {
    header("location: ../404.php");
    exit();
}

$user = User::findUsername($pdo, $username);
if (empty($user)) {
    header("location: ../404.php");
    exit();
}
$name = "";
$nameError = "";
$email = "";
$emailError = "";
$phone = "";
$phoneError = "";
$address = "";
$addressError = "";
$error = "";
$roleError = "";
$role = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //form thay đổi thông tin người dùng
    if (isset($_POST['form-change-account'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $role = $_POST['role'];
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
            if (User::updateUser($pdo, $user->username, $name, $phone, $email, $address, $role)) {
                $error = "Thay đổi thông tin thành công.";
            } else {
                $error = "Thay đổi thông tin thất bại.";
            }
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
                <h3>Update User</h3>
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
                        <div class="text-tiny">Update User</div>
                    </li>
                </ul>
            </div>
            <!-- add-new-user -->
            <div class="wg-box">
                <div class="left">
                    <h5 class="mb-4">Account</h5>
                    <div class="body-text">Fill in the information below to add a new account</div>
                </div>
                <div class="right flex-grow">
                    <form action="" method="post">
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <div class="billing-info">
                                    <label class="fs-4 mx-3">Họ và tên <span class="text-danger">*</span></label>
                                    <input type="text" value="<?= $user->name ?>" name="name">
                                    <span class="text-danger"><?= $nameError ?></span>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="billing-info">
                                    <label class="fs-4 mx-3">Tên đăng nhập (Không thể thay đổi)</label>
                                    <input type="text" value="<?= $user->username ?>" readonly>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 mt-5">
                                <div class="billing-info">
                                    <label class="fs-4 mx-3">Email <span class="text-danger">*</span></label>
                                    <input type="email" value="<?= $user->email ?>" name="email">
                                    <span class="text-danger"><?= $emailError ?></span>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 mt-5">
                                <div class="billing-info">
                                    <label class="fs-4 mx-3">Số điện thoại <span class="text-danger">*</span></label>
                                    <input type="number" value="<?= $user->phone ?>" name="phone">
                                    <span class="text-danger"><?= $phoneError ?></span>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 mt-5">
                                <div class="billing-info">
                                    <label class="fs-4 mx-3">Địa chỉ <span class="text-danger">*</span></label>
                                    <input type="text" value="<?= $user->address ?>" name="address">
                                    <span class="text-danger"><?= $addressError ?></span>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 mt-5">
                                <div class="body-title">Role <span class="tf-color-1">*</span></div>
                                <div class="select">
                                    <select aria-label="Default select example" name="role">
                                        <?php if ($user->role == "customer") : ?>
                                            <option value="customer" selected>Customer</option>
                                            <option value="admin">Admin</option>
                                        <?php else : ?>
                                            <option value="customer">Customer</option>
                                            <option value="admin" selected>Admin</option>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <span class="text-danger fs-5"><?= $roleError ?></span>
                            </div>
                        </div>
                        <div class="billing-back-btn mt-5">
                            <div class="billing-btn">
                                <button type="submit" name="form-change-account">Continue</button>
                                <span class="<?php if ($error == "Thay đổi thông tin thành công.") {
                                                    echo "text-success";
                                                } else {
                                                    echo "text-danger";
                                                }
                                                ?>"><?= $error ?></span>
                            </div>
                            <div class="billing-back" style="float: right;">
                                <a href="all-user.php" class="fs-3"><i class="ion-arrow-up-c"></i> back</a>
                            </div>
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