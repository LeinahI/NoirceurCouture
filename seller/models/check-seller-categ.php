<?php
include('../models/dbcon.php');

$user_ID = $_SESSION['auth_user']['user_ID'];

/* Check if seller have category existing before adding a product */
$check_address_query = "SELECT * FROM categories WHERE category_user_ID = '$user_ID' ";
$check_address_query_run = mysqli_query($con, $check_address_query);

if (mysqli_num_rows($check_address_query_run) <= 0) {
    redirectSwal("../seller/your-store.php", "Add your store first before adding your product", "warning");
    exit();
}
