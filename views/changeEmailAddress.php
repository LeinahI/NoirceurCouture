<?php include('../partials/__header.php');
include('../middleware/userMW.php');
?>

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
                ?>
                    <div class="card border rounded-3 bg-tertiary">
                        <div class="card-header">
                            <h5 class="card-title">Change Email Address
                                <span class="float-end">
                                    <a href="myAccount.php" class="btn btn-main">
                                        Go Back
                                    </a>
                                </span>
                            </h5>
                        </div>
                        <div class="card-body">
                            <form action="../models/profileUpdate.php" method="POST" enctype="multipart/form-data">
                                <div class="container-fluid d-flex">
                                    <div class="col-md-12">
                                        <input type="hidden" name="userID" value="<?= $data['user_ID'] ?>">
                                        <!-- Username start -->
                                        <div class="row">
                                            <div class="form-floating col-md-12 ps-0 mb-3">
                                                <input type="email" class="form-control" id="user_phone" name="oldEmail" required placeholder="0945" onkeypress="inpNum(event)">
                                                <label for="floatingInput">Current Email Address</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-floating col-md-12 ps-0 mb-3">
                                                <input type="email" class="form-control" id="user_phone" name="newEmail" required placeholder="0945" onkeypress="inpNum(event)">
                                                <label for="floatingInput">New Email Address</label>
                                            </div>
                                        </div>
                                        <!-- Username end -->

                                        <div class="row">
                                            <div class="text-center ps-0">
                                                <button type="submit" name="userChangeEmail" class="btn btn-main col-md-12">Submit</button>
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

<div style="margin-top:6%;">
    <?php include('footer.php'); ?>
</div>

<?php include('../partials/__footer.php'); ?>