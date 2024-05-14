<style>
    /* Owl Carousel */
    /* .owl-two {
        position: relative;
    }

    .owl-two .owl-theme .custom-nav {
        position: absolute;
        top: 20%;
        left: 0;
        right: 0;
    }

    .owl-two .owl-theme .custom-nav .owl-prev,
    .owl-two .owl-theme .custom-nav .owl-next {
        position: absolute;
        height: 100px;
        color: inherit;
        background: none;
        border: none;
        z-index: 100;
    }

    .owl-two .owl-theme .custom-nav .owl-prev i,
    .owl-two .owl-theme .custom-nav .owl-next i {
        font-size: 2.5rem;
        color: #cecece;
    }

    .owl-two .owl-theme .custom-nav .owl-prev {
        left: 0;
    }

    .owl-two .owl-theme .custom-nav .owl-next {
        right: 0;
    } */

   /*  .rating .fa-star {
        color: #bb6c54;
    }

    .rating .fa-star-half-stroke {
        color: #bb6c54;
    } */
</style>
<div class="mt-3">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h4 class="text=start">From The Same Shop</h4>
                <hr>
                <div class="row">
                    <div class="owl-two">
                        <div class="owl-carousel">
                            <?php
                            $ftss = getAllSameShop($product['category_id']);

                            if (mysqli_num_rows($ftss) > 0) {
                                foreach ($ftss as $item) {
                                    $product_name = $item['product_name'];
                                    if (strlen($product_name) > 30) {
                                        $product_name = substr($product_name, 0, 27) . '...';
                                    }
                                   /*  $product_ratings = getProductRatingsByProductID($item['product_id']); //+ Catch product ratings

                                    // Calculate average rating for the product
                                    $average_rating = calculateAverageRating($product_ratings);

                                    $soldCount = getSoldCountByProductID($item['product_id']); //+ Catch product sold
                                    $sold = mysqli_fetch_array($soldCount); */
                            ?>
                                    <div class="item">
                                        <a href="productView.php?product=<?= $item['product_slug'] ?>" class="card-link">
                                            <div class="card border-0">
                                                <div class="card-body d-flex flex-column justify-content-between bg-tertiary rounded">
                                                    <div>
                                                        <img src="../assets/uploads/products/<?= $item['product_image'] ?>" alt="Product Image" height="217.2px" class="w-100">
                                                        <h6 class="text-dark"><?= $product_name; ?></h6>
                                                        <h6 class="text-start fw-bold text-accent">₱<?= number_format($item['product_srp'], 2) ?></h6>
                                                       <!--  <div class="rating"> -->
                                                            <?php
                                                            // Display stars based on average rating
                                                            /* $wholeStars = floor($average_rating); // Whole star count
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
                                                            } */
                                                            ?>
                                                           <!--  <span><?php /* $sold['itemSold'] */ ?> sold</span>
                                                        </div> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                            <?php
                                }
                            }
                            ?>
                        </div>
                        <!-- <div class="owl-theme">
                            <div class="owl-controls">
                                <div class="custom-nav owl-nav"></div>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>