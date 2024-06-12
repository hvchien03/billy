<?php
session_start();
require_once "class/Product.php";
require_once "class/User.php";
require_once "class/Database.php";
require_once "class/Category.php";
require_once "class/Cart.php";
require_once "class/Orders.php";
require_once "class/OrderDetail.php";
require_once "class/Message.php";
//thư viện php mailer
require_once "inc/phpmailer/Exception.php";
require_once "inc/phpmailer/PHPMailer.php";
require_once "inc/phpmailer/SMTP.php";
require_once "inc/send_mail.php";

$pdo = Database::getConnect();
$data = Product::getAll($pdo, "", "", "", "", 0);
$data_category = Category::getAll($pdo);
$data_cart = Cart::getAll($pdo);
