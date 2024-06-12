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
$error = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($nameError) && empty($emailError) && empty($phoneError) && empty($addressError)) {
        if (User::deleteUser($pdo, $user->username)) {
            header("location: all-user.php");
            exit();
        } else {
            $error = "Xoá người dùng thất bại.";
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
                <h3>Delete User</h3>
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
                        <div class="text-tiny">Delete User</div>
                    </li>
                </ul>
            </div>
            <!-- add-new-user -->
            <div class="wg-box">
                <div class="left">
                    <h5 class="mb-4">Account</h5>
                </div>
                <div class="right flex-grow">
                    <form action="" method="post">
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <div class="billing-info">
                                    <label class="fs-4 mx-3">Họ và tên <span class="text-danger">*</span></label>
                                    <input type="text" value="<?= $user->name ?>" readonly>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="billing-info">
                                    <label class="fs-4 mx-3">Tên đăng nhập</label>
                                    <input type="text" value="<?= $user->username ?>" readonly>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 mt-5">
                                <div class="billing-info">
                                    <label class="fs-4 mx-3">Email <span class="text-danger">*</span></label>
                                    <input type="email" value="<?= $user->email ?>" readonly>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 mt-5">
                                <div class="billing-info">
                                    <label class="fs-4 mx-3">Số điện thoại <span class="text-danger">*</span></label>
                                    <input type="number" value="<?= $user->phone ?>" readonly>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 mt-5">
                                <div class="billing-info">
                                    <label class="fs-4 mx-3">Địa chỉ <span class="text-danger">*</span></label>
                                    <input type="text" value="<?= $user->address ?>" readonly>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 mt-5">
                                <div class="body-title">Role <span class="tf-color-1">*</span></div>
                                <div class="billing-info">
                                    <input type="text" value="<?= $user->role ?>" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="billing-back-btn mt-5">
                            <div class="billing-btn">
                                <button type="submit">Delete</button>
                                <span class="text-danger"><?= $error ?></span>
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