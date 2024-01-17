<?php include('partials/header.php');
include('../models/myFunctions.php'); ?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php
            if (isset($_GET['id'])) {
                $ids = $_GET['id'];
                $category = getByUserandSellerId($ids);

                if (mysqli_num_rows($category) > 0) {
                    $data = mysqli_fetch_array($category);
            ?>
                    <div class="card">
                        <div class="card-header">
                            <span class="fs-2 fw-bold">Edit <?= $data['user_firstName'] ?> Details</span>
                            <a href="users.php" class="btn btn-primary end-3 float-end">Back</a>
                        </div>
                        <div class="card-body">
                            <!-- Edit Category start -->
                            <form action="models/user-auth.php" method="POST" enctype="multipart/form-data">
                                <div class="container-fluid">
                                    <div class="row col-md-12">
                                        <div class="form-floating col-md-6 mb-3">
                                            <input type="hidden" name="userID" value="<?= $data['user_ID'] ?>">
                                            <input type="text" class="form-control ps-3" value="<?= $data['user_firstName'] ?>" id="fname" name="firstName" required placeholder="Name">
                                            <label for="floatingInput" class="ps-3">First Name</label>
                                        </div>
                                        <div class="form-floating col-md-6 mb-3">
                                            <input type="text" class="form-control ps-3" value="<?= $data['user_lastName'] ?>" id="lname" name="lastName" required placeholder="Slug">
                                            <label for="floatingPassword" class="ps-3">Last Name</label>
                                        </div>
                                        <div class="form-floating col-md-6 mb-3">
                                            <input type="email" class="form-control ps-3" value="<?= $data['user_email'] ?>" id="email" name="email" required placeholder="Name">
                                            <label for="floatingInput" class="ps-3">Email</label>
                                        </div>
                                        <div class="form-floating col-md-6 mb-3">
                                            <input type="number" class="form-control ps-3" value="<?= $data['user_phone'] ?>" id="pnum" name="phoneNumber" required placeholder="Slug">
                                            <label for="floatingPassword" class="ps-3">Phone Number</label>
                                        </div>
                                        <div class="form-floating col-md-6 mb-3">
                                            <input type="text" class="form-control ps-3" value="<?= $data['user_username'] ?>" id="uname" name="username" required placeholder="Name">
                                            <label for="floatingInput" class="ps-3">Username</label>
                                        </div>
                                        <div class="form-floating col-md-6 mb-3 position-relative">
                                            <input type="password" class="form-control ps-3" value="<?= $data['user_password'] ?>" id="pass" name="userPassword" required placeholder="Slug">
                                            <label for="floatingPassword" class="ps-3">Password</label>
                                            <span class="input-group-text border-0 position-absolute end-4 top-50 translate-middle-y cursor-pointer" id="togglePassword"><i class="fa-regular fa-eye"></i></span>
                                        </div>
                                        <?php
                                        if (!($data['user_ID'] == 1 && $data['user_role'] == 1)) {
                                            // Only show the select tag if the user is not admin with ID 1
                                        ?>
                                            <div class="col-md-12 mb-3">
                                                <div class="form-floating">
                                                    <select name="userRole" class="form-select ps-2" id="orderStat" required>
                                                        <option value="0" <?= $data['user_role'] == 0 ? "selected" : "" ?>>Buyer</option>
                                                        <option value="1" <?= $data['user_role'] == 1 ? "selected" : "" ?>>Admin</option>
                                                        <option value="2" <?= $data['user_role'] == 2 ? "selected" : "" ?>>Seller</option>
                                                    </select>
                                                    <label for="slug_input">User Role</label>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                        <?php
                                        if ($data['user_role'] == 2) {
                                            // Display the HTML code for seller verification
                                        ?>
                                            <h4>Other Seller Details</h4>
                                            <div class="col-md-12 mb-3">
                                                <div class="form-floating">
                                                    <select name="userSellerType" class="form-select ps-2" id="orderStat" required>
                                                        <option value="individual" <?= $data['seller_seller_type'] == 'individual' ? "selected" : "" ?>>Individual</option>
                                                        <option value="business" <?= $data['seller_seller_type'] == 'business' ? "selected" : "" ?>>Business</option>
                                                    </select>
                                                    <label for="slug_input">Seller Type</label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <h5>Is verified?</h5>
                                                <div class="btn-group" role="group">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="isConfirmed" id="inlineRadio1" value="1" <?= $data['seller_confirmed'] == 1 ? 'checked' : '' ?> required>
                                                        <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="isConfirmed" id="inlineRadio2" value="0" <?= $data['seller_confirmed'] == 0 ? 'checked' : '' ?> required>
                                                        <label class="form-check-label" for="inlineRadio2">No</label>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                        ?>

                                        <div class="text-center col-md-12 mb-3">
                                            <button type="submit" id="addCategory_btn" name="updateUserBtn" class="col-md-12 btn btn-primary">Update User Details</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <!-- Edit Category end -->
                        </div>
                    </div>
                <?php
                } else {
                    echo "User not found";
                }
                ?>

            <?php  } else {
                echo "Id missing from url";
            } ?>

        </div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var passwordInput = document.getElementById("pass");
        var togglePasswordBtn = document.getElementById("togglePassword");

        togglePasswordBtn.addEventListener("click", function() {
            // Toggle the password input type
            passwordInput.type = passwordInput.type === "password" ? "text" : "password";

            // Toggle the eye icon class
            var eyeIcon = togglePasswordBtn.querySelector("i");
            eyeIcon.classList.toggle("fa-eye");
            eyeIcon.classList.toggle("fa-eye-slash");
        });
    });
</script>

<?php include('partials/footer.php'); ?>