<?php
include('../models/dbcon.php');

$user_ID = $_SESSION['auth_user']['user_ID'];

/* Check if seller have pickup addr */
$check_address_query = "SELECT * FROM addresses WHERE address_user_ID = '$user_ID' ";
$check_address_query_run = mysqli_query($con, $check_address_query);

if (mysqli_num_rows($check_address_query_run) <= 0) {
    redirectSwal("../seller/account-details.php", "Add your pickup address first before creating a store", "warning");
    exit();
}
