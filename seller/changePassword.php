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
                    <h2 class="text-white">Change Seller Password
                        <a href="account-details.php" class="btn btn-light float-end ms-2">Go Back</a>
                    </h2>
                </div>
                <div class="card-body">
                    <form action="./models/user-auth.php" method="POST" enctype="multipart/form-data">
                        <div class="container-fluid">
                            <div class="col-md-12">
                                <?php
                                $categUser = getByCategAndUserId($_SESSION['auth_user']['user_ID']);

                                $data = mysqli_fetch_array($categUser);

                                $id = isset($data['user_ID']) ? $data['user_ID'] : '';
                                ?>
                                <input type="hidden" name="userID" value="<?= $id; ?>">

                                <div class="form-floating col-md-12 mb-3">
                                    <input type="password" class="form-control ps-3" value="" id="oldpass" name="oldpass" required placeholder="old pass">
                                    <label for="floatingPassword" class="ps-3">Old Password</label>
                                    <span class="input-group-text border-0 position-absolute end-3 top-50 translate-middle-y cursor-pointer" id="toggleOldPass"><i class="fa-regular fa-eye"></i></span>
                                </div>

                                <div class="form-floating col-md-12 mb-3">
                                    <input type="password" class="form-control ps-3" value="" id="newpass" name="newpass" required placeholder="new pass">
                                    <label for="floatingPassword" class="ps-3">New Password</label>
                                    <span class="input-group-text border-0 position-absolute end-3 top-50 translate-middle-y cursor-pointer" id="toggleNewPass"><i class="fa-regular fa-eye"></i></span>
                                </div>

                                <div class="form-floating col-md-12 mb-3">
                                    <input type="password" class="form-control ps-3" value="" id="cnewpass" name="cnewpass" required placeholder="new pass">
                                    <label for="floatingPassword" class="ps-3">Confirm New Password</label>
                                    <span class="input-group-text border-0 position-absolute end-3 top-50 translate-middle-y cursor-pointer" id="toggleCNewPass"><i class="fa-regular fa-eye"></i></span>
                                </div>

                                <div class="text-center col-md-12 mb-3">
                                    <button type="submit" name="changeSellerPassBtn" class="col-md-12 btn btn-primary">Confirm Change Password</button>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var passwordInputA = document.getElementById("oldpass");
        var passwordInputB = document.getElementById("newpass");
        var passwordInputC = document.getElementById("cnewpass");

        var togglePasswordBtnA = document.getElementById("toggleOldPass");
        var togglePasswordBtnB = document.getElementById("toggleNewPass");
        var togglePasswordBtnC = document.getElementById("toggleCNewPass");

        togglePasswordBtnA.addEventListener("click", function() {
            // Toggle the password input type
            passwordInputA.type = passwordInputA.type === "password" ? "text" : "password";

            // Toggle the eye icon class
            var eyeIconA = togglePasswordBtnA.querySelector("i");
            eyeIconA.classList.toggle("fa-eye");
            eyeIconA.classList.toggle("fa-eye-slash");
        });

        togglePasswordBtnB.addEventListener("click", function() {
            // Toggle the password input type
            passwordInputB.type = passwordInputB.type === "password" ? "text" : "password";

            // Toggle the eye icon class
            var eyeIconB = togglePasswordBtnB.querySelector("i");
            eyeIconB.classList.toggle("fa-eye");
            eyeIconB.classList.toggle("fa-eye-slash");
        });

        togglePasswordBtnC.addEventListener("click", function() {
            // Toggle the password input type
            passwordInputC.type = passwordInputC.type === "password" ? "text" : "password";

            // Toggle the eye icon class
            var eyeIconC = togglePasswordBtnC.querySelector("i");
            eyeIconC.classList.toggle("fa-eye");
            eyeIconC.classList.toggle("fa-eye-slash");
        });
    });
</script>

<?php include('partials/footer.php'); ?>