<?php
session_start();
date_default_timezone_set('Asia/Manila');
include('../../models/dbcon.php');
include('../../models/myFunctions.php');

if (isset($_POST['processAccDeletion'])) {
    $userId = $_POST['deletedUserID'];
    $action = $_POST['processAccDeletion'];

    if ($action === 'accept') {
        /* Delete Users */
        $deleteQuery = "DELETE FROM users WHERE user_ID = '$userId'";
        mysqli_query($con, $deleteQuery);

        /* Delete Current Carts under userId */
        $deleteCartsQuery = "DELETE FROM carts WHERE user_ID = '$userId'";
        mysqli_query($con, $deleteCartsQuery);

        /* Delte Current Likes under userId */
        $deleteLikesQuery = "DELETE FROM likes WHERE user_ID = '$userId'";
        mysqli_query($con, $deleteLikesQuery);

        /* Update deleted_confirmed = 1 */
        $updateUsersQuery = "UPDATE users_deleted_details SET deleted_confirmed = 1 WHERE deleted_user_ID = '$userId'";
        mysqli_query($con, $updateUsersQuery);


        redirectSwal("../deleteAccountRequest.php", "The user account deletion request has been deleted", "success");
        // Additional logic or redirect if needed
    } elseif ($action === 'reject') {
        // Perform the update for rejection
        $deleteQuery = "DELETE FROM users_deleted_details WHERE deleted_user_ID = '$userId'";

        mysqli_query($con, $deleteQuery);
        redirectSwal("../deleteAccountRequest.php", "The user account deletion request has been rejected!", "success");
    }
    // Redirect or display a success message as needed
}
