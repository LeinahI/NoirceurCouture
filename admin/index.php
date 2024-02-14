<?php include('partials/header.php'); ?>
<?php include('../middleware/adminMW.php');
?>
<div class="container">
    <div class="col-md-12">
        <div class="card-header">
            <span class="fs-2 fw-bold">Admin Dashboard</span>
            <span class="fs-3 float-end">Welcome <span class="fw-bold"><?= $_SESSION['auth_user']['user_firstName']; ?></span></span>
        </div>
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
        <div class="row mt-4">
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card bg-dark">
                    <div class="card-header bg-dark p-3 pt-2">
                        <div class="icon icon-lg icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-xl mt-n4 position-absolute">
                            <i class="material-icons opacity-10">store</i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-white text-capitalize">Total Registered Stores</p>
                            <h4 class="mb-0 text-white"><?= $allSellers['total_sellers'] ?></h4>
                        </div>
                    </div>

                    <hr class="dark horizontal my-0">
                    <div class="card-footer p-3">
                        <p class="mb-0"><span class="text-success text-sm font-weight-bolder"></p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card bg-warning mb-2">
                    <div class="card-header bg-warning p-3 pt-2">
                        <div class="icon icon-lg icon-shape bg-gradient-warning shadow-dark shadow text-center border-radius-xl mt-n4 position-absolute">
                            <i class="material-icons opacity-10">shopping_cart</i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="text-sm text-white mb-0 text-capitalize">Total Registered Buyers</p>
                            <h4 class="mb-0 text-white" id="orderCancelled"><?= $allBuyers['total_buyers'] ?></h4>
                        </div>
                    </div>

                    <hr class="dark horizontal my-0">
                    <div class="card-footer p-3">
                        <p class="mb-0"><span class="text-success text-sm font-weight-bolder"></p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card bg-success mb-2">
                    <div class="card-header p-3 pt-2 bg-success">
                        <div class="icon icon-lg icon-shape bg-gradient-success shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                            <i class="fa-solid fa-user-slash" style="color: #fff;"></i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-capitalize text-white ">Total Banned Buyers</p>
                            <h4 class="mb-0 text-white"><?= $banSell['total_stores'] ?></h4>
                        </div>
                    </div>

                    <hr class="horizontal my-0 dark">
                    <div class="card-footer p-3">
                        <p class="mb-0 "><span class="text-success text-sm font-weight-bolder"></p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card bg-info">
                    <div class="card-header p-3 pt-2 bg-info">
                        <div class="icon icon-lg icon-shape bg-gradient-info shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                            <i class="fa-solid fa-store-slash" style="color: #fff;"></i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-capitalize text-white">Total Banned Sellers</p>
                            <h4 class="mb-0 text-white" id="allProductCount"><?= $banBuy['total_ban_buyer'] ?></h4>
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

<?php include('partials/footer.php'); ?>