<?php
require_once "inc/init.php";
if (isset($_SESSION['logged_username'])) {
    $user = User::findUsername($pdo, $_SESSION['logged_username']);
    if ($user->role == "admin") {
        header("location: 404.php");
        exit();
    }
}
$cateid = isset($_GET['cateid']) ? $_GET['cateid'] : 0;
$search = isset($_GET['search']) ? $_GET['search'] : "";
$column = isset($_GET['column']) ? $_GET['column'] : "";
$order =  isset($_GET['order']) ? $_GET['order'] : "";
$page = isset($_GET['page']) ? $_GET['page'] : 1;

$data_shop = Product::getAll($pdo, $search, $column, $order, $cateid, $page);
$data_shop2 = Product::getAll($pdo, $search, $column, $order, $cateid, 0);
$count = count($data_shop2);
$number_of_page = ceil($count / 9);

?>


<?php
$title = "Sản phẩm";
require_once "inc/header.php";
?>
<div class="breadcrumb-area gray-bg">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="index.php">Trang chủ</a></li>
                <li class="active">Sản phẩm</li>
            </ul>
        </div>
    </div>
</div>
<div class="container pt-50">
    <form action="shop.php" method="get" class="row">
        <div class="col-md-8 col-8">
            <input name="search" value="<?= $search ?>" placeholder="Nhập sản phẩm bạn muốn tìm kiếm...">
        </div>
        <div class="col-md-4 col-4">
            <input class="btn h-100 btn-outline-danger" type="submit" value="Tìm kiếm">
        </div>
    </form>
