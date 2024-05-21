<?php
session_start();
date_default_timezone_set('Asia/Manila');
include('../../models/dbcon.php');
include('../../models/myFunctions.php');
include('../../models/emailSMTP.php');

if (isset($_POST['processSellerApplication'])) {
    $userId = $_POST['sellerUserID'];
    $action = $_POST['processSellerApplication'];

    $selectQuery = "SELECT u.user_firstName, u.user_lastName, u.user_email, c.category_name
            FROM users u
            INNER JOIN categories c ON u.user_ID = c.category_user_ID
            WHERE user_ID = '$userId'";
    $result = mysqli_query($con, $selectQuery);
    $row = mysqli_fetch_assoc($result);
    $email = $row['user_email'];
    $fname = $row['user_firstName'];
    $lname = $row['user_lastName'];
    $brandName = $row['category_name'];
    $subjectAccept = "Your seller application on Noireur Couture has been accepted!";
    $subjectReject = "Your seller application on Noireur Couture has been rejected!";


    if ($action === 'accept') {
        // Perform the update for acceptance
        $updateQuerySellerDetails = "UPDATE users_seller_details SET seller_confirmed = 1 WHERE seller_user_ID = ?";
        $stmtQuerySellerDetails = mysqli_prepare($con, $updateQuerySellerDetails);
        mysqli_stmt_bind_param($stmtQuerySellerDetails, "i", $userId);
        $update_query_stmtQuerySellerDetails_run = mysqli_stmt_execute($stmtQuerySellerDetails);

        $updateQueryUsers = "UPDATE users SET user_isVerified = 1 WHERE user_ID = ?";
        $stmtQueryUsers = mysqli_prepare($con, $updateQueryUsers);
        mysqli_stmt_bind_param($stmtQueryUsers, "i", $userId);
        $update_query_stmtQueryUsers_run = mysqli_stmt_execute($stmtQueryUsers);

        if ($update_query_stmtQueryUsers_run && $update_query_stmtQuerySellerDetails_run) {
            greetSellerAcceptedAccount($email, $subjectAccept, $fname, $lname, $brandName);
            redirectSwal("../seller-application.php", "The seller application has been verified!", "success");
        } else {
            redirectSwal("../seller-application.php", "Something went wrong", "error");
        }


        // Additional logic or redirect if needed
    } elseif ($action === 'reject') {
        // Perform the update for rejection
        greetSellerRejectedAccount($email, $subjectReject, $fname, $lname, $brandName);
        $deleteQuery = "
        DELETE users, users_seller_details, categories
        FROM users
        LEFT JOIN users_seller_details ON users.user_ID = users_seller_details.seller_user_ID
        LEFT JOIN categories ON users.user_ID = categories.category_user_ID
        WHERE users.user_ID = '$userId'";

        mysqli_query($con, $deleteQuery);
        redirectSwal("../seller-application.php", "The seller application has been rejected!", "success");
        // ...
    }
    // Redirect or display a success message as needed
}
