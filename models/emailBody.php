<?php

function emailBodyVerificationCode($veri_code, $fname, $lname, $subject)
{
    $image_url = 'https://i.imgur.com/ELe78u6.png';

    $body = "
    <center>
    <div style='margin-top: 30px; width: 600px;'>
        <div style='padding: 20px; background-color: #816ACC;'>
        <img src='$image_url' alt='Noirceur Couture Logo' height='75px' width='auto'>
        </div>

        <div style='width: 550px;'>
        <h1 style='font-size: 16px; text-align: left;'>$subject</h1>

        <p style='font-size: 14px; text-align: left;'>Dear $fname $lname,</p>
        <p style='font-size: 14px; text-align: left;'>Thanks for joining NoirceurCouture. We want to make sure it's really you. Please enter the following verification code when prompted.</p>

        <div style='padding: 1px; margin: 0px 80px 0px 80px; background-color: #816ACC'>
            <p style='font-size: 14px; color: white; font-weight: bold;'>Verification Code</p>
            <h1 style='color:white; font-size: 36px; margin-top: 0px'>$veri_code</h1>
        </div>
        <p style='font-size: 12px;'> This is valid for 15 mins. NEVER share this code with others, including NoirceurCouture staff. </p>

        <p style='font-size: 14px; text-align: left; font-weight: bold;'>Thank you!</p>
        <p style='font-size: 14px; text-align: left; font-weight: bold;'>Noirceur Couture Support Team</p>
        
        <hr>
        <p style='color:gray; font-size: 14px; text-align: left;'><i>If you didn't sign up, you can safely ignore this email.</i></p>
    </div>
    </center>
    ";

    return $body;
}

function emailBodyBuyerAccountActivation($fname, $lname)
{

    $image_url = 'https://i.imgur.com/ELe78u6.png';

    $body = "
    <center>
    <div style='margin-top: 30px; width: 600px'>
        <div style='padding: 20px; background-color: #816ACC;'>
            <img src='$image_url' alt='Noirceur Couture Logo' height='75px' width='auto'>
        </div>

        <div style='width: 550px;'>
            <p style='font-size: 16px; font-weight: bold; text-align: left;'>Dear $fname $lname,</p>
            <p style='font-size: 16px; font-weight: bold; text-align: left;'>We are excited to inform you that your account on NoirceurCouture has been successfully verified as a buyer. 🎉</p>
            <p style='font-size: 16px; text-align: left;'>With your verified account, you now have access to a range of benefits, including:</p>

            <ol style='text-align: left;'>
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
            <p style='font-size: 16px; text-align: left;'>Thank you for choosing NoirceurCouture. We're dedicated to providing you with the best shopping experience possible.</p>

            <p style='font-size: 16px; text-align: left;'>Happy shopping! 🛒</p>

            <p style='font-size: 16px; text-align: left; font-weight: bold;'>Best Regards,</p>
            <p style='font-size: 16px; text-align: left; font-weight: bold;'>Noirceur Couture Support Team</p>
        </div>
        <hr>
        <p style='color:gray; font-size: 14px; text-align: left;'><i>If you didn't make this, you can safely ignore this email or email us for any concerns.</i></p>
    </div>
</center>
    ";

    return $body;
}

function emailBodyResetPassword($fname, $lname, $resetPassUrl, $subject)
{
    $image_url = 'https://i.imgur.com/ELe78u6.png';

    $body = "
    <center>
    <div style='margin-top: 30px; width: 600px;'>
        <div style='padding: 20px; background-color: #816ACC;'>
        <img src='$image_url' alt='Noirceur Couture Logo' height='75px' width='auto'>
        </div>

    <div style='width: 550px;'>
        <h1 style='font-size: 16px; text-align: left;'>$subject</h1>

        <p style='font-size: 14px; text-align: left;'>Dear $fname $lname,</p>
        <p style='font-size: 14px; text-align: left;'>We received a request to reset your password for your account on NoirceurCouture. To proceed with resetting your password, please click the link below:</p>

        <div style='padding: 1px; margin: 0px 80px 0px 80px; background-color: #816ACC'>
            <h1><a href='$resetPassUrl' style='font-size: 16px; font-weight: bold; color:white;'>[Reset Password Link]</a></h1>
        </div>
        <p style='font-size: 12px;'> This is valid for 15 mins. NEVER share this link with others, including
                    NoirceurCouture staff. </p>
        

        <p style='font-size: 14px; text-align: left;'>If you did not request this password reset, you can safely ignore this email. Your password will remain unchanged.</p>
        <p style='font-size: 14px; text-align: left; font-weight: bold;'>Thank you for using NoirceurCouture.</p>

        <p style='font-size: 14px; font-weight: bold; text-align: left;'>Best Regards,</p>
        <p style='font-size: 14px; font-weight: bold; text-align: left;'>Noirceur Couture Support Team</p>
        
    </div>
</div>
</center>
    ";

    return $body;
}

