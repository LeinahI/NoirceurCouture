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

        .sidenav{
            visibility: hidden;
        }

        #printableArea {
            position: absolute;
            left: -50px;
            top: 0px;
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
            <?php
            $adminCateg = getByCategAndUserId($_SESSION['auth_user']['user_ID']);
            $data = mysqli_fetch_array($adminCateg);
            ?>
            <div class="form-floating col-md-12">
                <select class="form-select border bg-primary ps-2 text-white" id="selectCategory">
                    <?php
                    if (mysqli_num_rows($adminCateg) > 0) {
                        foreach ($adminCateg as $item) {
                    ?>
                            <option value="<?= $item['category_id'] ?>"><?= $item['category_name'] ?></option>
                    <?php
                        }
                    } else {
                        echo "No Category Available";
                    }
                    ?>
                </select>
                <label for="selectCategory" class="ps-3 text-white">Select Brand Category</label>
            </div>
        </div>
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
                            <img id="categImage" alt="brand_image" style="margin-right: 15px;" height="50px">
                            <h2 class="text-primary" id="categName"></h2>
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
                                        <h3 class="mb-0 text-white">₱<span id="revenueDeliver"></span></h3>
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
                                        <h3 class="mb-0 text-white" id="orderCancelled"></h3>
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
                                        <h3 class="mb-0 text-white">₱ <span id="expectedRevenue"></span></h3>
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
                                        <h3 class="mb-0 text-white" id="allProductCount"></h3>
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
                                        <img id="trendImageName" height="80px" alt="product_image">
                                        <div class="d-flex flex-row-reverse">
                                            <h5 class="mb-0 text-white" style="margin-left: 20px;" id="trendProductName"></h5>
                                            <h5 class="mb-0 text-white">₱ <span id="trendProductPrice"></span></h5>
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
                                        <div class="mt-4 d-flex flex-row-reverse">
                                            <h5 class="mb-0 text-white" style="margin-left: 20px;"><span id="itemSold"></span>&nbsp;pcs</h5>
                                            <h5 class="mb-0 text-white">₱<span id="priceSold"></span></h5>
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
<?php include('partials/footer.php'); ?>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function() {
        // Add change event listener to the select tag
        $('#selectCategory').change(function() {
            // Get the selected category ID
            var categoryId = $(this).val();
            var userId = <?= $_SESSION['auth_user']['user_ID'] ?? 'null'; ?>;

            // Send an AJAX request to your PHP script
            $.ajax({
                type: 'POST',
                url: 'models/dashboard-model.php',
                data: {
                    categoryId: categoryId,
                    userID: userId
                },
                dataType: 'json', // Specify the expected data type
                success: function(response) {

                    // Update HTML elements with the received data
                    $('#allProductCount').text(response.productCount);
                    $('#expectedRevenue').text(response.revenueTotal);
                    $('#orderCancelled').text(response.cancelTotal);
                    $('#revenueDeliver').text(response.revenueDeliverTotal);
                    $('#trendProductName').text(response.trendName);
                    $('#trendProductPrice').text(response.trendPrice);
                    $('#trendImageName').attr('src', '../assets/uploads/products/' + response.trendImage);
                    $('#itemSold').text(response.itemSold);
                    $('#priceSold').text(response.priceSold);
                    $('#categName').text(response.categName);
                    $('#categImage').attr('src', '../assets/uploads/brands/' + response.categImage);
                },
                error: function() {
                    console.log('Error in AJAX request');
                }
            });
        });

        // Trigger the change event on page load only if a category is selected
        if ($('#selectCategory').val()) {
            $('#selectCategory').trigger('change');
        }
    });
</script>