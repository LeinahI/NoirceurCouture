<?php
include('dbcon.php');
include('myFunctions.php');
session_start();

/* User Profile Update statement */
if (isset($_POST['userUpdateAccBtn'])) {
    $userId = mysqli_real_escape_string($con, $_POST['userID']);
    $firstName = mysqli_real_escape_string($con, trim($_POST['firstName']));
    $lastName = mysqli_real_escape_string($con, trim($_POST['lastName']));

    $fnameRegex = '/^[A-Za-z]+(?:\s+[A-Za-z]+)*(?:\s+[A-Za-z]+\.)?$/';
    $lnameRegex = '/^[A-Za-z]+(?:\s+[A-Za-z]+)*(?:\s+[A-Za-z]+\.)?$/';
    /* $email = mysqli_real_escape_string($con, $_POST['email']);

    $check_email_query = "SELECT user_email FROM users WHERE user_email = '$email' AND user_id != '$userId'";
    $check_email_query_run = mysqli_query($con, $check_email_query);

      if (!preg_match($phonePatternPH, $phoneNum)) {
        header("Location: ../views/myAccount.php");
        $_SESSION['Errormsg'] = "Invalid Philippine phone number format";
    } else if (mysqli_num_rows($check_email_query_run) > 0) {
        header("Location: ../views/myAccount.php");
        $_SESSION['Errormsg'] = "Email already in use, please try something different";
    } else if (mysqli_num_rows($check_phoneNum_query_run) > 0) {
        header("Location: ../views/myAccount.php");
        $_SESSION['Errormsg'] = "Phone number already in use, please try something different";
    }*/
    if (!preg_match($fnameRegex, $firstName) || !preg_match($lnameRegex, $lastName)) {
        header("Location: ../views/myAccount.php");
        $_SESSION['Errormsg'] = "First and Last Name can only contain letters and spaces";
    } else {
        // Image uploading code
        $old_image = $_POST['oldImage'];
        $new_image = $_FILES['profileUpload']['name'];
        $image_tmp = $_FILES['profileUpload']['tmp_name'];

        if ($new_image != "") {
            // Set the file name if a new image is uploaded
            $date = date("m-d-Y-H-i-s");
            $fileName = 'profile_' . $userId . '_' . $date . '.' . pathinfo($new_image, PATHINFO_EXTENSION);
            $destination = "../assets/uploads/userProfile/" . $fileName;

            if (file_exists("../assets/uploads/userProfile/" . $old_image)) {
                unlink("../assets/uploads/userProfile/" . $old_image); // Delete Old Image
            }
            move_uploaded_file($image_tmp, $destination);
        } else {
            // Keep the original file name if no new image is uploaded
            $fileName = $old_image;
        }

        // If no new image uploaded, update user profile without changing the image
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

    $check_phoneNum_query = "SELECT user_phone FROM users WHERE user_id = '$userId'";
    $check_phoneNum_query_run = mysqli_query($con, $check_phoneNum_query);
    $userdata = mysqli_fetch_array($check_phoneNum_query_run);

    if (!preg_match($phonePatternPH, $newNum)) {
        header("Location: ../views/changePhoneNumber.php");
        $_SESSION['Errormsg'] = "Invalid Philippine phone number format";
    } else if ($oldNum == $newNum) {
        header("Location: ../views/changePhoneNumber.php");
        $_SESSION['Errormsg'] = "Current phone number and new phone number cannot be the same";
    } else if ($oldNum != $userdata['user_phone']) {
        header("Location: ../views/changePhoneNumber.php");
        $_SESSION['Errormsg'] = "Current phone number doesn't match with our records";
    } else {
        $update_query = "UPDATE users SET user_phone=? WHERE user_ID=?";
        $stmt = mysqli_prepare($con, $update_query);
        mysqli_stmt_bind_param($stmt, "si", $newNum,  $userId);
        $update_query_run = mysqli_stmt_execute($stmt);

        if ($update_query_run) {
            header("Location: ../views/changePhoneNumber.php");
            $_SESSION['Successmsg'] = "Account updated successfully";
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
