<?php session_start();
if (isset($_SESSION['auth'])) {

    if ($_SESSION['user_role'] == 1) {
        /* redirect("../index.php", "You're not authorized to access this page"); */
        $_SESSION['status'] = "admin account can't go there";
        $_SESSION['status_code'] = "error";
        header("Location:admin/index.php");
        exit();
        /* Alert popup will show at index.php */
    }
}
include('../models/userFunctions.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noirceur Couture</title>

    <!-- fontawesome & bootstrap icons css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />

    <!-- Bootstrap css -->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <!-- Owl Carousel -->
    <link rel="stylesheet" href="../assets/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="../assets/css/owl.carousel.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">

    <!-- Main CSS -->
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>

<body class="bg-main">
    <?php include('navbar.php'); ?>