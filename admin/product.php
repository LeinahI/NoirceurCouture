<?php include('partials/header.php');
include('../middleware/adminMW.php'); ?>

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">

<div class="container">
    <div class="row"></div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-primary">
                <h2 class="text-white">All Products
                    <!-- <a href="addProduct.php" class="btn btn-light float-end ms-2"><i class="material-icons opacity-10">post_add</i> Add Product</a> -->
                </h2>
            </div>
            <div class="card-body">
                <div class="table-responsive" style="overflow-x: scroll; scrollbar-width: none;">
                    <table class="table table-bordered table-hover table-striped" id="prodTable" >
                        <thead class="table-active">
                            <tr>
                                <th>Store ID</th>
                                <th>Store Name</th>
                                <th>Product ID</th>
                                <th>Product Name</th>
                                <th>Price ₱</th>
                                <th>Image</th>
                                <th>Quantity</th>
                                <th>Visibility</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $product = getAll("products");

                            if (mysqli_num_rows($product) > 0) {

                                foreach ($product as $item) {
                            ?>
                                    <tr>
                                        <?php
                                        $categories = getAll("categories");
                                        if (mysqli_num_rows($categories) > 0) {
                                            $brandName = getBrandName($item['category_id']); // Assuming you have a function to retrieve the brand name based on the category ID
                                        }
                                        ?>
                                        <td><?= $item['category_id']; ?></td>
                                        <td><?= $brandName; ?></td>
                                        <td><?= $item['product_id']; ?></td>
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
                                        </td>
                                        <td class="text-end">₱<?= $item['product_srp']?></td>
                                        <td><img src="../assets/uploads/products/<?= $item['product_image']; ?>" height="100px" alt="<?= $item['product_name']; ?>"></td>
                                        <td><?= $item['product_qty']; ?></td>

                                        <td><?= $item['product_status'] == '0' ? "Visible" : "Hidden"; ?></td>
                                        <td>
                                            <div style="display: flex;">
                                                <a href="editProduct.php?id=<?= $item['product_id']; ?>" class="btn btn-primary mx-2">View</a>
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