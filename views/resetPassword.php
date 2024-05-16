<?php include('../partials/__header.php');
if (isset($_SESSION['auth'])) {
    $_SESSION['Errormsg'] = "You're already Logged in";
    header("Location:index.php");
    exit();
    /* Alert popup will show at index.php */
}
?>

<div class="d-flex align-items-center justify-content-center" style="min-height: 600px">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <?php include('../partials/sessionMessage.php') ?>
                <div class="card bg-tertiary">
                    <div class="card-header text-center">
                        <h4>Reset Your Password</h4>
                    </div>
                    <div class="card-body">
                        <form action="../models/authcode.php" method="POST">
                            <div class="container-fluid">
                                <div class="row">

                                    <?php if (isset($_GET['tkn']) && !empty($_GET['tkn'])) {
                                        $token = $_GET['tkn'];

                                        $selectQuery = "SELECT * FROM users WHERE user_general_token = '$token'";
                                        $result_check_acti_code = mysqli_query($con, $selectQuery);

                                        if (mysqli_num_rows($result_check_acti_code) > 0) {
                                    ?>
                                            <input type="hidden" name="tkn" value="<?= $token ?>">
                                            <div class="text-center">
                                                <p>Create a new password. Ensure it differs from the previously used password.</p>
                                            </div>
                                        <?php
                                        } else {
                                            header("Location: ../views/login.php");
                                            $_SESSION['Errormsg'] = "Token not found";
                                            exit; // Stop further execution
                                        }
                                        ?>
                                    <?php
                                    } elseif (empty($_GET['tkn'])) {
                                        header("Location: ../views/login.php");
                                        $_SESSION['Errormsg'] = "Token not not found";
                                        exit; // Stop further execution
                                    }
                                    ?>

                                    <div class="input-group ps-0 mb-3">
                                        <div class="form-floating">
                                            <input type="password" class="form-control" id="newpassword_input" name="NewPasswordInput" required placeholder="New Password">
                                            <label for="code1">New Password</label>
                                        </div>
                                        <span class="input-group-text" id="newtogglePassword"><i class="fa-regular fa-eye"></i></span>
                                    </div>

                                    <div class="input-group ps-0 mb-3">
                                        <div class="form-floating">
                                            <input type="password" class="form-control" id="confirmpassword_input" name="ConfirmPasswordInput" required placeholder="Confirm Password">
                                            <label for="code1">Confirm Password</label>
                                        </div>
                                        <span class="input-group-text" id="confirmtogglePassword"><i class="fa-regular fa-eye"></i></span>
                                    </div>

                                    <div class="text-center ps-0">
                                        <button type="submit" name="resetPassBtn" class="btn btn-main col-md-12">Reset Password</button>
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
        var newpasswordInput = $("#newpassword_input");
        var newtogglePasswordBtn = $("#newtogglePassword");
        var confirmpasswordInput = $("#confirmpassword_input");
        var confirmtogglePasswordBtn = $("#confirmtogglePassword");

        newtogglePasswordBtn.on("click", function() {
            // Toggle the password input type
            newpasswordInput.attr("type", function(index, attr) {
                return attr === "password" ? "text" : "password";
            });

            // Toggle the eye icon class
            var eyeIcon1 = newtogglePasswordBtn.find("i");
            eyeIcon1.toggleClass("fa-eye fa-eye-slash");
        });
        confirmtogglePasswordBtn.on("click", function() {
            // Toggle the password input type
            confirmpasswordInput.attr("type", function(index, attr) {
                return attr === "password" ? "text" : "password";
            });

            // Toggle the eye icon class
            var eyeIcon2 = confirmtogglePasswordBtn.find("i");
            eyeIcon2.toggleClass("fa-eye fa-eye-slash");
        });
    });
</script>