<?php include('includes/header.php');
if (isset($_SESSION['auth'])) {
    $_SESSION['Errormsg'] = "You're already Logged in";
    header("Location:index.php");
    exit();
    /* Alert popup will show at index.php */
} ?>

<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
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
                <div class="card">
                    <div class="card-header text-center">
                        <h4>Log in</h4>
                    </div>
                    <div class="card-body">
                        <form action="authcode.php" method="POST">
                            <div class="container-fluid">
                                <div class="row">
                                    <!-- Fname and Lname start -->
                                    <div class="form-floating mb-3 col-md-12 ps-0">
                                        <input type="text" class="form-control" id="login_input" name="loginInput" required placeholder="name@example.com">
                                        <label for="floatingInput">Username / Email / Phone Number</label>
                                    </div>

                                    <div class="form-floating mb-3 col-md-12 ps-0">
                                        <input type="password" class="form-control" id="password_input" name="loginPasswordInput" required placeholder="Password">
                                        <label for="floatingPassword">Password</label>
                                    </div>
                                    <!-- Pass and CPass end -->

                                    <div class="text-center mb-3 ps-0">
                                        <button type="submit" name="loginBtn" class="btn btn-primary col-md-12">Log In</button>
                                    </div>

                                    <div class="text-center ps-0">
                                        <h6>New to Noirceur Couture? <a href="register.php">Register</a></h6>
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

<div class="mt-5">
    <?php include('ftr.php'); ?>
</div>

<?php
include('includes/footer.php');
?>