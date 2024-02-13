<?php
session_start();
date_default_timezone_set('Asia/Manila');
include('dbcon.php');
include('myFunctions.php');

if (isset($_POST['rateProductBtn'])) {
    $track_num = $_POST['trackingNumber'];
    $prod_id = $_POST['prodID'];
    $user_id = $_POST['userID'];
    $rating = $_POST['star'];
    $review = trim($_POST['reviewText']);
    $review = mysqli_real_escape_string($con, $_POST['reviewText']); // Sanitize review text
    $isReviewed = 1;

    // Check if the product is already rated by the user
    $query_check = "SELECT * FROM products_reviews WHERE orders_tracking_no = ? AND product_id= ? AND review_isReviewed = 1";
    $stmt_check = mysqli_prepare($con, $query_check);
    mysqli_stmt_bind_param($stmt_check, "si", $track_num,$prod_id);
    mysqli_stmt_execute($stmt_check);
    $result_check = mysqli_stmt_get_result($stmt_check);

    // If a rating already exists, handle accordingly
    if (mysqli_num_rows($result_check) > 0) {
        redirectSwal("../views/reviewProduct.php?trck=$track_num", "You have already rated this product", "warning");
        mysqli_stmt_close($stmt_check);
        exit(); // Exit script
    } else {
        // Inserting into the database using prepared statement
        $query_insert = "INSERT INTO products_reviews (orders_tracking_no, product_id, user_ID, product_rating, product_review, review_isReviewed) 
    VALUES (?, ?, ?, ?, ?, ?)";

        // Prepare the statement
        $stmt_insert = mysqli_prepare($con, $query_insert);

        // Bind parameters
        mysqli_stmt_bind_param($stmt_insert, "siiisi", $track_num, $prod_id, $user_id, $rating, $review, $isReviewed);

        // Execute the statement
        if (mysqli_stmt_execute($stmt_insert)) {
            redirectSwal("../views/reviewProduct.php?trck=$track_num", "Your review has been submitted", "success");
        } else {
            redirectSwal("../views/reviewProduct.php?trck=$track_num", "Error submitting review", "error");
        }
    }

    // Close the statements
    mysqli_stmt_close($stmt_insert);
}
