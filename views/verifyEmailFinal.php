<?php include('../partials/__header.php');
?>

<div class="d-flex align-items-center justify-content-center" style="min-height: 600px">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <?php include('../partials/sessionMessage.php') ?>
                <div class="card bg-main">
                    <div class="card-header text-center">
                        <h4>Verify Your Account</h4>
                    </div>
                    <div class="card-body">
                        <form action="../models/profileUpdate.php" method="POST">
                            <div class="container-fluid">
                                <div class="row">

                                    <?php if (isset($_GET['fnlv']) && !empty($_GET['fnlv'])) {
                                        $activation_code = $_GET['fnlv'];

                                        $selectQuery = "SELECT * FROM users WHERE user_general_token = '$activation_code'";
                                        $result_check_acti_code = mysqli_query($con, $selectQuery);

                                        if (mysqli_num_rows($result_check_acti_code) > 0) {
                                    ?>
                                            <input type="hidden" name="fnlv" value="<?= $activation_code ?>">
                                            <input type="hidden" name="oldEmail" value="<?= $_SESSION['oldEmail'] ?>">
                                            <input type="hidden" name="newEmail" value="<?= $_SESSION['newEmail'] ?>">
                                            <div class="text-center">
                                                <p>We have sent the One-Time Password to your email as <br>
                                                    <b><?= $_SESSION['finalVerification'] ?></b>.
                                                </p>
                                                <?php
                                                if (isset($_SESSION['newEmail'])) {
                                                ?>
                                                    <p class="text-accent"><?= $_SESSION['newEmail'] ?></p>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        <?php
                                        } else {
                                            header("Location: ../views/changeEmailAddress.php");
                                            $_SESSION['Errormsg'] = "Token expired. Please try again";
                                            exit; // Stop further execution
                                        }
                                        ?>
                                    <?php
                                    } elseif (empty($_GET['fnlv'])) {
                                        header("Location: ../views/changeEmailAddress.php");
                                        $_SESSION['Errormsg'] = "Token expired. Please try again";
                                        exit; // Stop further execution
                                    }
                                    ?>

                                    <div class="d-flex align-items-center justify-content-between mt-2">
                                        <input type="text" name="code1" class="m-2 text-center form-control rounded" maxlength="1" oninput="this.value = this.value.replace(/[^0-9]/g, ''); if(this.value.length) this.nextElementSibling.focus(); else this.previousElementSibling.focus();" autofocus>
                                        <input type="text" name="code2" class="m-2 text-center form-control rounded" maxlength="1" oninput="this.value = this.value.replace(/[^0-9]/g, ''); if(this.value.length) this.nextElementSibling.focus(); else this.previousElementSibling.focus();">
                                        <input type="text" name="code3" class="m-2 text-center form-control rounded" maxlength="1" oninput="this.value = this.value.replace(/[^0-9]/g, ''); if(this.value.length) this.nextElementSibling.focus(); else this.previousElementSibling.focus();">
                                        <input type="text" name="code4" class="m-2 text-center form-control rounded" maxlength="1" oninput="this.value = this.value.replace(/[^0-9]/g, ''); if(this.value.length) this.nextElementSibling.focus(); else this.previousElementSibling.focus();">
                                        <input type="text" name="code5" class="m-2 text-center form-control rounded" maxlength="1" oninput="this.value = this.value.replace(/[^0-9]/g, ''); if(this.value.length) this.nextElementSibling.focus(); else this.previousElementSibling.focus();">
                                        <input type="text" name="code6" class="m-2 text-center form-control rounded" maxlength="1" oninput="this.value = this.value.replace(/[^0-9]/g, ''); if(this.value.length) this.nextElementSibling.focus(); else this.previousElementSibling.focus();">
                                    </div>

                                    <div class="text-center mb-3 ps-0">
                                        <button type="submit" name="verifyFinalOTPFromEmail" class="btn btn-primary col-md-12">Verify & Accept Changes</button>
                                    </div>

                                    <div class="text-center ps-0">
                                        <h6>Didn't receive the code? <button type="submit" name="resendCodeFinalEmailChange" class="btn btn-link text-accent px-0 text-decoration-none">Send Code Again</button></h6>
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