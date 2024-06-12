<?php
//check lại luôn
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
$success = "";
$product_id = $_GET['id'];
if (empty($product_id)) {
    header("location: ../404.php");
    exit();
}
$data = Product::getAll($pdo, "", "", "", 0, 0);
$product = Product::getOne($data, $product_id);
if(empty($product)){
    header("location: ../404.php");
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (Product::delete($pdo, $product_id)) {
        if (file_exists($product->image)) {
            unlink($product->image);
        }
        header("Location: product-list.php");
        exit();
    } else {
        $success = "Xoá không thành công";
    }
}
?>

<?php require_once "inc_admin/header.php"; ?>
<!-- /header-dashboard -->
<!-- main-content -->
<div class="main-content">
    <!-- main-content-wrap -->
    <div class="main-content-inner">
        <!-- main-content-wrap -->
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Xoá sản phẩm</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="index.php">
                            <div class="text-tiny">Trang chủ</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <a href="product-list.php">
                            <div class="text-tiny">Sản phẩm</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">Xoá sản phẩm</div>
                    </li>
                </ul>
            </div>
        </div>
        <!-- form-add-product -->
        <form class="tf-section-2 form-add-product" method="post" id="productForm">
            <div class="wg-box">
                <!-- Tên sản phẩm -->
                <div>
                    <div class="body-title">Tên sản phẩm <span class="tf-color-1">*</span></div>
                    <input class="form-control" style=" pointer-events: none;" type="text" name="name" tabindex="0" value="<?= $product->name ?>">
                </div>
                <div class="gap22 cols">
                    <!-- Giá -->
                    <div class="col-6">
                        <div class="body-title">Giá <span class="tf-color-1">*</span></div>
                        <div>
                            <input class="form-control" style=" pointer-events: none;" type="number" name="price" tabindex="0" value="<?= $product->price ?>">
                        </div>
                    </div>
                    <!-- Loại -->
                    <?php
                    $category_name = "";
                    foreach ($data_category as $category) {
                        if ($product->category == $category->category_id) {
                            $category_name = $category->category_name;
                            break;
                        }
                    }
                    ?>
                    <div class="col-6">
                        <div class="body-title">Loại <span class="tf-color-1">*</span></div>
                        <div>
                            <input class="form-control" style=" pointer-events: none;" type="text" name="category" tabindex="0" value="<?= $category_name ?>">
                        </div>
                    </div>
                </div>
                <!-- Hình ảnh -->
                <div>
                    <div class="body-title">Hình ảnh <span class="tf-color-1">*</span></div>
                    <div>
                        <input class="form-control" style=" pointer-events: none;" type="text" id="image" name="image" tabindex="0" value="<?= $product->image ?>">
                    </div>
                </div>
                <!-- Mô tả -->
                <div>
                    <div class="body-title">Mô tả <span class="tf-color-1">*</span></div>
                    <textarea class="form-control" style="font-size: 16px; pointer-events: none;" name="description" tabindex="0"><?= $product->description ?></textarea>

                </div>
                <div class="cols gap10">
                    <button class="tf-button w-full" type="submit">Xoá sản phẩm</button>
                </div>
                <span class="text-danger"><?= $success ?></span>
            </div>
            <div class="wg-box">
                <div class="body-title">Image Preview</div>
                <div class="upload-image mb-16">
                    <div class="mb-3">
                        <img id="imagePreview" class="w-100" src="../<?= $product->image ?>" />
                    </div>
                </div>
            </div>
        </form>
        <!-- /form-add-product -->
    </div>
    <!-- /main-content-wrap -->
</div>
<!-- /main-content-wrap -->
</div>
<!-- /main-content -->
<?php require_once "inc_admin/footer.php" ?>