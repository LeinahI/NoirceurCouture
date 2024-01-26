<?php
include('dbcon.php');
include('myFunctions.php');
session_start();

/* Request Seller Delete Account */
if (isset($_POST['SubmitDelAccReq'])) {
    $userID = $_POST['userID'];
    $fname = $_POST['fName'];
    $lname = $_POST['lName'];
    $email = $_POST['email'];
    $phoneNum = $_POST['phone'];
    $uname = $_POST['username'];
    $uPass = $_POST['pass'];
    $role = $_POST['role'];/* 0 = buyer, 1 = admin, 2 seller */

    $reason = $_POST['reasonDelAccList'];
    $reasonDetails = $_POST['reasonDelAccMoreDetails'];

    $check_userID_query = "SELECT deleted_user_ID FROM users_deleted_details WHERE deleted_user_ID = '$userID'";
    $check_userID_query_run = mysqli_query($con, $check_userID_query);

    if (mysqli_num_rows($check_userID_query_run) > 0) {
        redirectSwal("../views/requestDeleteAccount.php", "You already submit a request!", "error");
    } else {
        $insert_query = "INSERT INTO users_deleted_details (deleted_user_ID, deleted_user_firstName, deleted_user_lastName, deleted_user_email, deleted_user_phone, 
                        deleted_user_username, deleted_user_password, deleted_user_role, deleted_reason, deleted_reason_details)
                        VALUES('$userID','$fname','$lname','$email','$phoneNum','$uname','$uPass','$role','$reason','$reasonDetails')";
        $insert_query_run = mysqli_query($con, $insert_query);
        
        if ($insert_query_run) {
            redirectSwal("../views/requestDeleteAccount.php", "Request for account Deletion has been submitted. Wait for administrator confirmation.", "success");
        }
    }
}
