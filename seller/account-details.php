<?php include('partials/header.php');
include('../middleware/sellerMW.php');
include('../models/checkSession.php');
include('../models/dataEncryption.php');
checkUserValidityAndRedirect($_SESSION['auth_user']['user_ID'] ?? null);
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary">
                    <h2 class="text-white">Your Account Details
                        <a href="changePassword.php" class="btn btn-light float-end ms-2">Change Password</a>
                    </h2>
                </div>

                <div class="card-body">
                    <div class="container-fluid row">
                        <!-- Login Details -->
                        <div class="col-md-6">
                            <?php
                            $categUser = getByCategAndUserId($_SESSION['auth_user']['user_ID']);

                            $data = mysqli_fetch_array($categUser);

                            $id = isset($data['user_ID']) ? $data['user_ID'] : '';
                            ?>
                            <form action="./models/user-auth.php" method="POST" enctype="multipart/form-data">
                                <!-- Add Category start -->
                                <h3>Login Details</h3>
                                <input type="hidden" name="userID" value="<?= $id; ?>">
                                <div class="row">
                                    <div class="form-floating col-md-12 mb-3">
                                        <input type="text" class="form-control ps-3" value="<?= $data['user_username']; ?>" disabled placeholder="uname">
                                        <label for="floatingInput" class="ps-3">Username</label>
                                    </div>
                                </div>
                                <!-- First and Last Name -->
                                <div class="row">
                                    <div class="form-floating col-md-6 mb-3">
                                        <input type="text" class="form-control ps-3" value="<?= $data['user_firstName']; ?>" name="firstName" required placeholder="Fname">
                                        <label for="floatingInput" class="ps-3">First Name</label>
                                    </div>
                                    <div class="form-floating col-md-6 mb-3">
                                        <input type="text" class="form-control ps-3" value="<?= $data['user_lastName']; ?>" name="lastName" required placeholder="Lname">
                                        <label for="floatingPassword" class="ps-3">Last Name</label>
                                    </div>
                                </div>
                                <!-- Email and Phone Number -->

                                <div class="form-floating col-md-12 mb-3">
                                    <input type="email" class="form-control ps-3" value="<?= $data['user_email']; ?>" name="email" required placeholder="email@email.com">
                                    <label for="floatingInput" class="ps-3">Email Address</label>
                                </div>

                                <div class="form-floating col-md-12 mb-3">
                                    <input type="number" class="form-control ps-3" value="<?= $data['user_phone']; ?>" name="phoneNumber" required placeholder="09" onkeypress="inpNum(event)">
                                    <label for="floatingPassword" class="ps-3">Phone Number</label>
                                </div>

                                <!-- Update Details -->
                                <div class="text-center col-md-12 mb-3">
                                    <button type="submit" name="updateSellerDetailsBtn" class="col-md-12 btn btn-primary">Update Account Details</button>
                                </div>
                            </form>
                        </div>
                        <!-- Pickup Address -->
                        <div class="col-md-6">
                            <?php
                            $pickupaddr = getPickupAddress();
                            $pa = mysqli_fetch_array($pickupaddr);

                            $fname = isset($pa['address_fullName']) ? $pa['address_fullName'] : '';
                            $email = isset($pa['address_email']) ? $pa['address_email'] : '';
                            $phone = isset($pa['address_phone']) ? $pa['address_phone'] : '';
                            $regionCode = isset($pa['address_region']) ? $pa['address_region'] : '';
                            $provinceCode = isset($pa['address_province']) ? $pa['address_province'] : '';
                            $cityCode = isset($pa['address_city']) ? $pa['address_city'] : '';
                            $barangayCode = isset($pa['address_barangay']) ? $pa['address_barangay'] : '';
                            $fulladdr = isset($pa['address_fullAddress']) ? $pa['address_fullAddress'] : '';

                            $existingAddress = !empty($fulladdr);
                            $decryptedfullAddr = decryptData($fulladdr);
                            ?>
                            <form action="./models/user-auth.php" method="POST" enctype="multipart/form-data">
                                <!--Fname and Email -->
                                <h3>Pickup Address</h3>
                                <input type="hidden" name="userID" value="<?= $id; ?>">
                                <div class="row">
                                    <div class="form-floating col-md-6 mb-3">
                                        <input type="text" class="form-control ps-3" name="fullName" value="<?= $fname ?>" required placeholder="fulln">
                                        <label for="floatingInput" class="ps-3">Full Name</label>
                                    </div>
                                    <div class="form-floating col-md-6 mb-3">
                                        <input type="email" class="form-control ps-3" value="<?= $email ?>" name="email" required placeholder="email@email.com">
                                        <label for="floatingInput" class="ps-3">Email Address</label>
                                    </div>
                                </div>
                                <!-- Phone Number -->
                                <div class="row">
                                    <div class="form-floating col-md-6 mb-3">
                                        <input type="number" class="form-control ps-3" value="<?= $phone ?>" name="phoneNumber" required placeholder="09" onkeypress="inpNum(event)">
                                        <label for="floatingPassword" class="ps-3">Phone Number</label>
                                    </div>
                                    <!-- City State Country -->
                                    <div class="form-floating col-md-6 mb-3">
                                        <select name="region" class="ps-2 form-select form-control form-control-md" id="region" required></select>
                                        <input type="hidden" class="form-control ps-3 form-control-md" name="region_text" id="region-text" required>
                                        <label for="floatingInput" class="ps-3">Region</label>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-floating col-md-4 mb-3">
                                        <select name="province" class="ps-2 form-control form-control-md" id="province" required></select>
                                        <input type="hidden" class="form-control form-control-md" name="province_text" id="province-text" required> <!-- Province -->
                                        <label for="floatingInput" class="ps-3">Province</label>
                                    </div>
                                    <div class="form-floating col-md-4 mb-3">
                                        <select name="city" class="ps-2 form-control form-control-md" id="city" required></select>
                                        <input type="hidden" class="form-control form-control-md" name="city_text" id="city-text" required> <!-- City -->
                                        <label for="floatingInput" class="ps-3">City / Municipality</label>
                                    </div>
                                    <div class="form-floating col-md-4 mb-3">
                                        <select name="barangay" class="ps-2 form-control form-control-md" id="barangay" required></select>
                                        <input type="hidden" class="form-control form-control-md" name="barangay_text" id="barangay-text" required> <!-- Barangay -->
                                        <label for="floatingInput" class="ps-3">Barangay</label>
                                    </div>
                                </div>

                                <!--Addr start -->
                                <div class="form-floating col-md-12 ps-0 mb-3">
                                    <div class="form-floating ps-0 mb-3">
                                        <textarea rows="3" class="form-control ps-3" id="delivery_fullAddr" name="fullAddress" required placeholder="d" style="height:58px; min-height: 57px; max-height: 100px;"><?= $decryptedfullAddr ?></textarea>
                                        <label for="floatingInput" class="ps-1">Address</label>
                                    </div>
                                </div>

                                <!-- Add & Update button -->
                                <?php if ($existingAddress) { ?>
                                    <!-- If an existing address exists -->
                                    <div class="form-floating col-md-12 ps-0">
                                        <button type="submit" name="sellerUpdateAddrBtn" class="btn btn-primary col-md-12">Update My Address</button>
                                    </div>
                                <?php } else { ?>
                                    <!-- If no existing address exists -->
                                    <div class="form-floating col-md-12 ps-0">
                                        <button type="submit" name="sellerAddAddrBtn" class="btn btn-primary col-md-12">Add Address</button>
                                    </div>
                                <?php } ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include('../assets/js/ph-address-selector.php');
include('partials/footer.php'); ?>

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

    /* Prevent user to write letter or symbols in phone number */
    function inpNum(e) {
        e = e || window.event;
        var charCode = (typeof e.which == "undefined") ? e.keyCode : e.which;
        var charStr = String.fromCharCode(charCode);

        // Allow only numeric characters
        if (!charStr.match(/^[0-9]+$/)) {
            e.preventDefault();
        }

        // Allow a maximum of 11 digits
        var inputValue = e.target.value || '';
        var numericValue = inputValue.replace(/[^0-9]/g, '');

        if (numericValue.length >= 11) {
            e.preventDefault();
        }

        // Apply Philippine phone number format (optional)
        if (numericValue.length === 1 && numericValue !== '0') {
            // Add '0' at the beginning if the first digit is not '0'
            e.target.value = '0' + numericValue;
        } else if (numericValue.length >= 2 && !numericValue.startsWith('09')) {
            // Ensure it starts with '09'
            e.target.value = '09' + numericValue.substring(2);
        }
    }
</script>