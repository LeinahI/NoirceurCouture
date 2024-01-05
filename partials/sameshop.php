<style>
    /* Owl Carousel */
    .owl-two {
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
    }
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
                                    if (strlen($product_name) > 15) {
                                        $product_name = substr($product_name, 0, 20) . '...';
                                    }
                            ?>
                                    <div class="item">
                                        <a href="productView.php?product=<?= $item['product_slug'] ?>" class="card-link">
                                            <div class="card">
                                                <div class="card-body d-flex flex-column justify-content-between">
                                                    <div>
                                                        <img src="../assets/uploads/products/<?= $item['product_image'] ?>" alt="Product Image" height="217.2px" class="w-100">
                                                        <h6><?= $product_name; ?></h6>
                                                        <h6 class="text-start fw-bold">₱<?= number_format($item['product_srp'], 2) ?></h6>
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
                        <div class="owl-theme">
                            <div class="owl-controls">
                                <div class="custom-nav owl-nav"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>