function emailBodyChangeEmailVerifyIdentityOTP($veri_code, $fname, $lname, $subject)
{
    $image_url = 'https://i.imgur.com/ELe78u6.png';

    $body = "
    <center>
        <div style='margin-top: 30px; width: 600px;'>
            <div style='padding: 20px; background-color: #816ACC;'>
                <img src='$image_url' alt='Noirceur Couture Logo' height='75px' width='auto'>
            </div>

            <div style='width: 550px;'>
                <h1 style='font-size: 16px; text-align: left;'>$subject</h1>

                <p style='font-size: 14px; text-align: left;'>Dear $fname $lname,</p>
                <p style='font-size: 14px; text-align: left;'>We received a request to change your email address for
                    your account on NoirceurCouture. To proceed with changing your email, please copy this One-Time Password:</p>

                <div style='padding: 1px; margin: 0px 80px 0px 80px; background-color: #816ACC'>
                    <p style='font-size: 14px; color: white; font-weight: bold;'>One-Time Password</p>
                    <h1 style='color:white; font-size: 36px; margin-top: 0px'>$veri_code</h1>
                </div>
                <p style='font-size: 12px;'> This is valid for 15 mins. NEVER share this code with others, including
                    NoirceurCouture staff. </p>

                <p style='font-size: 14px; text-align: left;'>If you did not request this email change, you can safely
                    ignore this email. Your email will remain unchanged.</p>
                <p style='font-size: 14px; text-align: left; font-weight: bold;'>Thank you for using NoirceurCouture.
                </p>

                <p style='font-size: 14px; font-weight: bold; text-align: left;'>Best Regards,</p>
                <p style='font-size: 14px; font-weight: bold; text-align: left;'>Noirceur Couture Support Team</p>
            </div>
    </center>
    ";

    return $body;
}

function emailBodyEmailChangeSendToOld($fname, $lname, $subject, $oldEmail, $newEmail)
{
    $image_url = 'https://i.imgur.com/ELe78u6.png';

    $body = "
    <center>
        <div style='margin-top: 30px; width: 600px;'>
            <div style='padding: 20px; background-color: #816ACC;'>
                <img src='$image_url' alt='Noirceur Couture Logo' height='75px' width='auto'>
            </div>

            <div style='width: 550px;'>
                <h1 style='font-size: 16px; text-align: left;'>$subject</h1>

                <p style='font-size: 14px; text-align: left;'>Dear $fname $lname,</p>
                <p style='font-size: 14px; text-align: left;'>We want to inform you that the email address associated with NoirceurCouture has been successfully updated.</p>

                <b><p style='font-size: 14px; text-align: left;'>Old Email: $oldEmail</p></b>
                <p style='font-size: 14px; text-align: left;'>New Email: $newEmail</p>

                <p style='font-size: 14px; text-align: left;'>From now on, all future email notifications from NoirceurCouture will be sent to your new email address.</p>
                <p style='font-size: 14px; text-align: left;'>Thank you for choosing NoirceurCouture. If you have any questions or need further assistance, feel free to contact us at any time.</p>

                <p style='font-size: 14px; font-weight: bold; text-align: left;'>Best Regards,</p>
                <p style='font-size: 14px; font-weight: bold; text-align: left;'>Noirceur Couture Support Team</p>
            </div>
    </center>
    ";

    return $body;
}

function emailBodyEmailChangeSendToNew($fname, $lname, $subject, $oldEmail, $newEmail)
{
    $image_url = 'https://i.imgur.com/ELe78u6.png';

    $body = "
    <center>
        <div style='margin-top: 30px; width: 600px;'>
            <div style='padding: 20px; background-color: #816ACC;'>
                <img src='$image_url' alt='Noirceur Couture Logo' height='75px' width='auto'>
            </div>

            <div style='width: 550px;'>
                <h1 style='font-size: 16px; text-align: left;'>$subject</h1>

                <p style='font-size: 14px; text-align: left;'>Dear $fname $lname,</p>
                <p style='font-size: 14px; text-align: left;'>We want to inform you that the email address associated with NoirceurCouture has been successfully updated.</p>

                <p style='font-size: 14px; text-align: left;'>Old Email: $oldEmail</p>
                <b><p style='font-size: 14px; text-align: left;'>New Email: $newEmail</p></b>

                <p style='font-size: 14px; text-align: left;'>From now on, all future email notifications from NoirceurCouture will be sent to this new email address.</p>
                <p style='font-size: 14px; text-align: left;'>Thank you for choosing NoirceurCouture. If you have any questions or need further assistance, feel free to contact us at any time.
                </p>

                <p style='font-size: 14px; font-weight: bold; text-align: left;'>Best Regards,</p>
                <p style='font-size: 14px; font-weight: bold; text-align: left;'>Noirceur Couture Support Team</p>
            </div>
    </center>
    ";

    return $body;
}

