<?php
require_once "inc/init.php";
if (isset($_SESSION['logged_username'])) {
    $user = User::findUsername($pdo, $_SESSION['logged_username']);
    if ($user->role == "admin") {
        header("location: 404.php");
        exit();
    }
}
if (isset($_GET['product_id'])) {
    if (!isset($_SESSION['logged_user'])) {
        header("location: login-register.php");
        exit;
    } else {
        $proid = $_GET['product_id'];
        $amount = $_GET['amount'];
        $cart_user = Cart::getOneCart($data_cart, $_SESSION['logged_username']);
        $cart_item = Cart::checkProduct($cart_user, $proid);
        if ($cart_item != null) {
            Cart::updateAmount($pdo, $amount, $proid);
        } else {
            Cart::addCart($pdo, $proid, $amount);
        }
        header("location: cart-page.php");
    }
}
