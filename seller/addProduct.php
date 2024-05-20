<?php include('partials/header.php');
include('../middleware/sellerMW.php');
include('../models/checkSession.php');
include('models/check-seller-addr.php');
include('models/check-seller-categ.php');
checkUserValidityAndRedirect($_SESSION['auth_user']['user_ID'] ?? null);
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary">
                    <h2 class="text-white">Add Product
                        <a href="product.php" class="btn btn-light float-end ms-2">Go Back</a>
                    </h2>
                </div>
                <div class="card-body">
                    <form action="models/product-auth.php" method="POST" enctype="multipart/form-data">
                        <div class="container-fluid">
                            <div class=" col-md-12">
                                <!-- Add Category start -->

                                <?php
                                $categories = getByCategAndUserId($_SESSION['auth_user']['user_ID']);
                                $row = mysqli_fetch_assoc($categories)
                                ?>
                                <input type="hidden" name="selectBrandCategoryID" value="<?= $row['category_id'] ?>" placeholder="<?= $row['category_name'] ?>">

                                <div class="row">
                                    <div class="form-floating col-md-6 mb-3">
                                        <input type="text" class="form-control ps-3" id="name_input" name="productnameInput" required placeholder="Name">
                                        <label for="floatingInput" class="ps-3">Product Name</label>
                                    </div>
                                    <div class="form-floating col-md-6 mb-3">
                                        <input type="text" class="form-control ps-3" id="slug_input" name="productslugInput" required placeholder="Slug">
                                        <label for="floatingPassword" class="ps-3">Product Slug</label>
                                    </div>
                                </div>
                                <div class="form-floating col-md-12 mb-3">
                                    <textarea class="form-control ps-3" placeholder="d" id="description_input" name="productdescriptionInput" style="height:100px; min-height: 57px; max-height: 100px;" rows="3"></textarea>
                                    <label for="floatingPassword" class="ps-3">Product Description</label>
                                </div>
                                <div class="row">
                                    <div class="form-floating col-md-6 mb-3">
                                        <input type="number" class="form-control ps-3" id="orp_input" name="originalPriceInput" required placeholder="orp" oninput="calculateFinalPrice()" min="0" onwheel="return false;">
                                        <label for="orp_input" class="ps-3">Original Price in ₱</label>
                                    </div>
                                    <div class="form-floating col-md-6 mb-3">
                                        <select class="form-select ps-2" id="discountPercentage" name="priceDiscount" onchange="calculateFinalPrice()">
                                            <option value="0" selected>no discount</option>
                                            <option value="10">10% off</option>
                                            <option value="20">20% off</option>
                                            <option value="30">30% off</option>
                                            <option value="40">40% off</option>
                                            <option value="50">50% off</option>
                                            <option value="60">60% off</option>
                                            <option value="70">70% off</option>
                                            <option value="75">75% off</option>
                                            <option value="80">80% off</option>
                                            <option value="85">85% off</option>
                                            <option value="90">90% off</option>
                                        </select>
                                        <label for="discountPercentage" class="ps-3">Discount Percentage</label>
                                    </div>
                                </div>
                                <div class="form-floating col-md-12 mb-3">
                                    <input type="number" class="form-control ps-3" id="srp_input" name="suggestedRetailPriceInput" readonly required placeholder="srp">
                                    <label for="srp_input" class="ps-3">Final Price in ₱</label>
                                </div>
                                <div class="form-floating col-md-12 mb-3">
                                    <input type="file" class="form-control ps-3" id="uploadProductImage_input" accept=".jpg, .jpeg, .png, .webp, .avif, .gif" name="uploadProductImageInput" required>
                                    <label for="floatingPassword" class="ps-3">Upload Display Image</label>
                                </div>

                                <div class="col-md-12" style="display:flex;">
                                    <div class="form-floating col-md-6 mb-3">
                                        <input type="number" class="form-control ps-3" id="qty_input" name="quantityInput" required placeholder="qty" onwheel="return false;">
                                        <label for="floatingPassword" class="ps-1">Item Quantity</label>
                                    </div>
                                    <div class="btn-group col-md-6" role="group" aria-label="Basic checkbox toggle button group">
                                        <input type="checkbox" class="btn-check" id="popular_checkbox" name="productpopularCheckbox" autocomplete="off">
                                        <label class="btn btn-outline-primary" for="popular_checkbox">Popular</label>
                                    </div>
                                </div>
                                <div class="form-floating col-md-12 mb-3">
                                    <input type="text" class="form-control ps-3" id="metaTitle_input" name="productmetaTitleInput" required placeholder="Slug">
                                    <label for="floatingPassword" class="ps-3">Product Meta Title</label>
                                </div>
                                <div class="form-floating col-md-12 mb-3">
                                    <textarea class="form-control ps-3" placeholder="d" id="metaDescription_input" name="productmetaDescriptionInput" required style="height:100px; min-height: 57px; max-height: 100px;" rows="3"></textarea>
                                    <label for="floatingPassword" class="ps-3">Product Meta Description</label>
                                </div>
                                <div class="text-center col-md-12 mb-3">
                                    <button type="submit" id="addProduct_btn" name="addProductBtn" class="col-md-12 btn btn-primary">Add Product</button>
                                </div>
                                <!-- Add Category end -->
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    /* Automatic Input */
    document.addEventListener("DOMContentLoaded", function() {
        var nameInput = document.getElementById("name_input");
        var slugInput = document.getElementById("slug_input");
        var metaTitle = document.getElementById("metaTitle_input");
        var descriptionInput = document.getElementById("description_input");
        var metaDescription = document.getElementById("metaDescription_input");

        /* For slug and meta title */
        nameInput.addEventListener("input", function() {
            // Update the value of the slug input based on the name input
            slugInput.value = generateSlug(nameInput.value);
            metaTitle.value = nameInput.value;
        });

        /* for meta description */
        descriptionInput.addEventListener("input", function() {
            metaDescription.value = descriptionInput.value;
        });

        // Function to generate a slug from the given string
        function generateSlug(str) {
            // Replace spaces with dashes and convert to lowercase
            return str.trim().toLowerCase().replace(/\s+/g, '');
        }
    });

    /* Calculate Price */
    function calculateFinalPrice() {
        // Get original price and discount percentage
        let originalPrice = parseFloat(document.getElementById('orp_input').value);
        let discountPercentage = parseFloat(document.getElementById('discountPercentage').value);

        // Calculate final price
        let finalPrice = originalPrice - (originalPrice * (discountPercentage / 100));

        // Update the final price input
        document.getElementById('srp_input').value = finalPrice.toFixed(2);
    }
</script>

<?php include('partials/footer.php'); ?>