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
}

/* User Address Add statement */
if (isset($_POST['sellerAddAddrBtn'])) {
    $userId = $_POST['userID'];
    $fullN = $_POST['fullName'];
    $email = $_POST['email'];
    $phoneNum = $_POST['phoneNumber'];
    $region = $_POST['region'];
    $province = $_POST['province'];
    $city = $_POST['city'];
    $barangay = $_POST['barangay'];
    $fullAddr = $_POST['fullAddress'];
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
    $userId = $_POST['userID'];
    $fullN = $_POST['fullName'];
    $email = $_POST['email'];
    $phoneNum = $_POST['phoneNumber'];
    $region = $_POST['region'];
    $province = $_POST['province'];
    $city = $_POST['city'];
    $barangay = $_POST['barangay'];
    $fullAddr = $_POST['fullAddress'];
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
