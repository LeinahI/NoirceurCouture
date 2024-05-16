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

            @media (max-width: 991px) {
                .topBrandImg {
                    margin-bottom: 2rem;
                }
            }

            .brandImage {
                display: flex;
                justify-content: end;
            }

            @media (max-width: 767px) {
                .brandImage {
                    justify-content: start;
                }
            }
        </style>

        <div class="py-3 bg-main">
            <div class="container">
                <h6 class="text-dark">
                    <a href="index.php" class="text-dark">Home</a> /
                    <a href="storelist.php" class="text-dark">Collections</a> /
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
                            <div class="col-md-12 p-3 mb-2">
                                <div class="row">
                                    <div class="topBrandImg col-lg-3 col-md-12 text-center">
                                        <img src="../assets/uploads/brands/<?= $category['category_image'] ?>" alt="Store Image" class="object-fit-cover" height="150">
                                    </div>
                                    <div class="col-lg-9">
                                        <div class="row">
                                            <p class="col-12 fw-bold text-dark-4 col-md-3 col-sm-3 col-lg-2 text-end">Brand Name: </p>
                                            <p class="col-12 fs-4 fw-bold text-dark col-md-9 col-sm-3 col-lg-10"><?= $category['category_name'] ?></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-12 fw-bold text-dark-4 col-md-3 col-sm-3 col-lg-2 text-end">Description: </p>
                                            <p class="col-12 text-dark-4 col-md-9 col-sm-9 col-lg-10"><?= $category['category_description'] ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Display Products Here -->
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
                            ?>
                                <span class='fs-6 text-dark text-center'>This store currently have not posted a product yet.</span>
                                <?php
                            }

                            mysqli_data_seek($products, 0); // Reset the result set pointer

                            // Fetch the products using mysqli_fetch_array
                            while ($item = mysqli_fetch_array($products)) {
                                $product_name = $item['product_name'];
                                if (strlen($product_name) > 20) { //! Check if the length of the product name is greater than 33 characters
                                    $product_name = substr($product_name, 0, 17) . '...'; //! If it is, truncate it to 30 characters and append '...'
                                }
                                $product_ratings = getProductRatingsByProductID($item['product_id']); //+ Catch product ratings

                                // Calculate average rating for the product
                                $average_rating = calculateAverageRating($product_ratings);

                                $soldCount = getSoldCountByProductID($item['product_id']); //+ Catch product sold
                                $sold = mysqli_fetch_array($soldCount);

                                // Display a message if the category is on vacation
                                if ($category_onVacation) {
                                ?>
                                    <span class='fs-6 text-dark text-center'>This store is currently on vacation. No products are available for purchase.</span>
                                <?php
                                    break; // Exit the loop if the category is on vacation
                                }

                                if ($category_isBan) {
                                ?>
                                    <span class='fs-6 text-dark text-center'>This store has been permanently banned.</span>
                                <?php
                                    break; // Exit the loop if the category is banned
                                }

                                // Display the product card
                                ?>
                                <div class="col-lg-3 col-md-6 col-sm-6 col-6 mb-3 ">
                                    <a href="productView.php?product=<?= $item['product_slug'] ?>" class="card-link">
                                        <img src="../assets/uploads/products/<?= $item['product_image'] ?>" alt="Product Image" class="w-100">
                                        <div class="p-2 col-md-12 bg-tertiary">
                                            <div class="row">
                                                <div class="col-md-9 col-lg-8 col-xl-8">
                                                    <p class="fs-6 text-dark"><?= $product_name; ?></p>
                                                    <p class="fs-6 text-dark">₱<?= number_format($item['product_srp'], 2) ?></p>
                                                </div>
                                                <div class="col-md-3 col-lg-4 col-xl-4 brandImage">
                                                    <img height="50" width="50" src="../assets/uploads/brands/<?= $item['category_image'] ?>" alt="Brand Image">
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
include('../assets/js/ph-address-selector.php');
?>
<script>
    window.onload = () => {
        $('#onload').modal('show');
    }
</script>
<div style="margin-top:11.4%;">

    <?php include('footer.php'); ?>
</div>
<?php include('../partials/__footer.php'); ?>