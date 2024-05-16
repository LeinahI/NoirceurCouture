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
                <div class="card bg-main">
                    <div class="card-header text-center">
                        <h4>Reset Password</h4>
                    </div>
                    <div class="card-body">
                        <form action="../models/authcode.php" method="POST">
                            <div class="container-fluid">
                                <div class="row">
                                    <?php
                                    $bn = basename($_SERVER['HTTP_REFERER']);
                                    $bn_replace = str_replace($bn, "resetPassword.php", $_SERVER['HTTP_REFERER']);
                                    $resetPassUrl = $bn_replace;
                                    ?>
                                    <input type="hidden" name="resetPassUrl" value="<?= $resetPassUrl ?>">
                                    <div class="form-floating mb-3 col-md-12 ps-0">
                                        <input type="email" class="form-control" name="emailInput" required placeholder="name@example.com">
                                        <label for="floatingInput">Email</label>
                                    </div>

                                    <div class="text-center ps-0">
                                        <button type="submit" name="resetSendLink" class="btn mb-1 btn-main col-md-12">Next</button>
                                    </div>

                                    <div class="text-center ps-0">
                                        <h6>Didn't receive the code? <button type="submit" name="resendResetSendLink" class="btn btn-link text-dark-4 px-0 text-decoration-none">Send Code Again</button></h6>
                                    </div>

                                    <div class="NleHE1 ps-0">
                                        <div class="rEVZJ2"></div>
                                        <span class="EMof35">or</span>
                                        <div class="rEVZJ2"></div>
                                    </div>

                                    <div class="text-center ps-0">
                                        <h6><a href="login.php" class="btn mb-1 btn-secondary col-md-12">Go Back</a></h6>
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
            eyeIcon.toggleClass("fa-eye fa-eye-slash");
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