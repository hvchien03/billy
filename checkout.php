<?php
require_once "inc/init.php";
if (isset($_SESSION['logged_username'])) {
    $user = User::findUsername($pdo, $_SESSION['logged_username']);
    if ($user->role == "admin") {
        header("location: 404.php");
        exit();
    }
}
$user_cart = Cart::getOneCart($data_cart, $_SESSION['logged_username']);
$count = 0;
$total = 0;
foreach ($user_cart as $item) {
    $count++;
    $total += $item->total;
}
if($count == 0){
    header("location: shop.php");
}
$newAddress = "";
$checkPayment = "";
$checkPaymentError = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['form_address'])) {
        $_SESSION['newAddress'] = $_POST['address'];
        $newAddress = $_POST['address'];
    }
    if (isset($_POST['form_order'])) {
        //$checkPayment = $_POST['radio']; k lấy giá trị của radio được.
        if (isset($_SESSION['newAddress'])) { //người dùng thay đổi địa chỉ giao
            $newAddress = $_SESSION['newAddress'];
        } else { // người dùng không thay đổi địa chỉ giao
            $newAddress = User::findUsername($pdo, $_SESSION['logged_username'])->address;
        }
        $currentDateTime = date('Y/m/d H:i:s');
        Orders::create_Order($pdo, $_SESSION['logged_username'], $currentDateTime, $total, "Thanh toán khi giao hàng", "Chưa duyệt", $newAddress);
        $order_id = Orders::get_id($pdo, $_SESSION['logged_username'], $currentDateTime)->order_id;
        foreach ($user_cart as $item) {
            OrderDetail::createOrderDetail($pdo, $order_id, $item->product_id, $item->amount, $item->price, $item->total);
            Cart::delete_cart_item($pdo, $item->product_id);
        }
        unset($_SESSION['newAddress']);
        header("location: index.php");
    }
    $_SERVER['REQUEST_METHOD'] = "GET";
}

$title = "Thanh toán";
require_once "inc/header.php";
?>
<div class="breadcrumb-area gray-bg">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="index.php">Trang chủ</a></li>
                <li class="active"> Thanh toán </li>
            </ul>
        </div>
    </div>
</div>
<!-- checkout-area start -->
<div class="checkout-area pb-80 pt-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                <div class="checkout-wrapper">
                    <div id="faq" class="panel-group">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 class="panel-title"><span>1.</span>
                                    <a data-bs-toggle="collapse" data-bs-target="#payment-3">Thông tin giao hàng</a>
                                </h5>
                            </div>
                            <div id="payment-3" class="panel-collapse collapse show" data-bs-parent="#faq">
                                <div class="panel-body">
                                    <div class="shipping-information-wrapper">
                                        <div class="shipping-info-2">
                                            <?php $user = User::findUsername($pdo, $_SESSION['logged_username']) ?>
                                            <span>Billy</span>
                                            <span>Họ tên: <?= $user->name ?></span>
                                            <span>Số điện thoại: <?= $user->phone ?></span>
                                            <span>Địa chỉ: <?= $user->address ?></span>
                                        </div>
                                        <div class="edit-address">
                                            <a href="#">Thay đổi địa chỉ giao hàng</a>
                                        </div>
                                        <form action="" method="post">
                                            <div class="billing-select">
                                                <input type="text" name="address" value="<?= $newAddress ?>" placeholder="Nhập địa chỉ mới nếu bạn muốn thay đổi địa chỉ giao hàng">
                                            </div>
                                            <!-- <div class="ship-wrapper">
                                                <div class="single-ship">
                                                    <input type="radio" value="" name="check">
                                                    <label>Sử dụng địa chỉ mới</label>
                                                </div>
                                            </div> -->
                                            <div class="billing-back-btn">
                                                <div class="billing-back">
                                                </div>
                                                <div class="billing-btn">
                                                    <button type="submit" name="form_address">Tiếp tục</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 class="panel-title"><span>2.</span> <a data-bs-toggle="collapse" data-bs-target="#payment-6">Thông tin sản phẩm</a></h5>
                            </div>
                            <div id="payment-6" class="panel-collapse collapse" data-bs-parent="#faq">
                                <div class="panel-body">
                                    <div class="order-review-wrapper">
                                        <div class="order-review">
                                            <form action="" method="post">
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th class="width-1">Sản phẩm</th>
                                                                <th class="width-2">Giá</th>
                                                                <th class="width-3">Số lượng</th>
                                                                <th class="width-4">Tổng</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach ($user_cart as $item) : ?>
                                                                <?php $product = Product::getOne($data, $item->product_id);
                                                                $amount = $item->amount ?>
                                                                <tr>
                                                                    <td>
                                                                        <div class="o-pro-dec">
                                                                            <p><?= $product->name ?></p>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="o-pro-price">
                                                                            <p><?= number_format($product->price, 0, ',', '.') ?> VND</p>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="o-pro-qty">
                                                                            <p><?= $amount ?></p>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="o-pro-subtotal">
                                                                            <p><?= number_format($item->total, 0, ',', '.') ?> VND</p>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            <?php endforeach; ?>
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <td colspan="3">Tổng tiền các sản phẩm </td>
                                                                <td colspan="1"><?= number_format($total, 0, ',', '.') ?> VND</td>
                                                            </tr>
                                                            <tr class="tr-f">
                                                                <td colspan="3">Phí giao hàng</td>
                                                                <td colspan="1">20.000 VND</td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="3">Thành tiền</td>
                                                                <td colspan="1"><?= number_format($total + 20000, 0, ',', '.') ?> VND</td>
                                                            </tr>
                                                            <div class="total-shipping">
                                                                <h5>Phương thức thanh toán</h5>
                                                                <!-- <ul>
                                                                    <li><input type="radio" name="radio" value="Quét mã QR"> Quét mã QR </li>
                                                                    <li><input type="radio" name="radio" value="Thanh toán khi giao hàng" checked> Thanh toán khi giao hàng </li>
                                                                    <span class="text-danger"><?= $check_paymentError ?></span>
                                                                </ul> -->
                                                            </div>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                                <div class="billing-back-btn">
                                                    <span>
                                                        Bạn quên gì hả?
                                                        <a href="cart-page.php"> Trở lại giỏ hàng.</a>
                                                    </span>
                                                    <div class="billing-btn">
                                                        <button type="submit" name="form_order">Đặt hàng</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="checkout-progress">
                    <h4>Các bước thanh toán</h4>
                    <ul>
                        <li>Thông tin giao hàng</li>
                        <li>Thông tin sản phẩm</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require_once "inc/footer.php";
?>