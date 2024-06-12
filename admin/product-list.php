<?php 
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
require_once "inc_admin/header.php";
$cateid = isset($_GET['cateid']) ? $_GET['cateid'] : 0;
$search = isset($_GET['search']) ? $_GET['search'] : "";
$column = isset($_GET['column']) ? $_GET['column'] : "";
$order =  isset($_GET['order']) ? $_GET['order'] : "";
$page = isset($_GET['page']) ? $_GET['page'] : 1;

$data_shop2 = Product::getAll($pdo, $search, $column, $order, $cateid, 0);
$count = count($data_shop2);
$number_of_page = ceil($count / 9);
$data_shop = Product::getAll($pdo, $search, $column, $order, $cateid, $page);
?>
<!-- /header-dashboard -->
<!-- main-content -->
<div class="main-content">
    <!-- main-content-wrap -->
    <div class="main-content-inner">
        <!-- main-content-wrap -->
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Danh sách sản phẩm</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="home_admin.php">
                            <div class="text-tiny">Trang chủ</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <a href="#">
                            <div class="text-tiny">Sản phẩm</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">Danh sách sản phẩm</div>
                    </li>
                </ul>
            </div>
            <!-- product-list -->
            <div class="wg-box">
                <div class="flex items-center justify-between gap10 flex-wrap">
                    <div class="wg-filter flex-grow">
                        <form class="form-search">
                            <fieldset class="name">
                                <input type="text" value="<?= $search ?>" placeholder="Tìm kiếm..." class="" name="search" tabindex="2" value="" aria-required="true" required="">
                            </fieldset>
                            <div class="button-submit">
                                <button class="" type="submit"><i class="icon-search"></i></button>
                            </div>
                        </form>
                        <div class="product-show shorting-style">
                            <select class="sort" id="sort" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                                <option value="">Sắp xếp theo</option>
                                <option value="?search=<?= $search ?>&cateid=<?= $cateid ?>&column=name&order=asc"> A -> Z</option>
                                <option value="?search=<?= $search ?>&cateid=<?= $cateid ?>&column=name&order=desc"> Z -> A</option>
                                <option value="?search=<?= $search ?>&cateid=<?= $cateid ?>&column=price&order=asc"> Giá tăng dần</option>
                                <option value="?search=<?= $search ?>&cateid=<?= $cateid ?>&column=price&order=desc"> Giá giảm dần</option>
                            </select>
                        </div>
                    </div>

                    <a class="tf-button style-1 w208" href="add-product.php"><i class="icon-plus"></i>Thêm sản phẩm </a>
                </div>
                <div class="wg-table table-product-list">
                    <ul class="table-title flex gap20 mb-14">
                        <li>
                            <div class="body-title">Sản phẩm</div>
                        </li>
                        <li>
                            <div class="body-title">Mã sản phẩm</div>
                        </li>
                        <li>
                            <div class="body-title">Giá</div>
                        </li>
                        <li>
                            <div class="body-title">Loại</div>
                        </li>
                        <li>
                            <div class="body-title">Chỉnh sửa</div>
                        </li>
                    </ul>
                    <ul class="flex flex-column">
                        <?php if (count($data_shop) != 0) : ?>
                            <?php foreach ($data_shop as $product) : ?>
                                <li class="product-item gap14">
                                    <div class="image no-bg">
                                        <img src="../<?= $product->image ?>" alt="">
                                    </div>
                                    <div class="flex items-center justify-between gap20 flex-grow">
                                        <div class="name">
                                            <p class="body-title-2"><?= $product->name ?></p>
                                        </div>
                                        <div class="body-text">
                                            <p class="body-title-2" style="margin-left: 140px;"><?= $product->product_id ?></p>
                                        </div>
                                        <div class="body-text"><?= number_format($product->price, 0, ',', '.') ?> VND</div>
                                        <?php
                                        $category_name = "";
                                        foreach ($data_category as $category) {
                                            if ($product->category == $category->category_id) {
                                                $category_name = $category->category_name;
                                                break;
                                            }
                                        }
                                        ?>
                                        <div class="body-text"><?= $category->category_name ?></div>
                                        <div class="list-icon-function">
                                            <div class="item edit">
                                                <a class="text-success" href="update-product.php?id=<?= $product->product_id ?>"><i class="icon-edit-3"></i></a>
                                            </div>
                                            <div class="item trash">
                                                <a class="text-danger" href="delete-product.php?id=<?= $product->product_id ?>"><i class="icon-trash-2"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <li class="product-item gap14">
                                <h2>
                                    Sản phẩm không tồn tại
                                </h2>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
                <div class="divider"></div>
                <div class="flex items-center justify-between flex-wrap gap10">
                    <div class="text-tiny">Showing 10 entries</div>
                    <ul class="wg-pagination">
                        <li>
                            <a id="previous_button">
                                <i class="icon-chevron-left"></i></a>
                        </li>
                        <?php for ($i = 0; $i < $number_of_page; $i++) : ?>
                            <?php if ($page == $i + 1) : ?>
                                <li class="active">
                                    <a href="product-list.php?search=<?= $search ?>&cateid=<?= $cateid ?>&column=<?= $column ?>&order=<?= $order ?>&page=<?= $i + 1 ?>">
                                        <?= $i + 1 ?></a>
                                </li>
                            <?php else : ?>
                                <li><a href="product-list.php?search=<?= $search ?>&cateid=<?= $cateid ?>&column=<?= $column ?>&order=<?= $order ?>&page=<?= $i + 1 ?>">
                                        <?= $i + 1 ?></a></li>
                            <?php endif ?>
                        <?php endfor ?>
                        <li>
                            <a id="next_button">
                                <i class="icon-chevron-right"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- /product-list -->
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
<script>
    document.getElementById('previous_button').addEventListener('click', function() {
        // Lấy trang hiện tại
        var currentPage = <?= $page ?>;
        // Nếu không phải trang đầu tiên thì chuyển đến trang trước đó
        if (currentPage > 1) {
            window.location.href = "product-list.php?search=<?= $search ?>&cateid=<?= $cateid ?>&column=<?= $column ?>&order=<?= $order ?>&page=" + (currentPage - 1);
        }
    });

    document.getElementById('next_button').addEventListener('click', function() {
        // Lấy trang hiện tại
        var currentPage = <?= $page ?>;
        // Nếu không phải trang cuối cùng thì chuyển đến trang kế tiếp
        if (currentPage < <?= $number_of_page ?>) {
            window.location.href = "product-list.php?search=<?= $search ?>&cateid=<?= $cateid ?>&column=<?= $column ?>&order=<?= $order ?>&page=" + (currentPage + 1);
        }
    });
</script>
<!-- /main-content -->
<?php require_once "inc_admin/footer.php" ?>