<?php include('partials/header.php');
include('../middleware/adminMW.php'); ?>
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
                            <span class="fs-2 fw-bold">View <?= $data['user_firstName'] ?> Details</span>
                            <a href="users.php" class="btn btn-primary end-3 float-end">Back</a>
                        </div>
                        <div class="card-body">
                            <!-- Edit Category start -->
                            <form action="models/user-auth.php" method="POST" enctype="multipart/form-data">
                                <div class="container-fluid">
                                    <div class="row col-md-12">
                                        <div class="form-floating col-md-6 mb-3">
                                            <input type="hidden" name="userID" value="<?= $data['user_ID'] ?>">
                                            <input type="text" class="form-control ps-3" value="<?= $data['user_firstName'] ?>" id="fname" name="firstName" readonly placeholder="Name">
                                            <label for="floatingInput" class="ps-3">First Name</label>
                                        </div>
                                        <div class="form-floating col-md-6 mb-3">
                                            <input type="text" class="form-control ps-3" value="<?= $data['user_lastName'] ?>" id="lname" name="lastName" readonly placeholder="Slug">
                                            <label for="floatingPassword" class="ps-3">Last Name</label>
                                        </div>
                                        <div class="form-floating col-md-6 mb-3">
                                            <input type="text" class="form-control ps-3" value="<?= $data['user_username'] ?>" id="uname" name="username" readonly placeholder="Name">
                                            <label for="floatingInput" class="ps-3">Username</label>
                                        </div>
                                        <div class="form-floating col-md-6 mb-3">
                                            <input type="email" class="form-control ps-3" value="<?= $data['user_email'] ?>" id="email" name="email" readonly placeholder="Name">
                                            <label for="floatingInput" class="ps-3">Email</label>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <div class="form-floating">
                                                <select name="userRole" class="form-select ps-2" id="orderStat" disabled>
                                                    <option value="0" <?= $data['user_role'] == 0 ? "selected" : "" ?>>Buyer</option>
                                                    <option value="1" <?= $data['user_role'] == 1 ? "selected" : "" ?>>Admin</option>
                                                    <option value="2" <?= $data['user_role'] == 2 ? "selected" : "" ?>>Seller</option>
                                                </select>
                                                <label for="slug_input">User Role</label>
                                            </div>
                                        </div>

                                        <?php
                                        if ($data['user_role'] == 2) {
                                            // Display the HTML code for seller verification
                                        ?>
                                            <div class="row mt-3">
                                                <h3>Other Seller Details</h3>
                                                <div class="col-md-12 mb-3">
                                                    <div class="form-floating">
                                                        <select name="userSellerType" class="form-select ps-2" id="orderStat" disabled>
                                                            <option value="individual" <?= $data['seller_seller_type'] == 'individual' ? "selected" : "" ?>>Individual</option>
                                                            <option value="business" <?= $data['seller_seller_type'] == 'business' ? "selected" : "" ?>>Business</option>
                                                        </select>
                                                        <label for="slug_input">Seller Type</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <h5>Is verified?</h5>
                                                <div class="btn-group" role="group">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="isConfirmed" id="verifiedRadio1" value="1" <?= $data['seller_confirmed'] == 1 ? 'checked' : '' ?> disabled>
                                                        <label class="form-check-label" for="verifiedRadio1">Yes</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="isConfirmed" id="verifiedRadio2" value="0" <?= $data['seller_confirmed'] == 0 ? 'checked' : '' ?> disabled>
                                                        <label class="form-check-label" for="verifiedRadio2">No</label>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                        if ($data['user_role'] != 1) {
                                        ?>
                                            <div class="row">
                                                <h3>User Moderation</h3>
                                                <h5>Ban Status</h5>
                                                <div class="btn-group" role="group">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="isBanned" id="banRadio1" value="1" <?= $data['user_isBan'] == 1 ? 'checked' : '' ?> disabled>
                                                        <label class="form-check-label" for="banRadio1">Yes</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="isBanned" id="banRadio2" value="0" <?= $data['user_isBan'] == 0 ? 'checked' : '' ?> disabled>
                                                        <label class="form-check-label" for="banRadio2">No</label>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                        ?>
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