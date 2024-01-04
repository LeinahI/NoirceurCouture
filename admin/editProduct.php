<?php include('partials/header.php');
include('../models/myFunctions.php'); ?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php
            if (isset($_GET['id'])) {
                $ids = $_GET['id'];
                $product = getByIdProduct("products", $ids);

                if (mysqli_num_rows($product) > 0) {
                    $data = mysqli_fetch_array($product);
            ?>
                    <div class="card">
                        <div class="card-header">
                            <span class="fs-2 fw-bold">Edit <?= $data['product_name'] ?> Details</span>
                            <a href="product.php" class="btn btn-primary end-3 float-end">Back</a>
                        </div>
                        <div class="card-body">
                            <form action="authcode.php" method="POST" enctype="multipart/form-data">
                                <div class="container-fluid">
                                    <div class="row col-md-12">
                                        <!-- Add Category start -->
                                        <div class="form-floating col-md-12 mb-3">
                                            <input type="hidden" name="productID" value="<?= $data['product_id'] ?>">
                                            <select name="selectBrandCategoryID" class="form-select ps-2" id="selbr">

                                                <?php
                                                $categories = getAll("categories");
                                                if (mysqli_num_rows($categories) > 0) {
                                                    foreach ($categories as $item) {
                                                ?>
                                                        <option value="<?= $item['category_id'] ?>" <?= $data['category_id'] == $item['category_id'] ? 'selected' : '' ?>><?= $item['category_name'] ?></option>
                                                <?php
                                                    }
                                                } else {
                                                    echo "No Category Available";
                                                }
                                                ?>
                                            </select>
                                            <label for="selbr" class="ps-3">Select Brand Category</label>
                                        </div>
                                        <div class="form-floating col-md-6 mb-3">
                                            <input type="text" class="form-control ps-3" value="<?= $data['product_name'] ?>" id="name_input" name="productnameInput" required placeholder="Name">
                                            <label for="floatingInput" class="ps-3">Product Name</label>
                                        </div>
                                        <div class="form-floating col-md-6 mb-3">
                                            <input type="text" class="form-control ps-3" value="<?= $data['product_slug'] ?>" id="slug_input" name="productslugInput" required placeholder="Slug">
                                            <label for="floatingPassword" class="ps-3">Product Slug</label>
                                        </div>
                                        <div class="form-floating col-md-12 mb-3">
                                            <input type="text" class="form-control ps-3" value="<?= $data['product_small_description'] ?>" id="smallDesc_input" name="smallDescriptionInput" required placeholder="sdesc">
                                            <label for="smallDesc_input" class="ps-3">Product Small Description</label>
                                        </div>
                                        <div class="form-floating col-md-12 mb-3">
                                            <textarea class="form-control ps-3" placeholder="d" id="description_input" name="productdescriptionInput" style="height:100px; min-height: 57px; max-height: 100px;" rows="3"><?= $data['product_description'] ?></textarea>
                                            <label for="floatingPassword" class="ps-3">Product Description</label>
                                        </div>
                                        <div class="form-floating col-md-6 mb-3">
                                            <input type="number" class="form-control ps-3" value="<?= $data['product_original_price'] ?>" id="orp_input" name="originalPriceInput" required placeholder="orp">
                                            <label for="floatingInput" class="ps-3">Original Price in ₱</label>
                                        </div>
                                        <div class="form-floating col-md-6 mb-3">
                                            <input type="number" class="form-control ps-3" value="<?= $data['product_srp'] ?>" id="srp_input" name="suggestedRetailPriceInput" readonly required placeholder="srp">
                                            <label for="floatingPassword" class="ps-3">Suggested Retail Price in ₱ (SRP)</label>
                                        </div>
                                        <div class="form-floating col-md-6 mb-3">
                                            <input type="file" class="form-control ps-3" id="uploadProductImage_input" accept=".jpg, .jpeg, .png, .webp, .avif, .gif" name="uploadProductImageInput">
                                            <label for="floatingPassword" class="ps-3">Upload Product Image</label>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="">Current image:</label>
                                            <input type="hidden" name="oldProductImage" value="<?= $data['product_image'] ?>">
                                            <img src="../assets/uploads/products/<?= $data['product_image'] ?>" height="50px" alt="brand">
                                        </div>
                                        <div class="col-md-12" style="display:flex;">
                                            <div class="form-floating col-md-6 mb-3">
                                                <input type="number" class="form-control ps-3" value="<?= $data['product_qty'] ?>" id="qty_input" name="quantityInput" required placeholder="qty">
                                                <label for="floatingPassword" class="ps-1">Item Quantity</label>
                                            </div>
                                            <div class="btn-group col-md-6" role="group" aria-label="Basic checkbox toggle button group">
                                                <input type="checkbox" class="btn-check" <?= $data['product_status'] ? "checked" : "" ?> id="status_checkbox" name="productstatusCheckbox" autocomplete="off">
                                                <label id="status_label" class="btn btn-outline-primary" for="status_checkbox"><?= $data['product_status'] ? "Hidden" : "Visible" ?></label>

                                                <input type="checkbox" class="btn-check" <?= $data['product_popular'] ? "checked" : "" ?> id="popular_checkbox" name="productpopularCheckbox" autocomplete="off">
                                                <label class="btn btn-outline-primary" for="popular_checkbox">Popular</label>
                                            </div>
                                        </div>
                                        <div class="form-floating col-md-12 mb-3">
                                            <input type="text" class="form-control ps-3" value="<?= $data['product_meta_title'] ?>" id="metaTitle_input" name="productmetaTitleInput" required placeholder="Slug">
                                            <label for="floatingPassword" class="ps-3">Product Meta Title</label>
                                        </div>
                                        <div class="form-floating col-md-12 mb-3">
                                            <textarea class="form-control ps-3" placeholder="d" id="metaDescription_input" name="productmetaDescriptionInput" required style="height:100px; min-height: 57px; max-height: 100px;" rows="3"><?= $data['product_meta_description'] ?></textarea>
                                            <label for="floatingPassword" class="ps-3">Product Meta Description</label>
                                        </div>
                                        <div class="form-floating col-md-12 mb-3">
                                            <textarea class="form-control ps-3" placeholder="d" id="metaKeywords_input" name="productmetaKeywordsInput" required style="height:100px; min-height: 57px; max-height: 100px;" rows="3"><?= $data['product_meta_description'] ?></textarea>
                                            <label for="floatingPassword" class="ps-3">Product Meta Keywords</label>
                                        </div>
                                        <div class="text-center col-md-12 mb-3">
                                            <button type="submit" id="editProduct_btn" name="updateProductBtn" class="col-md-12 btn btn-primary">Update Data</button>
                                        </div>
                                        <!-- Add Category end -->
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
    const orpInput = document.getElementById('orp_input');
    const srpInput = document.getElementById('srp_input');

    orpInput.addEventListener('input', () => {
        const orpValue = orpInput.value;
        if (orpValue !== '') {
            const increaseAmount = parseFloat(orpValue) * 0.3;
            const srpValue = parseFloat(orpValue) + increaseAmount;
            srpInput.value = srpValue.toFixed(2);
        } else {
            srpInput.value = '';
        }
    });
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