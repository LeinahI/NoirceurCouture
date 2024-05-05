<?php
session_start();
date_default_timezone_set('Asia/Manila');
include('../../models/dbcon.php');
include('../../models/myFunctions.php');

if (isset($_POST['banUserBtn'])) { //!BAN User
    $userId = $_POST['userID'];
    $banConfirm = 1;

    /* Check if user is already ban */
    $check_ban_query = "SELECT ban_user_ID FROM users_banned WHERE ban_user_ID = ?";
    $check_ban_stmt = mysqli_prepare($con, $check_ban_query);
    mysqli_stmt_bind_param($check_ban_stmt, 'i', $userId);
    mysqli_stmt_execute($check_ban_stmt);
    $check_ban_result = mysqli_stmt_get_result($check_ban_stmt);

    if (mysqli_num_rows($check_ban_result) > 0) {
        redirectSwal("../users.php", "User has already been banned", "error");
    } else {
        //! BAN User 
        $update_query = "UPDATE users SET user_isBan=? WHERE user_ID=?";
        $stmt = mysqli_prepare($con, $update_query);
        mysqli_stmt_bind_param($stmt, "ii", $banConfirm, $userId);
        $update_query_run = mysqli_stmt_execute($stmt);

        //! add banned users on users_banned tbl
        $insert_query = "INSERT INTO users_banned (ban_user_ID) VALUES('$userId')";
        $insert_query_run = mysqli_query($con, $insert_query);

        //* Also ban User Category if exist
        $update_category_query = "UPDATE categories SET category_isBan=? WHERE category_user_ID=?";
        $stmt_category = mysqli_prepare($con, $update_category_query);
        mysqli_stmt_bind_param($stmt_category, "ii", $banConfirm, $userId);
        $update_category_query_run = mysqli_stmt_execute($stmt_category);

        //*Select category_id from database to put it from categories_banned
        $select_category_query = "SELECT category_id FROM categories WHERE `category_user_ID` = '$userId' LIMIT 1";
        $select_category_query_run = mysqli_query($con, $select_category_query);
        $category_row = mysqli_fetch_assoc($select_category_query_run);
        $categoryID = $category_row['category_id'];

        //* Also banned Category on category_banned tbl
        $insert_userCateg_query = "INSERT INTO categories_banned (categBan_category_id, categBan_userID) VALUES('$categoryID','$userId')";
        $insert_userCateg_query_run = mysqli_query($con, $insert_userCateg_query);

        if ($insert_query_run) {
            // Insertion successful, proceed with the update
            if ($update_query_run) {
                redirectSwal("../users.php", "User has been banned", "success");
            } else {
                redirectSwal("../users.php", "Something went wrong with the update", "error");
            }
        } else {
            // Insertion failed, do not proceed with the update
            redirectSwal("../users.php", "Something went wrong with the insertion", "error");
        }
    }
}

if (isset($_POST['updateUserBtn'])) { //!Update User Details
    $userId =  mysqli_real_escape_string($con, $_POST['userID']);
    $firstName =  mysqli_real_escape_string($con, $_POST['firstName']);
    $lastName = mysqli_real_escape_string($con, $_POST['lastName']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $phoneNum = mysqli_real_escape_string($con, $_POST['phoneNumber']);
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
        // Update User Data
        $update_query = "UPDATE users SET user_firstName=?, user_lastName=?, user_email=?, user_phone=? WHERE user_ID=?";
        $stmt = mysqli_prepare($con, $update_query);
        mysqli_stmt_bind_param($stmt, "ssssi", $firstName, $lastName, $email, $phoneNum, $userId);
        $update_query_run = mysqli_stmt_execute($stmt);
        if ($update_query_run) {
            redirectSwal("../account-details.php", "Account updated successfully", "success");
        } else {
            redirectSwal("../account-details.php", "Something went wrong", "error");
        }
    }
}

if (isset($_POST['changePassBtn'])) { //!Update User Password
    $userId =  mysqli_real_escape_string($con, $_POST['userID']);
    $oldPassword =  mysqli_real_escape_string($con, $_POST['oldpass']);
    $newPassword =  mysqli_real_escape_string($con, $_POST['newpass']);
    $confirmPassword =  mysqli_real_escape_string($con, $_POST['cnewpass']);

    $pass_select_query = "SELECT user_password FROM users u WHERE (u.user_ID = '$userId')";
    $pass_select_query_run = mysqli_query($con, $pass_select_query);
    $userdata = mysqli_fetch_array($pass_select_query_run);

    $bcryptuPass = $userdata['user_password'];

    if (!password_verify($oldPassword, $bcryptuPass)) {
        redirectSwal("../changePassword.php", "Incorrect old password", "error");
    } elseif ($oldPassword == $newPassword) {
        redirectSwal("../changePassword.php", "Old password and new password cannot be the same", "error");
    } elseif ($newPassword != $confirmPassword) {
        redirectSwal("../changePassword.php", "new and confirm Passwords do not match", "error");
    } else {
        //Hash Password
        $bcryptNewuPass = password_hash($newPassword, PASSWORD_BCRYPT);

        // Update User Password
        $update_query = "UPDATE users SET user_password=? WHERE user_ID=?";
        $stmt = mysqli_prepare($con, $update_query);
        mysqli_stmt_bind_param($stmt, "si", $bcryptNewuPass, $userId);
        $update_query_run = mysqli_stmt_execute($stmt);
        if ($update_query_run) {
            redirectSwal("../changePassword.php", "Password updated successfully", "success");
        } else {
            redirectSwal("../changePassword.php", "Something went wrong", "error");
        }
    }
}
