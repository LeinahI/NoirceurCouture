<?php
session_start();
date_default_timezone_set('Asia/Manila');
include('../../models/dbcon.php');
include('../../models/myFunctions.php');

if (isset($_POST['processAccDeletion'])) {
    $userId = $_POST['deletedUserID'];
    $action = $_POST['processAccDeletion'];

    if ($action === 'accept') {

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

        //+ Finally Delete the User
        $deleteQuery = "DELETE FROM users WHERE user_ID = '$userId'";
        mysqli_query($con, $deleteQuery);

        //+ Finally Update users_deleted_details in ud_confirmed = 1 
        $updateUsersQuery = "UPDATE users_deleted_details SET ud_confirmed = 1 WHERE ud_user_ID = '$userId'";
        mysqli_query($con, $updateUsersQuery);

        redirectSwal("../deleteAccountRequest.php", "The user account deletion request has been deleted", "success");
        // Additional logic or redirect if needed
    } elseif ($action === 'reject') {
        //* Perform the update for rejection
        $deleteQuery = "DELETE FROM users_deleted_details WHERE ud_user_ID = '$userId'";
        mysqli_query($con, $deleteQuery);

        redirectSwal("../deleteAccountRequest.php", "The user account deletion request has been rejected!", "success");
    }
    // Redirect or display a success message as needed
}
