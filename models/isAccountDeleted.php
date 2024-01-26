<?php
/* session_start(); */
include('dbcon.php');
ob_start(); //Ouput buffering

function checkUserValidityAndRedirect($userId) {
    global $con;

    // Use proper SQL and query to check if the user with the given ID exists in the database
    $query = "SELECT * FROM users WHERE user_id = ?";
    $statement = mysqli_prepare($con, $query);

    if ($statement) {
        mysqli_stmt_bind_param($statement, 'i', $userId);
        mysqli_stmt_execute($statement);
        $result = mysqli_stmt_get_result($statement);

        // Fetch the result
        $user = mysqli_fetch_assoc($result);

        // Check if user exists and meets any other validation criteria
        if ($user === null) {
            // If not valid, log the user out and redirect to login page
            session_destroy();
            /* redirectSwal('login.php', 'Your session is no longer valid. Please log in again.', 'error'); */
        }

        mysqli_stmt_close($statement);
    } else {
        // Handle error, if any
        die("Error in preparing statement: " . mysqli_error($con));
    }
}