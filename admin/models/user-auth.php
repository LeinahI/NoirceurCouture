<?php
session_start();
date_default_timezone_set('Asia/Manila');
include('../../models/dbcon.php');
include('../../models/myFunctions.php');

if (isset($_POST['updateUserBtn'])) { //!Update User Details
    $userId = $_POST['userID'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $phoneNum = $_POST['phoneNumber'];
    $uname = $_POST['username'];
    $uPass = $_POST['userPassword'];
    $role = $_POST['userRole'];

    $sellerType = $_POST['userSellerType'];
    $sellerConfirmed = isset($_POST['isConfirmed']) ? mysqli_real_escape_string($con, $_POST['isConfirmed']) : '0';
    $phonePatternPH = '/^09\d{9}$/';

    // Check if user already exists
    $check_email_query = "SELECT user_email FROM users WHERE user_email = '$email' AND user_id != '$userId'";
    $check_email_query_run = mysqli_query($con, $check_email_query);

    $check_phoneNum_query = "SELECT user_phone FROM users WHERE user_phone = '$phoneNum' AND user_id != '$userId'";
    $check_phoneNum_query_run = mysqli_query($con, $check_phoneNum_query);

    $check_username_query = "SELECT user_username FROM users WHERE user_username = '$uname' AND user_id != '$userId'";
    $check_username_query_run = mysqli_query($con, $check_username_query);

    if (!preg_match($phonePatternPH, $phoneNum)) {
        redirectSwal("../editusers.php?id=$userId", "Invalid Philippine phone number format.", "error");
    } else if (mysqli_num_rows($check_email_query_run) > 0) {
        redirectSwal("../editusers.php?id=$userId", "Email already in use, please try something different.", "error");
    } else if (mysqli_num_rows($check_phoneNum_query_run) > 0) {
        redirectSwal("../editusers.php?id=$userId", "Phone number already in use, please try something different.", "error");
    } else if (mysqli_num_rows($check_username_query_run) > 0) {
        redirectSwal("../editusers.php?id=$userId", "Username already in use, please try something different.", "error");
    } else {
        if ($uPass) {
            // Update User Data
            $update_user_query = "UPDATE users SET user_firstName=?, user_lastName=?, user_email=?, user_username=?, user_phone=?, user_password=?, user_role=? WHERE user_ID=?";
            $stmt_user = mysqli_prepare($con, $update_user_query);
            mysqli_stmt_bind_param($stmt_user, "ssssssii", $firstName, $lastName, $email, $uname, $phoneNum, $uPass, $role, $userId);
            $update_user_query_run = mysqli_stmt_execute($stmt_user);

            // Update Seller Details
            $update_seller_details_query = "UPDATE users_seller_details SET seller_seller_type=?, seller_confirmed=? WHERE seller_user_ID=?";
            $stmt_seller_details = mysqli_prepare($con, $update_seller_details_query);
            mysqli_stmt_bind_param($stmt_seller_details, "sii", $sellerType, $sellerConfirmed, $userId);
            $update_seller_details_query_run = mysqli_stmt_execute($stmt_seller_details);

            // Check if both updates were successful
            if ($update_user_query_run && $update_seller_details_query_run) {
                redirectSwal("../editusers.php?id=$userId", "Account updated successfully", "success");
            } else {
                redirectSwal("../editusers.php?id=$userId", "Something went wrong", "error");
            }
        }
    }
} else if (isset($_POST['deleteUserBtn'])) { //!Delete user
    $user_id = mysqli_real_escape_string($con, $_POST['user_ID']);

    // Check if the user with the specified user_ID exists
    $check_user_query = "SELECT * FROM users WHERE user_ID=?";
    $stmt_check_user = mysqli_prepare($con, $check_user_query);
    mysqli_stmt_bind_param($stmt_check_user, "i", $user_id);
    mysqli_stmt_execute($stmt_check_user);
    $check_user_query_run = mysqli_stmt_get_result($stmt_check_user);

    if (mysqli_num_rows($check_user_query_run) > 0) {
        // User exists, proceed with deletion
        $delete_query = "DELETE FROM users WHERE user_ID=?";
        $stmt_delete_user = mysqli_prepare($con, $delete_query);
        mysqli_stmt_bind_param($stmt_delete_user, "i", $user_id);
        $delete_query_run = mysqli_stmt_execute($stmt_delete_user);

        if ($delete_query_run) {
            redirectSwal("../users.php", "User deleted successfully!", "success");
        } else {
            redirectSwal("../users.php", "Something went wrong. Please try again later.", "error");
        }
    } else {
        // User does not exist
        redirectSwal("../users.php", "User not found.", "error");
    }

    mysqli_stmt_close($stmt_check_user);
    mysqli_stmt_close($stmt_delete_user);
}
