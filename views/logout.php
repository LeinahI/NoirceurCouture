<?php
session_start();

if (isset($_SESSION['auth'])) {
    unset($_SESSION['auth']);
    unset($_SESSION['auth_user']);
    header("Location:index.php");
    $_SESSION['Errormsg'] = "Logged out successfully";
    /* $_SESSION['status_code'] = "success"; */
}
