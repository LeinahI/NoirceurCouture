<?php
include('../functions/myFunctions.php');
if (isset($_SESSION['auth'])) {

    if ($_SESSION['user_role'] != 1) {
        redirect("../index.php", "You're not authorized to access this  page");
    }
} else {
    redirect("../login.php", "Log in to continue");
}
include('../includes/scripts.php');
?>