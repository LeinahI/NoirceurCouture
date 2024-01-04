<?php
include('../partials/__header.php');

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
                <h6 class="text-white">
                    <a href="brands.php" class="text-white">Home /</a>
                    <a href="brands.php" class="text-white">Collections /</a>
                    <?php
                    if ($category) {
                    ?>
                        <a href="products.php?category=<?= $category['category_slug'] ?>" class="text-white"><?= $category['category_name'] ?> /</a>
                    <?php } ?>
                    <?= $product['product_name'] ?>
                </h6>
            </div>
        </div>

        <div class="bg-light py-4">
            <div class="container productData mt-3">
                <div class="row">
                    <div class="col-md-4">
                        <div class="shadow">
                            <img src="../assets/uploads/products/<?= $product['product_image'] ?>" alt="Product Image" class="w-100">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <h4 class="fw-bold">
                            <?php
                            $product_name = $product['product_name'];
                            $words = explode(' ', $product_name);
                            $display_name = implode(' ', array_slice($words, 0, 5)); // Display only the first 5 words

                            echo $display_name;

                            if (count($words) > 5) {
                                echo '<br>'; // Add line break if there are more than 5 words
                                echo implode(' ', array_slice($words, 5)); // Display the remaining words on the next line
                            } ?>
                            <span class="float-end text-danger">
                                <?php if ($product['product_popular']) {
                                    echo "Trending";
                                } ?>
                            </span>
                        </h4>

                        <hr>
                        <div class="row">
                            <div>
                                <h5 class="fw-bold">₱<?= number_format($product['product_srp'], 2) ?></h5>
                                <input type="hidden" class="product_link" value="<?= $product['product_slug'] ?>">
                            </div>
                            <div>
                                <div class="input-group mb-2" style="width:120px;">
                                    <button class="input-group-text decrementProductBtn">-</button>
                                    <input type="text" class="form-control bg-white inputQty text-center" value="1" readonly>
                                    <button class="input-group-text incrementProductBtn">+</button>
                                </div>
                                <div>
                                    <h5 class="fw-bold"><?= $product['product_qty'] ?>&nbsp;pieces available</h5>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6">
                                <button class="btn btn-primary px-4 addToCartBtn" value="<?= $product['product_id'] ?>"><i class=" fa fa-shopping-cart me-2"></i>Add to cart</button>
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

        <div class="mt-3 mb-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="text-center">Trending Products</h4>
                        <hr>
                        <div class="row">
                            <div class="main-content">
                                <div class="owl-carousel">
                                    <?php
                                    $popularProducts = getAllPopular();

                                    if (mysqli_num_rows($popularProducts) > 0) {
                                        foreach ($popularProducts as $item) {
                                            $product_name = $item['product_name'];
                                            if (strlen($product_name) > 15) {
                                                $product_name = substr($product_name, 0, 20) . '...';
                                            }
                                    ?>
                                            <div class="item">
                                                <a href="productView.php?product=<?= $item['product_slug'] ?>" class="card-link">
                                                    <div class="card " style="height: 100%;">
                                                        <div class="card-body d-flex flex-column justify-content-between" style="height: 100%;">
                                                            <div>
                                                                <img src="../assets/uploads/products/<?= $item['product_image'] ?>" alt="Product Image" class="w-100">
                                                                <h6><?= $product_name; ?></h6>
                                                                <h6 class="text-center fw-bold">₱<?= number_format($item['product_srp'], 2) ?></h6>
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

        <div class="mt-5">
            <?php include('footer.php'); ?>
        </div>
<?php
    } else {
        echo "<h1><center>Product not found</center></h1>";
    }
} else {
    echo "<h1><center>Something went wrong</center></h1>";
}

include('../partials/__footer.php');
?>
<script>
    $('.main-content .owl-carousel').owlCarousel({
        loop: true,
        margin: 10,
        nav: true,
        navText: [
            '<i class="fa fa-angle-left" aria-hidden="true"></i>',
            '<i class="fa fa-angle-right" aria-hidden="true"></i>'
        ],
        navContainer: '.main-content .custom-nav',
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 3
            },
            1000: {
                items: 5
            }
        }
    });
</script>