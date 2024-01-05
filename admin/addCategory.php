<?php include('partials/header.php');
include('../middleware/adminMW.php'); ?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary">
                    <h2 class="text-white">Add Brand Category
                        <a href="category.php" class="btn btn-light float-end ms-2">Go Back</a>
                    </h2>
                </div>
                <div class="card-body">
                    <form action="./models/category-auth.php" method="POST" enctype="multipart/form-data">
                        <div class="container-fluid">
                            <div class=" col-md-12">
                                <!-- Add Category start -->
                                <div class="row">
                                    <div class="form-floating col-md-6 mb-3">
                                        <input type="text" class="form-control ps-3" id="name_input" name="nameInput" required placeholder="Name">
                                        <label for="floatingInput" class="ps-3">Name</label>
                                    </div>
                                    <div class="form-floating col-md-6 mb-3">
                                        <input type="text" class="form-control ps-3" id="slug_input" name="slugInput" required placeholder="Slug">
                                        <label for="floatingPassword" class="ps-3">Slug</label>
                                    </div>
                                </div>
                                <div class="form-floating col-md-12 mb-3">
                                    <textarea class="form-control ps-3" placeholder="d" id="description_input" name="descriptionInput" style="height:100px; min-height: 57px; max-height: 100px;" rows="3"></textarea>
                                    <label for="floatingPassword" class="ps-3">Description</label>
                                </div>
                                <div class="form-floating col-md-12 mb-3">
                                    <input type="file" class="form-control ps-3" id="uploadImage_input" accept=".jpg, .jpeg, .png, .webp, .avif, .gif" name="uploadImageInput" required>
                                    <label for="floatingPassword" class="ps-3">Upload Image</label>
                                </div>
                                <div class="form-floating col-md-12 mb-3">
                                    <input type="text" class="form-control ps-3" id="metaTitle_input" name="metaTitleInput" required placeholder="Slug">
                                    <label for="floatingPassword" class="ps-3">Meta Title</label>
                                </div>
                                <div class="form-floating col-md-12 mb-3">
                                    <textarea class="form-control ps-3" placeholder="d" id="metaDescription_input" name="metaDescriptionInput" required style="height:100px; min-height: 57px; max-height: 100px;" rows="3"></textarea>
                                    <label for="floatingPassword" class="ps-3">Meta Description</label>
                                </div>
                                <div class="form-floating col-md-12 mb-3">
                                    <textarea class="form-control ps-3" placeholder="d" id="metaKeywords_input" name="metaKeywordsInput" required style="height:100px; min-height: 57px; max-height: 100px;" rows="3"></textarea>
                                    <label for="floatingPassword" class="ps-3">Meta Keywords</label>
                                </div>
                                <div class="row">
                                    <div class="btn-group" role="group" aria-label="Basic checkbox toggle button group">
                                        <input type="checkbox" class="btn-check" id="status_checkbox" name="statusCheckbox" autocomplete="off">
                                        <label class="btn btn-outline-primary" for="status_checkbox">Status</label>

                                        <input type="checkbox" class="btn-check" id="popular_checkbox" name="popularCheckbox" autocomplete="off">
                                        <label class="btn btn-outline-primary" for="popular_checkbox">Popular</label>
                                    </div>
                                </div>
                                <div class="text-center col-md-12 mb-3">
                                    <button type="submit" id="addCategory_btn" name="addCategoryBtn" class="col-md-12 btn btn-primary">Add Brand Category</button>
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

<?php include('partials/footer.php'); ?>