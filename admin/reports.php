<?php include('partials/header.php');
include('../middleware/adminMW.php'); ?>

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">

<!-- Custom Style -->
<style>
    :root {
        --body-bg: rgb(204, 204, 204);
        --white: #ffffff;
        --darkWhite: #ccc;
        --black: #000000;
        --dark: #615c60;
        --themeColor: #22b8d1;
        --pageShadow: 0 0 0.5cm rgba(0, 0, 0, 0.5);
    }

    .page {
        background: var(--white);
        display: block;
        margin: 0 auto;
        position: relative;
        box-shadow: var(--pageShadow);
    }

    .logo img {
        /* Store Logo */
        height: 80px;
    }

    /* User Store Section */
    .store-user {
        padding-bottom: 25px;
    }

    .store-user h2 {
        color: var(--themeColor);
        font-family: "Rajdhani", sans-serif;
    }

    /* e-commerce logo */
    .logo-img {
        height: 50px;
        bottom: 78px;
        opacity: .5;
        position: absolute;
    }

    /* Footer Section */
    footer {
        text-align: center;
        position: absolute;
        bottom: 60px;
    }

    .footer-text {
        font-size: 12px;
    }

    .page[size="A4"] {
        width: 21cm;
        height: 29.6cm;
        overflow: hidden;
    }

    @media print {
        .card-body *:not(#printableArea):not(#printableArea *) {
            visibility: hidden;
        }

        .sidenav {
            visibility: hidden;
        }

        .navbar {
            visibility: hidden;
        }

        #printableArea {
            position: absolute;
            left: -50px;
            top: -34px;
        }

        .page {
            box-shadow: none;
        }
    }
</style>

<div class="container">
    <div class="card">
        <div class="card-header bg-primary">
            <h2 class="text-white">Your Reports
                <button class="btn btn-light float-end ms-2" onclick="window.print()"><i class="material-icons opacity-10">print</i> Print Report</button>
            </h2>
        </div>
        <div class="card-body">
            <!-- Printable page -->
            <div class="p-5 page" size="A4" id="printableArea">
                <!-- Sales Activity Report -->
                <div class="border border-top-0 rounded">
                    <section class="store-user card-header bg-primary">
                        <div>
                            <h2 class="text-white text-center">Admin Activity Report</h2>
                        </div>
                    </section>
                    <!-- Main Reports -->
                    <?php
                    $buyers = getAllBuyersList();
                    $allBuyers = mysqli_fetch_array($buyers);

                    $sellers = getAllSellerList();
                    $allSellers = mysqli_fetch_array($sellers);

                    $BANbuyers = getAllBannedBuyer();
                    $banBuy = mysqli_fetch_array($BANbuyers);

                    $BANsellers = getAllBannedSeller();
                    $banSell = mysqli_fetch_array($BANsellers);
                    ?>
                    <section class="product-area mt-3 p-3 row">
                        <!-- Total Revenue from Delivered -->
                        <div class="col-md-6 mb-4">
                            <div class="card bg-dark">
                                <div class="card-header p-3 pt-2 bg-dark text-white">
                                    <div class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-xl mt-n4 position-absolute">
                                        <i class="material-icons opacity-10">store</i>
                                    </div>
                                    <div class="text-end pt-1">
                                        <p class="fs-6 mb-0 text-capitalize">Total Registered Stores</p>
                                        <h3 class="mb-0 text-white"><?= $allSellers['total_sellers'] ?></h3>
                                    </div>
                                </div>
                                <hr class="dark horizontal my-0">
                                <div class="card-footer p-3">
                                </div>
                            </div>
                        </div>
                        <!-- Total Orders Cancelled -->
                        <div class="col-md-6 mb-4">
                            <div class="card bg-warning">
                                <div class="card-header p-3 pt-2 bg-warning text-white">
                                    <div class="icon icon-md icon-shape bg-gradient-warning shadow-dark shadow text-center border-radius-xl mt-n4 position-absolute">
                                        <i class="material-icons opacity-10">shopping_cart</i>
                                    </div>
                                    <div class="text-end pt-1">
                                        <p class="fs-6 mb-0 text-capitalize">Total Registered Buyers</p>
                                        <h3 class="mb-0 text-white" id="orderCancelled"><?= $allBuyers['total_buyers'] ?></h3>
                                    </div>
                                </div>
                                <hr class="dark horizontal my-0">
                                <div class="card-footer p-3">
                                </div>
                            </div>
                        </div>
                        <!-- Expected Revenue -->
                        <div class="col-md-6 ">
                            <div class="card bg-success">
                                <div class="card-header p-3 pt-2 bg-success text-white">
                                    <div class="icon icon-md icon-shape bg-gradient-success shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                                        <i class="fa-solid fa-user-slash" style="color: #fff;"></i>
                                    </div>
                                    <div class="text-end pt-1">
                                        <p class="fs-6 mb-0 text-capitalize">Total Banned Buyers</p>
                                        <h3 class="mb-0 text-white"><?= $banSell['total_stores'] ?></h3>
                                    </div>
                                </div>
                                <hr class="dark horizontal my-0">
                                <div class="card-footer p-3">
                                </div>
                            </div>
                        </div>
                        <!-- All Products total Qty -->
                        <div class="col-md-6 ">
                            <div class="card bg-info">
                                <div class="card-header p-3 pt-2 bg-info text-white">
                                    <div class="icon icon-md icon-shape bg-gradient-info shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                                        <i class="fa-solid fa-store-slash" style="color: #fff;"></i>
                                    </div>
                                    <div class="text-end pt-1">
                                        <p class="fs-6 mb-0 text-capitalize">Total Banned Sellers</p>
                                        <h3 class="mb-0 text-white" id="allProductCount"><?= $banBuy['total_ban_buyer'] ?></h3>
                                    </div>
                                </div>

                                <hr class="dark horizontal my-0">
                                <div class="card-footer p-3">
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

                <!-- e-commerce Logo -->
                <div>
                    <img src="../assets/images/logo/NoirceurCouture_BK.png" class="logo-img" />
                    <footer>
                        <div class="footer-text">
                            <span>
                                <i class="fa-solid fa-phone"></i>
                                <span>09193554999</span>
                            </span>
                            <span class="mx-3">
                                <i class="fas fa-envelope"></i>
                                <span>nctr@proton.mail</span>
                            </span>
                            <span class="">
                                <i class="fa-solid fa-location-dot"></i>
                                <span>Tagaytay City, 4120 Cavite</span>
                            </span>
                        </div>
                    </footer>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include('partials/footer.php'); ?>