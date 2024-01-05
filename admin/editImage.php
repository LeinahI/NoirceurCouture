<?php include('partials/header.php');
include('../models/myFunctions.php'); ?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php
            if (isset($_GET['id'])) {
                $ids = $_GET['id'];
                $product = slideShowId("slideshow", $ids);

                if (mysqli_num_rows($product) > 0) {
                    $data = mysqli_fetch_array($product);
            ?>
                    <div class="card">
                        <div class="card-header">
                            <span class="fs-2 fw-bold">Edit Image Slideshow</span>
                            <a href="slideshow.php" class="btn btn-primary end-3 float-end">Back</a>
                        </div>
                        <div class="card-body">
                            <form action="authcode.php" method="POST" enctype="multipart/form-data">
                                <div class="container-fluid">
                                    <div class="form-floating col-md-12 mb-3">
                                    <input type="hidden" name="ssID" value="<?= $data['ss_id'] ?>">
                                        <select name="selectBrandID" class="form-select ps-2">

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
                                    <div class="col-md-6 mb-3">
                                        <div>
                                            <label>Current image:</label>
                                        </div>
                                        <input type="hidden" name="oldSlideShowImage" value="<?= $data['ss_image'] ?>">
                                        <div class="border">
                                            <img src="../assets/uploads/slideshow/<?= $data['ss_image'] ?>" height="300px" class="w-100" alt="brand">
                                        </div>
                                    </div>
                                    <div class=" col-md-12">
                                        <!-- Add Image start -->
                                        <div class="form-floating col-md-12 mb-3">
                                            <input type="file" class="form-control ps-3" accept=".jpg, .jpeg, .png, .webp, .avif, .gif" name="uploadSlideshowImage">
                                            <label for="floatingPassword" class="ps-3">Upload Product Image</label>
                                        </div>
                                        <div class="text-center col-md-12 mb-3">
                                            <button type="submit" id="addProduct_btn" name="updateSlideshowBtn" class="col-md-12 btn btn-primary">Update Image</button>
                                        </div>
                                        <!-- Add Category end -->
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php
                } else {
                    echo "Image not found for given id";
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