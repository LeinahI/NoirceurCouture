<?php
session_start();
date_default_timezone_set('Asia/Manila');
include('../../models/dbcon.php');
include('../../models/myFunctions.php');

if (isset($_POST['processAccDeletion'])) {
    $userId = $_POST['deletedUserID'];

    // Fetch role
    $selectRoleQuery = "SELECT user_role FROM `users` WHERE user_ID = ?";
    $selectRole_stmt = mysqli_prepare($con, $selectRoleQuery);
    mysqli_stmt_bind_param($selectRole_stmt, 'i', $userId);
    mysqli_stmt_execute($selectRole_stmt);
    $selectRole_result = mysqli_stmt_get_result($selectRole_stmt);

    // Fetch the user role from the result
    $row = mysqli_fetch_array($selectRole_result);
    $userRole = $row['user_role'];

    if ($userRole == 0) {
        //? Buyer Delete Current Carts under userId 
        $deleteCartsQuery = "DELETE FROM carts WHERE user_ID = '$userId'";
        mysqli_query($con, $deleteCartsQuery);
        //? Buyer Delete Current Likes under userId 
        $deleteLikesQuery = "DELETE FROM likes WHERE user_ID = '$userId'";
        mysqli_query($con, $deleteLikesQuery);

        //? Fetch the user profile image path
        $selectUserProfileQuery = "SELECT user_profile_Image FROM `users` WHERE user_ID = ?";
        $selectUserProfile_stmt = mysqli_prepare($con, $selectUserProfileQuery);
        mysqli_stmt_bind_param($selectUserProfile_stmt, 'i', $userId);
        mysqli_stmt_execute($selectUserProfile_stmt);
        $selectUserProfile_result = mysqli_stmt_get_result($selectUserProfile_stmt);

        if ($selectUserProfile_result && $profileData = mysqli_fetch_assoc($selectUserProfile_result)) {
            $profileImageName = $profileData['user_profile_Image'];
            $profileImagePath = "../../assets/uploads/userProfile/" . $profileImageName;

            //+ Delete the profile image file if it exists
            if (file_exists($profileImagePath)) {
                unlink($profileImagePath); //+ Deletes the file
            }
        }
    } elseif ($userRole == 2) {

        //! Delete Addresses 
        $deleteAddressQuery = "DELETE FROM addresses WHERE address_user_ID = '$userId'";
        mysqli_query($con, $deleteAddressQuery);

        //! Delete user seller type info
        $deleteSellerInfo = "DELETE FROM users_seller_details WHERE seller_user_ID = '$userId'";
        mysqli_query($con, $deleteSellerInfo);

        //! Fetch the category/store profile image path
        $selectCategoryProfileQuery = "SELECT category_image FROM `categories` WHERE category_user_ID = ?";
        $selectCategoryProfile_stmt = mysqli_prepare($con, $selectCategoryProfileQuery);
        mysqli_stmt_bind_param($selectCategoryProfile_stmt, 'i', $userId);
        mysqli_stmt_execute($selectCategoryProfile_stmt);
        $selectCategoryProfile_result = mysqli_stmt_get_result($selectCategoryProfile_stmt);

        if ($selectCategoryProfile_result && $profileData = mysqli_fetch_assoc($selectCategoryProfile_result)) {
            $profileImageName = $profileData['category_image'];
            $profileImagePath = "../../assets/uploads/brands/" . $profileImageName;

            //+ Delete the profile image file if it exists
            if (file_exists($profileImagePath)) {
                unlink($profileImagePath); //+ Deletes the file
            }
        }
    }


    //+ Finally Delete the User
    $deleteQuery = "DELETE FROM users WHERE user_ID = '$userId'";
    mysqli_query($con, $deleteQuery);

    if ($userRole == 0) {
        //+ Finally Update users_deleted_details in ud_confirmed = 1 
        $updateUsersQuery = "UPDATE users_deleted_details SET ud_confirmed = 1 WHERE ud_user_ID = '$userId'";
        mysqli_query($con, $updateUsersQuery);
    } else if ($userRole == 2) {
        $updateUsersQuery1 = "UPDATE users_deleted_details SET ud_confirmed = 1 WHERE ud_user_ID = '$userId'";
        mysqli_query($con, $updateUsersQuery1);

        $updateUsersQuery2 = "UPDATE categories_deleted_details SET cd_confirmed = 1 WHERE cd_user_ID = '$userId'";
        mysqli_query($con, $updateUsersQuery2);
    }

    redirectSwal("../deleteAccountRequest.php", "The user account deletion request has been deleted", "success");
} else if (isset($_POST['processAccRejection'])) {
    //* Perform the update for rejection
    $userId = $_POST['rejectedUserID'];
    $rejectReason = $_POST['rejectReason'];
    $senderID = $_POST['senderID'];

    //+ Retrieve the corresponding Header and Body based on the selected reason
    $reasonHeader = '';
    $reasonBody = '';
    if ($rejectReason === 'reason1') {
        $reasonHeader = $_POST['reasonHeader1'];  // Accessing the value from hidden input field
        $reasonBody = $_POST['reasonBody1'];  // Accessing the value from hidden input field
    } elseif ($rejectReason === 'reason2') {
        $reasonHeader = $_POST['reasonHeader2'];  // Accessing the value from hidden input field
        $reasonBody = $_POST['reasonBody2'];  // Accessing the value from hidden input field
    }

    //+ Fetch role
    $selectRoleQuery = "SELECT user_role FROM `users` WHERE user_ID = ?";
    $selectRole_stmt = mysqli_prepare($con, $selectRoleQuery);
    mysqli_stmt_bind_param($selectRole_stmt, 'i', $userId);
    mysqli_stmt_execute($selectRole_stmt);
    $selectRole_result = mysqli_stmt_get_result($selectRole_stmt);

    // Fetch the user role from the result
    $row = mysqli_fetch_array($selectRole_result);

    if ($row['user_role'] == 0) {
        $deleteQuery = "DELETE FROM users_deleted_details WHERE ud_user_ID = '$userId'";
        mysqli_query($con, $deleteQuery);
    } else if ($row['user_role'] == 2) {
        $deleteQuery1 = "DELETE FROM users_deleted_details WHERE ud_user_ID = '$userId'";
        mysqli_query($con, $deleteQuery1);

        $deleteQuery2 = "DELETE FROM categories_deleted_details WHERE cd_user_ID = '$userId'";
        mysqli_query($con, $deleteQuery2);
    }

    // Insert notification into the notification table
    $insertNotificationQuery = "INSERT INTO notification (sender_id, receiver_id, notif_Header, notif_Body) VALUES ('$senderID', '$userId', '$reasonHeader', '$reasonBody')";
    mysqli_query($con, $insertNotificationQuery);

    redirectSwal("../deleteAccountRequest.php", "The user account deletion request has been rejected!", "success");
}
