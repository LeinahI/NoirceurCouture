<?php
include('dbcon.php');
ob_start(); //Ouput buffering

function checkUserValidityAndRedirect($userId) {
    global $con;

    
    $query = "SELECT * FROM users WHERE user_id = ?";
    $statement = mysqli_prepare($con, $query);

    if ($statement) {
        mysqli_stmt_bind_param($statement, 'i', $userId);
        mysqli_stmt_execute($statement);
        $result = mysqli_stmt_get_result($statement);

      
        $user = mysqli_fetch_assoc($result);

  
        if ($user === null || $user['user_isBan'] == 1) {
 
            session_destroy();
     
        }

        mysqli_stmt_close($statement);
    } else {
     
        die("Error in preparing statement: " . mysqli_error($con));
    }
    
}