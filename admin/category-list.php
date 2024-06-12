<?php 
require_once "inc_admin/init.php";
if (isset($_SESSION['logged_username'])) {
    $user = User::findUsername($pdo, $_SESSION['logged_username']);
    if ($user->role == "customer") {
        header("location: ../404.php");
        exit();
    }
}else{
    header("location: ../404.php");
    exit();
}
require_once "inc_admin/header.php";
$data_shop2 = Product::getAll($pdo, "", "", "", 0, 0);
$data_category = Category::getAll($pdo);

$cate_name = '';
$cate_name_error = '';
$success = '';
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cate_name'])) {
    $cate_name = $_POST['cate_name'];
    if (!preg_match("/^[\p{L}\s-]+$/u", $cate_name)) {
        $cate_name_error = 'Không nhập số và ký tự đặc biệt';
    }
    if (Category::checkName($pdo, $cate_name)) {
        $cate_name_error = 'Danh mục đã tồn tại';
    }
    if (empty($cate_name_error)) {
        if (Category::addCate($pdo, $cate_name)) {
            $success = 'Thêm thành công';
            $data_category = Category::getAll($pdo);
            $_POST['cate_name'] = null;
        } else {
            $success = 'Thêm thất bại';
        }
    }
}

?>
<!-- /header-dashboard -->
<!-- main-content -->
<div class="main-content">
    <!-- main-content-wrap -->
    <div class="main-content-inner">
        <!-- main-content-wrap -->
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>All category</h3>
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
                            <div class="text-tiny">Danh mục</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">Danh sách danh mục</div>
                    </li>
                </ul>
            </div>
            <!-- all-category -->
            <div class="wg-box">
                <!-- <div class="flex items-center justify-between gap10 flex-wrap">
                    <div class="wg-filter flex-grow">
                        <div class="show">
                            <div class="text-tiny">Showing</div>
                            <div class="select">
                                <select class="">
                                    <option>10</option>
                                    <option>20</option>
                                    <option>30</option>
                                </select>
                            </div>
                            <div class="text-tiny">entries</div>
                        </div>
                        <form class="form-search">
                            <fieldset class="name">
                                <input type="text" placeholder="Search here..." class="" name="name" tabindex="2" value="" aria-required="true" required="">
                            </fieldset>
                            <div class="button-submit">
                                <button class="" type="submit"><i class="icon-search"></i></button>
                            </div>
                        </form>
                    </div>
                    <a class="tf-button style-1 w208" href="new-category.php"><i class="icon-plus"></i>Add new</a>
                </div> -->
                <div class="wg-table table-all-category">
                    <ul class="table-title flex gap20 mb-14">
                        <li>
                            <div class="body-title">Tên danh mục</div>
                        </li>
                        <li>
                            <div class="body-title">Mã danh mục</div>
                        </li>
                        <li>
                            <div class="body-title">Số lượng</div>
                        </li>
                        <li>
                            <div class="body-title">Edit</div>
                        </li>
                    </ul>
                    <ul class="flex flex-column">
                        <?php foreach ($data_category as $cate) : ?>
                            <li class="product-item gap14">
                                <!-- <div class="image no-bg">
                                    <img src="images/products/51.png" alt="">
                                </div> -->
                                <div class="flex items-center justify-between gap20 flex-grow">
                                    <div class="name">
                                        <a href="product-list.php" class="body-title-2"><?= $cate->category_name ?></a>
                                    </div>
                                    <div class="body-text" style="margin-left: 100px;"><?= $cate->category_id ?></div>
                                    <?php $count = 0;
                                    foreach ($data_shop2 as $item) {
                                        if ($item->category == $cate->category_id)
                                            $count++;
                                    } ?>
                                    <div class="body-text"><?= $count ?></div>
                                    <div class="list-icon-function">
                                        <div class="item edit">
                                            <a href="update-category.php?id=<?= $cate->category_id ?>"><i class="icon-edit-3"></i></a>
                                        </div>
                                        <div class="item trash">
                                            <a href="delete-category.php?id=<?= $cate->category_id ?>"><i class="icon-trash-2"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <div class="divider mt-5">
                <div class="wg-box">
                    <form class="form-new-product form-style-1" name="add-cate" method="post">
                        <fieldset class="name">
                            <div class="body-title">Tên danh mục <span class="tf-color-1">*</span></div>
                            <input class="flex-grow" type="text" placeholder="Category name" name="cate_name" tabindex="0" required="">
                            <span class="text-danger fs-5"><?= $cate_name_error ?></span>
                        </fieldset>
                        <div class="bot">
                            <div></div>
                            <button class="tf-button w208" type="submit">Save</button>
                            <span class="fs-5"><?= $success ?></span>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /all-category -->
        </div>
        <!-- /main-content-wrap -->
    </div>
    <!-- /main-content-wrap -->
</div>
<!-- /main-content -->
<?php require_once "inc_admin/footer.php"; ?>