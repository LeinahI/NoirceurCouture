<?php
include('dbcon.php');
include('myFunctions.php');
include('emailSMTP.php');
include('addBGToPng.php');
session_start();

/* User Profile Update statement */
if (isset($_POST['userUpdateAccBtn'])) {
    $userId = mysqli_real_escape_string($con, $_POST['userID']);
    $firstName = mysqli_real_escape_string($con, trim($_POST['firstName']));
    $lastName = mysqli_real_escape_string($con, trim($_POST['lastName']));

    $fnameRegex = '/^[A-Za-z]+(?:\s+[A-Za-z]+)*(?:\s+[A-Za-z]+\.)?$/';
    $lnameRegex = '/^[A-Za-z]+(?:\s+[A-Za-z]+)*(?:\s+[A-Za-z]+\.)?$/';

    // Image uploading code
    $old_image = $_POST['oldImage'];
    $new_image = $_FILES['profileUpload']['name'];
    $image_tmp = $_FILES['profileUpload']['tmp_name'];
    $maxFileSize = 5 * 1024 * 1024; // 5MB in bytes

    // Allowed file types
    $allowed_types = ['jpg', 'jpeg', 'png'];

    // Get the file extension
    $file_extension = strtolower(pathinfo($new_image, PATHINFO_EXTENSION));

    if (!preg_match($fnameRegex, $firstName) || !preg_match($lnameRegex, $lastName)) {
        header("Location: ../views/myAccount.php");
        $_SESSION['Errormsg'] = "First and Last Name can only contain letters and spaces";
    } else if (!in_array($file_extension, $allowed_types)) {
        header("Location: ../views/myAccount.php");
        $_SESSION['Errormsg'] = "Invalid file type. Only JPG, JPEG, and PNG files are allowed.";
    } else if ($_FILES['profileUpload']['size'] >= $maxFileSize) {
        // Handle the case where the file size exceeds 5MB
        header("Location: ../views/myAccount.php");
        $_SESSION['Errormsg'] = "The uploaded image must be less than 5MB";
    } else {


        if ($new_image != "") {
            // Set the file name if a new image is uploaded
            $date = date("m-d-Y-H-i-s");
            $extension = pathinfo($new_image, PATHINFO_EXTENSION);
            $fileName = 'profile_' . $userId . '_' . $date . '.' . $extension;
            $destination = "../assets/uploads/userProfile/" . $fileName;

            if (file_exists("../assets/uploads/userProfile/" . $old_image)) {
                unlink("../assets/uploads/userProfile/" . $old_image); // Delete Old Image
            }

            // Move the uploaded file to the destination
            move_uploaded_file($image_tmp, $destination);
            addBackgroundToPng($destination, $extension);
        } else {
            // Keep the original file name if no new image is uploaded
            $fileName = $old_image;
        }

        // Update user profile without changing the image if no new image uploaded
        $update_query = "UPDATE users SET user_firstName=?, user_lastName=?, user_profile_image=? WHERE user_ID=?";
        $stmt = mysqli_prepare($con, $update_query);
        mysqli_stmt_bind_param($stmt, "sssi", $firstName, $lastName, $fileName,  $userId);
        $update_query_run = mysqli_stmt_execute($stmt);


        if ($update_query_run) {
            header("Location: ../views/myAccount.php");
            $_SESSION['Successmsg'] = "Account updated successfully";
        } else {
            header("Location: ../views/myAccount.php");
            $_SESSION['Errormsg'] = "Something went wrong";
        }
    }
}

if (isset($_POST['userPhoneNumber'])) {
    $userId = mysqli_real_escape_string($con, $_POST['userID']);
    $oldNum = mysqli_real_escape_string($con, $_POST['oldPhoneNumber']);
    $newNum = mysqli_real_escape_string($con, $_POST['newPhoneNumber']);
    $phonePatternPH = '/^09\d{9}$/';

    $check_phoneNum_query = "SELECT user_phone FROM users WHERE user_phone = '$oldNum'";
    $check_phoneNum_query_run = mysqli_query($con, $check_phoneNum_query);
    $userdata = mysqli_fetch_array($check_phoneNum_query_run);

    $check_newNum_query = "SELECT user_phone FROM users WHERE user_phone = '$newNum'";
    $check_newNum_query_run = mysqli_query($con, $check_newNum_query);

    if (!preg_match($phonePatternPH, $newNum)) {
        header("Location: ../views/changePhoneNumber.php");
        $_SESSION['Errormsg'] = "Invalid Philippine phone number format";
    } else if ($oldNum == $newNum) {
        header("Location: ../views/changePhoneNumber.php");
        $_SESSION['Errormsg'] = "Current phone number and new phone number cannot be the same";
    } else if ($oldNum != $userdata['user_phone']) {
        header("Location: ../views/changePhoneNumber.php");
        $_SESSION['Errormsg'] = "Current phone number doesn't match with our records";
    } else if (mysqli_num_rows($check_newNum_query_run) > 0) {
        header("Location: ../views/changePhoneNumber.php");
        $_SESSION['Errormsg'] = "Phone number is already in use, please try something different";
    } else {
        $update_query = "UPDATE users SET user_phone=? WHERE user_ID=?";
        $stmt = mysqli_prepare($con, $update_query);
        mysqli_stmt_bind_param($stmt, "si", $newNum,  $userId);
        $update_query_run = mysqli_stmt_execute($stmt);

        if ($update_query_run) {
            header("Location: ../views/changePhoneNumber.php");
            $_SESSION['Successmsg'] = "Phone number updated successfully";
        } else {
            header("Location: ../views/changePhoneNumber.php");
            $_SESSION['Errormsg'] = "Something went wrong";
        }
    }
}

