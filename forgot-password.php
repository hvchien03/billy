<?php
require_once "inc/init.php";
if (isset($_SESSION['logged_username'])) {
    $user = User::findUsername($pdo, $_SESSION['logged_username']);
    if ($user->role == "admin") {
        header("location: 404.php");
        exit();
    }
}

$error = "";
$username = "";
$usernameError = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['form-import'])) { #form import
        $username = $_POST['username'];
        $user = User::findUsername($pdo, $username);
        if (!$user) {
            $usernameError = "Username không tồn tại";
        } else {
            $verificationCode = mt_rand(100000, 999999);
            $_SESSION['verificationCode'] = $verificationCode;
            $_SESSION['account-change-password'] = $user->username;
            $content = "
<html>
<head>
    <style>
        /* Định dạng màu cho các phần tử HTML */
        body {
            font-family: Arial, sans-serif;
            color: #333; /* Màu chữ mặc định */
        }
        .username {
            color: blue; /* Màu chữ cho tên người dùng */
        }
        .code {
            color: red; /* Màu chữ cho mã code */
            font-weight: bold; /* In đậm mã code */
        }
    </style>
</head>
<body>
    <p>Chào <span class=\"username\">$user->name</span>,</p>
    <p>Bạn đã yêu cầu thay đổi mật khẩu cho tài khoản của mình. Dưới đây là mã xác thực để hoàn thành quy trình này:</p>
    <p><strong>Mã xác thực:</strong> <span class=\"code\">$verificationCode</span></p>
    <p>Vui lòng sao chép mã này và dán vào trang web để tiếp tục quy trình đổi mật khẩu. Lưu ý rằng mã sẽ chỉ có hiệu lực trong một khoảng thời gian nhất định.</p>
    <p>Nếu bạn không thực hiện yêu cầu này, vui lòng bỏ qua email này. Đảm bảo bảo mật thông tin tài khoản của bạn bằng cách không chia sẻ mã xác thực này với bất kỳ ai khác.</p>
    <p>Nếu bạn có bất kỳ câu hỏi hoặc cần hỗ trợ, vui lòng liên hệ với chúng tôi qua email này.</p>
    <p>Trân trọng.</p>
</body>
</html>";

            sendMail($user->email, $content);
            header("location: change-password.php");
            exit();
        }
    }
}
$title = "Quên mật khẩu";
require_once "inc/header.php";
?>
<div class="breadcrumb-area gray-bg">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="index.php">Trang chủ</a></li>
                <li class="active"> Quên mật khẩu </li>
            </ul>
        </div>
    </div>
</div>
<div class="login-register-area pt-95 pb-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7 col-md-12 ml-auto mr-auto">
                <div class="login-register-wrapper">
                    <div class="login-register-tab-list nav">
                        <h4 class="active"> Quên mật khẩu </h4>
                    </div>
                    <div class="tab-content">
                        <div>
                            <div class="login-form-container">
                                <div class="login-register-form">
                                    <form action="forgot-password.php" method="post">
                                        <input class="mb-1" type="text" name="username" placeholder="Nhập username">
                                        <span class="text-danger"><?= $usernameError ?></span>
                                        <div class="button-box">
                                            <div class="login-toggle-btn">
                                                <a href="login-register.php">Quay lại</a>
                                            </div>
                                            <button type="submit" name="form-import"><span>Gửi</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
require_once "inc/footer.php";
?>