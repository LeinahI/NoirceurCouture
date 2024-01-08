<?php include('../partials/__header.php');
if (isset($_SESSION['auth'])) {
    $_SESSION['Errormsg'] = "You're already Logged in";
    header("Location:index.php");
    exit();
    /* Alert popup will show at index.php */
} ?>

<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <?php
                if (isset($_SESSION['Errormsg'])) {
                ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fa-solid fa-triangle-exclamation" style="color: #58151C;"></i>
                        <?= $_SESSION['Errormsg']; ?>.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php
                    /* Alert popup will show here */
                    unset($_SESSION['Errormsg']);
                }
                ?>
                <div class="card bg-main">
                    <div class="card-header text-center">
                        <h4>Seller Registration</h4>
                    </div>
                    <div class="card-body">
                        <form action="../models/authcode.php" method="POST">
                            <div class="container-fluid">
                                <div class="row">
                                    <!-- Fname and Lname start -->
                                    <div class="form-floating col-md-6 ps-0 mb-3">
                                        <input type="text" class="form-control" id="user_fname" name="firstName" required placeholder="name@example.com">
                                        <label for="floatingInput">First Name</label>
                                    </div>
                                    <div class="form-floating mb-3 col-md-6 ps-0 mb-3">
                                        <input type="text" class="form-control" id="user_lname" name="lastName" required placeholder="name@example.com">
                                        <label for="floatingInput">Last Name</label>
                                    </div>
                                    <!-- Fname and Lname end -->

                                    <!-- Email and Number start -->
                                    <div class="form-floating mb-3 col-md-6 ps-0 mb-3">
                                        <input type="email" class="form-control" id="user_email" name="email" required placeholder="name@example.com">
                                        <label for="floatingInput">Email address</label>
                                    </div>
                                    <div class="form-floating mb-3 col-md-6 ps-0 mb-3">
                                        <input type="number" class="form-control" id="user_email" name="phoneNumber" required placeholder="0945">
                                        <label for="floatingInput">Phone Number</label>
                                    </div>
                                    <!-- Email and Number end -->

                                    <!-- Username start -->
                                    <div class="form-floating col-md-12 ps-0 mb-3">
                                        <input type="text" class="form-control" id="user_fname" name="username" required placeholder="name@example.com">
                                        <label for="floatingInput">Username</label>
                                    </div>
                                    <!-- Username end -->

                                    <!-- Pass and CPass start -->
                                    <div class="form-floating mb-3 col-md-6 ps-0 mb-3">
                                        <input type="password" class="form-control" id="user_password" name="userPassword" required placeholder="Password">
                                        <label for="floatingPassword">Password</label>
                                    </div>
                                    <div class="form-floating mb-3 col-md-6 ps-0 mb-3">
                                        <input type="password" class="form-control" id="user_cpassword" name="userConfirmPassword" required placeholder="Password">
                                        <label for="floatingPassword">Confirm Password</label>
                                    </div>
                                    <!-- Pass and CPass end -->

                                    <!-- Business Type -->
                                    <div class="mb-3">
                                        <div>
                                            <h4>Seller Type</h4>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" id="individualRadio" name="sellerType" value="individual" checked required>
                                            <label class="form-check-label" for="individualRadio">Individual</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" id="businessRadio" name="sellerType" value="business" required>
                                            <label class="form-check-label" for="businessRadio">Business</label>
                                        </div>
                                    </div>

                                    <div class="text-center mb-3 ps-0 mb-3">
                                        <button type="submit" name="sellerRegisterBtn" class="btn btn-primary col-md-12">Register</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div>
    <?php include('../views/footer.php'); ?>
</div>

<?php
include('../partials/__footer.php');
?>