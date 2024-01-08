<?php
session_start();
date_default_timezone_set('Asia/Manila');
include('../../models/dbcon.php');
include('../../models/myFunctions.php');

if (isset($_POST['processSellerApplication'])) {
    $userId = $_POST['sellerUserID'];
    $action = $_POST['processSellerApplication'];

    if ($action === 'accept') {
        // Perform the update for acceptance
        $updateQuery = "UPDATE users_seller_details SET seller_confirmed = 1 WHERE seller_user_ID = '$userId'";
        mysqli_query($con, $updateQuery);
        redirectSwal("../seller-application.php", "The seller application has been verified!", "success");
        // Additional logic or redirect if needed
    } elseif ($action === 'reject') {
        // Perform the update for rejection
        $deleteQuery = "
        DELETE users, users_seller_details
        FROM users
        LEFT JOIN users_seller_details ON users.user_ID = users_seller_details.seller_user_ID
        WHERE users.user_ID = '$userId'";

        mysqli_query($con, $deleteQuery);
        redirectSwal("../seller-application.php", "The seller application has been rejected!", "success");
        // ...
    }
    // Redirect or display a success message as needed
}
