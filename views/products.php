<?php /* <!-- also calledCategories.php --> */
include('../partials/__header.php');

include(__DIR__ . '/../models/checkSession.php');
checkUserValidityAndRedirect($_SESSION['auth_user']['user_ID'] ?? null);

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
                <h6 class="text-dark">
                    <a href="brands.php" class="text-dark">Home /</a>
                    <a href="brands.php" class="text-dark">Collections /</a>
                    <?= $category['category_name'] ?>
                </h6>
            </div>
        </div>

        <div class="py-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1><?= $category['category_name'] ?></h1>
                        <h5><?= $category['category_description'] ?></h5>
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
                                                    <a href="brands.php" type="button" class="btn btn-accent col-md-12">Proceed</a>
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