if (isset($_POST['changePasswordBtn'])) {
    $userId =  mysqli_real_escape_string($con, $_POST['userID']);
    $oldPassword =  mysqli_real_escape_string($con, $_POST['oldpass']);
    $newPassword =  mysqli_real_escape_string($con, $_POST['newpass']);
    $confirmPassword =  mysqli_real_escape_string($con, $_POST['cnewpass']);

    $pass_select_query = "SELECT user_password FROM users u WHERE (u.user_ID = '$userId')";
    $pass_select_query_run = mysqli_query($con, $pass_select_query);
    $userdata = mysqli_fetch_array($pass_select_query_run);

    $bcryptuPass = $userdata['user_password'];

    if (!password_verify($oldPassword, $bcryptuPass)) {
        header("Location: ../views/changePassword.php");
        $_SESSION['Errormsg'] = "Incorrect old password";
    } elseif ($oldPassword == $newPassword) {
        header("Location: ../views/changePassword.php");
        $_SESSION['Errormsg'] = "Old password and new password cannot be the same";
    } elseif ($newPassword != $confirmPassword) {
        header("Location: ../views/changePassword.php");
        $_SESSION['Errormsg'] = "new and confirm Passwords do not match";
    } else {
        //Hash Password
        $bcryptNewuPass = password_hash($newPassword, PASSWORD_BCRYPT);

        // Update User Password
        $update_query = "UPDATE users SET user_password=? WHERE user_ID=?";
        $stmt = mysqli_prepare($con, $update_query);
        mysqli_stmt_bind_param($stmt, "si", $bcryptNewuPass, $userId);
        $update_query_run = mysqli_stmt_execute($stmt);
        if ($update_query_run) {
            header("Location: ../views/changePassword.php");
            $_SESSION['Successmsg'] = "Password updated successfully";
        } else {
            header("Location: ../views/changePassword.php");
            $_SESSION['Errormsg'] = "Something went wrong";
        }
    }
}

if (isset($_POST['profileDeleteBtn'])) {
    $userId = mysqli_real_escape_string($con, $_POST['userID']);

    //+ Fetch the profile image path
    $selectProfileQuery = "SELECT user_profile_Image FROM users WHERE user_ID = ?";
    $selectProfile_stmt = mysqli_prepare($con, $selectProfileQuery);
    mysqli_stmt_bind_param($selectProfile_stmt, 'i', $userId);
    mysqli_stmt_execute($selectProfile_stmt);
    $selectProfile_result = mysqli_stmt_get_result($selectProfile_stmt);

    if ($selectProfile_result && $profileData = mysqli_fetch_assoc($selectProfile_result)) {
        $profileImageName = $profileData['user_profile_Image'];
        $profileImagePath = "../assets/uploads/userProfile/" . $profileImageName;

        //+ Delete the profile image file if it exists
        if (file_exists($profileImagePath)) {
            unlink($profileImagePath); //+ Deletes the file

            $deleteQuery = "UPDATE users SET user_profile_image = '' WHERE user_ID = '$userId'";
            mysqli_query($con, $deleteQuery);
        }
    }

    header("Location: ../views/myAccount.php");
    $_SESSION['Successmsg'] = "Profile Image Deleted successfully";
}

