<?php include('partials/header.php');
include('../models/myFunctions.php'); ?>
<style>
    .btn-check:checked+.btn {
        color: #fff !important;
    }

    .btn-check+.btn {
        color: #E91E63 !important;
    }

    .btn-check:hover+.btn {
        color: #E91E63 !important;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php
            if (isset($_GET['id'])) {
                $ids = $_GET['id'];
                $product = getByIdProduct("products", $ids);

                if (mysqli_num_rows($product) > 0) {
                    $data = mysqli_fetch_array($product);
                    $discount = $data['product_discount'];
            ?>
                    <div class="card">
                        <div class="card-header">
                            <span class="fs-2 fw-bold">View <?= $data['product_name'] ?> Details</span>
                            <a href="product.php" class="btn btn-primary end-3 float-end">Back</a>
                        </div>
                        <div class="card-body">
                            <form action="models/product-auth.php" method="POST" enctype="multipart/form-data">
                                <div class="container-fluid">
                                    <div class="row col-md-12">
                                        <!-- Add Category start -->
                                        <div class="form-floating col-md-12 mb-3">


                                            <?php
                                            $categories = getAllbyCategory("categories", $data['category_id']);
                                            if (mysqli_num_rows($categories) > 0) {
                                                foreach ($categories as $item) {
                                            ?>
                                                    <input disabled type="text" class="form-control ps-3" value="<?= $item['category_name'] ?>" id="name_input" name="productnameInput" required placeholder="Name">
                                                    <label for="floatingInput" class="ps-3">Brand Name</label>
                                            <?php
                                                }
                                            } else {
                                                echo "No Category Available";
                                            }
                                            ?>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <span class="fs-3 fw-bold">Product Image</span>
                                            <br>
                                            <img src="../assets/uploads/products/<?= $data['product_image'] ?>" height="150px" alt="brand">
                                        </div>
                                        <div class="form-floating col-md-6 mb-3">
                                            <input disabled type="text" class="form-control ps-3" value="<?= $data['product_name'] ?>" id="name_input" name="productnameInput" required placeholder="Name">
                                            <label for="floatingInput" class="ps-3">Product Name</label>
                                        </div>
                                        <div class="form-floating col-md-6 mb-3">
                                            <input disabled type="text" class="form-control ps-3" value="<?= $data['product_slug'] ?>" id="slug_input" name="productslugInput" required placeholder="Slug">
                                            <label for="floatingPassword" class="ps-3">Product Slug</label>
                                        </div>
                                        <div class="form-floating col-md-12 mb-3">
                                            <textarea disabled class="form-control ps-3" placeholder="d" id="description_input" name="productdescriptionInput" style="height:100px; min-height: 57px; max-height: 100px;" rows="3"><?= $data['product_description'] ?></textarea>
                                            <label for="floatingPassword" class="ps-3">Product Description</label>
                                        </div>
                                        <div class="form-floating col-md-6 mb-3">
                                            <input disabled type="number" class="form-control ps-3" value="<?= $data['product_original_price'] ?>" id="orp_input" name="originalPriceInput" required placeholder="orp" onwheel="return false;" oninput="calculateFinalPrice()" min="0">
                                            <label for="orp_input" class="ps-3">Original Price in ₱</label>
                                        </div>
                                        <div class="form-floating col-md-6 mb-3">
                                            <select disabled class="form-select ps-2" id="discountPercentage" name="priceDiscount" onchange="calculateFinalPrice()">
                                                <option value="0" <?php echo ($discount == 0) ? 'selected' : ''; ?> selected>no discount</option>
                                                <option value="10" <?php echo ($discount == 10) ? 'selected' : ''; ?>>10% off</option>
                                                <option value="20" <?php echo ($discount == 20) ? 'selected' : ''; ?>>20% off</option>
                                                <option value="30" <?php echo ($discount == 30) ? 'selected' : ''; ?>>30% off</option>
                                                <option value="40" <?php echo ($discount == 40) ? 'selected' : ''; ?>>40% off</option>
                                                <option value="50" <?php echo ($discount == 50) ? 'selected' : ''; ?>>50% off</option>
                                                <option value="60" <?php echo ($discount == 60) ? 'selected' : ''; ?>>60% off</option>
                                                <option value="70" <?php echo ($discount == 70) ? 'selected' : ''; ?>>70% off</option>
                                                <option value="75" <?php echo ($discount == 75) ? 'selected' : ''; ?>>75% off</option>
                                                <option value="80" <?php echo ($discount == 80) ? 'selected' : ''; ?>>80% off</option>
                                                <option value="85" <?php echo ($discount == 85) ? 'selected' : ''; ?>>85% off</option>
                                                <option value="90" <?php echo ($discount == 90) ? 'selected' : ''; ?>>90% off</option>
                                            </select>
                                            <label for="discountPercentage" class="ps-3">Discount Percentage</label>
                                        </div>
                                        <div class="form-floating col-md-12 mb-3">
                                            <input disabled type="number" class="form-control ps-3" value="<?= $data['product_srp'] ?>" id="srp_input" name="suggestedRetailPriceInput" readonly required placeholder="srp">
                                            <label for="srp_input" class="ps-3">Final Price in ₱</label>
                                        </div>
                                        <div class="col-md-12" style="display:flex;">
                                            <div class="form-floating col-md-6 mb-3">
                                                <input disabled type="number" class="form-control ps-3" value="<?= $data['product_qty'] ?>" id="qty_input" name="quantityInput" required placeholder="qty" onwheel="return false;" min="0">
                                                <label for="floatingPassword" class="ps-1">Item Quantity</label>
                                            </div>
                                            <div class="btn-group col-md-6" role="group" aria-label="Basic checkbox toggle button group">
                                                <input disabled type="checkbox" class="btn-check" <?= $data['product_visibility'] ? "checked" : "" ?> id="status_checkbox" name="productstatusCheckbox" autocomplete="off">
                                                <label id="status_label" class="btn btn-outline-primary" for="status_checkbox"><?= $data['product_visibility'] ? "Hidden" : "Visible" ?></label>

                                                <input disabled type="checkbox" class="btn-check" <?= $data['product_popular'] ? "checked" : "" ?> id="popular_checkbox" name="productpopularCheckbox" autocomplete="off">
                                                <label class="btn btn-outline-primary" for="popular_checkbox">Popular</label>
                                            </div>
                                        </div>
                                        <div class="form-floating col-md-12 mb-3">
                                            <input disabled type="text" class="form-control ps-3" value="<?= $data['product_meta_title'] ?>" id="metaTitle_input" name="productmetaTitleInput" required placeholder="Slug">
                                            <label for="floatingPassword" class="ps-3">Product Meta Title</label>
                                        </div>
                                        <div class="form-floating col-md-12 mb-3">
                                            <textarea disabled class="form-control ps-3" placeholder="d" id="metaDescription_input" name="productmetaDescriptionInput" required style="height:100px; min-height: 57px; max-height: 100px;" rows="3"><?= $data['product_meta_description'] ?></textarea>
                                            <label for="floatingPassword" class="ps-3">Product Meta Description</label>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php
                } else {
                    echo "Product not found for given id";
                }
                ?>

            <?php  } else {
                echo "id missing from url";
            } ?>

        </div>
    </div>
</div>
<script>
    //Visible & hidden
    document.addEventListener("DOMContentLoaded", function() {
        var checkbox = document.getElementById("status_checkbox");
        var label = document.getElementById("status_label");

        checkbox.addEventListener("change", function() {
            // Send an AJAX request to update the status in the database
            // For simplicity, we'll just toggle the label text on the client side
            label.textContent = checkbox.checked ? "Hidden" : "Visible";
        });
    });
</script>


<?php include('partials/footer.php'); ?>