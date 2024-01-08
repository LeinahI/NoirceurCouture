<?php include('partials/header.php');
include('../middleware/adminMW.php'); ?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php
            $category = getByUserandSellerId($_SESSION['auth_user']['user_ID']);

            if (mysqli_num_rows($category) > 0) {
                $data = mysqli_fetch_array($category);
            ?>
                <div class="card">
                    <div class="card-header bg-primary">
                        <h2 class="text-white">Add New Store
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
                                            <input type="hidden" name="userID" value="<?= $data['user_ID'] ?>">
                                            <input type="text" class="form-control ps-3" id="name_input" name="nameInput" required placeholder="Name">
                                            <label for="floatingInput" class="ps-3">Store Name</label>
                                        </div>
                                        <div class="form-floating col-md-6 mb-3">
                                            <input type="text" class="form-control ps-3" id="slug_input" name="slugInput" required placeholder="Slug">
                                            <label for="floatingPassword" class="ps-3">Store Slug</label>
                                        </div>
                                    </div>
                                    <div class="form-floating col-md-12 mb-3">
                                        <textarea class="form-control ps-3" placeholder="d" id="description_input" name="descriptionInput" style="height:100px; min-height: 57px; max-height: 100px;" rows="3"></textarea>
                                        <label for="floatingPassword" class="ps-3">Store Description</label>
                                    </div>
                                    <div class="form-floating col-md-12 mb-3">
                                        <input type="file" class="form-control ps-3" id="uploadImage_input" accept=".jpg, .jpeg, .png, .webp, .avif, .gif" name="uploadImageInput" required>
                                        <label for="floatingPassword" class="ps-3">Store Image</label>
                                    </div>
                                    <div class="form-floating col-md-12 mb-3">
                                        <input type="text" class="form-control ps-3" id="metaTitle_input" name="metaTitleInput" required placeholder="Slug">
                                        <label for="floatingPassword" class="ps-3">Store Meta Title</label>
                                    </div>
                                    <div class="form-floating col-md-12 mb-3">
                                        <textarea class="form-control ps-3" placeholder="d" id="metaDescription_input" name="metaDescriptionInput" required style="height:100px; min-height: 57px; max-height: 100px;" rows="3"></textarea>
                                        <label for="floatingPassword" class="ps-3">Store Meta Description</label>
                                    </div>
                                    <div class="text-center col-md-12 mb-3">
                                        <button type="submit" id="addCategory_btn" name="addCategoryBtn" class="col-md-12 btn btn-primary">Add New Store</button>
                                    </div>
                                    <!-- Add Category end -->
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            <?php
            } else {
                echo "User not found";
            }
            ?>
        </div>
    </div>
</div>

<?php include('partials/footer.php'); ?>