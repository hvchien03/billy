<?php
require_once "inc/init.php";
if (isset($_SESSION['logged_username'])) {
    $user = User::findUsername($pdo, $_SESSION['logged_username']);
    if ($user->role == "admin") {
        header("location: 404.php");
        exit();
    }
}
$title = "Liên hệ";
require_once "inc/header.php";
?>
<div class="breadcrumb-area gray-bg">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="index.php">Trang chủ</a></li>
                <li class="active"> Liên hệ </li>
            </ul>
        </div>
    </div>
</div>
<div class="contact-area pt-100 pb-100">
    <div class="container">
        <!-- <div class="row">
            <div class="col-lg-4 col-md-6 col-12">
                <div class="contact-info-wrapper text-center mb-30">
                    <div class="contact-info-icon">
                        <i class="ion-ios-location-outline"></i>
                    </div>
                    <div class="contact-info-content">
                        <h4>Our Location</h4>
                        <p>012 345 678 / 123 456 789</p>
                        <p><a href="#">info@example.com</a></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12">
                <div class="contact-info-wrapper text-center mb-30">
                    <div class="contact-info-icon">
                        <i class="ion-ios-telephone-outline"></i>
                    </div>
                    <div class="contact-info-content">
                        <h4>Contact us Anytime</h4>
                        <p>Mobile: 0374230091</p>
                        <p>Fax: 123 456 789</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12">
                <div class="contact-info-wrapper text-center mb-30">
                    <div class="contact-info-icon">
                        <i class="ion-ios-email-outline"></i>
                    </div>
                    <div class="contact-info-content">
                        <h4>Write Some Words</h4>
                        <p>chienvan1203@gmail.com</p>
                        <p><a href="#">info@example.com</a></p>
                    </div>
                </div>
            </div>
        </div> -->
        <div class="row">
            <div class="col-12">
                <div class="contact-message-wrapper">
                    <h4 class="contact-title">GET IN TOUCH</h4>
                    <div class="contact-message">
                        <form action="https://formspree.io/f/moqgzrra" method="post">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="contact-form-style mb-20">
                                        <input id="name" name="name" placeholder="Full Name" type="text" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="contact-form-style mb-20">
                                        <input id="email" name="email" placeholder="Email Address" type="email" required>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="contact-form-style mb-20">
                                        <input id="subject" name="subject" placeholder="Subject" type="text" required>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="contact-form-style">
                                        <textarea id="message" name="message" placeholder="Message" required></textarea>
                                        <button class="submit btn-style" type="submit">SEND MESSAGE</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <p class="form-messege"></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="contact-map">
            <iframe class="map-size" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.067295510655!2d106.62389239678951!3d10.806157900000017!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752be27d8b4f4d%3A0x92dcba2950430867!2zVHLGsOG7nW5nIMSQ4bqhaSBo4buNYyBDw7RuZyBUaMawxqFuZyBUUC4gSOG7kyBDaMOtIE1pbmg!5e0!3m2!1svi!2s!4v1711108488603!5m2!1svi!2s">
            </iframe>
        </div>
    </div>
</div>
<?php
require_once "inc/footer.php";
?>