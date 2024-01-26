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
                <div class="card bg-main">
                    <div class="card-header text-center">
                        <h4>Log in</h4>
                    </div>
                    <div class="card-body">
                        <form action="../models/authcode.php" method="POST">
                            <div class="container-fluid">
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
                                        <span class="input-group-text" id="togglePassword"><i class="fa-regular fa-eye"></i></span>
                                    </div>
                                    <!-- Pass and CPass end -->

                                    <div class="text-center mb-3 ps-0">
                                        <button type="submit" name="loginBtn" class="btn btn-primary col-md-12">Log In</button>
                                    </div>

                                    <div class="text-center ps-0">
                                        <h6>New to Noirceur Couture? <a href="register.php" class="text-accent">Register</a></h6>
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