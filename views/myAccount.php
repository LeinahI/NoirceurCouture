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
                    $profilePic = $data['user_profile_image'];
                ?>
                    <div class="card border rounded-3 shadow bg-main">
                        <div class="card-header">
                            <h5 class="card-title">My Profile</h5>
                        </div>
                        <div class="card-body">
                            <form action="../models/profileUpdate.php" method="POST" enctype="multipart/form-data">
                                <div class="container-fluid d-flex">
                                    <div class="col-md-8">
                                        <input type="hidden" name="userID" value="<?= $data['user_ID'] ?>">
                                        <!-- Username start -->
                                        <div class="row">
                                            <div class="form-floating col-md-12 ps-0 mb-3">
                                                <input type="text" class="form-control" id="user_fname" value="<?= $data['user_username'] ?>" readonly placeholder="nam">
                                                <label for="floatingInput">Username</label>
                                            </div>
                                        </div>
                                        <!-- Username end -->

                                        <!-- Fname and Lname start -->
                                        <div class="row">
                                            <div class="form-floating col-md-6 ps-0 mb-3">
                                                <input type="text" class="form-control" id="user_fname" name="firstName" value="<?= $data['user_firstName'] ?>" required placeholder="nam">
                                                <label for="floatingInput">First Name</label>
                                            </div>
                                            <div class="form-floating col-md-6 ps-0 mb-3">
                                                <input type="text" class="form-control" id="user_lname" name="lastName" value="<?= $data['user_lastName'] ?>" required placeholder="n">
                                                <label for="floatingInput">Last Name</label>
                                            </div>
                                        </div>
                                        <!-- Fname and Lname end -->

                                        <!-- Email and Number start -->
                                        <div class="row">
                                            <div class="form-floating col-md-6 ps-0 mb-3">
                                                <input type="email" class="form-control" id="user_email" name="email" value="<?= $data['user_email'] ?>" required placeholder="name@example.com">
                                                <label for="floatingInput">Email address</label>
                                            </div>
                                            <div class="form-floating col-md-6 ps-0 mb-3">
                                                <input type="number" class="form-control" id="user_email" name="phoneNumber" value="<?= $data['user_phone'] ?>" required placeholder="09">
                                                <label for="floatingInput">Phone Number</label>
                                            </div>
                                        </div>
                                        <!-- Email and Number end -->

                                        <!-- Pass and CPass start -->
                                        <div class="row">
                                            <div class="input-group ps-0 mb-3">
                                                <div class="form-floating">
                                                    <input type="password" class="form-control" id="old_password" name="userPassword" value="<?= $data['user_password'] ?>" required placeholder="Password">
                                                    <label for="code1">Password</label>
                                                </div>
                                                <span class="input-group-text" id="togglePassword"><i class="fa-regular fa-eye"></i></span>
                                            </div>
                                        </div>
                                        <!-- Pass and CPass end -->

                                        <div class="row">
                                            <div class="text-center ps-0">
                                                <button type="submit" name="userUpdateAccBtn" class="btn btn-accent col-md-12">Update Credentials</button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Profile Picture -->
                                    <div class="col-md-4 text-center">
                                        <label for="profileUpload">
                                            <div class="profile-pic user-select-none" style="background-image: url('../assets/uploads/userProfile/<?= ($profilePic) ? $profilePic : 'defaultProfile.jpg' ?>')">
                                                <i class="fa-solid fa-camera"></i>
                                                <span>Change Image</span>
                                            </div>
                                        </label>
                                        <div>
                                            <input type="hidden" name="oldImage" value="<?= $profilePic; ?>">
                                            <input class="profileUp" type="file" name="profileUpload" accept=".jpg, .jpeg, .png" id="profileUpload" onchange="displayImage(this)">
                                        </div>
                                        <p>File size: maximum 5 MB <br>
                                            File extension: .JPEG, .PNG</p>
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
    function displayImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                var imagePreview = document.querySelector('.profile-pic');
                imagePreview.style.backgroundImage = 'url(' + e.target.result + ')';
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
        var passwordInput = document.getElementById("old_password");
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

<div style="margin-top:5%;">
    <?php include('footer.php'); ?>
</div>

<?php include('../partials/__footer.php'); ?>