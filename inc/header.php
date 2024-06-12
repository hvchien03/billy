<?php
require_once "inc/init.php";
?>
<!doctype html>
<!-- <html class="no-js" lang="zxx"> -->
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?= $title ?></title>
    <meta name="description" content="">
    <meta name="robots" content="noindex, follow" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/animate.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/slick.css">
    <link rel="stylesheet" href="assets/css/chosen.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/simple-line-icons.css">
    <link rel="stylesheet" href="assets/css/ionicons.min.css">
    <link rel="stylesheet" href="assets/css/meanmenu.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
    <script src="assets/js/vendor/modernizr-2.8.3.min.js"></script>
</head>

<body>
    <!-- header start -->
    <header class="header-area">
        <div class="header-middle py-2">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-12 col-sm-4">
                        <div class="logo">
                            <a href="index.php">
                                <img src="assets\img\logo\billy.jpg" class="w-25" style="filter:invert(100%); border-radius:50%" />
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-9 col-md-8 col-12 col-sm-8 m-auto">
                        <div class="header-middle-right f-right m-auto">
                            <?php if (!isset($_SESSION['logged_user'])) {
                                $total = 0;
                            } else {
                                $total = 0;
                                foreach ($data_cart as $item) {
                                    if ($item->username == $_SESSION['logged_username'])
                                        $total = $total + $item->total;
                                }
                            }
                            ?>
                            <div>
                                <a href="cart-page.php" class="m-auto">
                                    <div class="header-icon-style">
                                        <i class="icon-handbag icons"></i>
                                        <!-- <span class="count-style"><?= $count ?></span> -->
                                    </div>
                                    <div class="cart-text">
                                        <span class="digit">Giỏ hàng</span>
                                        <span class="cart-digit-bold">
                                            <?= number_format($total, 0, ',', '.') ?> VND
                                        </span>
                                    </div>
                                </a>
                            </div>
                            <?php if (!isset($_SESSION['logged_user'])) : ?>
                                <div class="header-wishlist">
                                    <a href="login-register.php">
                                        <div class="header-icon-style">
                                            <i class="icon-user icons"></i>
                                        </div>
                                        <div class="login-text-content">
                                            <p>Đăng ký <br><span>Đăng nhập</span></p>
                                        </div>
                                    </a>
                                </div>
                            <?php else : ?>
                                <div class="header-wishlist">
                                    <div class="account-curr-lang-wrap f-right">
                                        <ul>
                                            <div class="header-icon-style">
                                                <i class="icon-user icons"></i>
                                            </div>
                                            <li class="top-hover"><a href="#">
                                                    <div class="login-text-content">
                                                        <p>Xin chào </br><span><?= $_SESSION['logged_user'] ?></span></p>
                                                    </div>
                                                </a>
                                                <ul>
                                                    <li><a href="my-account.php">Tài khoản</a></li>
                                                    <li><a href="logout.php">Đăng xuất</a></li>
                                                    <li><a href="orders.php">Đơn hàng</a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if (!isset($_SESSION['logged_user'])) {
                                $total = 0;
                            } else {
                                $total = 0;
                                foreach ($data_cart as $item) {
                                    if ($item->username == $_SESSION['logged_username'])
                                        $total = $total + $item->total;
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-bottom transparent-bar black-bg">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="main-menu">
                            <nav>
                                <ul>
                                    <li class="top-hover"><a href="index.php">Trang chủ</a></li>
                                    <li><a href="about-us.php">Về chúng tôi</a></li>
                                    <li class="mega-menu-position top-hover"><a href="shop.php">Sản phẩm</a></li>
                                    <li><a href="contact.php">Liên hệ</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- mobile-menu-area-start -->
        <div class="mobile-menu-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="mobile-menu">
                            <nav id="mobile-menu-active">
                                <ul class="menu-overflow" id="nav">
                                    <li><a href="index.php">Trang chủ</a></li>
                                    <li><a href="shop.php"> Sản phẩm </a></li>
                                    <li><a href="contact.php">Liên hệ</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- mobile-menu-area-end -->
    </header>