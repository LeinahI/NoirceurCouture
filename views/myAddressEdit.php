<?php include('../partials/__header.php');

include('../middleware/userMW.php');
?>

<style>
    .border-accent {
        border-color: #bb6c54 !important;
    }
</style>

<div class="container mt-5">
    <?php include('../partials/sessionMessage.php') ?>
    <div class="row">
        <?php include('../partials/sidebar.php') ?>
        <div class="col-md-9">
            <div>

                <div class="card border rounded-3 shadow bg-main">
                    <div class="card-header">
                        <h5 class="card-title ">
                            <span>Edit Address</span>
                            <span class="float-end">
                                <a href="myAddress.php" class="btn btn-primary">
                                    Go Back
                                </a>
                            </span>
                        </h5>
                    </div>

                    <div class="card-body">
                        <?php
                        $addressID = isset($_GET['addrID']) ? $_GET['addrID'] : null;

                        $userAddressResult = getUserAddressByaddrID($addressID);
                        $user_id = $_SESSION['auth_user']['user_ID'];
                        $data = mysqli_fetch_array($userAddressResult);

                        if (empty($data)) {
                            header("Location: ../views/myAddress.php");
                            $_SESSION['Errormsg'] = "You have no address yet";
                            // Handle the error as needed
                        } else {
                            $isDefault = $data['address_isDefault'];
                            $fname = $data['address_fullName'];
                            $email = $data['address_email'];
                            $regionCode = $data['address_region'];
                            $provinceCode = $data['address_province'];
                            $cityCode = $data['address_city'];
                            $barangayCode = $data['address_barangay'];
                            $phone = $data['address_phone'];
                            $fulladdr = $data['address_fullAddress'];

                            $decryptedfullAddr = decryptData($fulladdr);

                        ?>
                            <!-- //!Display user addresses in cards -->
                            <!-- //*ADD NEW ADDRESS -->
                            <form action="../models/authcode.php" method="POST">
                                <div class="container-fluid">
                                    <div class="row">
                                        <input type="hidden" name="updateAddrID" value="<?= $addressID ?>">
                                        <input type="hidden" name="updateuserID" value="<?= $user_id ?>">

                                        <!-- Fname and Lname start -->
                                        <div class="form-floating col-md-12 ps-0 mb-3">
                                            <input type="text" class="form-control" id="user_fname" name="fullName" value="<?= $fname ?>" required placeholder="name" autocomplete="off">
                                            <label for="floatingInput">Full Name</label>
                                        </div>
                                        <!-- Fname and Lname end -->

                                        <!-- Email and Number start -->
                                        <div class="form-floating col-md-6 ps-0 mb-3">
                                            <input type="email" class="form-control" id="user_email" name="email" value="<?= $email ?>" required placeholder="name@example.com" autocomplete="off">
                                            <label for="floatingInput">Email address</label>
                                        </div>

                                        <div class="form-floating col-md-6 ps-0 mb-3">
                                            <input type="number" class="form-control" id="user_email" name="phoneNumber" value="<?= $phone ?>" required placeholder="09" onkeypress="inpNum(event)">
                                            <label for="floatingInput">Phone Number</label>
                                        </div>
                                        <!-- Email and Number end -->

                                        <!--//! Select Region Province City Barangay -->
                                        <div class="form-floating ps-0 mb-3">
                                            <select name="region" class="form-select form-control form-control-md" id="region" required>
                                                <?php foreach ($regionData as $RegD) : ?>
                                                    <option value="<?= $RegD['region_code'] ?>" <?= ($RegD['region_code'] == $regionCode) ? 'selected' : '' ?>>
                                                        <?= $RegD['region_name'] ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select> <!-- Region -->
                                            <label for="floatingInput">Region</label>
                                        </div>

                                        <div class="form-floating col-md-4 ps-0 mb-3">
                                            <select name="province" class="form-control form-control-md" id="province" required>
                                                <?php foreach ($provinceData as $ProvD) : ?>
                                                    <option value="<?= $ProvD['province_code'] ?>" <?= ($ProvD['province_code'] == $provinceCode) ? 'selected' : '' ?>>
                                                        <?= $ProvD['province_name'] ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>

                                            <label for="floatingInput">Province</label>
                                        </div>
                                        <div class="form-floating col-md-4 ps-0 mb-3">
                                            <select name="city" class="form-control form-control-md" id="city" required>
                                                <?php foreach ($cityData as $CtyD) : ?>
                                                    <option value="<?= $CtyD['city_code'] ?>" <?= ($CtyD['city_code'] == $cityCode) ? 'selected' : '' ?>>
                                                        <?= $CtyD['city_name'] ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>

                                            <label for="floatingInput">City / Municipality</label>
                                        </div>
                                        <div class="form-floating col-md-4 ps-0 mb-3">
                                            <select name="barangay" class="form-control form-control-md" id="barangay" required>
                                                <?php foreach ($barangayData as $BrgyD) : ?>
                                                    <option value="<?= $BrgyD['brgy_code'] ?>" <?= ($BrgyD['brgy_code'] == $barangayCode) ? 'selected' : '' ?>>
                                                        <?= $BrgyD['brgy_name'] ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>

                                            <label for="floatingInput">Barangay</label>
                                        </div>

                                        <!--Addr start -->
                                        <div class="form-floating col-md-12 ps-0 mb-3">
                                            <div class="form-floating ps-0 ">
                                                <textarea rows="3" class="form-control" id="delivery_fullAddr" name="fullAddress" required placeholder="d" style="height:100px; min-height: 57px; max-height: 100px;"><?= $decryptedfullAddr ?></textarea>
                                                <label for="floatingInput">Address</label>
                                            </div>
                                        </div>

                                        <!-- Set Default Address -->
                                        <div class="ps-4 mb-3">
                                            <input class="form-check-input" type="checkbox" name="defaultAddr" id="reverseCheck1">
                                            <label class="form-check-label" for="reverseCheck1">
                                                Set as Default Address
                                            </label>
                                        </div>

                                    <?php
                                }
                                if (!$isDefault) {
                                    ?>

                                    <?php
                                } ?>

                                    <div>
                                        <button name="userUpdateAddrBtn" class="btn btn-accent col-md-12">Edit Address</button>
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


<script>
    //
    document.addEventListener("DOMContentLoaded", function() {
        // Assuming $isDefault is either true or false
        var isDefault = <?= $isDefault ? 'true' : 'false' ?>;

        // Get the checkbox element
        var checkbox = document.getElementById("reverseCheck1");

        // If $isDefault is true, add "disabled" and "checked" attributes to the checkbox
        if (isDefault) {
            checkbox.disabled = true;
            checkbox.checked = true;
        }
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
</script>

<div style="margin-top:5%;">
    <?php include('footer.php'); ?>
</div>

<?php
include('../assets/js/ph-address-selector.php');
include('../partials/__footer.php'); ?>