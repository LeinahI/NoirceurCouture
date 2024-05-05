<?php
session_start();
date_default_timezone_set('Asia/Manila');
include('../../models/dbcon.php');
include('../../models/myFunctions.php');

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

/* User Address Add statement */
if (isset($_POST['sellerAddAddrBtn'])) {
    $userId = mysqli_real_escape_string($con, $_POST['userID']);
    $fullN = mysqli_real_escape_string($con, $_POST['fullName']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $phoneNum = mysqli_real_escape_string($con, $_POST['phoneNumber']);
    $region = mysqli_real_escape_string($con, $_POST['region']);
    $province = mysqli_real_escape_string($con, $_POST['province']);
    $city = mysqli_real_escape_string($con, $_POST['city']);
    $barangay = mysqli_real_escape_string($con, $_POST['barangay']);
    $fullAddr = mysqli_real_escape_string($con, $_POST['fullAddress']);
    $phonePatternPH = '/^09\d{9}$/';

    if (!preg_match($phonePatternPH, $phoneNum)) {
        header("Location: ../account-details.php");
        $_SESSION['Errormsg'] = "Invalid Philippine phone number format";
    } else {
        // Check if userID already exists
        $stmt = $con->prepare("SELECT address_user_ID FROM addresses WHERE address_user_ID = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $_SESSION['Errormsg'] = "Add address button can't be use anymore";
            header("Location: ../account-details.php");
            exit;
        }

        // Prepare and bind the parameters for inserting a new address
        $stmt = $con->prepare("INSERT INTO addresses (address_user_ID, address_fullName, address_email, address_region, address_province, address_city, address_barangay, address_phone, address_fullAddress)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issssssss", $userId, $fullN, $email, $region, $province, $city, $barangay, $phoneNum, $fullAddr);

        if ($stmt->execute()) {
            redirectSwal("../account-details.php", "Address updated successfully", "success");
        } else {
            redirectSwal("../account-details.php", "Something went wrong", "error");
        }
        $stmt->close();
    }
}

/* User Address Update statement */
if (isset($_POST['sellerUpdateAddrBtn'])) {
    $userId = mysqli_real_escape_string($con, $_POST['userID']);
    $fullN = mysqli_real_escape_string($con, $_POST['fullName']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $phoneNum = mysqli_real_escape_string($con, $_POST['phoneNumber']);
    $region = mysqli_real_escape_string($con, $_POST['region']);
    $province = mysqli_real_escape_string($con, $_POST['province']);
    $city = mysqli_real_escape_string($con, $_POST['city']);
    $barangay = mysqli_real_escape_string($con, $_POST['barangay']);
    $fullAddr = mysqli_real_escape_string($con, $_POST['fullAddress']);
    $phonePatternPH = '/^09\d{9}$/';

    if (!preg_match($phonePatternPH, $phoneNum)) {
        $_SESSION['Errormsg'] = "Invalid Philippine phone number format";
    } else {
        // Prepare and bind the parameters
        $stmt = $con->prepare("UPDATE addresses SET address_fullName = ?, address_email = ?, address_region = ?, address_province = ?, address_city = ?, address_barangay = ?, address_phone = ?, address_fullAddress = ? WHERE address_user_ID = ?");
        $stmt->bind_param("ssssssssi", $fullN, $email, $region, $province, $city, $barangay, $phoneNum, $fullAddr, $userId);

        if ($stmt->execute()) {
            redirectSwal("../account-details.php", "Address updated successfully", "success");
        } else {
            redirectSwal("../account-details.php", "Something went wrong", "error");
        }

        $stmt->close();
    }
}
