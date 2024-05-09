<?php include('partials/header.php');
include('../middleware/sellerMW.php');
include('../models/checkSession.php');
include('models/check-seller-addr.php');
checkUserValidityAndRedirect($_SESSION['auth_user']['user_ID'] ?? null);
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary">
                    <h2 class="text-white">Request Account Deletion
                    </h2>
                </div>
                <?php
                $categUser = getByCategAndUserId($_SESSION['auth_user']['user_ID']);
                $data = mysqli_fetch_array($categUser);
                ?>

                <div class="card-body">
                    <form action="models/reqDeleteAccSeller.php" method="POST" enctype="multipart/form-data">
                        <div class="container-fluid">
                            <div class="col-md-12">

                                <input type="hidden" name="userID" value="<?= $data['user_ID'] ?>">
                                <input type="hidden" name="fName" value="<?= $data['user_firstName'] ?>">
                                <input type="hidden" name="lName" value="<?= $data['user_lastName'] ?>">
                                <input type="hidden" name="email" value="<?= $data['user_email'] ?>">
                                <input type="hidden" name="phone" value="<?= $data['user_phone'] ?>">
                                <input type="hidden" name="username" value="<?= $data['user_username'] ?>">
                                <input type="hidden" name="pass" value="<?= $data['user_password'] ?>">
                                <input type="hidden" name="role" value="<?= $data['user_role'] ?>">
                                <input type="hidden" name="categID" value="<?= $data['category_id'] ?>">
                                <input type="hidden" name="categName" value="<?= $data['category_name'] ?>">
                                
                                <div>
                                    <p class="fs-5 fw-bold">Please select a reason for account deletion.</p>
                                </div>
                                <div class="form-floating col-md-12 mb-3">
                                    <select name="reasonDelAccList" class="form-select form-select-md ps-2" aria-label="Large select example" required>
                                        <option selected disabled></option>
                                        <option value="Retirement">I am no longer wanted to continue my business operations</option>
                                        <option value="Marketplace Dissatisfaction">I am unsatisfied of Noirceur Couture features, policies, & services</option>
                                        <option value="Lack of Marketing Support">I feel unsupported in terms of marketing and promotional efforts from Noirceur Couture</option>
                                        <option value="Others">Others</option>
                                    </select>
                                    <label for="floatingInput">Reason</label>
                                </div>
                                <div class="form-floating col-md-12 mb-3">
                                    <textarea class="form-control ps-3" placeholder="d" id="metaDescription_input" name="reasonDelAccMoreDetails" style="height:120px; min-height: 57px; max-height: 100px;" rows="3"></textarea>
                                    <label for="floatingPassword" class="ps-3">Please Provide More Details</label>
                                </div>

                                <!-- Submit Request -->
                                <div class="text-center col-md-12 mb-3">
                                    <button type="submit" name="SubmitDelAccReqSeller" class="col-md-12 btn btn-primary">Submit Request</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('partials/footer.php'); ?>