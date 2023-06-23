<?php include('includes/header.php');

include('middleware/userMW.php');
?>

<div class="container mt-5">
    <?php
    if (isset($_SESSION['Errormsg'])) {
    ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fa-solid fa-triangle-exclamation" style="color: #58151C;"></i>
            <?= $_SESSION['Errormsg']; ?>.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php
        /* Alert popup will show here */
        unset($_SESSION['Errormsg']);
    }
    ?>
    <div class="row">
        <div class="col-md-3">
            <div class="card p-3 border rounded-3 shadow">
                <div class="row">
                    <div class="card-title">
                        My Account
                    </div>
                    <div class="card-body">
                        <div>
                            <a href="myAccount.php" class="text-dark">My Profile</a>
                        </div>
                        <div>
                            <a href="myAddress.php" class="text-dark">My Address</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div>
                <?php
                $user = getUserDetails();
                // Group items by category_name

                if (mysqli_num_rows($user) > 0) {
                    $data = mysqli_fetch_array($user);
                ?>
                    <div class="card p-3 border rounded-3 shadow">
                        <div class="card-header">
                            <h5 class="card-title">My Profile</h5>
                        </div>
                        <div class="card-body">
                            <form action="authcode.php" method="POST">
                                <div class="container-fluid">
                                    <div class="row">
                                        <input type="hidden" name="userID" value="<?= $data['user_ID'] ?>">
                                        <!-- Username start -->
                                        <div class="form-floating col-md-12 ps-0 mb-3">
                                            <input type="text" class="form-control" id="user_fname" name="username" value="<?= $data['user_username'] ?>" readonly placeholder="nam">
                                            <label for="floatingInput">Username</label>
                                        </div>
                                        <!-- Username end -->

                                        <!-- Fname and Lname start -->
                                        <div class="form-floating col-md-6 ps-0 mb-3">
                                            <input type="text" class="form-control" id="user_fname" name="firstName" value="<?= $data['user_firstName'] ?>" required placeholder="nam">
                                            <label for="floatingInput">First Name</label>
                                        </div>
                                        <div class="form-floating col-md-6 ps-0 mb-3">
                                            <input type="text" class="form-control" id="user_lname" name="lastName" value="<?= $data['user_lastName'] ?>" required placeholder="n">
                                            <label for="floatingInput">Last Name</label>
                                        </div>
                                        <!-- Fname and Lname end -->

                                        <!-- Email and Number start -->
                                        <div class="form-floating col-md-6 ps-0 mb-3">
                                            <input type="email" class="form-control" id="user_email" name="email" value="<?= $data['user_email'] ?>" required placeholder="name@example.com">
                                            <label for="floatingInput">Email address</label>
                                        </div>
                                        <div class="form-floating col-md-6 ps-0 mb-3">
                                            <input type="number" class="form-control" id="user_email" name="phoneNumber" value="<?= $data['user_phone'] ?>" required placeholder="09">
                                            <label for="floatingInput">Phone Number</label>
                                        </div>
                                        <!-- Email and Number end -->

                                        <!-- Pass and CPass start -->
                                        <div class="input-group ps-0 mb-3">
                                            <div class="form-floating">
                                                <input type="password" class="form-control" id="old_password" name="userPassword" value="<?= $data['user_password'] ?>" required placeholder="Password">
                                                <label for="code1">Password</label>
                                            </div>
                                            <span class="input-group-text" id="togglePassword"><i class="fa fa-eye-slash"></i></span>
                                        </div>
                                        <!-- Pass and CPass end -->

                                        <div class="text-center ps-0">
                                            <button type="submit" name="userUpdateAccBtn" class="btn btn-primary col-md-12">Update Credentials</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>
<script>
    const togglePassword = document
        .querySelector('#togglePassword');
    const password = document.querySelector('#old_password');
    togglePassword.addEventListener('click', () => {
        // Toggle the type attribute using
        // getAttribure() method
        const type = password
            .getAttribute('type') === 'password' ?
            'text' : 'password';
        password.setAttribute('type', type);
        // Toggle the eye and bi-eye icon
        this.classList.toggle('bi-eye');
    });
</script>

<div style="margin-top:5%;">
    <?php include('ftr.php'); ?>
</div>

<?php include('includes/footer.php'); ?>