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
$search = isset($_GET['search']) ? $_GET['search'] : "";
$page = isset($_GET['page']) ? $_GET['page'] : 1;

$users = User::search($pdo, $search, $page);
$users1 = User::search($pdo, $search, 0);
$count = count($users1);
$number_of_page = ceil($count / 7);

require_once "inc_admin/header.php"; ?>
<!-- /header-dashboard -->
<!-- main-content -->
<div class="main-content">
    <!-- main-content-wrap -->
    <div class="main-content-inner">
        <!-- main-content-wrap -->
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>All User</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="home_admin.php">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <a href="all-user.php">
                            <div class="text-tiny">User</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">All User</div>
                    </li>
                </ul>
            </div>
            <!-- all-user -->
            <div class="wg-box">
                <div class="flex items-center justify-between gap10 flex-wrap">
                    <div class="wg-filter flex-grow">
                        <form class="form-search" method="get">
                            <fieldset class="name">
                                <input type="text" placeholder="Search here..." class="" name="search" tabindex="2" value="" aria-required="true" required="">
                            </fieldset>
                            <div class="button-submit">
                                <button class="" type="submit"><i class="icon-search"></i></button>
                            </div>
                        </form>
                    </div>
                    <a class="tf-button style-1 w208" href="add-new-user.php"><i class="icon-plus"></i>Tạo người dùng </a>
                </div>
                <div class="wg-table table-all-user">
                    <ul class="table-title flex gap20 mb-14">
                        <li>
                            <div class="body-title">User</div>
                        </li>
                        <li>
                            <div class="body-title">Phone</div>
                        </li>
                        <li>
                            <div class="body-title">Email</div>
                        </li>
                        <li>
                            <div class="body-title">Address</div>
                        </li>
                        <li>
                            <div class="body-title">Action</div>
                        </li>
                    </ul>
                    <ul class="flex flex-column">
                        <?php foreach ($users as $user) : ?>
                            <li class="user-item gap14">
                                <div class="flex items-center justify-between gap20 flex-grow">
                                    <div class="name" style="width:22%">
                                        <div class="body-title-2"><?= $user->name ?></div>
                                        <div class="text-tiny mt-3"><?= $user->username ?> - <?= $user->role ?></div>
                                    </div>
                                    <div class="body-text"><?= $user->phone ?></div>
                                    <div class="body-text"><?= $user->email ?></div>
                                    <div class="body-text"><?= $user->address ?></div>
                                    <div class="list-icon-function">
                                        <a href="update-user.php?username=<?= $user->username ?>">
                                            <div class="item edit">
                                                <i class="icon-edit-3"></i>
                                            </div>
                                        </a>
                                        <a href="delete-user.php?username=<?= $user->username ?>">
                                            <div class="item trash">
                                                <i class="icon-trash-2"></i>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="divider"></div>
                <div class="flex items-center justify-between flex-wrap gap10">
                    <div class="text-tiny">Showing 7 entries</div>
                    <ul class="wg-pagination">
                        <li>
                            <a id="previous_button" class="prev-next prev" href="#"><i class="icon-chevron-left"></i></a>
                        </li>
                        <?php for ($i = 0; $i < $number_of_page; $i++) : ?>
                            <?php if ($page == $i + 1) : ?>
                                <li>
                                    <a class="active" href="all-user.php?search=<?= $search ?>&page=<?= $i + 1 ?>">
                                        <?= $i + 1 ?></a>
                                </li>
                            <?php else : ?>
                                <li><a href="all-user.php?search=<?= $search ?>&page=<?= $i + 1 ?>"><?= $i + 1 ?></a></li>
                            <?php endif ?>
                        <?php endfor ?>
                        <li>
                            <a id="next_button" class="prev-next next" href="#"><i class="icon-chevron-right"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- /all-user -->
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
<script>
    document.getElementById('previous_button').addEventListener('click', function() {
        // Lấy trang hiện tại
        var currentPage = <?= $page ?>;
        // Nếu không phải trang đầu tiên thì chuyển đến trang trước đó
        if (currentPage > 1) {
            window.location.href = "all-user.php?search=<?= $search ?>&page=" + (currentPage - 1);
        }
    });

    document.getElementById('next_button').addEventListener('click', function() {
        // Lấy trang hiện tại
        var currentPage = <?= $page ?>;
        // Nếu không phải trang cuối cùng thì chuyển đến trang kế tiếp
        if (currentPage < <?= $number_of_page ?>) {
            window.location.href = "all-user.php?search=<?= $search ?>&page=" + (currentPage + 1);
        }
    });
</script>
<?php require_once "inc_admin/footer.php"; ?>