<?php include('../partials/__header.php');
?>
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

    /* Responsive layout adjustments for 320px width */
    @media (max-width: 480px) {
        .col-3 {
            display: none;
        }
    }
</style>
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <?php include('../partials/sessionMessage.php') ?>
            <div class="text-center">
                <p>Account Registration</p>
                <p>Please fill in all fields</p>
            </div>
            <form method="POST" action="../models/authcode.php">
                <table class="table">
                    <tbody>
                        <tr>
                            <td class="col-3 bg-tertiary py-3 align-middle">
                                <p class="text-end">Name</p>
                            </td>
                            <td class="col-9 bg-main py-3">
                                <div class="col-md-12 row gy-2">
                                    <div class="form-floating col-lg-6 col-sm-12">
                                        <input type="text" class="form-control" id="user_fname" name="firstName" required placeholder="fname">
                                        <label for="floatingInput" class="ms-2 text-dark-4">First Name</label>
                                    </div>
                                    <div class="form-floating col-lg-6 col-sm-12 ">
                                        <input type="text" class="form-control" id="user_lname" name="lastName" required placeholder="lname">
                                        <label for="floatingInput" class="ms-2 text-dark-4">Last Name</label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="col-3 bg-tertiary py-3 align-middle">
                                <p class="text-end">E-mail Address</p>
                            </td>
                            <td class="col-9 bg-main py-3">
                                <div class="col-md-12 row">
                                    <div class="form-floating">
                                        <input type="email" class="form-control" id="user_email" name="email" required placeholder="name@example.com">
                                        <label for="floatingInput" class="ms-2 text-dark-4">Email address</label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="col-3 bg-tertiary py-3 align-middle">
                                <p class="text-end">Phone Number</p>
                            </td>
                            <td class="col-9 bg-main py-3">
                                <div class="col-md-12 row">
                                    <div class="form-floating">
                                        <input type="number" class="form-control" id="user_phone" name="phoneNumber" required placeholder="0945" onkeypress="inpNum(event)">
                                        <label for="floatingInput" class="ms-2 text-dark-4">Phone Number</label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="col-3 bg-tertiary py-3 align-middle">
                                <p class="text-end">Username</p>
                            </td>
                            <td class="col-9 bg-main py-3">
                                <div class="col-md-12 row">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="user_uname" name="username" required placeholder="name@example.com">
                                        <label for="floatingInput" class="ms-2 text-dark-4">Username</label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="col-3 bg-tertiary py-3 align-middle">
                                <p class="text-end">Password</p>
                            </td>
                            <td class="col-9 bg-main py-3">
                                <div class="col-md-12 row gy-2">
                                    <div class="input-group">
                                        <div class="form-floating">
                                            <input type="password" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*\W).{8,30}$" class="form-control" id="user_password" name="userPassword" required placeholder="Password">
                                            <label for="floatingPassword" class="text-dark-4">Password</label>
                                        </div>
                                        <span class="input-group-text" id="togglePass"><i class="bi bi-eye"></i></span>
                                    </div>

                                    <div class="input-group">
                                        <div class="form-floating">
                                            <input type="password" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*\W).{8,30}$" class="form-control" id="user_cpassword" name="userConfirmPassword" required placeholder="Password">
                                            <label for="floatingPassword" class="text-dark-4">Confirm Password</label>
                                        </div>
                                        <span class="input-group-text" id="toggleCPass"><i class="bi bi-eye"></i></span>
                                    </div>
                                    <small class="mb-0 text-dark-4">1 lowercase, 1 uppercase, 1 numeric, 1 symbol. Min: 8, Max: 30 characters is required.
                                    </small>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div>
                    <div class="text-center mb-3">
                        <button type="submit" name="userRegisterBtn" class="btn btn-main col-md-12">Register</button>
                    </div>
                </div>
            </form>
            <div>
                <div class="NleHE1 ps-0">
                    <div class="rEVZJ2"></div>
                    <span class="EMof35">or</span>
                    <div class="rEVZJ2"></div>
                </div>
                <div class="text-center ps-0">
                    <h6>Have an account? <a href="login.php" class="text-dark-4">Log in</a></h6>
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
            eyeIcon.toggleClass("bi bi-eye");
            eyeIcon.toggleClass("bi bi-eye-slash");
        });

        toggleCPasswordBtn.on("click", function() {
            // Toggle the password input type
            CpasswordInput.attr("type", function(index, attr) {
                return attr === "password" ? "text" : "password";
            });

            // Toggle the eye icon class
            var eyeIcon = toggleCPasswordBtn.find("i");
            eyeIcon.toggleClass("bi bi-eye");
            eyeIcon.toggleClass("bi bi-eye-slash");
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