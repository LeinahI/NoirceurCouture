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
    $uPass = mysqli_real_escape_string($con, $_POST['userPassword']);
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
        $update_query = "UPDATE users SET user_firstName=?, user_lastName=?, user_email=?, user_phone=?, user_password=?, user_profile_image=? WHERE user_ID=?";
        $stmt = mysqli_prepare($con, $update_query);
        mysqli_stmt_bind_param($stmt, "ssssssi", $firstName, $lastName, $email, $phoneNum, $uPass, $fileName,  $userId);
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
