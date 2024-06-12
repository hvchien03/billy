<?php
require_once "inc/init.php";
if (isset($_SESSION['logged_username'])) {
    $user = User::findUsername($pdo, $_SESSION['logged_username']);
    if ($user->role == "admin") {
        header("location: 404.php");
        exit();
    }
}
$title = "Billy - Food & Drink";
require_once "inc/header.php";
?>


<div class="slider-area-2">
    <div class="slider-active owl-dot-style owl-carousel">
        <div class="single-slider pt-210 pb-220 bg-img" style="background-image:url(assets/img/slider/slider-3.jpg);">
            <div class="container">
                <div class="slider-content slider-animated-2 text-center">
                    <h1 class="animated">Cà phê & Bánh ngọt</h1>
                    <div class="slider-btn mt-90">
                        <a class="animated" href="#">Đặt ngay</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="single-slider pt-210 pb-220 bg-img" style="background-image:url(https://pikbest.com//backgrounds/drawing-coffee-banner-poster-background_453178.html);">
            <div class="container">
                <div class="slider-content slider-animated-2 text-center">
                    <h1 class="animated">Cà phê & Bánh ngọt</h1>
                    <div class="slider-btn mt-90">
                        <a class="animated" href="#">Đặt ngay</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="product-area pt-95 pb-70">
    <div class="custom-container">
        <div class="product-tab-list-wrap text-center mb-40 yellow-color">
            <div class="product-tab-list nav">
                <a class="active" href="#tab1" data-bs-toggle="tab">
                    <h4>Trà </h4>
                </a>
                <a href="#tab2" data-bs-toggle="tab">
                    <h4>Bánh Ngọt </h4>
                </a>
                <a href="#tab3" data-bs-toggle="tab">
                    <h4> Cà Phê </h4>
                </a>
            </div>
        </div>
        <div class="tab-content jump yellow-color">
            <!-- all sản phẩm -->
            <div id="tab1" class="tab-pane active">
                <div class="row">
                    <?php foreach ($data as $product) : ?>
                        <?php if ($product->category == 1) : ?>
                            <div class="custom-col-5">
                                <div class="product-wrapper mb-25">
                                    <div class="product-img">
                                        <a href="product-details.php?id=<?= $product->product_id ?>">
                                            <img src="<?= $product->image ?>" alt="">
                                        </a>
                                        <div class="product-action">
                                            <div class="pro-action-left">
                                                <a class="add-to-cart" href="add-cart.php?product_id=<?= $product->product_id ?>&amount=1">
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
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
            <!-- đồ ăn -->
            <div id="tab2" class="tab-pane">
                <div class="row">
                    <?php foreach ($data as $product) : ?>
                        <?php if ($product->category == 2) : ?>
                            <div class="custom-col-5">
                                <div class="product-wrapper mb-25">
                                    <div class="product-img">
                                        <a href="product-details.php?id=<?= $product->product_id ?>">
                                            <img src="<?= $product->image ?>" alt="">
                                        </a>
                                        <div class="product-action">
                                            <div class="pro-action-left">
                                                <a class="add-to-cart" href="add-cart.php?product_id=<?= $product->product_id ?>&amount=1">
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
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
            <!-- đồ uống -->
            <div id="tab3" class="tab-pane">
                <div class="row">
                    <?php foreach ($data as $product) : ?>
                        <?php if ($product->category == 3) : ?>
                            <div class="custom-col-5">
                                <div class="product-wrapper mb-25">
                                    <div class="product-img">
                                        <a href="product-details.php?id=<?= $product->product_id ?>">
                                            <img src="<?= $product->image ?>" alt="">
                                        </a>
                                        <div class="product-action">
                                            <div class="pro-action-left">
                                                <a class="add-to-cart" href="add-cart.php?product_id=<?= $product->product_id ?>&amount=1">
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
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="banner-area row-col-decrease pb-75 clearfix">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                <div class="single-banner mb-30">
                    <div class="hover-style">
                        <a href="#"><img src="assets/img/banner/banner-7.jpg" alt=""></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                <div class="single-banner mb-30">
                    <div class="hover-style">
                        <a href="#"><img src="assets/img/banner/banner-8.jpg" alt=""></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="best-food-area pb-95">
    <div class="custom-container">
        <div class="row">
            <div class="best-food-width-1">
                <div class="single-banner">
                    <div class="hover-style">
                        <!-- <a href="#"><img src="assets/img/banner/banner-5.jpg" alt=""></a> -->
                        <a href="#"><img src="assets/img/banner/cake.jpg" alt=""></a>
                    </div>
                </div>
            </div>
            <div class="best-food-width-2">
                <div class="product-top-bar section-border mb-25 yellow-color">
                    <div class="section-title-wrap">
                        <h3 class="section-title section-bg-white">Best Food In Our Shop</h3>
                    </div>
                    <div class="product-tab-list-2 nav section-bg-white">
                        <a class="active" href="#tab4" data-bs-toggle="tab">
                            <h4>Trà </h4>
                        </a>
                        <a href="#tab5" data-bs-toggle="tab">
                            <h4>Bánh Ngọt</h4>
                        </a>
                        <a href="#tab6" data-bs-toggle="tab">
                            <h4> Cà Phê </h4>
                        </a>
                    </div>
                </div>
                <div class="tab-content jump yellow-color">
                    <div id="tab4" class="tab-pane active">
                        <div class="product-slider-active owl-carousel product-nav">
                            <?php foreach ($data as $product) : ?>
                                <?php if ($product->category == 1) : ?>
                                    <div class="product-wrapper">
                                        <div class="product-img">
                                            <a href="product-details.php?id=<?= $product->product_id ?>">
                                                <img src="<?= $product->image ?>" alt="">
                                            </a>
                                            <div class="product-action">
                                                <div class="pro-action-left">
                                                    <a class="add-to-cart" href="add-cart.php?product_id=<?= $product->product_id ?>&amount=1">
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
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div id="tab5" class="tab-pane">
                        <div class="product-slider-active owl-carousel product-nav">
                            <?php foreach ($data as $product) : ?>
                                <?php if ($product->category == 2) : ?>
                                    <div class="product-wrapper">
                                        <div class="product-img">
                                            <a href="product-details.php?id=<?= $product->product_id ?>">
                                                <img src="<?= $product->image ?>" alt="">
                                            </a>
                                            <div class="product-action">
                                                <div class="pro-action-left">
                                                    <a class="add-to-cart" href="add-cart.php?product_id=<?= $product->product_id ?>&amount=1">
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
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div id="tab6" class="tab-pane">
                        <div class="product-slider-active owl-carousel product-nav">
                            <?php foreach ($data as $product) : ?>
                                <?php if ($product->category == 3) : ?>
                                    <div class="product-wrapper">
                                        <div class="product-img">
                                            <a href="product-details.php?id=<?= $product->product_id ?>">
                                                <img src="<?= $product->image ?>" alt="">
                                            </a>
                                            <div class="product-action">
                                                <div class="pro-action-left">
                                                    <a class="add-to-cart" href="add-cart.php?product_id=<?= $product->product_id ?>&amount=1">
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
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="best-food-width-1 mrg-small-35">
                <div class="single-banner">
                    <div class="hover-style">
                        <!-- <a href="#"><img src="assets/img/banner/banner-6.jpg" alt=""></a> -->
                        <a href="#"><img src="assets/img/banner/cf2.jpg" alt=""></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="banner-area">
    <div class="container">
        <div class="discount-overlay bg-img pt-180 pb-150" style="background-image:url(assets/img/banner/banner-10.jpg);">
            <div class="discount-content text-center">
                <h3>It’s Time To Start <br>Your Own Revolution By Laurent</h3>
                <p>Exclusive Offer -10% Off This Week</p>
                <div class="banner-btn">
                    <a href="#">Order Now</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="brand-logo-area pt-100 pb-100">
    <div class="container">
        <div class="brand-logo-active owl-carousel">
            <div class="single-brand-logo">
                <img alt="" src="assets/img/brand-logo/logo-1.png">
            </div>
            <div class="single-brand-logo">
                <img alt="" src="assets/img/brand-logo/logo-2.png">
            </div>
            <div class="single-brand-logo">
                <img alt="" src="assets/img/brand-logo/logo-3.png">
            </div>
            <div class="single-brand-logo">
                <img alt="" src="assets/img/brand-logo/logo-4.png">
            </div>
            <div class="single-brand-logo">
                <img alt="" src="assets/img/brand-logo/logo-5.png">
            </div>
            <div class="single-brand-logo">
                <img alt="" src="assets/img/brand-logo/logo-2.png">
            </div>
        </div>
    </div>
</div>

<?php
require_once "inc/footer.php";
?>