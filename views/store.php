<?php /* <!-- also calledCategories.php --> */
include('../partials/__header.php');
include(__DIR__ . '/../models/checkSession.php');
checkUserValidityAndRedirect($_SESSION['auth_user']['user_ID'] ?? null);

if (isset($_GET['category'])) {
    $category_slug = $_GET['category'];
    $category_data = getSlugActiveCategories($category_slug);
    $category = mysqli_fetch_array($category_data);
    if ($category) {
        $cid = $category['category_id'];
?>
        <style>
            .img-fixed-height {
                height: 272px;
                /* Set the height to your desired value */
                width: auto;
                object-fit: cover;
                /* This property ensures that the image retains its aspect ratio while covering the specified height */
            }

            .card {
                height: 100%;

            }

            .card-body {
                height: 100%;
            }

            .icon {
                width: 90px;
                height: 90px;
                padding: 50px;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .bg-darker {
                background-color: #d8cbc3 !important;
            }

            .fa-solid {
                height: 20px;
                width: 20px;
            }
        </style>

        <div class="py-3 bg-primary">
            <div class="container">
                <h6 class="text-dark">
                    <a href="storelist.php" class="text-dark">Home /</a>
                    <a href="storelist.php" class="text-dark">Collections /</a>
                    <?= $category['category_name'] ?>
                </h6>
            </div>
        </div>

        <div class="py-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <!-- Profile -->
                            <div class="col-md-4">
                                <div class="card border border-0 bg-primary p-3 mb-2">
                                    <div class="d-flex justify-content-between">
                                        <div class="d-flex flex-row align-items-center">
                                            <div class="icon bg-darker rounded-circle">
                                                <img src="../assets/uploads/brands/<?= $category['category_image'] ?>" alt="Store Image" class="object-fit-cover rounded-circle" width="90" height="90">
                                            </div>
                                            <div class="ms-2 c-details">
                                                <p class="fs-5 mb-0 fw-bold"><?= $category['category_name'] ?><span class="fw-normal desc fs-6"><br><?= $category['category_description'] ?></span></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Details -->
                            <div class="col-md-8">
                                <div class="px-3 pt-3 h-100">
                                    <div class="d-flex justify-content-between">
                                        <div class="col-md-12 d-flex flex-row align-items-center">
                                            <?php
                                            /* Get Product Count */
                                            $prodCount = getProductsCountByCategoryByID($cid);
                                            $count = mysqli_fetch_array($prodCount);

                                            /* Get Seller State & City */
                                            $getaddr = getSellerStateCityByCategoryByID($cid);
                                            $addr = mysqli_fetch_array($getaddr);
                                            ?>
                                            <div class="row col-md-6">
                                                <div class="d-flex mb-4">
                                                    <div class="pr-2"><i class="fa-solid fa-store text-center"></i></div>
                                                    <div>Products:&nbsp;<span class="text-accent"><?= $count['allproduct'] ?></span></div>
                                                </div>

                                                <div class="d-flex mb-4">
                                                    <div class="pr-2"><i class="fa-solid fa-location-dot text-center"></i></div>
                                                    <div>Location:&nbsp;<span class="text-accent"><?= $addr['address_city'] ?? "not" ?>,&nbsp;<?= $addr['address_state'] ?? "available" ?></span></div>
                                                </div>
                                            </div>
                                            <div class="row col-md-6">
                                                <div class="d-flex mb-4">
                                                    <div class="pr-2"><i class="fa-solid fa-star text-center"></i></div>
                                                    <div>Ratings:</div>
                                                </div>

                                                <div class="d-flex mb-4">
                                                    <div class="pr-2"><i class="fa-solid fa-person-circle-check text-center"></i></div>
                                                    <div>Joined:&nbsp;<span class="text-accent"><?= (new DateTime($category['category_createdAt']))->format('M d Y') ?></span></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <?php
                            $products = getProdByCategory($cid);

                            // Check if the category is on vacation or banned
                            $category_onVacation = false;
                            $category_isBan = false;

                            if ($row = mysqli_fetch_array($products)) {
                                $category_onVacation = $row['category_onVacation'];
                                $category_isBan = $row['category_isBan'];
                            } else {
                                echo "<span class='fs-4 fw-bold text-accent'>This store currently have not posted a product yet.</span>";
                            }

                            mysqli_data_seek($products, 0); // Reset the result set pointer

                            // Fetch the products using mysqli_fetch_array
                            while ($item = mysqli_fetch_array($products)) {
                                if (strlen($item['product_name']) > 15) {
                                    $item['product_name'] = substr($item['product_name'], 0, 20) . '...';
                                }

                                // Display a message if the category is on vacation
                                if ($category_onVacation) {
                            ?>
                                    <span class='fs-4 fw-bold text-accent'>This store is currently on vacation. No products are available for purchase.</span>
                                <?php
                                    break; // Exit the loop if the category is on vacation
                                }

                                if ($category_isBan) {
                                ?>
                                    <span class='fs-4 fw-bold text-accent'>This store has been permanently banned.</span>
                                    <!-- Modal Initialize on load -->
                                    <div class="modal" id="onload" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-centered">
                                            <div class="modal-content bg-main">
                                                <div class="modal-header text-center">
                                                    <span class='fs-3 fw-bold text-accent modal-title w-100'>This store has been permanently banned.</span>
                                                </div>
                                                <div class="modal-footer">
                                                    <a href="storelist.php" type="button" class="btn btn-accent col-md-12">Proceed</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                    break; // Exit the loop if the category is banned
                                }

                                // Display the product card
                                ?>
                                <div class="col-md-3 mb-3">
                                    <a href="productView.php?product=<?= $item['product_slug'] ?>" class="card-link">
                                        <div class="card shadow">
                                            <div class="card-body d-flex flex-column justify-content-between bg-primary">
                                                <div>
                                                    <img src="../assets/uploads/products/<?= $item['product_image'] ?>" alt="Product Image" class="w-100 img-fixed-height">
                                                    <h4><?= $item['product_name'] ?></h4>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php
                            }

                            mysqli_free_result($products); // Free the result set
                            ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>

<?php
    } else {
        echo "<h1><center>Something went wrong</center></h1>";
    }
}
?>
<script>
    window.onload = () => {
        $('#onload').modal('show');
    }
</script>
<?php include('footer.php');
include('../partials/__footer.php'); ?>