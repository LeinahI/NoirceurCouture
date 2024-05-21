<?php include('partials/header.php');
include('../middleware/sellerMW.php');
include('../models/checkSession.php');
include('models/check-seller-addr.php');
checkUserValidityAndRedirect($_SESSION['auth_user']['user_ID'] ?? null);
?>
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
            <div class="card">
                <div class="card-header bg-primary">
                    <h2 class="text-white">Your Store Details
                    </h2>
                </div>
                <?php
                $categUser = getByCategAndUserId($_SESSION['auth_user']['user_ID']);
                $data = mysqli_fetch_array($categUser);

                $id = isset($data['user_ID']) ? $data['user_ID'] : '';
                $category_id = isset($data['category_id']) ? $data['category_id'] : '';
                $categName = isset($data['category_name']) ? $data['category_name'] : '';
                $categSlug = isset($data['category_slug']) ? $data['category_slug'] : '';
                $categDesc = isset($data['category_description']) ? $data['category_description'] : '';
                $categImage = isset($data['category_image']) ? $data['category_image'] : '';
                $categMetaTitle = isset($data['category_meta_title']) ? $data['category_meta_title'] : '';
                $categMetaDesc = isset($data['category_meta_description']) ? $data['category_meta_description'] : '';

                // Check if there's existing data (assuming categName is a key field)
                $existingDetails = !empty($categName);
                ?>

                <div class="card-body">
                    <form action="./models/category-auth.php" method="POST" enctype="multipart/form-data">
                        <div class="container-fluid">
                            <div class="col-md-12">
                                <!-- Add Category start -->
                                <div class="row">
                                    <div class="form-floating col-md-6 mb-3">
                                        <input type="hidden" name="userID" value="<?= $id; ?>">
                                        <input type="hidden" name="categoryID" value="<?= $category_id; ?>">

                                        <input type="text" class="form-control ps-3" id="name_input" value="<?= $categName; ?>" name="nameInput" required placeholder="Name">
                                        <label for="floatingInput" class="ps-3">Store Name</label>
                                    </div>
                                    <div class="form-floating col-md-6 mb-3">
                                        <input type="text" class="form-control ps-3" id="slug_input" value="<?= $categSlug; ?>" name="slugInput" required placeholder="Slug">
                                        <label for="floatingPassword" class="ps-3">Store Slug</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="">Store Logo:</label>
                                    <input type="hidden" name="oldImage" value="<?= $categImage; ?>">
                                    <img src="../assets/uploads/brands/<?= $categImage; ?>" height="100px" alt="Store Image">
                                </div>
                                <div class="form-floating col-md-12 mb-3">
                                    <input type="file" class="form-control ps-3" id="uploadImage_input" accept=".jpg, .jpeg, .png, .webp, .avif, .gif" name="uploadImageInput">
                                    <label for="floatingPassword" class="ps-3">Upload Image</label>
                                </div>
                                <div class="form-floating col-md-12 mb-3">
                                    <textarea class="form-control ps-3" placeholder="d" id="description_input" name="descriptionInput" style="height:100px; min-height: 57px; max-height: 100px;" rows="3"><?= htmlspecialchars($categDesc, ENT_QUOTES, 'UTF-8'); ?></textarea>
                                    <label for="floatingPassword" class="ps-3">Store Description</label>
                                </div>

                                <div class="form-floating col-md-12 mb-3">
                                    <input type="text" class="form-control ps-3" id="metaTitle_input" value="<?= $categMetaTitle; ?>" name="metaTitleInput" required placeholder="Slug">
                                    <label for="floatingPassword" class="ps-3">Store Meta Title</label>
                                </div>
                                <div class="form-floating col-md-12 mb-3">
                                    <textarea class="form-control ps-3" placeholder="d" id="metaDescription_input" name="metaDescriptionInput" required style="height:100px; min-height: 57px; max-height: 100px;" rows="3"><?= $categMetaDesc; ?></textarea>
                                    <label for="floatingPassword" class="ps-3">Store Meta Description</label>
                                </div>


                                <!-- Add & Update button -->
                                <?php if ($existingDetails) { ?>
                                    <!--//! Store Visibility -->
                                    <div class="col-md-12 btn-group" role="group" aria-label="Basic checkbox toggle button group">
                                        <input type="checkbox" class="btn-check" <?= $data['category_onVacation'] ? "checked" : "" ?> id="visibility_cb" name="visibilityCheckbox" autocomplete="off" />
                                        <label id="visibility_label" class="btn btn-outline-primary " for="visibility_cb">
                                            <?= $data['category_onVacation'] ? "Set Visible" : "Set On Vacation" ?>
                                        </label>
                                    </div>
                                    <!-- If existing details exist -->
                                    <div class="text-center col-md-12 mb-3">
                                        <button type="submit" name="updateCategoryBtn" class="col-md-12 btn btn-primary">Update Your Store Details</button>
                                    </div>
                                <?php } else { ?>
                                    <!-- If no existing details exist -->
                                    <div class="text-center col-md-12 mb-3">
                                        <button type="submit" id="addCategory_btn" name="addCategoryBtn" class="col-md-12 btn btn-primary">Add New Store Details</button>
                                    </div>
                                <?php } ?>

                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<?php include('partials/footer.php'); ?>

<script>
    //Visible & hidden
    document.addEventListener("DOMContentLoaded", function() {
        var checkbox = document.getElementById("visibility_cb");
        var label = document.getElementById("visibility_label");

        checkbox.addEventListener("change", function() {
            label.textContent = checkbox.checked ? "Set On Vacation" : "Set Visible";
        });
    });

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
</script>