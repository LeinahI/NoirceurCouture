<?php

function emailBodyVerificationCode($veri_code, $fname, $lname)
{
    $image_url = 'https://i.imgur.com/yTLX0Y2.png';

    $body = "
    <div style='margin-top: 30px;'>
    <img src='$image_url' alt='Noirceur Couture Logo' height='40px' width='auto'>
    <h1>Verification Code</h1>

    <p style='font-size: 16px;'>Hi $fname $lname,</p>
    <p style='font-size: 16px;'>This is your temporary verification code.</p>

    <h1 style='color:blue'>$veri_code</h1>

    <p style='font-size: 16px;'>Thank you!</p>
    <p style='font-size: 16px;'>Noirceur Couture Support Team</p>

    <p style='color:gray; font-size: 16px'><i>If you didn't sign up, you can safely ignore this email.</i></p>
    </div>
    ";

    return $body;
}

function emailBodyBuyerAccountActivation($fname, $lname)
{

    $image_url = 'https://i.imgur.com/yTLX0Y2.png';

    $body = "
    <div style='margin-top: 30px;'>
    <img src='$image_url' alt='Noirceur Couture Logo' height='40px' width='auto'>
    <h1>Congratulations! Your Account is Now Verified</h1>

    <p style='font-size: 16px; font-weight: bold;'>Dear $fname $lname,</p>
    <p style='font-size: 16px; font-weight: bold;'>We are excited to inform you that your account on NoirceurCouture has been successfully verified as a buyer. 🎉</p>
    <p style='font-size: 16px;'>With your verified account, you now have access to a range of benefits, including:</p>

    <ol>
        <li>
            <p style='font-size: 16px; font-weight: bold;'>Seamless shopping experience: Browse and purchase products effortlessly.</p>
        </li>
        <li>
            <p style='font-size: 16px; font-weight: bold;'>Exclusive offers: Stay updated on the latest deals and promotions.</p>
        </li>
        <li>
            <p style='font-size: 16px; font-weight: bold;'>Faster checkout: Save time with pre-filled information during checkout.</p>
        </li>
    </ol>
    <br>
    <p style='font-size: 16px;'>Thank you for choosing NoirceurCouture. We're dedicated to providing you with the best shopping experience possible.</p>

    <p style='font-size: 16px;'>Happy shopping! 🛒</p>

    <p style='font-size: 16px; font-weight: bold;'>Best Regards,</p>
    <p style='font-size: 16px; font-weight: bold;'>Noirceur Couture Support Team</p>


    <p style='color:gray; font-size: 16px'><i>If you didn't sign up, you can safely email us for any concerns</i></p>
    </div>
    ";

    return $body;
}

function emailBodyResetPassword($fname, $lname, $resetPassUrl, $subject)
{
    $image_url = 'https://i.imgur.com/yTLX0Y2.png';

    $body = "
    <div style='margin-top: 30px;'>
    <img src='$image_url' alt='Noirceur Couture Logo' height='40px' width='auto'>
    <h1>$subject</h1>

    <p style='font-size: 16px; font-weight: bold;'>Dear $fname $lname,</p>
    <p style='font-size: 16px;'>We received a request to reset your password for your account on NoirceurCouture. To proceed with resetting your password, please click the link below:</p>

    <a href='$resetPassUrl' style='font-size: 16px; font-weight: bold;'>[Reset Password Link]</a>


    <p style='font-size: 16px;'>If you did not request this password reset, you can safely ignore this email. Your password will remain unchanged.</p>

    <p style='font-size: 16px;'>Thank you for using NoirceurCouture.</p>

    <p style='font-size: 16px; font-weight: bold;'>Best Regards,</p>
    <p style='font-size: 16px; font-weight: bold;'>Noirceur Couture Support Team</p>
    </div>
    ";

    return $body;
}
