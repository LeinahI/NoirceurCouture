<?php
include('emailBody.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$emailService = '';
$emailUsername = '';
$emailPassword = '';

function send_otp($email, $subject, $veri_code, $fname, $lname)
{
    //Load Composer's autoloader
    require '../vendor/autoload.php';

    //Create an instance; Passing `true` enables exceptions
    $mail = new PHPMailer(true);

    global $emailService, $emailUsername, $emailPassword;

    try {
        //Server settings
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = $emailService;                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = $emailUsername;                     //SMTP username
        $mail->Password   = $emailPassword;                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('from@example.com', 'Noirceur Couture Support Team');
        $mail->addAddress($email, "$fname $lname"); //Add a recipient

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body = emailBodyVerificationCode($veri_code, $fname, $lname, $subject);

        $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

function greetVerifiedUser($email, $subject, $fname, $lname)
{
    //Load Composer's autoloader
    require '../vendor/autoload.php';

    //Create an instance; Passing `true` enables exceptions
    $mail = new PHPMailer(true);

    global $emailService, $emailUsername, $emailPassword;

    try {
        //Server settings
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = $emailService;                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = $emailUsername;                     //SMTP username
        $mail->Password   = $emailPassword;                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('from@example.com', 'Noirceur Couture Support Team');
        $mail->addAddress($email, "$fname $lname"); //Add a recipient

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body = emailBodyBuyerAccountActivation( $fname, $lname);

        $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

function userResetPassword($email, $subject, $fname, $lname, $resetPassUrl){
    //Load Composer's autoloader
    require '../vendor/autoload.php';

    //Create an instance; Passing `true` enables exceptions
    $mail = new PHPMailer(true);

    global $emailService, $emailUsername, $emailPassword;

    try {
        //Server settings
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = $emailService;                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = $emailUsername;                     //SMTP username
        $mail->Password   = $emailPassword;                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('from@example.com', 'Noirceur Couture Support Team');
        $mail->addAddress($email, "$fname $lname"); //Add a recipient

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body = emailBodyResetPassword($fname, $lname, $resetPassUrl, $subject);

        $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
