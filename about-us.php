<?php
require_once "inc/init.php";
if (isset($_SESSION['logged_username'])) {
    $user = User::findUsername($pdo, $_SESSION['logged_username']);
    if ($user->role == "admin") {
        header("location: 404.php");
        exit();
    }
}
$title = "Về chúng tôi";
require_once "inc/header.php";
?>
<div class="breadcrumb-area gray-bg">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="index.php">Trang chủ</a></li>
                <li class="active">Về chúng tôi </li>
            </ul>
        </div>
    </div>
</div>
<div class="about-us-area pt-100 pb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-5">
                <div class="overview-img text-center">
                    <a href="#">
                        <!-- <img src="assets/img/banner/about-us.jpg" alt=""> -->
                        <img src="https://images.pexels.com/photos/15961746/pexels-photo-15961746/free-photo-of-mon-an-c-c-ban-tra.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1">
                    </a>
                </div>
            </div>
            <div class="col-lg-6 col-md-7 d-flex align-items-center">
                <div class="overview-content-2">
                    <h2>Chào mừng đến với <span>Billy</span></h2>
                    <p class="peragraph-blog" style="text-align: justify;"> Đây là nơi bạn có thể tìm thấy sự hòa quyện tinh tế giữa hương vị tinh tế và không gian ấm cúng.
                        Chúng tôi tự hào giới thiệu một địa điểm lý tưởng cho những người yêu thưởng thức hương vị của nước,
                        trà và cà phê, cùng với những lựa chọn điểm tâm bánh ngọt hấp dẫn.
                    </p>
                    <p class="peragraph-blog" style="text-align: justify;">Tại cửa hàng của chúng tôi, chúng tôi không chỉ là những nhà bán nước, trà và cà phê,
                        mà còn là những người làm nên những trải nghiệm đặc biệt.
                        Với mỗi tách cà phê được pha chế tỉ mỉ, mỗi ly trà thơm ngon,
                        hay mỗi hơi thở của không khí ấm áp, chúng tôi mang đến cho khách hàng sự trọn vẹn và đầy đủ.</p>
                    <p class="peragraph-blog" style="text-align: justify;">Chúng tôi luôn lắng nghe và thấu hiểu những mong muốn của khách hàng,
                        từ đó tạo ra những sản phẩm và dịch vụ tốt nhất.
                        Bạn có thể tận hưởng những khoảnh khắc thư giãn bên bạn bè,
                        gia đình hoặc người thân trong không gian thoải mái và thân thiện của cửa hàng chúng tôi. </p>
                    <p class="peragraph-blog" style="text-align: justify;">Ngoài ra, với các lựa chọn điểm tâm bánh ngọt đa dạng và phong phú,
                        chúng tôi chắc chắn sẽ làm hài lòng cả những vị khách khó tính nhất.
                        Từ những chiếc bánh mềm mịn, đến những món bánh ngọt độc đáo,
                        chúng tôi luôn cam kết mang lại cho bạn những trải nghiệm đáng nhớ và thú vị. </p>
                    <p class="peragraph-blog" style="text-align: justify;">Hãy đến và thăm cửa hàng của chúng tôi để khám phá thế giới hương vị đa dạng và phong phú.
                        Chúng tôi rất mong được chào đón bạn và phục vụ bạn mỗi ngày!</p>
                    <div class="overview-btn mt-45">
                        <a class="btn-style-2" href="shop.php">Shop now!</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- <div class="project-count-area gray-bg pt-100 pb-70">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="single-count text-center mb-30">
                    <div class="count-icon">
                        <span class="ion-ios-briefcase-outline"></span>
                    </div>
                    <div class="count-title">
                        <h2 class="count">100</h2>
                        <span>project done</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="single-count text-center mb-30">
                    <div class="count-icon">
                        <span class="ion-ios-wineglass-outline"></span>
                    </div>
                    <div class="count-title">
                        <h2 class="count">100</h2>
                        <span>cups of coffee</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="single-count text-center mb-30">
                    <div class="count-icon">
                        <span class="ion-ios-lightbulb-outline"></span>
                    </div>
                    <div class="count-title">
                        <h2 class="count">100</h2>
                        <span>branding</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="single-count text-center mb-30 mrgn-none">
                    <div class="count-icon">
                        <span class="ion-happy-outline"></span>
                    </div>
                    <div class="count-title">
                        <h2 class="count">100</h2>
                        <span>happy clients</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> -->
