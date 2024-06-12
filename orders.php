<?php
require_once "inc/init.php";
if (isset($_SESSION['logged_username'])) {
    $user = User::findUsername($pdo, $_SESSION['logged_username']);
    if ($user->role == "admin") {
        header("location: 404.php");
        exit();
    }
}
if (!isset($_SESSION['logged_username'])) {
    header("Location: login-register.php");
    exit();
}
$orders = Orders::get_order($pdo, $_SESSION['logged_username']);
$title = "Đơn đặt hàng";
require_once "inc/header.php";
?>
<div class="breadcrumb-area gray-bg">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="index.php">Trang chủ</a></li>
                <li class="active">Đơn đặt hàng </li>
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
                                    <th>Người đặt</th>
                                    <th>Địa chỉ / Thời gian</th>
                                    <th>Thành tiền</th>
                                    <th>Trạng thái</th>
                                    <th>Huỷ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($orders as $item) : ?>
                                    <?php $user = User::findUsername($pdo, $item->username); ?>
                                    <tr>
                                        <td class="product-thumbnail">
                                            <a href="orderdetail.php?order_id=<?= $item->order_id ?>">
                                                <?= $i ?>
                                            </a>
                                        </td>
                                        <td class="product-name">
                                            <?= $user->name ?>
                                        </td>
                                        <td class="product-price-cart">
                                            <span class="amount"><?= $item->delivery_address ?></br>
                                                <?= $item->date ?></span>
                                        </td>
                                        <td class="product-subtotal"><?= number_format($item->total, 0, ',', '.') ?> VND </br> (<?= $item->payment_status ?>)</td>
                                        <td class="product-subtotal"><?= $item->delivery_status ?></td>
                                        <td class="product-remove">
                                            <?php if ($item->delivery_status == "Chưa duyệt") : ?>
                                                <a href="cancel-order.php?order_id=<?= $item->order_id ?>"><i class="fa fa-times"></i></a>
                                            <?php else : ?>
                                                <p class="text-danger">Không thể huỷ đơn</p>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php $i += 1;
                                endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="cart-shiping-update-wrapper">
                                <div class="cart-shiping-update">
                                    <a href="shop.php">Tiếp tục mua hàng</a>
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