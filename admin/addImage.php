<?php include('partials/header.php');
include('../middleware/adminMW.php'); ?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary">
                    <h2 class="text-white">Add Image Slideshow
                        <a href="slideshow.php" class="btn btn-light float-end ms-2">Go Back</a>
                    </h2>
                </div>
                <div class="card-body">
                    <form action="authcode.php" method="POST" enctype="multipart/form-data">
                        <div class="container-fluid">
                            <div class="form-floating col-md-12 mb-3">
                                <select name="selectBrandID" class="form-select ps-2">

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
                            <div class=" col-md-12">
                                <!-- Add Image start -->
                                <div class="form-floating col-md-12 mb-3">
                                    <input type="file" class="form-control ps-3" accept=".jpg, .jpeg, .png, .webp, .avif, .gif" name="uploadSlideshowImage" required>
                                    <label for="floatingPassword" class="ps-3">Upload Product Image</label>
                                </div>
                                <div class="text-center col-md-12 mb-3">
                                    <button type="submit" id="addProduct_btn" name="addSlideshowBtn" class="col-md-12 btn btn-primary">Add Product</button>
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