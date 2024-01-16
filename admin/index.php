<?php include('partials/header.php'); ?>
<?php include('../middleware/adminMW.php');
?>
<div class="container">
    <div class="col-md-12">
        <div class="card-header">
            <span class="fs-2 fw-bold">Admin Dashboard</span>
            <span class="fs-3 float-end">Welcome <span class="fw-bold"><?= $_SESSION['auth_user']['user_firstName']; ?></span></span>
        </div>
        <div class="row mt-4">
            <?php
            $adminCateg = getAdminCategories($_SESSION['auth_user']['user_ID']);

            ?>
            <div class="form-floating col-md-12 mb-5">
                <select class="form-select border border-primary ps-2" id="selectCategory">
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
                <label for="selectCategory" class="ps-3">Select Brand Category</label>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card bg-dark">
                    <div class="card-header bg-dark p-3 pt-2">
                        <div class="icon icon-lg icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-xl mt-n4 position-absolute">
                            <i class="material-icons opacity-10">shopping_cart</i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-white text-capitalize">Total Revenue from Delivered</p>
                            <h4 class="mb-0 text-white">₱<span id="revenueDeliver"></span></h4>
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
                            <i class="material-icons opacity-10">assignment_return</i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="text-sm text-white mb-0 text-capitalize">Total Orders Cancelled</p>
                            <h4 class="mb-0 text-white" id="orderCancelled"></h4>
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
                            <i class="material-icons opacity-10">store</i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-capitalize text-white ">Expected Revenue by Product</p>
                            <h4 class="mb-0 text-white">₱<span id="expectedRevenue"></span></h4>
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
                            <i class="material-icons opacity-10">inventory_2</i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-capitalize text-white">All products Total Count</p>
                            <h4 class="mb-0 text-white" id="allProductCount"></h4>
                        </div>
                    </div>

                    <hr class="horizontal my-0 dark">
                    <div class="card-footer p-3">
                        <p class="mb-0 "></p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mt-4">
                <div class="card bg-primary">
                    <div class="card-header p-3 pt-2 bg-primary text-white">
                        <div class="icon icon-xl icon-shape bg-gradient-primary shadow-dark shadow text-center border-radius-xl mt-n4 position-absolute">
                            <i class="material-icons opacity-10">whatshot</i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="fs-3 mb-0 text-capitalize">most sellable product</p>
                            <img id="trendImageName" height="150px" alt="product_image">
                            <div class="d-flex flex-row-reverse">
                                <h3 class="mb-0 text-white" style="margin-left: 20px;" id="trendProductName"></h3>
                                <h3 class="mb-0 text-white">₱<span id="trendProductPrice"></span></h3>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer p-3">
                    </div>
                </div>
            </div>

            <div class="col-md-6 mt-4">
                <div class="card bg-success">
                    <div class="card-header p-3 pt-2 bg-success text-white">
                        <div class="icon icon-xl icon-shape bg-gradient-success shadow-dark shadow text-center border-radius-xl mt-n4 position-absolute">
                            <i class="material-icons opacity-10">attach_money</i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="fs-3 mb-0 text-capitalize">most sellable product count</p>
                            <div class="mt-4 d-flex flex-row-reverse">
                                <h3 class="mb-0 text-white" style="margin-left: 20px;"><span id="itemSold"></span>&nbsp;pcs</h3>
                                <h3 class="mb-0 text-white">₱<span id="priceSold"></span></h3>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer p-3">
                    </div>
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