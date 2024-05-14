<?php include('../partials/__header.php');
include('../middleware/userMW.php');
?>

<style>
    .profile-pic {
        border-radius: 50%;
        height: 150px;
        width: 150px;
        background-size: cover;
        background-position: center;
        background-blend-mode: multiply;
        vertical-align: middle;
        text-align: center;
        color: transparent;
        transition: all .3s ease;
        text-decoration: none;
        cursor: pointer;
    }

    .profile-pic:hover {
        background-color: rgba(0, 0, 0, .5);
        z-index: 10000;
        color: #fff;
        transition: all .3s ease;
        text-decoration: none;
    }

    .profile-pic span {
        display: inline-block;
        padding-top: 4em;
        padding-bottom: 3em;
    }

    div input[type="file"] {
        display: none;
        cursor: pointer;
    }
</style>

<div class="container mt-5">
    <?php include('../partials/sessionMessage.php') ?>
    <div class="row">
        <?php include('../partials/sidebar.php') ?>
        <div class="col-md-9">
            <div>
                <?php
                $user = getUserDetails();
                // Group items by category_name

                if (mysqli_num_rows($user) > 0) {
                    $data = mysqli_fetch_array($user);
                ?>
                    <div class="card border rounded-3 shadow bg-main">
                        <div class="card-header">
                            <h5 class="card-title">Change Password</h5>
                        </div>
                        <div class="card-body">
                            <form action="../models/profileUpdate.php" method="POST" enctype="multipart/form-data">
                                <div class="container-fluid d-flex">
                                    <div class="col-md-12">
                                        <input type="hidden" name="userID" value="<?= $data['user_ID'] ?>">

                                        <!-- Pass and CPass start -->
                                        <div class="row">
                                            <div class="input-group ps-0 mb-3">
                                                <div class="form-floating">
                                                    <input type="password" class="form-control" id="oldpass" name="oldpass" value="" required placeholder="Password">
                                                    <label for="code1">Old Password</label>
                                                </div>
                                                <span class="input-group-text" id="toggleOldPass"><i class="fa-regular fa-eye"></i></span>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="input-group ps-0 mb-3">
                                                <div class="form-floating">
                                                    <input type="password" class="form-control" id="newpass" name="newpass" value="" required placeholder="Password">
                                                    <label for="code1">New Password</label>
                                                </div>
                                                <span class="input-group-text" id="toggleNewPass"><i class="fa-regular fa-eye"></i></span>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="input-group ps-0 mb-3">
                                                <div class="form-floating">
                                                    <input type="password" class="form-control" id="cnewpass" name="cnewpass" value="" required placeholder="Password">
                                                    <label for="code1">Confirm New Password</label>
                                                </div>
                                                <span class="input-group-text" id="toggleCNewPass"><i class="fa-regular fa-eye"></i></span>
                                            </div>
                                        </div>
                                        <!-- Pass and CPass end -->

                                        <div class="row">
                                            <div class="text-center ps-0">
                                                <button type="submit" name="changePasswordBtn" class="btn btn-main col-md-12">Confirm Change Password</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php
                }
                ?>
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

<div style="margin-top:6%;">
    <?php include('footer.php'); ?>
</div>

<?php include('../partials/__footer.php'); ?>