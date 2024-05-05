<?php
include('dbcon.php');
include('myFunctions.php');
session_start();

/* User Profile Update statement */
if (isset($_POST['userUpdateAccBtn'])) {
    $userId = mysqli_real_escape_string($con, $_POST['userID']);
    $firstName = mysqli_real_escape_string($con, $_POST['firstName']);
    $lastName = mysqli_real_escape_string($con, $_POST['lastName']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $phoneNum = mysqli_real_escape_string($con, $_POST['phoneNumber']);
    $phonePatternPH = '/^09\d{9}$/';

    $check_email_query = "SELECT user_email FROM users WHERE user_email = '$email' AND user_id != '$userId'";
    $check_email_query_run = mysqli_query($con, $check_email_query);

    $check_phoneNum_query = "SELECT user_phone FROM users WHERE user_phone = '$phoneNum' AND user_id != '$userId'";
    $check_phoneNum_query_run = mysqli_query($con, $check_phoneNum_query);

    if (!preg_match($phonePatternPH, $phoneNum)) {
        header("Location: ../views/myAccount.php");
        $_SESSION['Errormsg'] = "Invalid Philippine phone number format";
    } else if (mysqli_num_rows($check_email_query_run) > 0) {
        header("Location: ../views/myAccount.php");
        $_SESSION['Errormsg'] = "Email already in use, please try something different";
    } else if (mysqli_num_rows($check_phoneNum_query_run) > 0) {
        header("Location: ../views/myAccount.php");
        $_SESSION['Errormsg'] = "Phone number already in use, please try something different";
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
        $update_query = "UPDATE users SET user_firstName=?, user_lastName=?, user_email=?, user_phone=?, user_profile_image=? WHERE user_ID=?";
        $stmt = mysqli_prepare($con, $update_query);
        mysqli_stmt_bind_param($stmt, "sssssi", $firstName, $lastName, $email, $phoneNum, $fileName,  $userId);
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
