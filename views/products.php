<?php /* <!-- also calledCategories.php --> */
include('../partials/__header.php');

if (isset($_GET['category'])) {
    $category_slug = $_GET['category'];
    $category_data = getSlugActiveCategories("categories", $category_slug);
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
        </style>

        <div class="py-3 bg-primary">
            <div class="container">
                <h6 class="text-white">
                    <a href="brands.php" class="text-white">Home /</a>
                    <a href="brands.php" class="text-white">Collections /</a>
                    <?= $category['category_name'] ?>
                </h6>
            </div>
        </div>

        <div class="py-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1><?= $category['category_name'] ?></h1>
                        <hr>
                        <div class="row">
                            <?php
                            $products = getProdByCategory($cid);
                            // Check if the query was executed successfully
                            if ($products !== false) {
                                // Check if there are any rows returned
                                if (mysqli_num_rows($products) > 0) {
                                    // Fetch the products using mysqli_fetch_array
                                    while ($item = mysqli_fetch_array($products)) {
                                        if (strlen($item['product_name']) > 15) {
                                            $item['product_name'] = substr($item['product_name'], 0, 20) . '...';
                                        }
                            ?>
                                        <div class="col-md-3 mb-3">
                                            <a href="productView.php?product=<?= $item['product_slug'] ?>" class="card-link">
                                                <div class="card shadow">
                                                    <div class="card-body d-flex flex-column justify-content-between">
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
                                    // Free the result set
                                    mysqli_free_result($products);
                                } else {
                                    echo "<h1>No data available</h1>";
                                }
                            } else {
                                echo "<h1>Error executing query</h1>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <?php include('footer.php'); ?>
        </div>

<?php
    } else {
        echo "<h1><center>Something went wrong</center></h1>";
    }
}
include('../partials/__footer.php');
?>