<?php include('partials/header.php');
include('../middleware/sellerMW.php'); ?>

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

    .page[size="A4"] {
        width: 21cm;
        height: 29.7cm;
        overflow: hidden;
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

    @media print {
        .card-body *:not(#printableArea):not(#printableArea *) {
            visibility: hidden;
        }

        #printableArea {
            position: absolute;
            left: -50px;
            top: -25px;
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
        <?php
        $categUser = getByCategAndUserId($_SESSION['auth_user']['user_ID']);
        $data = mysqli_fetch_array($categUser);

        $categImage = isset($data['category_image']) ? $data['category_image'] : '';
        $categName = isset($data['category_name']) ? $data['category_name'] : '';

        $revdel = getRevenueDeliver($_SESSION['auth_user']['user_ID']);
        $revdelTotal = mysqli_fetch_array($revdel);

        $cancel = getCancelledOrdersCount($_SESSION['auth_user']['user_ID']);
        $cancelCount = mysqli_fetch_array($cancel);

        $rev = getRevenue($_SESSION['auth_user']['user_ID']);
        $revTotal = mysqli_fetch_array($rev);

        $prod = getAllProductsCount($_SESSION['auth_user']['user_ID']);
        $prodCount = mysqli_fetch_array($prod);

        $trendItem = getTrendingItem($_SESSION['auth_user']['user_ID']);
        $trend = mysqli_fetch_array($trendItem);
        ?>
        <div class="card-body">
            <!-- Printable page -->
            <div class="p-5 page" size="A4" id="printableArea">
                <!-- Sales Activity Report -->
                <div class="border border-top-0 rounded">
                    <section class="store-user card-header bg-primary">
                        <div>
                            <h2 class="text-white text-center">Sales Activity Report</h2>
                        </div>
                    </section>
                    <!-- Brand Name and Logo -->
                    <section class="store-user mt-3 px-3">
                        <div class="logo d-flex align-items-center">
                            <img src="../assets/uploads/brands/<?= $categImage; ?>" style="margin-right: 15px;" height="50px">
                            <h2 class="text-primary"><?= $categName ?></h2>
                        </div>
                    </section>
                    <!-- Main Reports -->
                    <section class="product-area p-3 row">
                        <!-- Total Revenue from Delivered -->
                        <div class="col-md-6 mb-4">
                            <div class="card bg-dark">
                                <div class="card-header p-3 pt-2 bg-dark text-white">
                                    <div class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-xl mt-n4 position-absolute">
                                        <i class="material-icons opacity-10">shopping_cart</i>
                                    </div>
                                    <div class="text-end pt-1">
                                        <p class="fs-6 mb-0 text-capitalize">Total Revenue from Delivered</p>
                                        <h3 class="mb-0 text-white">₱<?= number_format($revdelTotal['total_orders_price'], 2); ?></h3>
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
                                        <i class="material-icons opacity-10">assignment_return</i>
                                    </div>
                                    <div class="text-end pt-1">
                                        <p class="fs-6 mb-0 text-capitalize">Total Orders Cancelled</p>
                                        <h3 class="mb-0 text-white"><?= $cancelCount['total_cancelled_orders']; ?></h3>
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
                                        <i class="material-icons opacity-10">store</i>
                                    </div>
                                    <div class="text-end pt-1">
                                        <p class="fs-6 mb-0 text-capitalize">Expected Revenue by Product</p>
                                        <h3 class="mb-0 text-white">₱<?= number_format($revTotal['total_if_sold'], 2); ?></h3>
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
                                        <i class="material-icons opacity-10">inventory_2</i>
                                    </div>
                                    <div class="text-end pt-1">
                                        <p class="fs-6 mb-0 text-capitalize">All products Total Count</p>
                                        <h3 class="mb-0 text-white"><?= $prodCount['total_prod_qty'] ?? 0; ?></h3>
                                    </div>
                                </div>

                                <hr class="dark horizontal my-0">
                                <div class="card-footer p-3">
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <!-- Product Report -->
                <div class="border border-top-0 rounded mt-4">
                    <section class="store-user card-header bg-primary">
                        <div>
                            <h2 class="text-white text-center">Product Activity Report</h2>
                        </div>
                    </section>
                    <!-- Main Reports -->
                    <section class="product-area mt-3 p-3 row">
                        <!-- most sellable product -->
                        <div class="col-md-6">
                            <div class="card bg-primary ">
                                <div class="card-header p-3 pt-2 bg-primary text-white">
                                    <div class="icon icon-md icon-shape bg-gradient-primary shadow-dark shadow text-center border-radius-xl mt-n4 position-absolute">
                                        <i class="material-icons opacity-10">whatshot</i>
                                    </div>
                                    <div class="text-end pt-1">
                                        <p class="fs-6 mb-0 text-capitalize">most sellable product</p>
                                        <img src="../assets/uploads/products/<?= $trend['product_image']; ?>" height="80px">
                                        <div class="d-flex flex-row-reverse">
                                            <h5 class="mb-0 text-white"><?= $trend['product_name']; ?></h5>
                                            <h5 class="mb-0 text-white">₱<?= number_format($trend['product_srp'], 2); ?></h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer p-3">
                                </div>
                            </div>
                        </div>
                        <!-- Total Count Sold of Most sellable Product -->
                        <div class="col-md-6">
                            <div class="card bg-success ">
                                <div class="card-header p-3 pt-2 bg-success text-white">
                                    <div class="icon icon-md icon-shape bg-gradient-success shadow-dark shadow text-center border-radius-xl mt-n4 position-absolute">
                                        <i class="material-icons opacity-10">attach_money</i>
                                    </div>
                                    <div class="text-end pt-1">
                                        <p class="fs-6 mb-0 text-capitalize">most sellable product count</p>
                                        <div class="mt-4">
                                            <h3 class="mb-0 text-white"><?= $trend['trending']; ?> pcs</h3>
                                            <h3 class="mb-0 text-white">₱<?= number_format($trend['orders_total_price'], 2); ?></h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-end p-3 ">

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

<!--jquery cdn start-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<!--jquery cdn end-->

<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<?php include('partials/footer.php'); ?>