</div>
<div class="shop-page-area pt-50 pb-50">
    <div class="container">
        <div class="row flex-row-reverse">
            <div class="col-lg-9">
                <div class="banner-area pb-30">
                    <!-- <a href="product-details.php"><img alt="" src="assets/img/banner/banner-49.jpg"></a> -->
                    <img alt="" src="assets/img/banner/banner-49.jpg">
                </div>
                <div class="shop-topbar-wrapper">
                    <div class="shop-topbar-left">
                        <ul class="view-mode">
                            <!-- Sửa lại chỗ này! -->
                            <li class="active"><a href="#product-grid" data-view="product-grid"><i class="fa fa-th"></i></a></li>
                            <li><a href="#product-list" data-view="product-list"><i class="fa fa-list-ul"></i></a></li>
                        </ul>
                    </div>
                    <div class="product-sorting-wrapper">
                        <div class="product-show shorting-style">
                            <label>Sắp xếp:</label>
                            <select class="sort" id="sort" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                                <option value="">Sắp xếp theo</option>
                                <option value="?search=<?= $search ?>&cateid=<?= $cateid ?>&column=name&order=asc"> A -> Z</option>
                                <option value="?search=<?= $search ?>&cateid=<?= $cateid ?>&column=name&order=desc"> Z -> A</option>
                                <option value="?search=<?= $search ?>&cateid=<?= $cateid ?>&column=price&order=asc"> Giá tăng dần</option>
                                <option value="?search=<?= $search ?>&cateid=<?= $cateid ?>&column=price&order=desc"> Giá giảm dần</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="grid-list-product-wrapper">
                    <div class="product-grid product-view pb-20">
                        <div class="row">
                            <?php if (count($data_shop) != 0) : ?>
                                <?php foreach ($data_shop as $product) : ?>
                                    <div class="product-width col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 mb-30">
                                        <div class="product-wrapper">
                                            <div class="product-img">
                                                <a href="product-details.php?id=<?= $product->product_id ?>">
                                                    <img src="<?= $product->image ?>" alt="">
                                                </a>
                                                <div class="product-action">
                                                    <div class="pro-action-left">
                                                        <a href="add-cart.php?product_id=<?= $product->product_id ?>&amount=1">
                                                            <i class="ion-android-cart"></i>Thêm vào giỏ hàng
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="product-content">
                                                <h4>
                                                    <a href="product-details.php?id=<?= $product->product_id ?>"><?= $product->name ?></a>
                                                </h4>
                                                <div class="product-price-wrapper">
                                                    <span><?= number_format($product->price, 0, ',', '.') ?> VND</span>
                                                    <!-- <span class="product-price-old">$120.00 </span> -->
                                                </div>
                                            </div>
                                            <div class="product-list-details">
                                                <h4>
                                                    <a href="product-details.php?id=<?= $product->product_id ?>"><?= $product->name ?></a>
                                                </h4>
                                                <div class="product-price-wrapper">
                                                    <span><?= number_format($product->price, 0, ',', '.') ?> VND</span>
                                                    <!-- <span class="product-price-old">$120.00 </span> -->
                                                </div>
                                                <p><?= $product->description ?></p>
                                                <div class="shop-list-cart-wishlist">
                                                    <a href="add-cart.php?product_id=<?= $product->product_id ?>&amount=1" title="Thêm vào giỏ hàng"><i class="ion-android-cart"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <div>
                                    <h1>Sản phẩm bạn tìm không tồn tại</h1>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="pagination-total-pages">
                        <div class="pagination-style">
                            <ul>
                                <li><a id="previous_button" class="prev-next prev" href="#"><i class="ion-ios-arrow-left"></i> Prev</a></li>
                                <?php for ($i = 0; $i < $number_of_page; $i++) : ?>
                                    <?php if ($page == $i + 1) : ?>
                                        <li>
                                            <a class="active" href="shop.php?search=<?= $search ?>&cateid=<?= $cateid ?>&column=<?= $column ?>&order=<?= $order ?>&page=<?= $i + 1 ?>">
                                                <?= $i + 1 ?></a>
                                        </li>
                                    <?php else : ?>
                                        <li><a href="shop.php?search=<?= $search ?>&cateid=<?= $cateid ?>&column=<?= $column ?>&order=<?= $order ?>&page=<?= $i + 1 ?>"><?= $i + 1 ?></a></li>
                                    <?php endif ?>
                                <?php endfor ?>
                                <li><a id="next_button" class="prev-next next" href="#">Next<i class="ion-ios-arrow-right"></i> </a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="shop-sidebar-wrapper gray-bg-7 shop-sidebar-mrg">
                    <div class="shop-widget">
                        <h4 class="shop-sidebar-title">Danh mục</h4>
                        <div class="shop-catigory">
                            <ul id="faq">
                                <?php foreach ($data_category as $cate) : ?>
                                    <li>
                                        <a href="shop.php?cateid=<?= $cate->category_id ?>&column=<?= $column ?>&order=<?= $order ?>"><?= $cate->category_name ?></a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                    <div class="shop-widget mt-40 shop-sidebar-border pt-35">
                        <h4 class="shop-sidebar-title">Popular Tags</h4>
                        <div class="shop-tags mt-25">
                            <ul>
                            <li><a href="shop.php">All</a></li>
                                <?php foreach ($data_category as $cate) : ?>
                                    <li><a href="shop.php?cateid=<?= $cate->category_id ?>&column=<?= $column ?>&order=<?= $order ?>"><?= $cate->category_name ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById('previous_button').addEventListener('click', function() {
        // Lấy trang hiện tại
        var currentPage = <?= $page ?>;
        // Nếu không phải trang đầu tiên thì chuyển đến trang trước đó
        if (currentPage > 1) {
            window.location.href = "shop.php?search=<?= $search ?>&cateid=<?= $cateid ?>&column=<?= $column ?>&order=<?= $order ?>&page=" + (currentPage - 1);
        }
    });

    document.getElementById('next_button').addEventListener('click', function() {
        // Lấy trang hiện tại
        var currentPage = <?= $page ?>;
        // Nếu không phải trang cuối cùng thì chuyển đến trang kế tiếp
        if (currentPage < <?= $number_of_page ?>) {
            window.location.href = "shop.php?search=<?= $search ?>&cateid=<?= $cateid ?>&column=<?= $column ?>&order=<?= $order ?>&page=" + (currentPage + 1);
        }
    });
</script>
<?php
require_once "inc/footer.php";
?>