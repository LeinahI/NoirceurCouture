<?php
session_start();

if (isset($_SESSION['auth'])) {
    unset($_SESSION['auth']);
    unset($_SESSION['auth_user']);
    header("Location:../views/index.php");
    $_SESSION['Successmsg'] = "Logged out successfully";
}