<!-- <div class="skill-area pt-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="skill-wrapper">
                    <div class="section-border section-mrg-none mb-45">
                        <div class="section-title-wrap">
                            <h3 class="section-title section-bg-white">Our skills</h3>
                        </div>
                    </div>
                    <div class="skill">
                        <div class="progress">
                            <div class="lead">Marketing</div>
                            <div class="progress-bar wow fadeInLeft" data-progress="50%" style="width: 50%;" data-wow-duration="1.5s" data-wow-delay="1.2s"> <span>50%</span></div>
                        </div>
                        <div class="progress">
                            <div class="lead">Wordpress Theme</div>
                            <div class="progress-bar wow fadeInLeft" data-progress="60%" style="width: 60%;" data-wow-duration="1.5s" data-wow-delay="1.2s"><span>60%</span> </div>
                        </div>
                        <div class="progress">
                            <div class="lead">Shopify Theme</div>
                            <div class="progress-bar wow fadeInLeft" data-progress="70%" style="width: 70%;" data-wow-duration="1.5s" data-wow-delay="1.2s"><span>70%</span> </div>
                        </div>
                        <div class="progress">
                            <div class="lead">UI/UX Design</div>
                            <div class="progress-bar wow fadeInLeft" data-progress="80%" style="width: 80%;" data-wow-duration="1.5s" data-wow-delay="1.2s"><span>80%</span> </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="our-work-wrapper">
                    <div class="section-border section-mrg-none mb-45">
                        <div class="section-title-wrap">
                            <h3 class="section-title section-bg-white">Our Work</h3>
                        </div>
                    </div>
                    <div class="work-list">
                        <div class="single-work">
                            <div class="work-number">
                                <span>1</span>
                            </div>
                            <div class="work-content">
                                <h5>LOREM IPSUM DOLOR SIT AMET</h5>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent eu nisi ac mi</p>
                            </div>
                        </div>
                        <div class="single-work">
                            <div class="work-number">
                                <span>1</span>
                            </div>
                            <div class="work-content">
                                <h5>LOREM IPSUM DOLOR SIT AMET</h5>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent eu nisi ac mi</p>
                            </div>
                        </div>
                        <div class="single-work">
                            <div class="work-number">
                                <span>1</span>
                            </div>
                            <div class="work-content">
                                <h5>LOREM IPSUM DOLOR SIT AMET</h5>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent eu nisi ac mi</p>
                            </div>
                        </div>
                        <div class="single-work">
                            <div class="work-number">
                                <span>1</span>
                            </div>
                            <div class="work-content">
                                <h5>LOREM IPSUM DOLOR SIT AMET</h5>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent eu nisi ac mi</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> -->
<div class="team-area pt-100">
    <div class="container">
        <div class="section-border section-mrg-none mb-45">
            <div class="section-title-wrap">
                <h3 class="section-title section-bg-white">Đề tài</h3>
                <div>
                    <p class="peragraph-blog" style="text-align: justify;">Dự án lập trình web bán trà, cà phê, bánh ngọt được phát triển nhằm cung cấp một nền tảng thương mại điện tử chuyên nghiệp và tiện lợi cho các cửa hàng và quán cafe. Sử dụng PHP làm ngôn ngữ chính, trang web này sẽ giúp quản lý và bán hàng trực tuyến hiệu quả. Điểm nổi bật bao gồm:</p>
                    <ol>
                        <li>Giao diện thân thiện và dễ sử dụng: Khách hàng có thể dễ dàng duyệt và mua sắm các sản phẩm trà, cà phê, và bánh ngọt.</li>
                        <li>Giỏ hàng và thanh toán tại chỗ, khi nhận hàng: Hỗ trợ nhiều phương thức thanh toán an toàn và nhanh chóng.</li>
                        <li>Quản lý đơn hàng: Hệ thống theo dõi và quản lý đơn hàng từ lúc đặt hàng đến khi nhận đơn.</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="team-wrapper mb-30">
                    <div class="team-content text-center">
                        <span>Sinh viên thực hiện:</span>
                        <h4>Hoàng Văn Chiến</h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="team-wrapper mb-30">
                    <div class="team-content text-center">
                        <span>MSSV: </span>
                        <h4>2001215635</h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="team-wrapper mb-30">
                    <div class="team-content text-center">
                        <span>Trường, lớp: </span>
                        <h4>HUIT - 12DHTH03</h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="team-wrapper mb-30">
                    <div class="team-content text-center">
                        <span>Giảng viên hướng dẫn</span>
                        <h4>Đinh Nguyễn Trọng Nghĩa </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<div class="brand-logo-area pt-70 pb-100">
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