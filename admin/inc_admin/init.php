<?php
session_start();
require_once "../class/Product.php";
require_once "../class/User.php";
require_once "../class/Database.php";
require_once "../class/Category.php";
require_once "../class/Orders.php";
require_once "../class/OrderDetail.php";
$pdo = Database::getConnect();
$data_category = Category::getAll($pdo);