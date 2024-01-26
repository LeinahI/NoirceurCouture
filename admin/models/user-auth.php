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
    $uPass = $_POST['userPassword'];
    $phonePatternPH = '/^09\d{9}$/';

    // Check if user already exists
    $check_email_query = "SELECT user_email FROM users WHERE user_email = '$email' AND user_id != '$userId'";
    $check_email_query_run = mysqli_query($con, $check_email_query);

    // Check if phone already exists
    $check_phoneNum_query = "SELECT user_phone FROM users WHERE user_phone = '$phoneNum' AND user_id != '$userId'";
    $check_phoneNum_query_run = mysqli_query($con, $check_phoneNum_query);

    if (!preg_match($phonePatternPH, $phoneNum)) {
        redirectSwal("../account-details.php", "Invalid Philippine phone number format.", "error");
    } else if (mysqli_num_rows($check_email_query_run) > 0) {
        redirectSwal("../account-details.php", "Email already in use, please try something different.", "error");
    } else if (mysqli_num_rows($check_phoneNum_query_run) > 0) {
        redirectSwal("../account-details.php", "Phone number already in use, please try something different.", "error");
    } else {
        if ($uPass) {
            // Update User Data
            $update_query = "UPDATE users SET user_firstName=?, user_lastName=?, user_email=?, user_phone=?, user_password=? WHERE user_ID=?";
            $stmt = mysqli_prepare($con, $update_query);
            mysqli_stmt_bind_param($stmt, "sssssi", $firstName, $lastName, $email, $phoneNum, $uPass, $userId);
            $update_query_run = mysqli_stmt_execute($stmt);
            if ($update_query_run) {
                redirectSwal("../account-details.php", "Account updated successfully", "success");
            } else {
                redirectSwal("../account-details.php", "Something went wrong", "error");
            }
        }
    }
} /* else if (isset($_POST['deleteUserBtn'])) { //!Delete user
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
 */