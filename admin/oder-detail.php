<?php
//check
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
$order_id = $_GET['order_id'];
if (empty($order_id)) {
    header("location: ../404.php");
    exit();
}
$order = Orders::get_orders_by_id($pdo, $order_id);
$ordersdetail = OrderDetail::getOrderDetail($pdo, $order_id);
if (empty($ordersdetail)) {
    header("location: ../404.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (Orders::updateStatus($pdo, $order_id, "Đang chuẩn bị hàng")) {
        header("location: oder-list.php");
        exit();
    }
}

$title = "Chi tiết đơn đặt hàng";
require_once "inc_admin/header.php" ?>

<!-- /header-dashboard -->
<!-- main-content -->
<div class="main-content">
    <!-- main-content-wrap -->
    <div class="main-content-inner">
        <!-- main-content-wrap -->
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Order <?= $order_id ?></h3>
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
                        <a href="oder-list.php">
                            <div class="text-tiny">Order</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <a href="#">
                            <div class="text-tiny">Order detail</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">Order <?= $order_id ?></div>
                    </li>
                </ul>
            </div>
            <!-- order-detail -->
            <div class="wg-order-detail">
                <div class="left flex-grow">
                    <div class="wg-box mb-20">
                        <div class="wg-table table-order-detail">
                            <ul class="table-title flex items-center justify-between gap20 mb-24">
                                <li>
                                    <div class="body-title">All item</div>
                                </li>
                                <!-- <li>
                                    <div class="dropdown default">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="body-title-2 flex items-center gap8">Sort<i class="h6 icon-chevron-down"></i></span>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a href="javascript:void(0);">Name</a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);">Quantity</a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);">Price</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li> -->
                            </ul>
                            <ul class="flex flex-column">
                                <!-- lỗi chỗ này -->
                                <?php $TOTAL = 0;
                                foreach ($ordersdetail as $pro) :
                                    $TOTAL += $pro->total;
                                    $product = Product::getOneById($pdo, $pro->product_id); ?>
                                    <li class="product-item gap14">
                                        <div class="image no-bg">
                                            <img src="../<?= $product->image ?>" alt="">
                                        </div>
                                        <div class="flex items-center justify-between gap40 flex-grow">
                                            <div class="name">
                                                <div class="text-tiny mb-1">Product name</div>
                                                <a href="product-list.php" class="body-title-2"><?= $product->name ?></a>
                                            </div>
                                            <div class="name">
                                                <div class="text-tiny mb-1">Quantity</div>
                                                <div class="body-title-2"><?= $pro->quantity ?></div>
                                            </div>
                                            <div class="name">
                                                <div class="text-tiny mb-1">Price</div>
                                                <div class="body-title-2"><?= number_format($pro->price, 0, ',', '.') ?> VND</div>
                                            </div>
                                            <div class="name">
                                                <div class="text-tiny mb-1">Total</div>
                                                <div class="body-title-2"><?= number_format($pro->total, 0, ',', '.') ?> VND</div>
                                            </div>
                                        </div>
                                    </li>
                                <?php
                                endforeach; ?>
                            </ul>
                        </div>
                    </div>
                    <div class="wg-box">
                        <div class="wg-table table-cart-totals">
                            <ul class="table-title flex mb-24">
                                <li>
                                    <div class="body-title">Cart Totals</div>
                                </li>
                                <li>
                                    <div class="body-title">Price</div>
                                </li>
                            </ul>
                            <ul class="flex flex-column gap14">
                                <li class="cart-totals-item">
                                    <span class="body-text">Subtotal:</span>
                                    <span class="body-title-2"><?= number_format($TOTAL, 0, ',', '.') ?> VND</span>
                                </li>
                                <li class="divider"></li>
                                <li class="cart-totals-item">
                                    <span class="body-text">Shipping:</span>
                                    <span class="body-title-2">20.000 VND</span>
                                </li>
                                <li class="divider"></li>
                                <li class="cart-totals-item">
                                    <span class="body-title">Total price:</span>
                                    <span class="body-title tf-color-1"><?= number_format($TOTAL + 20000, 0, ',', '.') ?> VND</span>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
                <div class="right">
                    <div class="wg-box mb-20 gap10">
                        <div class="body-title">Summary</div>
                        <div class="summary-item">
                            <div class="body-text">Order ID</div>
                            <div class="body-title-2"><?= $order_id ?></div>
                        </div>
                        <div class="summary-item">
                            <div class="body-text">Date</div>
                            <div class="body-title-2"><?= $order->date ?></div>
                        </div>
                        <div class="summary-item">
                            <div class="body-text">Total</div>
                            <div class="body-title-2 tf-color-1"><?= number_format($TOTAL + 20000, 0, ',', '.') ?> VND</div>
                        </div>
                    </div>
                    <div class="wg-box mb-20 gap10">
                        <div class="body-title">Shipping Address</div>
                        <div class="body-text"><?= $order->delivery_address ?></div>
                    </div>
                    <div class="wg-box mb-20 gap10">
                        <div class="body-title">Payment Method</div>
                        <div class="body-text"><?= $order->payment_status ?></div>
                    </div>
                    <div class="wg-box gap10">
                        <div class="body-title">Expected Date Of Delivery</div>
                        <div class="body-title-2 tf-color-2">20 Nov 2023</div>
                        <form method="post">
                            <button class="tf-button style-1 w-full" type="submit"><i class="icon-truck"></i>Preparing</button>
                        </form>
                        <a class="tf-button style-1 w-full" href="oder-tracking.php?order_id=<?= $order_id ?>"><i class="icon-truck"></i>Tracking</a>
                    </div>
                </div>
            </div>
            <!-- /order-detail -->
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
<?php require_once "inc_admin/footer.php" ?>