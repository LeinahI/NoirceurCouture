<?php include('partials/header.php');
include('../middleware/adminMW.php');
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary">
                    <h2 class="text-white">Your Admin Account Details
                    </h2>
                </div>

                <div class="card-body">
                    <div class="container-fluid row">
                        <!-- Login Details -->
                        <div class="col-md-12">
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
                                    <input type="password" class="form-control ps-3" value="<?= $data['user_password'] ?>" id="passw" name="userPassword" required placeholder="Slug">
                                    <label for="floatingPassword" class="ps-3">Password</label>
                                    <span class="input-group-text border-0 position-absolute end-2 top-50 translate-middle-y cursor-pointer" id="togglePassword"><i class="fa-regular fa-eye"></i></span>
                                </div>
                                <!-- Pass and CPass end -->

                                <!-- Update Details -->
                                <div class="text-center col-md-12 mb-3">
                                    <button type="submit" name="updateUserBtn" class="col-md-12 btn btn-primary">Update Account Details</button>
                                </div>
                            </form>
                        </div>
                        <!-- Pickup Address -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('partials/footer.php'); ?>

<script>

    document.addEventListener("DOMContentLoaded", function() {
        var passwordInput = document.getElementById("passw");
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