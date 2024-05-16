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

    @media (max-width: 991px) {
        .deleteContainer {
            position: relative !important;
        }

        .profileNotice {
            display: none !important;
        }
    }

    @media (max-width: 767px) {
        .d-flex {
            display: block !important;
        }

        .profile {
            margin-top: 1rem;
        }

        .profileNotice {
            display: inherit !important;
        }
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

                    $hiddenEmail = hideEmailCharacters($data['user_email']);
                    $hiddenPhoneNumber = maskPhoneNumber($data['user_phone']);

                    $userId = $data['user_ID'];
                ?>
                    <div class="card border rounded-3 bg-tertiary">
                        <div class="card-header">
                            <h5 class="card-title">My Profile</h5>
                        </div>
                        <div class="card-body">
                            <form action="../models/profileUpdate.php" method="POST" enctype="multipart/form-data">
                                <div class="container d-flex">
                                    <div class="col-md-8 col-12">
                                        <input type="hidden" name="userID" value="<?= $userId; ?>">
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
                                            <div class="col">
                                                <p>Email: <span><?= $hiddenEmail;  ?></span> <a class="text-dark-4" href="changeEmailAddress.php">Change</a></p>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <p>Phone number: <span><?= $hiddenPhoneNumber; ?> <a class="text-dark-4" href="changePhoneNumber.php">Change</a></span></p>
                                            </div>
                                        </div>

                                        <!-- Email and Number end -->

                                        <div class="row">
                                            <div class="text-center ps-0">
                                                <button type="submit" name="userUpdateAccBtn" class="btn btn-main col-md-12">Update Credentials</button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Profile Picture -->
                                    <div class="profile col-md-4 col-12 text-center">
                                        <label for="profileUpload">
                                            <div class="profile-pic user-select-none" style="background-image: url('../assets/uploads/userProfile/<?= ($profilePic) ? $profilePic : 'defaultProfile.jpg' ?>')">
                                                <span>Change Image</span>
                                            </div>
                                        </label>
                                        <div>
                                            <input type="hidden" name="oldImage" value="<?= $profilePic; ?>">
                                            <input class="profileUp" type="file" name="profileUpload" accept=".jpg, .jpeg, .png" id="profileUpload" onchange="displayImage(this)">
                                        </div>
                                        <div>
                                            <p class="profileNotice">File size: maximum 5 MB <br>
                                                File extension: .JPEG, .PNG
                                            </p>
                                        </div>
                                        <?php
                                        if ($profilePic > 0) {
                                        ?>

                                            <div class="deleteContainer position-absolute bottom-0 start-0 col-12">
                                                <a href="#" class="btn btn-tertiary col-12" data-bs-toggle="modal" data-bs-target="#deleteProfileModal<?= $userId ?>">Delete Profile Image</a>
                                                <div class="modal fade" id="deleteProfileModal<?= $userId ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content bg-main">
                                                            <form action="../models/authcode.php" method="POST">
                                                                <div class="modal-body fs-5">
                                                                    <input type="hidden" name="deleteAddruserID" value="<?= $userid ?>">
                                                                    Are you sure you want to delete your Profile Image?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-tertiary" data-bs-dismiss="modal">Close</button>
                                                                    <button name="profileDeleteBtn" class="btn btn-main">Confirm Delete</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        <?php
                                        }
                                        ?>
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
</script>

<div style="margin-top:8.5%;">
    <?php include('footer.php'); ?>
</div>

<?php include('../partials/__footer.php'); ?>