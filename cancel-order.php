<?php
require_once 'inc/init.php';
if (isset($_SESSION['logged_username'])) {
    $user = User::findUsername($pdo, $_SESSION['logged_username']);
    if ($user->role == "admin") {
        header("location: 404.php");
        exit();
    }
}
$order_id = $_GET['order_id'];
if (empty($order_id) || Orders::get_orders_by_id($pdo, $order_id) == null) {
    die("Order id không tồn tại");
}
Orders::cancel_order($pdo, $order_id);
header("location: orders.php");