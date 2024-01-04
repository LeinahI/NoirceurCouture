<?php include('partials/header.php');
include('../models/myFunctions.php'); ?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php
            if (isset($_GET['id'])) {
                $ids = $_GET['id'];
                $category = getById("categories", $ids);

                if (mysqli_num_rows($category) > 0) {
                    $data = mysqli_fetch_array($category);
            ?>
                    <div class="card">
                        <div class="card-header">
                            <span class="fs-2 fw-bold">Edit <?= $data['category_name'] ?> Details</span>
                            <a href="category.php" class="btn btn-primary end-3 float-end">Back</a>
                        </div>
                        <div class="card-body">
                            <!-- Edit Category start -->
                            <form action="authcode.php" method="POST" enctype="multipart/form-data">
                                <div class="container-fluid">
                                    <div class="row col-md-12">
                                        
                                        <div class="form-floating col-md-6 mb-3">
                                            <input type="hidden" name="categoryID" value="<?= $data['category_id'] ?>">
                                            <input type="text" class="form-control ps-3" value="<?= $data['category_name'] ?>" id="name_input" name="nameInput" required placeholder="Name">
                                            <label for="floatingInput" class="ps-3">Name</label>
                                        </div>
                                        <div class="form-floating col-md-6 mb-3">
                                            <input type="text" class="form-control ps-3" value="<?= $data['category_slug'] ?>" id="slug_input" name="slugInput" required placeholder="Slug">
                                            <label for="floatingPassword" class="ps-3">Slug</label>
                                        </div>
                                        <div class="form-floating col-md-12 mb-3">
                                            <textarea class="form-control ps-3" id="description_input" name="descriptionInput" required placeholder="d" style="height:100px; min-height: 57px; max-height: 100px;" rows="3"><?= $data['category_description'] ?></textarea>
                                            <label for="floatingPassword" class="ps-3">Description</label>
                                        </div>
                                        <div class="form-floating col-md-6 mb-3" >
                                            <input type="file" class="form-control ps-3" id="uploadImage_input" accept=".jpg, .jpeg, .png, .webp, .avif, .gif" name="uploadNewImageInput">
                                            <label for="floatingPassword" class="ps-3">Upload Image</label>
                                        </div>
                                        <div class="col-md-6 mb-3" >
                                                <label for="">Current image:</label>
                                                <input type="hidden" name="oldImage" value="<?= $data['category_image'] ?>">
                                                <img src="../assets/uploads/brands/<?= $data['category_image'] ?>" height="50px" alt="brand">
                                        </div>
                                        <div class="form-floating col-md-12 mb-3">
                                            <input type="text" class="form-control ps-3" value="<?= $data['category_meta_title'] ?>" id="metaTitle_input" name="metaTitleInput" required placeholder="Slug">
                                            <label for="floatingPassword" class="ps-3">Meta Title</label>
                                        </div>
                                        <div class="form-floating col-md-12 mb-3">
                                            <textarea class="form-control ps-3" id="metaDescription_input" name="metaDescriptionInput" required placeholder="d" style="height:100px; min-height: 57px; max-height: 100px;" rows="3"><?= $data['category_meta_description'] ?></textarea>
                                            <label for="floatingPassword" class="ps-3">Meta Description</label>
                                        </div>
                                        <div class="form-floating col-md-12 mb-3">
                                            <textarea class="form-control ps-3" id="metaKeywords_input" name="metaKeywordsInput" required placeholder="d" style="height:100px; min-height: 57px; max-height: 100px;" rows="3"><?= $data['category_meta_keywords'] ?></textarea>
                                            <label for="floatingPassword" class="ps-3">Meta Keywords</label>
                                        </div>
                                        <div class="btn-group" role="group" aria-label="Basic checkbox toggle button group">
                                            <input type="checkbox" class="btn-check" <?= $data['category_status'] ? "checked" : "" ?> id="status_checkbox" name="statusCheckbox" autocomplete="off">
                                            <label id="status_label" class="btn btn-outline-primary" for="status_checkbox"><?= $data['category_status'] ? "Hidden" : "Visible" ?></label>

                                            <input type="checkbox" class="btn-check" <?= $data['category_popular'] ? "checked" : "" ?> id="popular_checkbox" name="popularCheckbox" autocomplete="off">
                                            <label class="btn btn-outline-primary" for="popular_checkbox">Popular</label>
                                        </div>
                                        <div class="text-center col-md-12 mb-3">
                                            <button type="submit" id="addCategory_btn" name="updateCategoryBtn" class="col-md-12 btn btn-primary">Update Data</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <!-- Edit Category end -->
                        </div>
                    </div>
                <?php
                } else {
                    echo "Category not found";
                }
                ?>

            <?php  } else {
                echo "Id missing from url";
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