if (isset($_POST['userChangeEmail'])) {
    $userId = mysqli_real_escape_string($con, $_POST['userID']);
    $oldEmail = mysqli_real_escape_string($con, $_POST['oldEmail']);
    $newEmail = mysqli_real_escape_string($con, $_POST['newEmail']);

    $check_email_query = "SELECT * FROM users WHERE user_email = '$oldEmail'";
    $check_email_query_run = mysqli_query($con, $check_email_query);
    $userdata = mysqli_fetch_array($check_email_query_run);

    $check_newEmail_query = "SELECT user_email FROM users WHERE user_email = '$newEmail'";
    $check_newEmail_query_run = mysqli_query($con, $check_newEmail_query);

    if ($oldEmail == $newEmail) {
        header("Location: ../views/changeEmailAddress.php");
        $_SESSION['Errormsg'] = "Current email and new email cannot be the same";
    } else if ($oldEmail != $userdata['user_email']) {
        header("Location: ../views/changeEmailAddress.php");
        $_SESSION['Errormsg'] = "Current email doesn't match with our records";
    } else if (mysqli_num_rows($check_newEmail_query_run) > 0) {
        header("Location: ../views/changeEmailAddress.php");
        $_SESSION['Errormsg'] = "Email is already in use, please try something different";
    } else {

        $veri_code = verificationCode();
        $general_token = generateToken();

        $fname = $userdata['user_firstName'];
        $lname = $userdata['user_lastName'];

        /* Send OTP to EMAIL SMTP */
        $subject = "NoirceurCouture First Step of Email Change Identity Verification";
        emailChangeVerifyOTP($oldEmail, $subject, $veri_code, $fname, $lname);

        $update_query = "UPDATE users SET user_otp=?, user_general_token=? WHERE user_email=?";
        $stmt = mysqli_prepare($con, $update_query);
        mysqli_stmt_bind_param($stmt, "sss", $veri_code, $general_token, $oldEmail);
        $update_query_run = mysqli_stmt_execute($stmt);

        $_SESSION['oldEmail'] = $oldEmail;
        $_SESSION['newEmail'] = $newEmail;
        $_SESSION['initialVerification'] = "first-step of email verification";

        if ($update_query_run) {
            header("Location: ../views/verifyEmail.php?initv=$general_token");
            $_SESSION['Successmsg'] = "First-step One-Time Password has been sent to your email address";
        } else {
            header("Location: ../views/changeEmailAddress.php");
            $_SESSION['Errormsg'] = "Something went wrong. Please try again later.";
        }
    }
}

if (isset($_POST['verifyInitialOTPFromEmail'])) {
    if (isset($_POST['initv'])) {
        $acti_code = mysqli_real_escape_string($con, $_POST['initv']);

        $oldEmail = mysqli_real_escape_string($con, $_POST['oldEmail']);
        $newEmail = mysqli_real_escape_string($con, $_POST['newEmail']);

        $code1 = mysqli_real_escape_string($con, $_POST['code1']);
        $code2 = mysqli_real_escape_string($con, $_POST['code2']);
        $code3 = mysqli_real_escape_string($con, $_POST['code3']);
        $code4 = mysqli_real_escape_string($con, $_POST['code4']);
        $code5 = mysqli_real_escape_string($con, $_POST['code5']);
        $code6 = mysqli_real_escape_string($con, $_POST['code6']);

        $veri_code = $code1 . $code2 . $code3 . $code4 . $code5 . $code6;

        $selectQuery = "SELECT * FROM users WHERE user_general_token = '$acti_code'";
        $result_check_acti_code = mysqli_query($con, $selectQuery);
        $userdata = mysqli_fetch_array($result_check_acti_code);

        if (mysqli_num_rows($result_check_acti_code) > 0) {
            $verification_code = $userdata['user_otp'];
            $accountCreated = $userdata['user_accCreatedAt'];

            if ($verification_code !== $veri_code) {
                header("Location: ../views/verifyEmail.php?initv=$acti_code");
                $_SESSION['Errormsg'] = "Please provide the correct One-Time Password";
            } else {

                $veri_code_new = verificationCode();
                $general_token_new = generateToken();

                $fname = $userdata['user_firstName'];
                $lname = $userdata['user_lastName'];

                /* Send OTP to EMAIL SMTP */
                $subject = "NoirceurCouture Final Step of Email Change Identity Verification";
                emailChangeVerifyOTP($newEmail, $subject, $veri_code_new, $fname, $lname);

                $update_query = "UPDATE users SET user_otp=?, user_general_token=? WHERE user_email=?";
                $stmt = mysqli_prepare($con, $update_query);
                mysqli_stmt_bind_param($stmt, "sss", $veri_code_new, $general_token_new, $oldEmail);
                $update_query_run = mysqli_stmt_execute($stmt);

                $_SESSION['newEmail'] = $newEmail;
                $_SESSION['oldEmail'] = $oldEmail;
                $_SESSION['finalVerification'] = "final-step of email verification";

                if ($update_query_run) {
                    header("Location: ../views/verifyEmailFinal.php?fnlv=$general_token_new");
                    $_SESSION['Successmsg'] = "Final-step One-Time Password has been sent to your email address";
                } else {
                    header("Location: ../views/changeEmailAddress.php");
                    $_SESSION['Errormsg'] = "Something went wrong. Please try again later.";
                }
            }
        }
    } else {
        echo "Activation code didn't get";
    }
}

