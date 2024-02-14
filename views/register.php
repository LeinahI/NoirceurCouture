<?php include('../partials/__header.php');
?>

<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <?php include('../partials/sessionMessage.php') ?>
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
                        <h4>Registration Form</h4>
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
                                        <input type="number" class="form-control" id="user_phone" name="phoneNumber" required placeholder="0945" onkeypress="inpNum(event)">
                                        <label for="floatingInput">Phone Number</label>
                                    </div>
                                    <!-- Email and Number end -->

                                    <!-- Username start -->
                                    <div class="form-floating col-md-12 ps-0 mb-3">
                                        <input type="text" class="form-control" id="user_uname" name="username" required placeholder="name@example.com">
                                        <label for="floatingInput">Username</label>
                                    </div>
                                    <!-- Username end -->

                                    <!-- Pass and CPass start -->
                                    <div class="input-group mb-3 ps-0 mb-3">
                                        <div class="form-floating">
                                            <input type="password" class="form-control" id="user_password" name="userPassword" required placeholder="Password">
                                            <label for="floatingPassword">Password</label>
                                        </div>
                                        <span class="input-group-text" id="togglePass"><i class="fa-regular fa-eye"></i></span>
                                    </div>

                                    <div class="input-group mb-3 col-md-6 ps-0 mb-3">
                                        <div class="form-floating">
                                            <input type="password" class="form-control" id="user_cpassword" name="userConfirmPassword" required placeholder="Password">
                                            <label for="floatingPassword">Confirm Password</label>
                                        </div>
                                        <span class="input-group-text" id="toggleCPass"><i class="fa-regular fa-eye"></i></span>
                                    </div>
                                    <!-- Pass and CPass end -->

                                    <div class="text-center mb-3 ps-0 mb-3">
                                        <button type="submit" name="userRegisterBtn" class="btn btn-primary col-md-12">Register</button>
                                    </div>

                                    <div class="text-center ps-0">
                                        <h6>Have an account? <a href="login.php" class="text-accent">Log in</a></h6>
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
    <?php include('footer.php'); ?>
</div>

<?php
include('../partials/__footer.php');
?>

<script>
    /* Toggle password */
    $(document).ready(function() {
        var passwordInput = $("#user_password");
        var togglePasswordBtn = $("#togglePass");
        var CpasswordInput = $("#user_cpassword");
        var toggleCPasswordBtn = $("#toggleCPass");

        togglePasswordBtn.on("click", function() {
            // Toggle the password input type
            passwordInput.attr("type", function(index, attr) {
                return attr === "password" ? "text" : "password";
            });

            // Toggle the eye icon class
            var eyeIcon = togglePasswordBtn.find("i");
            eyeIcon.toggleClass("fa-eye fa-eye-slash");
        });

        toggleCPasswordBtn.on("click", function() {
            // Toggle the password input type
            CpasswordInput.attr("type", function(index, attr) {
                return attr === "password" ? "text" : "password";
            });

            // Toggle the eye icon class
            var eyeIcon = toggleCPasswordBtn.find("i");
            eyeIcon.toggleClass("fa-eye fa-eye-slash");
        });
    });

    /* Prevent user to write letter or symbols in phone number */
    function inpNum(e) {
        e = e || window.event;
        var charCode = (typeof e.which == "undefined") ? e.keyCode : e.which;
        var charStr = String.fromCharCode(charCode);

        // Allow only numeric characters
        if (!charStr.match(/^[0-9]+$/)) {
            e.preventDefault();
        }

        // Allow a maximum of 11 digits
        var inputValue = e.target.value || '';
        var numericValue = inputValue.replace(/[^0-9]/g, '');

        if (numericValue.length >= 11) {
            e.preventDefault();
        }

        // Apply Philippine phone number format (optional)
        if (numericValue.length === 1 && numericValue !== '0') {
            // Add '0' at the beginning if the first digit is not '0'
            e.target.value = '0' + numericValue;
        } else if (numericValue.length >= 2 && !numericValue.startsWith('09')) {
            // Ensure it starts with '09'
            e.target.value = '09' + numericValue.substring(2);
        }
    }

    //Save fname_input text
    $(document).ready(function() {
        var loginInput = $('#user_fname');

        // Retrieve and set the input text on page load
        var savedLoginInput = sessionStorage.getItem('firstName');
        if (savedLoginInput) {
            loginInput.val(savedLoginInput);
        }

        // Save input text on every change
        loginInput.on('input', function() {
            sessionStorage.setItem('firstName', loginInput.val());
        });
    });

    //Save lname_input text
    $(document).ready(function() {
        var loginInput = $('#user_lname');

        // Retrieve and set the input text on page load
        var savedLoginInput = sessionStorage.getItem('lastName');
        if (savedLoginInput) {
            loginInput.val(savedLoginInput);
        }

        // Save input text on every change
        loginInput.on('input', function() {
            sessionStorage.setItem('lastName', loginInput.val());
        });
    });

    //Save email_input text
    $(document).ready(function() {
        var loginInput = $('#user_email');

        // Retrieve and set the input text on page load
        var savedLoginInput = sessionStorage.getItem('email');
        if (savedLoginInput) {
            loginInput.val(savedLoginInput);
        }

        // Save input text on every change
        loginInput.on('input', function() {
            sessionStorage.setItem('email', loginInput.val());
        });
    });

    //Save phone_input text
    $(document).ready(function() {
        var loginInput = $('#user_phone');

        // Retrieve and set the input text on page load
        var savedLoginInput = sessionStorage.getItem('phoneNumber');
        if (savedLoginInput) {
            loginInput.val(savedLoginInput);
        }

        // Save input text on every change
        loginInput.on('input', function() {
            sessionStorage.setItem('phoneNumber', loginInput.val());
        });
    });

    //Save uname_input text
    $(document).ready(function() {
        var loginInput = $('#user_uname');

        // Retrieve and set the input text on page load
        var savedLoginInput = sessionStorage.getItem('username');
        if (savedLoginInput) {
            loginInput.val(savedLoginInput);
        }

        // Save input text on every change
        loginInput.on('input', function() {
            sessionStorage.setItem('username', loginInput.val());
        });
    });

    //Save password_input text
    $(document).ready(function() {
        var loginInput = $('#user_password');

        // Retrieve and set the input text on page load
        var savedLoginInput = sessionStorage.getItem('userPassword');
        if (savedLoginInput) {
            loginInput.val(savedLoginInput);
        }

        // Save input text on every change
        loginInput.on('input', function() {
            sessionStorage.setItem('userPassword', loginInput.val());
        });
    });

    //Save confirmpassword_input text
    $(document).ready(function() {
        var loginInput = $('#user_cpassword');

        // Retrieve and set the input text on page load
        var savedLoginInput = sessionStorage.getItem('userConfirmPassword');
        if (savedLoginInput) {
            loginInput.val(savedLoginInput);
        }

        // Save input text on every change
        loginInput.on('input', function() {
            sessionStorage.setItem('userConfirmPassword', loginInput.val());
        });
    });
</script>