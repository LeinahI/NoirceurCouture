<?php
session_start();
include('../../models/dbcon.php');
include('../../models/myFunctions.php');

/* Request Seller Delete Account */
if (isset($_POST['SubmitDelAccReqSeller'])) {
    $userID = $_POST['userID'];
    $fname = $_POST['fName'];
    $lname = $_POST['lName'];
    $email = $_POST['email'];
    $phoneNum = $_POST['phone'];
    $uname = $_POST['username'];
    $uPass = $_POST['pass'];
    $role = $_POST['role'];/* 0 = buyer, 1 = admin, 2 seller */
    $categoryId = $_POST['categID'];
    $categoryName = $_POST['categName'];

    $reason = $_POST['reasonDelAccList'];
    $reasonDetails = $_POST['reasonDelAccMoreDetails'];

    $check_userID_query = "SELECT ud_user_ID FROM users_deleted_details WHERE ud_user_ID = '$userID'";
    $check_userID_query_run = mysqli_query($con, $check_userID_query);

    if (mysqli_num_rows($check_userID_query_run) > 0) {
        redirectSwal("../requestDeleteAccountSeller.php", "You already submit a request!", "error");
    } else {
        $insert_ud_query = "INSERT INTO users_deleted_details (ud_user_ID, ud_firstName, ud_lastName, ud_email, ud_phone, 
                        ud_username, ud_password, ud_role, ud_reason, ud_details)
                        VALUES('$userID','$fname','$lname','$email','$phoneNum','$uname','$uPass','$role','$reason','$reasonDetails')";
        $insert_ud_query_run = mysqli_query($con, $insert_ud_query);

        $insert_cd_query = "INSERT INTO categories_deleted_details (cd_category_id, cd_user_ID, cd_category_name)
                        VALUES('$categoryId','$userID','$categoryName')";
        $insert_cd_query_run = mysqli_query($con, $insert_cd_query);
        
        if ($insert_ud_query_run && $insert_cd_query_run) {
            redirectSwal("../requestDeleteAccountSeller.php", "Request for account Deletion has been submitted. Wait for administrator confirmation.", "success");
        }
    }
}
