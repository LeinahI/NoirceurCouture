<?php
include(__DIR__ . '/../models/myFunctions.php');

if (isset($_SESSION['auth'])) {
    if ($_SESSION['user_role'] != 2) {
        redirect("../views/index.php", "You're not authorized to access this page");
    } else if ($_SESSION['seller_confirmed'] == 0) {
        unset($_SESSION['auth']);
        unset($_SESSION['auth_user']);
        redirect("../views/login.php", "Your credentials still on process. Wait for admin to accept your application");
    }
} else {
    redirect("../views/login.php", "Log in to continue");
}
