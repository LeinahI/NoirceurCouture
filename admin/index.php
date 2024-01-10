<?php include('partials/header.php'); ?>
<?php include('../middleware/adminMW.php');
?>
<div class="container">
    <div class="row"></div>
    <div class="col-md-12">
        <h2>Admin Dashboard</h2>
        <div class="row mt-4">
            <?php
            $user = getCancelledOrdersCount($_SESSION['auth_user']['user_ID']);
            $cancelCount = mysqli_fetch_array($user);

            $prod = getAllProductsCount($_SESSION['auth_user']['user_ID']);
            $prodCount = mysqli_fetch_array($prod);

            $rev = getRevenue($_SESSION['auth_user']['user_ID']);
            $revTotal = mysqli_fetch_array($rev);

            $revdel = getRevenueDeliver($_SESSION['auth_user']['user_ID']);
            $revdelTotal = mysqli_fetch_array($revdel);

            ?>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-header p-3 pt-2">
                        <div class="icon icon-lg icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-xl mt-n4 position-absolute">
                            <i class="material-icons opacity-10">shopping_cart</i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-capitalize">Total Revenue from Delivered</p>
                            <h4 class="mb-0">₱<?= number_format($revdelTotal['total_orders_price'], 2); ?></h4>
                        </div>
                    </div>

                    <hr class="dark horizontal my-0">
                    <div class="card-footer p-3">
                        <p class="mb-0"><span class="text-success text-sm font-weight-bolder"></p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card  mb-2">
                    <div class="card-header p-3 pt-2">
                        <div class="icon icon-lg icon-shape bg-gradient-primary shadow-primary shadow text-center border-radius-xl mt-n4 position-absolute">
                            <i class="material-icons opacity-10">groups</i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-capitalize">Total Orders Cancelled</p>
                            <h4 class="mb-0"><?= $cancelCount['total_cancelled_orders']; ?></h4>
                        </div>
                    </div>

                    <hr class="dark horizontal my-0">
                    <div class="card-footer p-3">
                        <p class="mb-0"><span class="text-success text-sm font-weight-bolder"></p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card  mb-2">
                    <div class="card-header p-3 pt-2 bg-transparent">
                        <div class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                            <i class="material-icons opacity-10">store</i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-capitalize ">Expected Revenue</p>
                            <h4 class="mb-0 ">₱<?= number_format($revTotal['total_if_sold'], 2); ?></h4>
                        </div>
                    </div>

                    <hr class="horizontal my-0 dark">
                    <div class="card-footer p-3">
                        <p class="mb-0 "><span class="text-success text-sm font-weight-bolder"></p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card ">
                    <div class="card-header p-3 pt-2 bg-transparent">
                        <div class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                            <i class="material-icons opacity-10">inventory_2</i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-capitalize ">All products Total Qty.</p>
                            <h4 class="mb-0 "><?= $prodCount['total_prod_qty'] ?? 0; ?></h4>
                        </div>
                    </div>

                    <hr class="horizontal my-0 dark">
                    <div class="card-footer p-3">
                        <p class="mb-0 "></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<?php include('partials/footer.php'); ?>