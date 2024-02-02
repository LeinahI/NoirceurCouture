<?php include('partials/header.php');
include('../middleware/sellerMW.php');
include('../models/checkSession.php');
checkUserValidityAndRedirect($_SESSION['auth_user']['user_ID'] ?? null);
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary">
                    <h2 class="text-white">Your Account Details
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
                                        <input type="text" class="form-control ps-3" value="<?= $data['user_username']; ?>" readonly placeholder="uname">
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
                                <div class="row">
                                    <div class="form-floating col-md-6 mb-3">
                                        <input type="email" class="form-control ps-3" value="<?= $data['user_email']; ?>" name="email" required placeholder="email@email.com">
                                        <label for="floatingInput" class="ps-3">Email Address</label>
                                    </div>
                                    <div class="form-floating col-md-6 mb-3">
                                        <input type="number" class="form-control ps-3" value="<?= $data['user_phone']; ?>" name="phoneNumber" required placeholder="09">
                                        <label for="floatingPassword" class="ps-3">Phone Number</label>
                                    </div>
                                </div>
                                <!-- Pass and CPass start -->
                                <div class="form-floating col-md-12 mb-3 position-relative">
                                    <input type="password" class="form-control ps-3" value="<?= $data['user_password'] ?>" id="pass" name="userPassword" required placeholder="Slug">
                                    <label for="floatingPassword" class="ps-3">Password</label>
                                    <span class="input-group-text border-0 position-absolute end-3 top-50 translate-middle-y cursor-pointer" id="togglePassword"><i class="fa-regular fa-eye"></i></span>
                                </div>
                                <!-- Pass and CPass end -->

                                <!-- Update Details -->
                                <div class="text-center col-md-12 mb-3">
                                    <button type="submit" name="updateUserBtn" class="col-md-12 btn btn-primary">Update Account Details</button>
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
                            $state = isset($pa['address_state']) ? $pa['address_state'] : '';
                            $city = isset($pa['address_city']) ? $pa['address_city'] : '';
                            $pcode = isset($pa['address_postal_code']) ? $pa['address_postal_code'] : '';
                            $country = isset($pa['address_country']) ? $pa['address_country'] : '';
                            $fulladdr = isset($pa['address_fullAddress']) ? $pa['address_fullAddress'] : '';

                            $existingAddress = !empty($fulladdr);
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
                                        <input type="number" class="form-control ps-3" value="<?= $phone ?>" name="phoneNumber" required placeholder="09">
                                        <label for="floatingPassword" class="ps-3">Phone Number</label>
                                    </div>
                                    <div class="form-floating col-md-6 mb-3">
                                        <input type="text" class="form-control ps-3" value="<?= $state ?>" name="state" required placeholder="09">
                                        <label for="floatingPassword" class="ps-3">State</label>
                                    </div>
                                </div>
                                <!-- City State Country -->
                                <div class="row">
                                    <div class="form-floating col-md-4 mb-3">
                                        <input type="text" class="form-control ps-3" value="<?= $city ?>" name="city" required placeholder="email@email.com">
                                        <label for="floatingInput" class="ps-3">City</label>
                                    </div>
                                    <div class="form-floating col-md-4 mb-3">
                                        <input type="text" class="form-control ps-3" value="<?= $pcode ?>" name="postalCode" required placeholder="09">
                                        <label for="floatingPassword" class="ps-3">Postal Code</label>
                                    </div>
                                    <div class="form-floating col-md-4 mb-3">
                                        <select class="form-select ps-2" id="country" name="country">
                                            <?php include('../partials/country-options.php') ?>
                                        </select>
                                        <label for="country" class="ps-3">Country</label>
                                    </div>
                                </div>

                                <!--Addr start -->
                                <div class="form-floating col-md-12 ps-0 mb-3">
                                    <div class="form-floating ps-0 mb-3">
                                        <textarea rows="3" class="form-control ps-3" id="delivery_fullAddr" name="fullAddress" required placeholder="d" style="height:58px; min-height: 57px; max-height: 100px;"><?= $fulladdr ?></textarea>
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

<?php include('partials/footer.php'); ?>

<script>
    /* display selected country */
    var selectedCountry = "<?php echo $country; ?>";
    // Set the selected attribute based on the PHP variable
    document.getElementById("country").value = selectedCountry;

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