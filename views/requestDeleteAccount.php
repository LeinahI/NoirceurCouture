<?php
include('../partials/__header.php');
include('../middleware/userMW.php');
?>

<div class="container mt-5">
    <?php include('../partials/sessionMessage.php') ?>


    <div class="row">
        <?php include('../partials/sidebar.php') ?>
        <!-- Modal Initialize on load -->
        <div class="modal" id="onload" tabindex="-1" data-bs-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content bg-tertiary">
                    <div class="modal-header text-center">
                        <h3 class="modal-title w-100" id="exampleModalLabel">Important</h3>
                    </div>
                    <div class="modal-body">
                        <p><span class="fs-3">•</span> This account should have no ongoing purchases.</p>
                        <p><span class="fs-3">•</span> After successful deletion of this account, you will not be able to log in to a deleted account and view previous account history.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-main col-md-12" data-bs-dismiss="modal">Proceed</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div>
                <?php
                $user = getUserDetails();
                // Group items by category_name

                if (mysqli_num_rows($user) > 0) {
                    $data = mysqli_fetch_array($user);
                ?>
                    <div class="card border rounded-3 bg-tertiary">
                        <div class="card-header">
                            <h5 class="card-title">Request Account Deletion</h5>
                        </div>
                        <div class="card-body">
                            <form action="../models/reqDeleteAcc.php" method="POST">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div>
                                            <p class="fs-5">Please select a reason for account deletion.</p>
                                        </div>
                                        <input type="hidden" name="userID" value="<?= $data['user_ID'] ?>">
                                        <input type="hidden" name="fName" value="<?= $data['user_firstName'] ?>">
                                        <input type="hidden" name="lName" value="<?= $data['user_lastName'] ?>">
                                        <input type="hidden" name="email" value="<?= $data['user_email'] ?>">
                                        <input type="hidden" name="phone" value="<?= $data['user_phone'] ?>">
                                        <input type="hidden" name="username" value="<?= $data['user_username'] ?>">
                                        <input type="hidden" name="pass" value="<?= $data['user_password'] ?>">
                                        <input type="hidden" name="role" value="<?= $data['user_role'] ?>">

                                        <div class="form-floating col-md-12 ps-0 mb-2">
                                            <select name="reasonDelAccList" id="selectReason" class="form-select form-select-md" aria-label="Large select example" required>
                                                <option selected disabled></option>
                                                <option value="User Identity">I want to change my username</option>
                                                <option value="I am no longer want to use Noirceur Couture">I am no longer want to use Noirceur Couture</option>
                                                <option value="Others">Others</option>
                                            </select>
                                            <label for="floatingInput">Reason</label>
                                        </div>
                                        <div class="form-floating col-md-12 ps-0 mb-3">
                                            <textarea name="reasonDelAccMoreDetails" class="form-control" placeholder="Leave a comment here" id="floatingTextarea" style="height: 120px"></textarea>
                                            <label for="floatingInput">Please provide more details</label>
                                        </div>

                                        <div class="text-center ps-0">
                                            <button type="submit" name="SubmitDelAccReq" id="submitReq" class="btn btn-main col-md-12">Submit Request</button>
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
    window.onload = () => {
        $('#onload').modal('show');
    }
</script>

<div style="margin-top:6%;">
    <?php include('footer.php'); ?>
</div>

<?php include('../partials/__footer.php'); ?>