<?php
require_once "inc/init.php";
if (!isset($_SESSION['logged_user'])) {
    header("location: login-register.php");
    exit();
}
if (isset($_SESSION['logged_username'])) {
    $user = User::findUsername($pdo, $_SESSION['logged_username']);
    if ($user->role == "admin") {
        header("location: 404.php");
        exit();
    }
}

$user_cart = Cart::getOneCart($data_cart, $_SESSION['logged_username']);
$title = "Giỏ hàng";
require_once "inc/header.php";
?>
<div class="breadcrumb-area gray-bg">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="index.php">Trang chủ</a></li>
                <li class="active">Giỏ hàng </li>
            </ul>
        </div>
    </div>
</div>
<!-- shopping-cart-area start -->
<div class="cart-main-area pt-95 pb-100">
    <div class="container">
        <h3 class="page-title">Giỏ hàng của bạn</h3>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                <form action="" method="post">
                    <div class="table-content table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th>Hình ảnh</th>
                                    <th>Sản phẩm</th>
                                    <th>Giá</th>
                                    <th>Số lượng</th>
                                    <th>Tổng</th>
                                    <th>Xoá</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($user_cart as $item) : ?>
                                    <?php $product = Product::getOne($data, $item->product_id);
                                    $amount = $item->amount ?>
                                    <tr>
                                        <form method="post">
                                            <td class="product-thumbnail">
                                                <a href="product-details.php?id=<?= $product->product_id ?>">
                                                    <img class="w-50" src="<?= $product->image ?>" alt=""></a>
                                            </td>
                                            <td class="product-name">
                                                <a href="product-details.php?id=<?= $product->product_id ?>">
                                                    <?= $product->name ?>
                                                </a>
                                            </td>
                                            <td class="product-price-cart">
                                                <span class="amount"><?= number_format($product->price, 0, ',', '.') ?> VND</span>
                                            </td>
                                            <td class="product-quantity">
                                                <div class="cart-plus-minus">
                                                    <input class="cart-plus-minus-box" type="text" name="qtybutton" value="<?= $amount ?>">
                                                </div>
                                            </td>
                                            <td class="product-subtotal"><?= number_format($item->total, 0, ',', '.') ?> VND</td>
                                            <td class="product-remove">
                                                <a href="delete-cart.php?id=<?= $product->product_id ?>"><i class="fa fa-times"></i></a>
                                            </td>
                                        </form>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="cart-shiping-update-wrapper">
                                <div class="cart-shiping-update">
                                    <a href="shop.php">Tiếp tục mua hàng</a>
                                </div>
                                <div class="cart-clear">
                                    <button>Cập nhật</button>
                                    <a href="delete-cart.php?delete_all=true">Xoá</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="row">
                    <!-- <div class="col-lg-4 col-md-6">
                        <div class="cart-tax">
                            <div class="title-wrap">
                                <h4 class="cart-bottom-title section-bg-gray">Estimate Shipping And Tax</h4>
                            </div>
                            <div class="tax-wrapper">
                                <p>Enter your destination to get a shipping estimate.</p>
                                <div class="tax-select-wrapper">
                                    <div class="tax-select">
                                        <label>
                                            * Country
                                        </label>
                                        <select class="email s-email s-wid">
                                            <option>Bangladesh</option>
                                            <option>Albania</option>
                                            <option>Åland Islands</option>
                                            <option>Afghanistan</option>
                                            <option>Belgium</option>
                                        </select>
                                    </div>
                                    <div class="tax-select">
                                        <label>
                                            * Region / State
                                        </label>
                                        <select class="email s-email s-wid">
                                            <option>Bangladesh</option>
                                            <option>Albania</option>
                                            <option>Åland Islands</option>
                                            <option>Afghanistan</option>
                                            <option>Belgium</option>
                                        </select>
                                    </div>
                                    <div class="tax-select">
                                        <label>
                                            * Zip/Postal Code
                                        </label>
                                        <input type="text">
                                    </div>
                                    <button class="cart-btn-2" type="submit">Get A Quote</button>
                                </div>
                            </div>
                        </div>
                    </div> -->
                    <div class="col-lg-4 col-md-6">
                        <div class="discount-code-wrapper">
                            <div class="title-wrap">
                                <h4 class="cart-bottom-title section-bg-gray">Thêm mã giảm giá</h4>
                            </div>
                            <div class="discount-code">
                                <p>Nhập mã giảm giá</p>
                                <form>
                                    <input type="text" required="" name="name">
                                    <button class="cart-btn-2" type="submit">Thêm</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12">
                        <div class="grand-totall">
                            <div class="title-wrap">
                                <h4 class="cart-bottom-title section-bg-gary-cart">Thanh toán</h4>
                            </div>
                            <?php
                            $total = 0;
                            foreach ($user_cart as $item) {
                                $total += $item->total;
                            } ?>
                            <h5>Tổng số tiền <span><?= number_format($total, 0, ',', '.') ?> VND</span></h5>
                            <div class="total-shipping">
                                <h5>Phí vận chuyển <span style="float:right;">20.000 VND</span></h5>
                            </div>
                            <h4 class="grand-totall-title">Thành tiền <span><?= number_format($total + 20000, 0, ',', '.') ?> VND</span></h4>
                            <a href="checkout.php">Thanh toán</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
require_once "inc/footer.php";
?>