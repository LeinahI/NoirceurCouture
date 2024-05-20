<?php include('../partials/__header.php');
if (isset($_SESSION['auth'])) {
    $_SESSION['Errormsg'] = "You're already Logged in";
    header("Location:index.php");
    exit();
    /* Alert popup will show at index.php */
} ?>
<style>
    .rEVZJ2 {
        background-color: #CBC3BE;
        flex: 1;
        height: 1px;
        width: 100%;
    }

    .EMof35 {
        color: #212529;
        font-size: .75rem;
        padding: 0 16px;
        text-transform: uppercase;
    }

    .NleHE1 {
        padding-bottom: 14px;
        align-items: center;
        display: flex;
    }
</style>
<div class="d-flex align-items-center justify-content-center" style="min-height: 600px">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <?php include('../partials/sessionMessage.php') ?>
                <div class="card bg-main border-0">
                    <div class="card-body">
                        <form action="../models/authcode.php" method="POST">
                            <div class="container-fluid">
                                <div class="text-center mt-2 mb-4">
                                    <img src="../assets/images/logo/NoirceurCouture_BK.png" height="40" alt="Logo">
                                    <p class="fs-6 mt-1">Welcome Back</p>
                                </div>
                                <div class="row">
                                    <!-- Fname and Lname start -->
                                    <div class="form-floating mb-3 col-md-12 ps-0">
                                        <input type="text" class="form-control" id="login_input" name="loginInput" required placeholder="name@example.com">
                                        <label for="floatingInput">Username / Email / Phone Number</label>
                                    </div>

                                    <div class="input-group ps-0 mb-3">
                                        <div class="form-floating">
                                            <input type="password" class="form-control" id="password_input" name="loginPasswordInput" required placeholder="Password">
                                            <label for="code1">Password</label>
                                        </div>
                                        <span class="input-group-text" id="togglePassword"><i class="bi bi-eye"></i></span>
                                    </div>
                                    <!-- Pass and CPass end -->

                                    <div class="text-center ps-0">
                                        <button type="submit" name="loginBtn" class="btn mb-1 btn-main col-md-12">Log In</button>
                                    </div>
                                    <a href="reset.php" class="mb-3 ps-0 text-dark-4 text-decoration-none w-auto">Forgot Password</a>

                                    <div class="NleHE1 ps-0">
                                        <div class="rEVZJ2"></div>
                                        <span class="EMof35">or</span>
                                        <div class="rEVZJ2"></div>
                                    </div>

                                    <div class="text-center ps-0">
                                        <h6>New to Noirceur Couture? <a href="register.php" class="text-dark-4">Create a new account</a></h6>
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
    <?php include('footer.php'); ?>
</div>

<?php
include('../partials/__footer.php');
?>

<script>
    /* Toggle password */
    $(document).ready(function() {
        var passwordInput = $("#password_input");
        var togglePasswordBtn = $("#togglePassword");

        togglePasswordBtn.on("click", function() {
            // Toggle the password input type
            passwordInput.attr("type", function(index, attr) {
                return attr === "password" ? "text" : "password";
            });

            // Toggle the eye icon class
            var eyeIcon = togglePasswordBtn.find("i");
            eyeIcon.toggleClass("bi bi-eye");
            eyeIcon.toggleClass("bi bi-eye-slash");
        });
    });

    //Save login_input text
    $(document).ready(function() {
        var loginInput = $('#login_input');

        // Retrieve and set the input text on page load
        var savedLoginInput = sessionStorage.getItem('loginInput');
        if (savedLoginInput) {
            loginInput.val(savedLoginInput);
        }

        // Save input text on every change
        loginInput.on('input', function() {
            sessionStorage.setItem('loginInput', loginInput.val());
        });
    });

    //Save password_input text
    $(document).ready(function() {
        var loginInput = $('#password_input');

        // Retrieve and set the input text on page load
        var savedLoginInput = sessionStorage.getItem('loginPasswordInput');
        if (savedLoginInput) {
            loginInput.val(savedLoginInput);
        }

        // Save input text on every change
        loginInput.on('input', function() {
            sessionStorage.setItem('loginPasswordInput', loginInput.val());
        });
    });
</script>