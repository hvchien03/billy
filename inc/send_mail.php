<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function sendMail($to, $content)
{

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'chienvan1203@gmail.com';                     //SMTP username
        $mail->Password   = 'hlma yiaz nycm vubk';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('chienvan1203@gmail.com', 'BILLY');
        $mail->addAddress($to);     //Add a recipient

        //Content
        $mail->isHTML(true);
        //Set email format to HTML
        $mail->Subject = '=?UTF-8?B?' . base64_encode('Mã đổi mật khẩu cho tài khoản của bạn') . '?=';
        $mail->Body    = $content;

        $mail->send();
        echo 'Gửi thành công';
    } catch (Exception $e) {
        echo "Gửi mail thất bại. Mailer Error: {$mail->ErrorInfo}";
    }
}