if (isset($_POST['verifyFinalOTPFromEmail'])) {
    if (isset($_POST['fnlv'])) {
        $acti_code = mysqli_real_escape_string($con, $_POST['fnlv']);

        $oldEmail = mysqli_real_escape_string($con, $_POST['oldEmail']);
        $newEmail = mysqli_real_escape_string($con, $_POST['newEmail']);

        $code1 = mysqli_real_escape_string($con, $_POST['code1']);
        $code2 = mysqli_real_escape_string($con, $_POST['code2']);
        $code3 = mysqli_real_escape_string($con, $_POST['code3']);
        $code4 = mysqli_real_escape_string($con, $_POST['code4']);
        $code5 = mysqli_real_escape_string($con, $_POST['code5']);
        $code6 = mysqli_real_escape_string($con, $_POST['code6']);

        $veri_code = $code1 . $code2 . $code3 . $code4 . $code5 . $code6;

        $selectQuery = "SELECT * FROM users WHERE user_general_token = '$acti_code'";
        $result_check_acti_code = mysqli_query($con, $selectQuery);
        $userdata = mysqli_fetch_array($result_check_acti_code);

        if (mysqli_num_rows($result_check_acti_code) > 0) {
            $verification_code = $userdata['user_otp'];
            $accountCreated = $userdata['user_accCreatedAt'];

            if ($verification_code !== $veri_code) {
                header("Location: ../views/verifyEmailFinal.php?fnlv=$acti_code");
                $_SESSION['Errormsg'] = "Please provide the correct One-Time Password";
            } else {

                $fname = $userdata['user_firstName'];
                $lname = $userdata['user_lastName'];
                /* Send OTP to EMAIL SMTP */
                $updateQuery = "UPDATE users SET user_otp = '', user_general_token = '', user_email = '$newEmail' WHERE user_otp = '$veri_code' AND user_general_token = '$acti_code'";
                $resultUpdateQuery = mysqli_query($con, $updateQuery);
                if ($resultUpdateQuery) {

                    $subject = "Your NoirceurCouture email has been changed";
                    emailChangeEmailSendOld($oldEmail, $newEmail, $subject, $fname, $lname);
                    emailChangeEmailSendNew($oldEmail, $newEmail, $subject, $fname, $lname);
                    header("Location: ../views/myAccount.php");
                    $_SESSION['Successmsg'] = "Your email has been changed successfully.";
                } else {
                    echo "error something";
                }
            }
        }
    } else {
        echo "Activation code didn't get";
    }
}

if (isset($_POST['resendCodeinitialEmailChange'])) {

    $veri_code = verificationCode();
    $acti_code = mysqli_real_escape_string($con, $_POST['initv']);
    //Insert User Data
    $insert_query = "UPDATE users SET user_otp = '$veri_code' WHERE user_general_token = '$acti_code'";
    $insert_query_run = mysqli_query($con, $insert_query);
    if ($insert_query_run) {
        $selectQuery = "SELECT * FROM users WHERE user_general_token = '$acti_code'";
        $result_check_acti_code = mysqli_query($con, $selectQuery);
        $row = mysqli_fetch_assoc($result_check_acti_code);

        $oldEmail = mysqli_real_escape_string($con, $_POST['oldEmail']);
        $subject = "Resending NoirceurCouture First Step of Email Change Identity Verification";
        $fname = $row['user_firstName'];
        $lname = $row['user_lastName'];

        emailChangeVerifyOTP($oldEmail, $subject, $veri_code, $fname, $lname);

        header("Location: ../views/verifyEmail.php?initv=$acti_code");
        $_SESSION['Successmsg'] = "New verification code has been sent to your email";
    }
}

if (isset($_POST['resendCodeFinalEmailChange'])) {

    $veri_code = verificationCode();
    $acti_code = mysqli_real_escape_string($con, $_POST['fnlv']);
    //Insert User Data
    $insert_query = "UPDATE users SET user_otp = '$veri_code' WHERE user_general_token = '$acti_code'";
    $insert_query_run = mysqli_query($con, $insert_query);
    if ($insert_query_run) {
        $selectQuery = "SELECT * FROM users WHERE user_general_token = '$acti_code'";
        $result_check_acti_code = mysqli_query($con, $selectQuery);
        $row = mysqli_fetch_assoc($result_check_acti_code);

        $newEmail = mysqli_real_escape_string($con, $_POST['newEmail']);
        $subject = "Resending NoirceurCouture Final Step of Email Change Identity Verification";
        $fname = $row['user_firstName'];
        $lname = $row['user_lastName'];

        emailChangeVerifyOTP($newEmail, $subject, $veri_code, $fname, $lname);

        header("Location: ../views/verifyEmailFinal.php?fnlv=$acti_code");
        $_SESSION['Successmsg'] = "New verification code has been sent to your email";
    }
}
