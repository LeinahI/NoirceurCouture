<?php include('partials/header.php');
include('../middleware/adminMW.php'); ?>
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
                    <form action="authcode.php" method="POST" enctype="multipart/form-data">
                        <div class="container-fluid">
                            <div class=" col-md-12">
                                <!-- Add Category start -->
                                <div class="form-floating col-md-12 mb-3">
                                    <select name="selectBrandCategoryID" class="form-select ps-2" id="selbr">

                                        <?php
                                        $categories = getAll("categories");
                                        if (mysqli_num_rows($categories) > 0) {
                                            foreach ($categories as $item) {
                                        ?>
                                                <option value="<?= $item['category_id'] ?>"><?= $item['category_name'] ?></option>
                                        <?php
                                            }
                                        } else {
                                            echo "No Category Available";
                                        }
                                        ?>
                                    </select>
                                    <label for="selbr" class="ps-3">Select Brand Category</label>
                                </div>
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
                                    <input type="text" class="form-control ps-3" id="smallDesc_input" name="smallDescriptionInput" required placeholder="sdesc">
                                    <label for="smallDesc_input" class="ps-3">Product Small Description</label>
                                </div>
                                <div class="form-floating col-md-12 mb-3">
                                    <textarea class="form-control ps-3" placeholder="d" id="description_input" name="productdescriptionInput" style="height:100px; min-height: 57px; max-height: 100px;" rows="3"></textarea>
                                    <label for="floatingPassword" class="ps-3">Product Description</label>
                                </div>
                                <div class="row">
                                    <div class="form-floating col-md-6 mb-3">
                                        <input type="number" class="form-control ps-3" id="orp_input" name="originalPriceInput" required placeholder="orp">
                                        <label for="floatingInput" class="ps-3">Original Price in ₱</label>
                                    </div>
                                    <div class="form-floating col-md-6 mb-3">
                                        <input type="text" class="form-control ps-3" id="srp_input" name="suggestedRetailPriceInput" readonly required placeholder="srp">
                                        <label for="floatingPassword" class="ps-3">Suggested Retail Price in ₱ (SRP)</label>
                                    </div>
                                </div>
                                <div class="form-floating col-md-12 mb-3">
                                    <input type="file" class="form-control ps-3" id="uploadProductImage_input" accept=".jpg, .jpeg, .png, .webp, .avif, .gif" name="uploadProductImageInput" required>
                                    <label for="floatingPassword" class="ps-3">Upload Product Image</label>
                                </div>

                                <div class="col-md-12" style="display:flex;">
                                    <div class="form-floating col-md-6 mb-3">
                                        <input type="number" class="form-control ps-3" id="qty_input" name="quantityInput" required placeholder="qty">
                                        <label for="floatingPassword" class="ps-1">Item Quantity</label>
                                    </div>
                                    <div class="btn-group col-md-6" role="group" aria-label="Basic checkbox toggle button group">
                                        <input type="checkbox" class="btn-check" id="status_checkbox" name="productstatusCheckbox" autocomplete="off">
                                        <label class="btn btn-outline-primary" for="status_checkbox">Status</label>

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
                                <div class="form-floating col-md-12 mb-3">
                                    <textarea class="form-control ps-3" placeholder="d" id="metaKeywords_input" name="productmetaKeywordsInput" required style="height:100px; min-height: 57px; max-height: 100px;" rows="3"></textarea>
                                    <label for="floatingPassword" class="ps-3">Product Meta Keywords</label>
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
</script>

<?php include('partials/footer.php'); ?>