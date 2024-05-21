<?php
include('emailBody.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../vendor/autoload.php';
use josegonzalez\Dotenv\Loader;
$dotenv = new Loader(dirname(__DIR__) . '/.env');
$dotenv->parse()->putenv()->toEnv();

$emailService = getenv('EMAIL_HOST_SERVICE');
$emailUsername = getenv('EMAIL_SENDER_USERNAME');
$emailPassword = getenv('EMAIL_SENDER_PASSWORD');

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

function emailChangeVerifyOTP($email, $subject, $veri_code, $fname, $lname)
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
        $mail->Body = emailBodyChangeEmailVerifyIdentityOTP($veri_code, $fname, $lname, $subject);

        $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

function emailChangeEmailSendOld($oldEmail, $newEmail, $subject, $fname, $lname)
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
        $mail->addAddress($oldEmail, "$fname $lname"); //Add a recipient

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body = emailBodyEmailChangeSendToOld($fname, $lname, $subject, $oldEmail, $newEmail);

        $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

function emailChangeEmailSendNew($oldEmail, $newEmail, $subject, $fname, $lname)
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
        $mail->addAddress($newEmail, "$fname $lname"); //Add a recipient

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body = emailBodyEmailChangeSendToNew($fname, $lname, $subject, $oldEmail, $newEmail);

        $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

function sellerRegistration($email, $subject, $registrationUrl){
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
        $mail->addAddress($email); //Add a recipient

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body = emailBodySellerRegistration($email, $subject, $registrationUrl);

        $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

function greetSellerAcceptedAccount($email, $subject, $fname, $lname, $brandName)
{
    //Load Composer's autoloader
    require __DIR__ . '/../vendor/autoload.php';


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
        $mail->Body = emailBodySellerAccepted($brandName);

        $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

function greetSellerRejectedAccount($email, $subject, $fname, $lname, $brandName)
{
    //Load Composer's autoloader
    require __DIR__ . '/../vendor/autoload.php';


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
        $mail->Body = emailBodySellerRejected($brandName);

        $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}