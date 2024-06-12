<?php
require_once "inc/init.php";
if (isset($_SESSION['logged_username'])) {
    $user = User::findUsername($pdo, $_SESSION['logged_username']);
    if ($user->role == "admin") {
        header("location: 404.php");
        exit();
    }
}
if (isset($_GET['delete_all'])) {
    $Carts = Cart::getOneCart($data_cart, $_SESSION['logged_username']);
    foreach ($Carts as $item) {
        Cart::delete_cart_item($pdo, $item->product_id);
    }
} else {
    $id = $_GET['id'];
    Cart::delete_cart_item($pdo, $id);
}
header("location: cart-page.php");
