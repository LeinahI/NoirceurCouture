<?php

function emailBody($veri_code, $fname, $lname)
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
