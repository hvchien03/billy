<?php
require_once "inc/init.php";
if (isset($_SESSION['logged_username'])) {
    $user = User::findUsername($pdo, $_SESSION['logged_username']);
    if ($user->role == "admin") {
        header("location: 404.php");
        exit();
    }
}
$product_id = $_GET['id'];
if (empty($product_id)) {
    header("Location: 404.php");
    exit();
}
$product = Product::getOne($data, $product_id);
if (empty($product)) {
    header("Location: 404.php");
    exit();
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];
    if(Message::addReview($pdo, $name, $email, $message, $product_id)){
        echo "<script>alert('Thêm đánh giá thành công')</script>";
    }else{
        echo "<script>alert('Thêm đánh giá thất bại')</script>";
    }
}
$title = "Chi tiết sản phẩm";
require_once "inc/header.php";
?>
<div class="breadcrumb-area gray-bg">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="index.php">Trang chủ</a></li>
                <li class="active">Chi tiết sản phẩm </li>
            </ul>
        </div>
    </div>
</div>
<div class="product-details pt-100 pb-90">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-12">
                <div class="product-details-img">
                    <img class="w-100" src="<?= $product->image ?>" />
                    <span>-29%</span>
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
                <div class="product-details-content">
                    <h4><?= $product->name ?></h4>
                    <div class="rating-review">
                        <div class="pro-dec-rating">
                            <i class="ion-android-star-outline theme-star"></i>
                            <i class="ion-android-star-outline theme-star"></i>
                            <i class="ion-android-star-outline theme-star"></i>
                            <i class="ion-android-star-outline theme-star"></i>
                            <i class="ion-android-star-outline"></i>
                        </div>
                        <div class="pro-dec-review">
                            <ul>
                                <li> 32 Đánh giá </li>
                                <!-- <li> Thêm đánh giá</li> -->
                            </ul>
                        </div>
                    </div>
                    <span><?= number_format($product->price, 0, ',', '.') ?> VND</span>
                    <p><?= $product->description ?></p>
                    <div class="pro-details-cart-wrap">
                        <div class="shop-list-cart-wishlist">
                            <div class="select-option-part">
                                <select class="select">
                                    <option value="">M</option>
                                    <option value="">L</option>
                                </select>
                            </div>

                        </div>
                        <form action="add-cart.php" method="get">
                            <input style="display:none;" name="product_id" value="<?= $product->product_id ?>">
                            <div class="product-quantity px-3">
                                <div class="cart-plus-minus">
                                    <input class="cart-plus-minus-box" type="text" name="amount" value="1">
                                </div>
                            </div>
                            <div class="shop-list-cart-wishlist mt-3">
                                <!-- Thêm vào giỏ hàng // href="add-cart.php?product_id=<?= $product->product_id ?>&amount=" -->
                                <button type="submit" style="width: 90px; height:60px" class="btn btn-outline-danger" title="Thêm vào giỏ hàng">
                                    <i class="ion-android-cart fs-2"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="pro-dec-categories">
                        <ul>
                            <li class="categories-title">Categories:</li>
                            <?php foreach ($data_category as $cate) : ?>
                                <li><a href="shop.php?cateid=<?= $cate->category_id ?>"><?= $cate->category_name ?>,</a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="description-review-area pb-100">
    <div class="container">
        <div class="description-review-wrapper">
            <div class="description-review-topbar nav text-center">
                <a class="active" data-bs-toggle="tab" href="#des-details3">Review</a>
            </div>
            <div class="tab-content description-review-bottom">
                <div id="des-details3" class="tab-pane active">
                    <div class="rattings-wrapper">
                        <?php $data_message = Message::getOneMessage($pdo, $product_id);
                        foreach ($data_message as $item) : ?>
                            <div class="sin-rattings">
                                <div class="star-author-all">
                                    <div class="ratting-star f-left">
                                        <i class="ion-star theme-color"></i>
                                        <i class="ion-star theme-color"></i>
                                        <i class="ion-star theme-color"></i>
                                        <i class="ion-star theme-color"></i>
                                        <i class="ion-star theme-color"></i>
                                        <span>(5)</span>
                                    </div>
                                    <div class="ratting-author f-right">
                                        <h3><?=$item->name?></h3>
                                        <span><?= date('H:i', strtotime($item->date)) ?></span>
                                        <span><?= date('d/m/Y', strtotime($item->date)) ?></span>
                                    </div>
                                </div>
                                <p><?=$item->message?>.</p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="ratting-form-wrapper">
                        <h3>Add your Comments :</h3>
                        <div class="ratting-form">
                            <form method="post">
                                <div class="star-box">
                                    <h2>Rating:</h2>
                                    <div class="ratting-star">
                                        <i class="ion-star theme-color"></i>
                                        <i class="ion-star theme-color"></i>
                                        <i class="ion-star theme-color"></i>
                                        <i class="ion-star theme-color"></i>
                                        <i class="ion-star"></i>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="rating-form-style mb-20">
                                            <input name="name" placeholder="Name" type="text" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="rating-form-style mb-20">
                                            <input name="email" placeholder="Email" type="text" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="rating-form-style form-submit">
                                            <textarea name="message" placeholder="Message" required></textarea>
                                            <input type="submit" value="add review">
                                        </div>
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
<div class="product-area pb-95">
    <div class="container">
        <div class="product-top-bar section-border mb-25">
            <div class="section-title-wrap">
                <h3 class="section-title section-bg-white">Related Products</h3>
            </div>
        </div>
        <div class="related-product-active owl-carousel product-nav">
            <?php foreach ($data as $item) {
                if ($item->product_id != $product_id) : ?>
                    <div class="product-wrapper">
                        <div class="product-img">
                            <a href="product-details.php?id=<?= $item->product_id ?>">
                                <img src="<?= $item->image ?>" alt="">
                            </a>
                            <div class="product-action">
                                <div class="pro-action-left">
                                    <a title="Thêm vào giỏ hàng" href="add-cart.php?product_id=<?= $item->product_id ?>?amount=1"><i class="ion-android-cart"></i>Thêm vào giỏ hàng</a>
                                </div>
                            </div>
                        </div>
                        <div class="product-content">
                            <h4>
                                <a href="product-details.php?id=<?= $item->product_id ?>"><?= $item->name ?></a>
                            </h4>
                            <div class="product-price-wrapper">
                                <span><?= number_format($item->price, 0, ',', '.') ?> VND</span>
                                <!-- <span class="product-price-old">$120.00 </span> -->
                            </div>
                        </div>
                    </div>
            <?php endif;
            } ?>
        </div>
    </div>
</div>
<?php
require_once "inc/footer.php";
?>