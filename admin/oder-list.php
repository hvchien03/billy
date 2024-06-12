<?php
//search chưa làm
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
$search = '';
// if($_SERVER['REQUEST_METHOD'] == 'POST'){
//     $search = $_POST['search'];
//     $orders = Orders::get_order($pdo, $search);
// }
$orders = Orders::get_all_orders($pdo);
require_once "inc_admin/header.php" ?>
<!-- /header-dashboard -->
<!-- main-content -->
<div class="main-content">
    <!-- main-content-wrap -->
    <div class="main-content-inner">
        <!-- main-content-wrap -->
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Order List</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="index.php">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <a href="#">
                            <div class="text-tiny">Order</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">Order List</div>
                    </li>
                </ul>
            </div>
            <!-- order-list -->
            <div class="wg-box">
                <div class="flex items-center justify-between gap10 flex-wrap">
                    <div class="wg-filter flex-grow">
                        <form class="form-search" method="post">
                            <fieldset class="name">
                                <input type="text" placeholder="Search here..." class="" name="search" tabindex="2" value="<?=$search?>" aria-required="true" required="">
                            </fieldset>
                            <div class="button-submit">
                                <button class="" type="submit"><i class="icon-search"></i></button>
                            </div>
                        </form>
                    </div>
                    <a class="tf-button style-1 w208" href="oder-list.php"><i class="icon-file-text"></i>All order</a>
                </div>
                <div class="wg-table table-all-category">
                    <ul class="table-title flex gap20 mb-14">
                        <li>
                            <div class="body-title">Username</div>
                        </li>
                        <li style="margin-left: -90px;">
                            <div class="body-title">Order ID</div>
                        </li>
                        <li>
                            <div class="body-title">Date</div>
                        </li>
                        <li>
                            <div class="body-title">Price</div>
                        </li>
                        <li>
                            <div class="body-title">Address</div>
                        </li>
                        <li>
                            <div class="body-title">Payment Status</div>
                        </li>
                        <li>
                            <div class="body-title">Tracking</div>
                        </li>
                        <li>
                            <div class="body-title">Action</div>
                        </li>
                    </ul>
                    <ul class="flex flex-column">
                        <?php foreach ($orders as $order) : ?>
                            <li class="product-item gap14">
                                <div class="flex items-center justify-between gap20 flex-grow">
                                    <div class="name">
                                        <a href="oder-detail.php?order_id=<?= $order->order_id ?>" class="body-title-2"><?= $order->username ?></a>
                                    </div>
                                    <div class="body-text"><?= $order->order_id ?></div>
                                    <div style="margin-left:-100px;" class="body-text"><?= $order->date ?></div>
                                    <div style="margin-left:20px;" class="body-text"><?= number_format($order->total, 0, ',', '.') ?> VND</div>
                                    <div class="body-text"><?= $order->delivery_address ?></div>
                                    <div style="margin-left:-50px;">
                                        <div class="block-available"><?= $order->payment_status ?></div>
                                    </div>
                                    <div>
                                        <div class="block-tracking"><?= $order->delivery_status ?></div>
                                    </div>
                                    <div class="list-icon-function">
                                        <a href="oder-detail.php?order_id=<?= $order->order_id ?>">
                                            <div class="item eye">
                                                <i class="icon-eye"></i>
                                            </div>
                                        </a>
                                        <!-- <div class="item edit">
                                            <i class="icon-edit-3"></i>
                                        </div>
                                        <div class="item trash">
                                            <i class="icon-trash-2"></i>
                                        </div> -->
                                    </div>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="divider"></div>
                <div class="flex items-center justify-between flex-wrap gap10">
                    <div class="text-tiny">Showing 10 entries</div>
                    <ul class="wg-pagination">
                        <li>
                            <a href="#"><i class="icon-chevron-left"></i></a>
                        </li>
                        <li>
                            <a href="#">1</a>
                        </li>
                        <li class="active">
                            <a href="#">2</a>
                        </li>
                        <li>
                            <a href="#">3</a>
                        </li>
                        <li>
                            <a href="#"><i class="icon-chevron-right"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- /order-list -->
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