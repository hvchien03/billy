<?php
require_once "inc/init.php";
if (isset($_SESSION['logged_username'])) {
    $user = User::findUsername($pdo, $_SESSION['logged_username']);
    if ($user->role == "admin") {
        header("location: 404.php");
        exit();
    }
}

$order_id = $_GET['order_id'];
if (empty($order_id)) {
    header("Location: 404.php");
    exit();
}
$order = Orders::get_orders_by_id($pdo, $order_id);
if ($order->username != $_SESSION['logged_username']) {
    header("Location: 404.php");
    exit();
}

$ordersdetail = OrderDetail::getOrderDetail($pdo, $order_id);
$title = "Chi tiết đơn đặt hàng";
require_once "inc/header.php";
?>
<div class="breadcrumb-area gray-bg">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="index.php">Trang chủ</a></li>
                <li class="active">Chi tiết đơn đặt hàng </li>
            </ul>
        </div>
    </div>
</div>
<!-- shopping-cart-area start -->
<div class="cart-main-area pt-95 pb-100">
    <div class="container">
        <h3 class="page-title">Đơn đặt hàng của bạn</h3>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                <form action="" method="post">
                    <div class="table-content table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Sản phẩm</throw>
                                    <th>Số lượng</th>
                                    <th>Giá</th>
                                    <th>Tổng</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($ordersdetail as $pro) :
                                    $product = Product::getOne($data, $pro->product_id); ?>
                                    <tr>
                                        <td class="product-thumbnail">
                                            <img class="w-50" src="<?= $product->image ?>">

                                        </td>
                                        <td class="product-name">

                                            <?= $product->name ?>
                                        </td>
                                        <td class="product-price-cart">
                                            <span class="amount">
                                                <p><?= $pro->quantity ?></p>
                                            </span>
                                        </td>
                                        <td class="product-subtotal"><?= number_format($pro->price, 0, ',', '.') ?> VND</td>
                                        <td class="product-subtotal"><?= number_format($pro->total, 0, ',', '.') ?> VND</td>
                                    </tr>
                                <?php
                                endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="cart-shiping-update-wrapper">
                                <div class="cart-shiping-update">
                                    <a href="orders.php">Trở lại</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
require_once "inc/footer.php";
?>