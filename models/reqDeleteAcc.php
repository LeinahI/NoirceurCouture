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

    $check_userID_query = "SELECT ud_user_ID FROM users_deleted_details WHERE ud_user_ID = '$userID'";
    $check_userID_query_run = mysqli_query($con, $check_userID_query);

    $check_parcelProcess_query = "SELECT u.user_ID, o.orders_status FROM users u JOIN orders o ON u.user_ID = o.orders_user_ID WHERE u.user_ID = '$userID' AND o.orders_status = 0 OR o.orders_status = 1";
    $check_parcelProcess_query_run = mysqli_query($con, $check_parcelProcess_query);

    if (mysqli_num_rows($check_parcelProcess_query_run) > 0) {
        redirectSwal("../views/requestDeleteAccount.php", "You still have ongoing 'To Ship' or 'To Receive' purchases", "error");
    } else if (mysqli_num_rows($check_userID_query_run) > 0) {
        redirectSwal("../views/requestDeleteAccount.php", "You already submit a request!", "error");
    } else {
        $insert_query = "INSERT INTO users_deleted_details (ud_user_ID, ud_firstName, ud_lastName, ud_email, ud_phone, 
                        ud_username, ud_password, ud_role, ud_reason, ud_details)
                        VALUES('$userID','$fname','$lname','$email','$phoneNum','$uname','$uPass','$role','$reason','$reasonDetails')";
        $insert_query_run = mysqli_query($con, $insert_query);

        if ($insert_query_run) {
            redirectSwal("../views/requestDeleteAccount.php", "Request for account Deletion has been submitted. Wait for administrator confirmation.", "success");
        }
    }
}
