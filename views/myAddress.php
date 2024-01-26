<?php include('../partials/__header.php');

include('../middleware/userMW.php');
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
        <?php include('../partials/sidebar.php') ?>
        <div class="col-md-9">
            <div>
                <?php
                $userid = getUserDetails();
                $dataid = mysqli_fetch_array($userid);

                $user = getUserAddress();
                $data = mysqli_fetch_array($user);

                $id = isset($dataid['user_ID']) ? $dataid['user_ID'] : '';
                $fname = isset($data['address_fullName']) ? $data['address_fullName'] : '';
                $email = isset($data['address_email']) ? $data['address_email'] : '';
                $state = isset($data['address_state']) ? $data['address_state'] : '';
                $city = isset($data['address_city']) ? $data['address_city'] : '';
                $pcode = isset($data['address_postal_code']) ? $data['address_postal_code'] : '';
                $country = isset($data['address_country']) ? $data['address_country'] : '';
                $phone = isset($data['address_phone']) ? $data['address_phone'] : '';
                $fulladdr = isset($data['address_fullAddress']) ? $data['address_fullAddress'] : '';

                $existingAddress = !empty($fulladdr);
                ?>

                <div class="card border rounded-3 shadow bg-main">
                    <div class="card-header">
                        <h5 class="card-title">My Address</h5>
                    </div>
                    <div class="card-body">
                        <form action="../models/authcode.php" method="POST">
                            <div class="container-fluid">
                                <div class="row">
                                    <input type="hidden" name="userID" value="<?= $id ?>">

                                    <!-- Fname and Lname start -->
                                    <div class="form-floating col-md-12 ps-0 mb-3">
                                        <input type="text" class="form-control" id="user_fname" name="fullName" value="<?= $fname ?>" required placeholder="nam">
                                        <label for="floatingInput">Full Name</label>
                                    </div>
                                    <!-- Fname and Lname end -->

                                    <!-- Email and Number start -->
                                    <div class="form-floating col-md-6 ps-0 mb-3">
                                        <input type="email" class="form-control" id="user_email" name="email" value="<?= $email ?>" required placeholder="name@example.com">
                                        <label for="floatingInput">Email address</label>
                                    </div>

                                    <div class="form-floating col-md-6 ps-0 mb-3">
                                        <input type="number" class="form-control" id="user_email" name="phoneNumber" value="<?= $phone ?>" required placeholder="09" onkeypress="inpNum(event)">
                                        <label for="floatingInput">Phone Number</label>
                                    </div>
                                    <!-- Email and Number end -->

                                    <!-- City State Country -->
                                    <div class="form-floating col-md-4 ps-0 mb-3">
                                        <input type="text" class="form-control" id="delivery_postCode" value="<?= $state ?>" name="state" placeholder="st">
                                        <label for="floatingInput">State</label>
                                    </div>
                                    <div class="form-floating col-md-4 ps-0 mb-3">
                                        <input type="text" class="form-control" id="delivery_postCode" value="<?= $city ?>" name="city" placeholder="ct">
                                        <label for="floatingInput">City</label>
                                    </div>
                                    <div class="form-floating col-md-4 ps-0 mb-3">
                                        <input type="text" class="form-control" id="user_fname" value="<?= $pcode ?>" name="postalCode" required placeholder="nam">
                                        <label for="floatingInput">Postal Code</label>
                                    </div>
                                    <div class="form-floating ps-0 mb-3">
                                        <select class="form-select" id="country" name="country">
                                            <?php include('../partials/country-options.php') ?>
                                        </select>
                                        <label for="floatingInput">Country</label>
                                    </div>

                                    <!--Addr start -->
                                    <div class="form-floating col-md-12 ps-0 mb-3">
                                        <div class="form-floating ps-0 mb-3">
                                            <textarea rows="3" class="form-control" id="delivery_fullAddr" name="fullAddress" required placeholder="d" style="height:100px; min-height: 57px; max-height: 100px;"><?= $fulladdr ?></textarea>
                                            <label for="floatingInput">Address</label>
                                        </div>
                                    </div>

                                    <!-- Add & Update button -->
                                    <?php if ($existingAddress) { ?>
                                        <!-- If an existing address exists -->
                                        <div class="form-floating col-md-12 ps-0">
                                            <button type="submit" name="userUpdateAddrBtn" class="btn btn-accent col-md-12">Update My Address</button>
                                        </div>
                                    <?php } else { ?>
                                        <!-- If no existing address exists -->
                                        <div class="form-floating col-md-12 ps-0">
                                            <button type="submit" name="userAddAddrBtn" class="btn btn-accent col-md-12">Add Address</button>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    /* display selected country */
    var selectedCountry = "<?php echo $country; ?>";
    // Set the selected attribute based on the PHP variable
    document.getElementById("country").value = selectedCountry;

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
</script>

<div style="margin-top:5%;">
    <?php include('footer.php'); ?>
</div>

<?php include('../partials/__footer.php'); ?>