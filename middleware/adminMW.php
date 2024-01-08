<?php
include(__DIR__ . '/../models/myFunctions.php');

if (isset($_SESSION['auth'])) {
    if ($_SESSION['user_role'] != 1) {
        redirect("../views/index.php", "You're not authorized to access this page");
    }
} else {
    redirect("../views/login.php", "Log in to continue");
}

