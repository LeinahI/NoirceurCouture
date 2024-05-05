<?php
session_start();
date_default_timezone_set('Asia/Manila');
include('../../models/dbcon.php');
include('../../models/myFunctions.php');

if (isset($_POST['processAccDeletion'])) {
    $userId = $_POST['deletedUserID'];

    //? Buyer Delete Current Carts under userId 
    $deleteCartsQuery = "DELETE FROM carts WHERE user_ID = '$userId'";
    mysqli_query($con, $deleteCartsQuery);
    //? Buyer Delete Current Likes under userId 
    $deleteLikesQuery = "DELETE FROM likes WHERE user_ID = '$userId'";
    mysqli_query($con, $deleteLikesQuery);
    //? Delete Addresses 
    $deleteAddressQuery = "DELETE FROM addresses WHERE address_user_ID = '$userId'";
    mysqli_query($con, $deleteAddressQuery);

    //! Seller Delete their product
    $deleteProducts = "DELETE p FROM products AS p
                        JOIN categories AS c ON p.category_id = c.category_id
                        WHERE c.category_user_ID = '$userId'";
    mysqli_query($con, $deleteProducts);

    //! Seller Delete their store
    $deleteStore = "DELETE FROM categories WHERE category_user_ID = '$userId'";
    mysqli_query($con, $deleteStore);

    //! Delete user seller type info
    $deleteSellerInfo = "DELETE FROM users_seller_details WHERE seller_user_ID = '$userId'";
    mysqli_query($con, $deleteSellerInfo);

    //+ Fetch the profile image path
    $selectProfileQuery = "SELECT user_profile_Image FROM `users` WHERE user_ID = ?"; 
    $selectProfile_stmt = mysqli_prepare($con, $selectProfileQuery);
    mysqli_stmt_bind_param($selectProfile_stmt, 'i', $userId);
    mysqli_stmt_execute($selectProfile_stmt);
    $selectProfile_result = mysqli_stmt_get_result($selectProfile_stmt);

    if ($selectProfile_result && $profileData = mysqli_fetch_assoc($selectProfile_result)) {
        $profileImageName = $profileData['user_profile_Image'];
        $profileImagePath = "../../assets/uploads/userProfile/" . $profileImageName;

        //+ Delete the profile image file if it exists
        if (file_exists($profileImagePath)) {
            unlink($profileImagePath); //+ Deletes the file
        }
    }

    //+ Finally Delete the User
    $deleteQuery = "DELETE FROM users WHERE user_ID = '$userId'";
    mysqli_query($con, $deleteQuery);

    //+ Finally Update users_deleted_details in ud_confirmed = 1 
    $updateUsersQuery = "UPDATE users_deleted_details SET ud_confirmed = 1 WHERE ud_user_ID = '$userId'";
    mysqli_query($con, $updateUsersQuery);

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

    $deleteQuery = "DELETE FROM users_deleted_details WHERE ud_user_ID = '$userId'";
    mysqli_query($con, $deleteQuery);

    // Insert notification into the notification table
    $insertNotificationQuery = "INSERT INTO notification (sender_id, receiver_id, notif_Header, notif_Body) VALUES ('$senderID', '$userId', '$reasonHeader', '$reasonBody')";
    mysqli_query($con, $insertNotificationQuery);

    redirectSwal("../deleteAccountRequest.php", "The user account deletion request has been rejected!", "success");
}