function emailBodySellerRegistration($email, $subject, $registrationUrl)
{
    $image_url = 'https://i.imgur.com/ELe78u6.png';

    $body = "
    <center>
    <div style='margin-top: 30px; width: 600px;'>
        <div style='padding: 20px; background-color: #816ACC;'>
        <img src='$image_url' alt='Noirceur Couture Logo' height='75px' width='auto'>
        </div>

    <div style='width: 550px;'>
        <h1 style='font-size: 16px; text-align: left;'>$subject</h1>

        <p style='font-size: 14px; text-align: left;'>Dear $email,</p>
        <p style='font-size: 14px; text-align: left;'>We received a request that you wanted to join on NoirceurCouture as a seller. To proceed with seller registration, please click the link below:</p>

        <div style='padding: 1px; margin: 0px 80px 0px 80px; background-color: #816ACC'>
            <h1><a href='$registrationUrl' style='font-size: 16px; font-weight: bold; color:white;'>[Seller Registration Link]</a></h1>
        </div>
        <p style='font-size: 12px;'> This is valid for 15 mins. NEVER share this link with others, including
                    NoirceurCouture staff. </p>
        

        <p style='font-size: 14px; text-align: left;'>If you did not request this registraion, you can safely ignore this email.</p>
        <p style='font-size: 14px; text-align: left; font-weight: bold;'>Thank you for using NoirceurCouture.</p>

        <p style='font-size: 14px; font-weight: bold; text-align: left;'>Best Regards,</p>
        <p style='font-size: 14px; font-weight: bold; text-align: left;'>Noirceur Couture Support Team</p>
        
    </div>
</div>
</center>
    ";

    return $body;
}

function emailBodySellerAccepted($brandName)
{

    $image_url = 'https://i.imgur.com/ELe78u6.png';

    $body = "
    <center>
    <div style='margin-top: 30px; width: 600px'>
        <div style='padding: 20px; background-color: #816ACC;'>
            <img src='$image_url' alt='Noirceur Couture Logo' height='75px' width='auto'>
        </div>

        <div style='width: 550px;'>
            <p style='font-size: 16px; font-weight: bold; text-align: left;'>Dear $brandName,</p>
            <p style='font-size: 16px; font-weight: bold; text-align: left;'>We are excited to inform you that your account on NoirceurCouture has been successfully verified as a seller. 🎉</p>
            <p style='font-size: 16px; text-align: left;'>With your verified account, you now have access to a range of benefits, including:</p>

            <ol style='text-align: left;'>
                <li>
                    <p style='font-size: 16px; font-weight: bold;'>Increased visibility: Showcase your products to a larger audience.</p>
                </li>
                <li>
                    <p style='font-size: 16px; font-weight: bold;'>Priority support: Receive dedicated assistance for any queries or issues.</p>
                </li>
                <li>
                    <p style='font-size: 16px; font-weight: bold;'>Advanced analytics: Gain insights into your sales.</p>
                </li>
            </ol>
            <p style='font-size: 16px; text-align: left;'>Thank you for choosing NoirceurCouture. We're dedicated to providing you with the best selling experience possible.</p>

            <p style='font-size: 16px; text-align: left;'>Happy selling! 🛍️</p>


            <p style='font-size: 16px; text-align: left; font-weight: bold;'>Best Regards,</p>
            <p style='font-size: 16px; text-align: left; font-weight: bold;'>Noirceur Couture Support Team</p>
        </div>
    </div>
</center>
    ";

    return $body;
}
function emailBodySellerRejected($brandName)
{

    $image_url = 'https://i.imgur.com/ELe78u6.png';

    $body = "
    <center>
    <div style='margin-top: 30px; width: 600px'>
        <div style='padding: 20px; background-color: #816ACC;'>
            <img src='$image_url' alt='Noirceur Couture Logo' height='75px' width='auto'>
        </div>

        <div style='width: 550px;'>
            <p style='font-size: 16px; font-weight: bold; text-align: left;'>Dear $brandName,</p>
            <p style='font-size: 16px; text-align: left;'>Thank you for your interest in joining NoirceurCouture as a seller. We appreciate the time and effort you invested in your application.</p>
            <p style='font-size: 16px; text-align: left;'>After careful consideration, we regret to inform you that your account has not been approved. Unfortunately, the vision and values of Noirceur Couture are not fully aligned with $brandName.</p>
            <p style='font-size: 16px; text-align: left;'>We encourage you to continue pursuing excellence in your brand, and we hope to have the opportunity to collaborate in the future under more aligned circumstances.</p>
            <p style='font-size: 16px; text-align: left;'>Thank you once again for considering NoirceurCouture. If you have any questions or require further information, please do not hesitate to reach out to our support team.</p>
            <p style='font-size: 16px; text-align: left;'>Best Regards,</p>
            <p style='font-size: 16px; text-align: left; font-weight: bold;'>Noirceur Couture Support Team</p>
        </div>
    </div>
</center>
    ";

    return $body;
}
