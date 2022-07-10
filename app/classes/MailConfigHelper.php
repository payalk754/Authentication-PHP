<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

class MailConfigHelper
{
    public static function getMailer(): PHPMailer
    {
        //create an instance passing 'true' enables exceptions
        $mail = new PHPMailer(true);
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.mailtrap.io';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = '4cb8f58a5b40cd';                     //SMTP username
        $mail->Password   = 'ffbefc714bf969';                               //SMTP password
        $mail->SMTPSecure = 'tls';        //Enable implicit TLS encryption
        $mail->Port       = 2525;                                   //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        
        $mail->setFrom('from@example.com', 'Mailer');
        //$mail->addAddress('joe@example.net', 'Joe User');     //Add a recipient
        $mail->isHTML(true);

        return $mail;
    }
}
?>