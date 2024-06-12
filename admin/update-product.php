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
$success = "";
$product_id = $_GET['id'];
if (empty($product_id)) {
    header("location: ../404.php");
    exit();
}
$data = Product::getAll($pdo, "", "", "", 0, 0);
$product = Product::getOne($data, $product_id);
if (empty($product)) {
    header("location: ../404.php");
    exit();
}
$name = "";
$price = 0;
//$image = "";
$dest = "";
$category = "";
$description = "";
$nameError = "";
$priceError = "";
$imageError = "";
$categoryError = "";
$descriptionError = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $price = $_POST['price'];
    //$image = $_POST['image'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    if (empty($name)) {
        $nameError = "Không được để trống";
    } else if (!preg_match("/^[\p{L}\s-]+$/u", $name)) {
        $nameError = "Không được có ký tự đặc biệt";
    }
    if (empty($price)) {
        $priceError = "Không được để trống";
    } else if ($price % 1000 !== 0) {
        $priceError = "Giá phải chia hết cho 1000";
    }
    if (!empty($image)) {
        try {
            switch ($_FILES['image']['error']) {
                case UPLOAD_ERR_OK:
                    break;
                case UPLOAD_ERR_NO_FILE:
                    throw new Exception('Tệp rỗng');
                default:
                    throw new Exception('Tải tệp thất bại');
            }
            if ($_FILES['image']['size'] > 2000000) {
                throw new Exception('Tệp quá lớn, không thể tải');
            }
            $mime_types = ['image/jpeg', 'image/png', 'image/webp'];
            $file_info = finfo_open(FILEINFO_MIME_TYPE);
            $mime_type = finfo_file($file_info, $_FILES['image']['tmp_name']);
            if (!in_array($mime_type, $mime_types)) {
                throw new Exception('Chỉ chấp nhận tệp .jpg .png .webp');
            }

            $pathinfo = pathinfo($_FILES['image']['name']);
            $fname = 'image';
            $extension = $pathinfo['extension'];
            $dest = '../assets/img/product/' . $fname . '.' . $extension;
            $i = 1;
            while (file_exists($dest)) {
                $dest = '../assets/img/product/' . $fname . "-$i." . $extension;
                $i++;
            }
            if (!move_uploaded_file($_FILES['image']['tmp_name'], $dest)) {
                throw new Exception('Lỗi');
            }
        } catch (Exception $e) {
            $imageError = $e->getMessage();
        }
    }

    if (empty($category)) {
        $categoryError = "Không được để trống";
    }
    if (empty($description)) {
        $descriptionError = "Không được để trống";
    }
    if (empty($nameError) && empty($priceError) && empty($imageError) && empty($categoryError) && empty($descriptionError)) {
        $dest1 = ltrim($dest, '../');
        if (empty($image)) {
            if (Product::update($pdo, $product_id, $name, $price, "", $category, $description)) {
                header("Location: product-list.php");
                exit();
            } else {
                $success = "Sửa không thành công";
            }
        } else {
            if (Product::update($pdo, $product_id, $name, $price, $dest1, $category, $description)) {
                header("Location: product-list.php");
                exit();
            } else {
                $success = "Sửa không thành công";
            }
        }
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
                <h3>Sửa sản phẩm</h3>
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
                        <div class="text-tiny">Sửa sản phẩm</div>
                    </li>
                </ul>
            </div>
        </div>
        <!-- form-add-product -->
        <form class="tf-section-2 form-add-product" method="post" id="productForm" enctype="multipart/form-data">
            <div class="wg-box">
                <!-- Tên sản phẩm -->
                <div>
                    <div class="body-title">Tên sản phẩm <span class="tf-color-1">*</span></div>
                    <input class="form-control" type="text" name="name" tabindex="0" value="<?= $product->name ?>">
                    <span class="text-danger fs-5 fs-5"><?= $nameError ?></span>
                </div>
                <div class="gap22 cols">
                    <!-- Giá -->
                    <div class="col-6">
                        <div class="body-title">Giá <span class="tf-color-1">*</span></div>
                        <div>
                            <input class="form-control" type="number" name="price" tabindex="0" value="<?= $product->price ?>">
                        </div>
                        <span class="text-danger fs-5"><?= $priceError ?></span>
                    </div>
                    <!-- Loại -->
                    <div class="col-6">
                        <div class="body-title">Loại <span class="tf-color-1">*</span></div>
                        <div class="select">
                            <select aria-label="Default select example" name="category">
                                <?php foreach ($data_category as $category) : ?>
                                    <?php if ($category->category_id == $product->category) : ?>
                                        <option value="<?= $category->category_id; ?>" selected><?= $category->category_name; ?></option>
                                    <?php else : ?>
                                        <option value="<?= $category->category_id; ?>"><?= $category->category_name; ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <span class="text-danger fs-5"><?= $categoryError ?></span>
                    </div>
                </div>
                <!-- Hình ảnh -->
                <div>
                    <div class="body-title">Hình ảnh <span class="tf-color-1">*</span></div>
                    <div>
                        <input class="form-control" type="file" id="formFile" name="image" tabindex="0" value="<?= $product->image ?>">
                        <span class="text-danger fs-5"><?= $imageError ?></span>
                    </div>
                </div>
                <!-- Mô tả -->
                <div>
                    <div class="body-title">Mô tả <span class="tf-color-1">*</span></div>
                    <textarea class="form-control" style="font-size: 16px;" name="description" tabindex="0"><?= $product->description ?></textarea>
                    <span class="text-danger fs-5"><?= $descriptionError ?></span>
                </div>
                <div class="cols gap10">
                    <button class="tf-button w-full" type="submit">Sửa sản phẩm</button>
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
<script>
    document.getElementById('formFile').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const imagePreview = document.getElementById('imagePreview');
                imagePreview.src = e.target.result;
                imagePreview.style.display = 'block';
            }
            reader.readAsDataURL(file);
        }
    });
    document.getElementById('imagePreview').addEventListener('error', function() {
        this.src = '../assets/img/product/no-image.png'; // Thay đổi đường dẫn tới ảnh no-image của bạn
    });
</script>