<?php
require_once 'inc_admin/init.php';
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
if (empty($_GET['id'])) {
    header("location: ../404.php");
    exit();
}
$id = $_GET['id'];
$error = '';
$error_name = "";
$cate_name = "";
$cate_item = Category::getOne($pdo, $_GET['id']);
if (empty($cate_item)) {
    header("location: ../404.php");
    exit();
} else {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $cate_name = $_POST['cate_name'];
        if (empty($cate_name)) {
            $error_name = "Không được để trống";
        }
        if (Category::checkName($pdo, $cate_name)) {
            $error_name = 'Danh mục đã tồn tại';
        }
        if (empty($error_name)) {
            if (Category::update($pdo, $id, $cate_name)) {
                header("location: category-list.php");
                exit();
            } else {
                $error = 'Sửa thất bại';
            }
        }
    }
}
?>
<?php require_once "inc_admin/header.php" ?>
<!-- /header-dashboard -->
<!-- main-content -->
<div class="main-content">
    <!-- main-content-wrap -->
    <div class="main-content-inner">
        <!-- main-content-wrap -->
        <div class="main-content-wrap">
            <!-- new-category -->
            <div class="wg-box">
                <form class="form-new-product form-style-1" method="post">
                    <div class="name">
                        <div class="body-title">Product name <span class="tf-color-1">*</span></div>
                        <input class="flex-grow" type="text" name="cate_name" tabindex="0" value="<?= $cate_item->category_name ?>">
                        <span class="fs-4 text-danger"><?= $error_name ?></span>
                    </div>
                    <div class="bot">
                        <a class="fs-4" href="category-list.php">Quay lại</a>
                        <div></div>
                        <button class="btn-danger tf-button w208" type="submit">Update</button>
                        <span class="fs-4 text-danger"><?= $error ?></span>
                    </div>
                </form>
            </div>
            <!-- /new-category -->
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