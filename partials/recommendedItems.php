<style>
    .swiper-slide {
        width: 300px !important;
    }

    .swiper-slide .product-image {
        display: block;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .brandImage {
        display: flex;
        justify-content: end;
    }
    
    @media (max-width: 1200px) {
        .swiper-slide {
            width: 257px !important;
        }
    }

    @media (max-width: 992px) {
        .swiper-slide {
            width: 290px !important;
        }
    }

    @media (max-width: 768px) {
        .swiper-slide {
            width: 225px !important;
        }
        .brandImage {
            justify-content: start;
        }
    }

    @media (max-width: 576px) {
        .swiper-slide {
            width: 252px !important;
        }
    }

    @media (max-width: 480px) {
        .swiper-slide {
            width: 223px !important;
        }
    }

    @media (max-width: 320px) {
        .swiper-slide {
            width: 295px !important;
        }
    }

    
</style>
<div class="container mt-3">
    <div class="row">
        <div class="col-md-12">
            <p class="my-4 text-center <?= basename($_SERVER['PHP_SELF']) === 'productView.php' ? 'fs-4 text-dark-4' : 'fs-6'; ?>">Recommended Items</p>
            <div class="swiper swiperRecommendedItems">
                <div class="swiper-wrapper">
                    <?php
                    $popularProducts = getAllPopular();
                    $slide = mysqli_num_rows($popularProducts);
                    if (mysqli_num_rows($popularProducts) > 0) {
                        foreach ($popularProducts as $item) {
                            $product_name = $item['product_name'];
                            if (strlen($product_name) > 20) {
                                $product_name = substr($product_name, 0, 17) . '...';
                            }

                    ?>
                            <div class="swiper-slide">
                                <a class="card-link" href="productView.php?product=<?= $item['product_slug'] ?>">
                                    <img class="product-image" src="../assets/uploads/products/<?= $item['product_image'] ?>" alt="Product Image">
                                    <div class="col-md-12 p-2 bg-tertiary">
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
                    }
                    ?>
                </div>

            </div>

        </div>
    </div>
</div>

<!-- Swiper JS -->


<script>
    var swiper = new Swiper(".swiperRecommendedItems", {
        autoHeight: true,
        spaceBetween: 10,
        slidesPerView: "auto",
        grid: {
            rows: 1,
        },
        breakpoints: {
            992: {
                slidesPerView: "auto",
                spaceBetween: 30
            },
            769: {
                slidesPerView: "auto",
                spaceBetween: 20
            }
        }
    });
</script>