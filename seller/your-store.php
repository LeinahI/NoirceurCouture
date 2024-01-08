<?php include('partials/header.php');
include('../middleware/sellerMW.php');
?>
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
                                <div class="form-floating col-md-12 mb-3">
                                    <textarea class="form-control ps-3" placeholder="d" id="description_input" name="descriptionInput" style="height:100px; min-height: 57px; max-height: 100px;" rows="3"><?= $categDesc; ?></textarea>
                                    <label for="floatingPassword" class="ps-3">Store Description</label>
                                </div>
                                <div class="form-floating col-md-6 mb-3">
                                    <input type="file" class="form-control ps-3" id="uploadImage_input" accept=".jpg, .jpeg, .png, .webp, .avif, .gif" name="uploadImageInput">
                                    <label for="floatingPassword" class="ps-3">Upload Image</label>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="">Current image:</label>
                                    <input type="hidden" name="oldImage" value="<?= $categImage; ?>">
                                    <img src="../assets/uploads/brands/<?= $categImage; ?>" height="50px" alt="Store Image">
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