<div id="productView">
    <style>
        .soldout {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 120px;
            height: 120px;
            border-radius: 60px;
            background-color: rgba(0, 0, 0, .7);
            font-size: 20px;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            text-transform: capitalize;
        }

        .fa-star {
            color: #bb6c54;
        }

        .fa-star-half-stroke {
            color: #bb6c54;
        }
    </style>

    <?php
    include('../partials/__header.php');

    include(__DIR__ . '/../models/checkSession.php');
    checkUserValidityAndRedirect($_SESSION['auth_user']['user_ID'] ?? null);

    if (isset($_GET['product'])) {
        $product_slug = $_GET['product'];
        $product_data = getSlugActiveProducts("products", $product_slug);
        $product = mysqli_fetch_array($product_data);
        if ($product) {
            $categories = getAllActive("categories");
            $category = mysqli_fetch_array($categories);

            // Fetch the category information based on product's category ID
            $category_data = getCategoryByID($product['category_id']);
            $category = mysqli_fetch_array($category_data);

    ?>
            <div class="py-3 bg-primary">
                <div class="container">
                    <h6 class="text-dark">
                        <a href="storelist.php" class="text-dark">Home /</a>
                        <a href="storelist.php" class="text-dark">Collections /</a>
                        <?php
                        if ($category) {
                        ?>
                            <a href="store.php?category=<?= $category['category_slug'] ?>" class="text-dark"><?= $category['category_name'] ?> /</a>
                        <?php } ?>
                        <?= $product['product_name'] ?>
                    </h6>
                </div>
            </div>

            <?php

            if ($product['product_visibility'] == 1) {
            ?>
                <p class='fs-1 fw-bold text-accent text-center'>This product is not available for a moment</p>
            <?php
            } elseif ($product['category_onVacation'] == 1) {
            ?>
                <div class="container">
                    <p class='fs-2 fw-bold text-accent text-center'>"<?= $category['category_name'] ?>" is currently on vacation. "<?= $product['product_name'] ?>" are not available for a moment.</p>
                </div>
            <?php
            } elseif ($product['category_isBan'] == 1) {
            ?>
                <div class="container">
                    <p class='fs-2 fw-bold text-accent text-center'>"<?= $category['category_name'] ?>" is permanently banned</p>
                    <div class="modal" id="onload" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content bg-main">
                                <div class="modal-header text-center">
                                    <span class='fs-3 fw-bold text-accent modal-title w-100'><?= $category['category_name'] ?> has been permanently banned.</span>
                                </div>
                                <div class="modal-footer">
                                    <a href="storelist.php" type="button" class="btn btn-accent col-md-12">Proceed</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            } else {
            ?>
                <div class="bg-main py-4">
                    <div class="container productData mt-3">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="shadow imgBox">
                                    <img src="../assets/uploads/products/<?= $product['product_image'] ?>" data-origin="../assets/uploads/products/<?= $product['product_image'] ?>" alt="Product Image" height="416" class="w-100">
                                    <?php
                                    if ($product['product_qty'] == 0) {
                                    ?>
                                        <div class="soldout">
                                            Sold&nbsp;Out
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <h4 class="fw-bold">
                                    <?php
                                    $getTotalRating = getProductRatingsByProductID($product['product_id']); //+ Catch product ratings
                                    // Calculate average rating for the product
                                    $average_rating = calculateAverageRating($getTotalRating);

                                    $soldCount = getSoldCountByProductID($product['product_id']); //+ Catch product sold
                                    $sold = mysqli_fetch_array($soldCount);

                                    $ratingCount = getRatingCountByProductID($product['product_id']); //+ Catch product sold
                                    $ratingCt = mysqli_fetch_array($ratingCount);
                                    $rtCt = $ratingCt['ratingCount'];

                                    $product_name = $product['product_name'];
                                    $words = explode(' ', $product_name);
                                    $display_name = implode(' ', array_slice($words, 0, 5)); // Display only the first 5 words

                                    $srp = $product['product_srp'];
                                    $orig_price = $product['product_original_price'];
                                    $discount = $product['product_discount'];

                                    echo $display_name;

                                    if (count($words) > 5) {
                                        echo '<br>'; // Add line break if there are more than 5 words
                                        echo implode(' ', array_slice($words, 5)); // Display the remaining words on the next line
                                    } ?>
                                    <span class="float-end text-accent">
                                        <?php if ($product['product_popular']) {
                                            echo "Trending";
                                        } ?>
                                    </span>
                                </h4>

                                <div class="row">
                                    <div class="d-flex align-items-center mb-2">
                                        <span class="mr-2"><?php
                                                            // Display stars based on average rating
                                                            if ($average_rating > 0) {
                                                                $wholeStars = floor($average_rating); // Whole star count
                                                                $halfStar = $average_rating - $wholeStars; // Fractional part for half star

                                                                for ($i = 1; $i <= 5; $i++) {
                                                                    if ($i <= $wholeStars) {
                                                                        echo '<i class="fa-solid fa-star"></i>'; // Full star
                                                                    } elseif ($halfStar >= 0.5) {
                                                                        echo '<i class="fa-solid fa-star-half-stroke"></i>'; // Half star
                                                                        $halfStar = 0; // Reset for next iteration
                                                                    } else {
                                                                        echo '<i class="fa-regular fa-star"></i>'; // Empty star
                                                                    }
                                                                }
                                                            } else {
                                                                echo 'No rating';
                                                            }
                                                            ?>
                                        </span>|<span class="mx-2"><?php echo $rtCt . " " . ($rtCt <= 1 ? "rating" : "ratings"); ?></span>|<span class="ml-2"><span class="fw-bold text-accent"><?= $sold['itemSold'] ?></span> sold</span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <?php
                                        if ($srp == $orig_price) {
                                        ?>
                                            <h4 class="fw-bold text-accent mr-3">₱<?= number_format($srp, 2) ?></h4>
                                        <?php
                                        } else {
                                        ?>
                                            <h6 class="text-secondary text-decoration-line-through mr-2">₱<?= number_format($orig_price, 2) ?></h6>
                                            <h4 class="fw-bold text-accent mr-3">₱<?= number_format($srp, 2) ?></h4>
                                            <h6 class="fs-6 text-light"><span class="bg-accent px-1"><?= $discount; ?>% OFF</span></h6>
                                        <?php
                                        }
                                        ?>
                                        <input type="hidden" class="product_link" value="<?= $product['product_slug'] ?>">
                                        <input type="hidden" class="categID" value="<?= $category['category_id'] ?>">
                                    </div>
                                    <!-- Product QTY slider -->
                                    <div class="product-quantity-container">
                                        <div class="input-group mb-2" style="width:120px;">
                                            <button class="input-group-text decrementProductBtn">-</button>
                                            <input type="text" class="form-control bg-white inputQty text-center" value="1" readonly data-price="<?= $product['product_srp'] ?>" data-remain="<?= $product['product_qty'] ?>">
                                            <button class="input-group-text incrementProductBtn">+</button>
                                        </div>
                                        <div>
                                            <h5 class="fw-bold"><span class="prodRmn"><?= $product['product_qty'] ?></span>&nbsp;pieces available</h5>
                                        </div>
                                    </div>


                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <button class="btn btn-primary px-4 addToCartBtn" value="<?= $product['product_id'] ?>" <?= ($product['product_qty'] == 0) ? 'disabled' : '' ?>>
                                            <?= ($product['product_qty'] == 0) ? 'Sold Out' : '<i class="fa fa-shopping-cart me-2"></i>Add to cart' ?>
                                        </button>
                                    </div>
                                    <div class="col-md-6">
                                        <button class="btn btn-danger px-4 addToLikesBtn" value="<?= $product['product_id'] ?>"><i class="fa fa-heart me-2"></i>Add to Likes</button>
                                    </div>
                                </div>
                                <hr>
                                <h6>Product Description</h6>
                                <h4 class="fw-normal"><?= $product['product_description'] ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- //+Product Ratings -->
                <div class="mt-3">
                    <div class="container card bg-main">
                        <div class="row">
                            <div class="col-md-12 p-3">
                                <div class="card-title">
                                    <h4 class="text=start">Product Ratings</h4>
                                </div>
                                <div class="card-body">
                                    <?php
                                    $product_ratings = getProductRatingsByProductID($product['product_id']);

                                    if (mysqli_num_rows($product_ratings) > 0) {
                                        while ($rating = mysqli_fetch_array($product_ratings)) {
                                    ?>
                                            <div class="card p-2 bg-main mb-3">
                                                <div class="d-flex flex-row">
                                                    <img src="../assets/uploads/userProfile/<?= ($rating['user_profile_image']) ? $rating['user_profile_image'] : 'defaultProfile.jpg' ?>" alt="profile_image" height="40" width="40" class="rounded-circle object-fit-cover">
                                                    <div class="d-flex flex-column pl-2">
                                                        <div><?= ($rating['user_username']) ? $rating['user_username'] : 'deleted user'?></div>
                                                        <div class="rating">
                                                            <?php
                                                            // Display stars based on product_rating
                                                            $ratingValue = $rating['product_rating'];
                                                            for ($i = 1; $i <= 5; $i++) {
                                                                if ($i <= $ratingValue) {
                                                                    echo '<i class="fa-solid fa-star"></i>';
                                                                } else {
                                                                    echo '<i class="fa-regular fa-star"></i>';
                                                                }
                                                            }
                                                            ?>
                                                        </div>
                                                        <div class="mb-3"><?= date('m-d-Y h:i A', strtotime($rating['review_createdAt'])) ?></div>
                                                        <div><?= $rating['product_review'] ?></div>
                                                        <?php
                                                        if ($rating['review_editCount'] >= 1) {
                                                        ?>
                                                            <div class="text-secondary">edited</div>
                                                        <?php
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                    <?php
                                        }
                                    } else {
                                        echo "No ratings yet";
                                    }
                                    ?>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>



            <?php
            include('../partials/sameshop.php');
            include('../partials/trending.php');
            ?>
            <div class="mt-5">
                <?php include('footer.php'); ?>
            </div>
    <?php
        }
    } else {
        echo "<h1><center>Something went wrong</center></h1>";
    }

    include('../partials/__footer.php');
    ?>
</div>

<script>
    window.onload = () => {
        $('#onload').modal('show');
    }
</script>