<?php include('partials/header.php');
include('../middleware/sellerMW.php');
include('../models/checkSession.php');
include('models/check-seller-addr.php');
checkUserValidityAndRedirect($_SESSION['auth_user']['user_ID'] ?? null);
?>

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<style>
    .fa-star {
        color: #e91e63;
    }

    .fa-star-half-stroke {
        color: #e91e63;
    }
</style>

<div class="container">
    <div class="row"></div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-primary">
                <h2 class="text-white">All Products
                    <a href="addProduct.php" class="btn btn-light float-end ms-2"><i class="material-icons opacity-10">post_add</i> Add Product</a>
                </h2>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped" id="prodTable">
                        <thead class="table-active">
                            <tr>
                                <th>Product ID</th>
                                <th>Image</th>
                                <th>Product Name</th>
                                <th>Price ₱</th>
                                <th>Quantity</th>
                                <th>Rating</th>
                                <th>Rating Count</th>
                                <th>Visibility</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $product = getByCategAndProduct($_SESSION['auth_user']['user_ID']);

                            if (mysqli_num_rows($product) > 0) {

                                foreach ($product as $item) {

                                    $getTotalRating = getProductRatingsByProductIDOnAdmin($item['product_id']); //+ Catch product ratings
                                    //+ Calculate average rating for the product
                                    $average_rating = calculateAverageRatingOnAdmin($getTotalRating);

                                    $ratingCount = getRatingCountByProductIDOnAdmin($item['product_id']); //+ Catch product sold
                                    $ratingCt = mysqli_fetch_array($ratingCount);
                                    $rtCt = $ratingCt['ratingCount'];
                            ?>
                                    <tr>
                                        <td><?= $item['product_id']; ?></td>
                                        <td><img src="../assets/uploads/products/<?= $item['product_image']; ?>" height="100px" alt="<?= $item['product_name']; ?>"></td>
                                        <td style="word-wrap: break-word;">
                                            <?php
                                            $productName = $item['product_name'];
                                            $maxWords = 5;
                                            $words = explode(' ', $productName);

                                            if (count($words) > $maxWords) {
                                                echo implode(' ', array_slice($words, 0, $maxWords)) . '<br>';
                                                echo implode(' ', array_slice($words, $maxWords));
                                            } else {
                                                echo $productName;
                                            }
                                            ?>
                                            <input type="hidden" name="productSlug" value="<?= $item['product_slug'] ?>">
                                        </td>
                                        <td class="text-end">₱<?= $item['product_srp'] ?></td>
                                        <td><?= $item['product_qty']; ?></td>
                                        <?php
                                        $categories = getAll("categories");
                                        if (mysqli_num_rows($categories) > 0) {
                                            $brandName = getBrandName($item['category_id']); // Assuming you have a function to retrieve the brand name based on the category ID
                                        ?>
                                        <?php
                                        }
                                        ?>
                                        <td><?php //+ Display stars based on average rating
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
                                            } ?>
                                        </td>
                                        <td><?php echo $rtCt . " " . ($rtCt <= 1 ? "rating" : "ratings"); ?></td>
                                        <td><?= $item['product_visibility'] == '0' ? "Visible" : "Hidden"; ?></td>
                                        <td>
                                            <div style="display: flex;">
                                                <a href="editProduct.php?id=<?= $item['product_id']; ?>" class="btn btn-primary mx-2">Edit</a>
                                                <form action="models/product-auth.php" method="POST">
                                                    <input type="hidden" name="productID" value="<?= $item['product_id'] ?>">
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $item['product_id'] ?>">Delete</button>
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="deleteModal<?= $item['product_id'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">Delete Product <span><?= $item['product_id']; ?></span></h5>
                                                                </div>
                                                                <div class="modal-body">
                                                                    Are you sure you want to delete <b><?= $productName ?></b>?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                                                                    <input type="submit" class="btn btn-primary" name="deleteProductBtn" value="Confirm Delete">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                            <?php
                                }
                            } else {
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!--jquery cdn start-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<!--jquery cdn end-->

<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        $('#prodTable').DataTable({
            "bProcessing": true,
            stateSave: true,
            pageLength: 0,
            lengthMenu: [
                [4, -1],
                [4, "All"]
            ],
            responsive: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search records"
            },
            order: [
                [0, 'desc'] // Assuming the first column (index 0) contains timestamps or dates
            ]
        });
    });
</script>

<?php include('partials/footer.php'); ?>